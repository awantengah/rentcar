<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Car_rental extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->check_validation();

        $this->load->model('car_data_model');
        $this->load->model('car_rental_model');

        $this->load->helper('string');

        $this->page_title = 'Car Rental';
        $this->layout     = 'template/dashboard';

        $this->_sidebar_active = 'car_rental';
    }

    public function get_data()
    {
        $data = $this->car_rental_model->all(
            array(
                'fields'    => 'car_rental.*, car_data.car_name',
                'left_join' => array(
                    'car_data' => 'car_data.id = car_rental.id_car_data AND car_data.deleted_at IS NULL',
                ),
            )
        );
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function index()
    {
        $data['breadcrumb'] = [
            ['link' => '', 'title' => 'car rental', 'icon' => '', 'active' => '1'],
        ];
        $this->render('car_rental/index', $data);
    }

    public function add()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('order_number', 'order number', 'required');
        $this->form_validation->set_rules('num_box', 'car rental amount', 'required');
        if (!empty($this->input->post('id_car_data', true))) {
            $this->form_validation->set_rules('id_car_data[]', 'car', 'required');
        }
        if (!empty($this->input->post('rent_begin', true))) {
            $this->form_validation->set_rules('rent_begin[]', 'rent start', 'required');
        }
        if (!empty($this->input->post('rent_end', true))) {
            $this->form_validation->set_rules('rent_end[]', 'rent end', 'required');
        }

        if ($this->form_validation->run() == false) {
            $data['page_title'] = 'Add ' . $this->page_title;
            $data['breadcrumb'] = [
                ['link' => site_url('dashboard/car-rental'), 'title' => 'car rental', 'icon' => '', 'active' => '0'],
                ['link' => '', 'title' => 'add car rental', 'icon' => '', 'active' => '1'],
            ];
            $this->render('car_rental/edit', $data);
        } else {
            $num_box = $this->input->post('num_box', true);

            for ($i = 0; $i < $num_box; $i++) {

                $id_car_data = $this->input->post("id_car_data[{$i}]", true);

                $car_detail = $this->car_data_model->first($id_car_data);

                if ($car_detail) {
                    $rent_begin_format = to_date_format($this->input->post("rent_begin[{$i}]", true), 'Y-m-d');
                    $rent_end_format   = to_date_format($this->input->post("rent_end[{$i}]", true), 'Y-m-d');

                    $rent_begin = date_create($rent_begin_format);
                    $rent_end   = date_create($rent_end_format);
                    $rent_days  = date_diff($rent_begin, $rent_end)->days;

                    $rent_amount = $car_detail->price_per_day * $rent_days;

                    if ($rent_days >= 3) {
                        $discount1     = 0.05; //5%
                        $ppd_discount1 = $rent_amount * $discount1;
                    } else {
                        $discount1     = 0;
                        $ppd_discount1 = 0;
                    }

                    if ($num_box >= 2) { //lebih dari sama dengan 2 mobil
                        $discount2     = 0.1; //10%
                        $ppd_discount2 = $discount1 == 0 ? ($rent_amount * $discount2) : ($ppd_discount1 * $discount2);
                    } else {
                        $discount2     = 0;
                        $ppd_discount2 = 0;
                    }

                    if ($car_detail->production_year < 2010 && $car_detail->production_year != 0) {
                        $discount3     = 0.07; //7%
                        $ppd_discount3 = $discount2 == 0 ? ($rent_amount * $discount3) : ($ppd_discount2 * $discount3);
                    } else {
                        $discount3     = 0;
                        $ppd_discount3 = 0;
                    }

                    $data = array(
                        'order_number' => $this->input->post('order_number', true),
                        'id_car_data'  => $id_car_data,
                        'rent_begin'   => $rent_begin_format,
                        'rent_end'     => $rent_end_format,
                        'cost'         => $rent_amount,
                        'discount'     => ((int) $ppd_discount1 + (int) $ppd_discount2 + (int) $ppd_discount3),
                        'created_at'   => $this->now,
                    );
                    $this->car_rental_model->save($data);
                }
            }

            $this->session->set_flashdata('message', array('message' => 'Action Successfully..', 'class' => 'alert-success'));
            redirect('dashboard/car-rental');
        }
    }

    public function edit($order_number)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('num_box', 'car rental amount', 'required');
        if (!empty($this->input->post('id_car_data', true))) {
            $this->form_validation->set_rules('id_car_data[]', 'car', 'required');
        }
        if (!empty($this->input->post('rent_begin', true))) {
            $this->form_validation->set_rules('rent_begin[]', 'rent start', 'required');
        }
        if (!empty($this->input->post('rent_end', true))) {
            $this->form_validation->set_rules('rent_end[]', 'rent end', 'required');
        }

        if ($this->form_validation->run() == false) {
            $data['page_title'] = 'Edit ' . $this->page_title;
            $data['breadcrumb'] = [
                ['link' => site_url('dashboard/car-rental'), 'title' => 'car rental', 'icon' => '', 'active' => '0'],
                ['link' => '', 'title' => 'edit car rental', 'icon' => '', 'active' => '1'],
            ];
            $data['car_rental'] = $this->car_rental_model->first(
                array(
                    'order_number' => $order_number,
                )
            );
            $this->render('car_rental/edit', $data);
        } else {

            $this->session->set_flashdata('message', array('message' => 'Action Successfully..', 'class' => 'alert-success'));
            redirect('dashboard/car-rental');
        }
    }

    public function delete()
    {
        $id = $this->input->get('id', true);
        if ($id) {
            $check_exist = $this->car_rental_model->first($id);
            if ($check_exist) {
                $data_edit = array(
                    'deleted_at' => $this->now,
                );
                $this->car_rental_model->edit($id, $data_edit);
                return true;
            }
            return false;
        } else {
            return false;
        }
    }

}
