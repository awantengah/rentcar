<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Car_data extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->check_validation();

        $this->load->model('car_data_model');

        $this->page_title = 'Car Data';
        $this->layout     = 'template/dashboard';

        $this->_sidebar_active = 'car_data';
    }

    public function get_data()
    {
        $data = $this->car_data_model->all();
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function index()
    {
        $data['breadcrumb'] = [
            ['link' => '', 'title' => 'car data', 'icon' => '', 'active' => '1'],
        ];
        $this->render('car_data/index', $data);
    }

    public function add()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('car_name', 'car name', 'required');
        $this->form_validation->set_rules('production_year', 'production year', 'required');

        if ($this->form_validation->run() == false) {
            $data['page_title'] = 'Add ' . $this->page_title;
            $data['breadcrumb'] = [
                ['link' => site_url('dashboard/car-data'), 'title' => 'car data', 'icon' => '', 'active' => '0'],
                ['link' => '', 'title' => 'add car data', 'icon' => '', 'active' => '1'],
            ];
            $this->render('car_data/edit', $data);
        } else {
            $data = array(
                'car_name'        => $this->input->post('car_name', true),
                'production_year' => $this->input->post('production_year', true),
                'created_at'      => $this->now,
            );
            $this->car_data_model->save($data);

            $this->session->set_flashdata('message', array('message' => 'Action Successfully..', 'class' => 'alert-success'));
            redirect('dashboard/car-data');
        }
    }

    public function edit($id)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('car_name', 'car name', 'required');
        $this->form_validation->set_rules('production_year', 'production year', 'required');

        if ($this->form_validation->run() == false) {
            $data['page_title'] = 'Edit ' . $this->page_title;
            $data['breadcrumb'] = [
                ['link' => site_url('dashboard/car-data'), 'title' => 'car data', 'icon' => '', 'active' => '0'],
                ['link' => '', 'title' => 'edit car data', 'icon' => '', 'active' => '1'],
            ];
            $data['car_data'] = $this->car_data_model->first($id);
            $this->render('car_data/edit', $data);
        } else {
            $data = array(
                'car_name'        => $this->input->post('car_name', true),
                'production_year' => $this->input->post('production_year', true),
                'updated_at'      => $this->now,
            );
            $this->car_data_model->edit($id, $data);

            $this->session->set_flashdata('message', array('message' => 'Action Successfully..', 'class' => 'alert-success'));
            redirect('dashboard/car-data');
        }
    }

    public function delete()
    {
        $id = $this->input->get('id', true);
        if ($id) {
            $check_exist = $this->car_data_model->first($id);
            if ($check_exist) {
                $data_edit = array(
                    'deleted_at' => $this->now,
                );
                $this->car_data_model->edit($id, $data_edit);
                return true;
            }
            return false;
        } else {
            return false;
        }
    }

}
