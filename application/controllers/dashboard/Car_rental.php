<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Car_rental extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->check_validation();

        $this->load->model('car_rental_model');

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
        $this->form_validation->set_rules('car_name', 'car name', 'required');
        $this->form_validation->set_rules('production_year', 'production year', 'required');
        $this->form_validation->set_rules('price_per_day', 'price per day', 'required');

        if ($this->form_validation->run() == false) {
            $data['page_title'] = 'Add ' . $this->page_title;
            $data['breadcrumb'] = [
                ['link' => site_url('dashboard/car-data'), 'title' => 'car data', 'icon' => '', 'active' => '0'],
                ['link' => '', 'title' => 'add car data', 'icon' => '', 'active' => '1'],
            ];
            $this->render('car_rental/edit', $data);
        } else {

            $this->session->set_flashdata('message', array('message' => 'Action Successfully..', 'class' => 'alert-success'));
            redirect('dashboard/car-data');
        }
    }

    public function edit($id)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('car_name', 'car name', 'required');
        $this->form_validation->set_rules('production_year', 'production year', 'required');
        $this->form_validation->set_rules('price_per_day', 'price per day', 'required');

        if ($this->form_validation->run() == false) {
            $data['page_title'] = 'Edit ' . $this->page_title;
            $data['breadcrumb'] = [
                ['link' => site_url('dashboard/car-data'), 'title' => 'car data', 'icon' => '', 'active' => '0'],
                ['link' => '', 'title' => 'edit car data', 'icon' => '', 'active' => '1'],
            ];
            $data['car_rental'] = $this->car_rental_model->first($id);
            $this->render('car_rental/edit', $data);
        } else {

            $this->session->set_flashdata('message', array('message' => 'Action Successfully..', 'class' => 'alert-success'));
            redirect('dashboard/car-data');
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
