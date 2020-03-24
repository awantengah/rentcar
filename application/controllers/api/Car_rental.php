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
    }

    public function call_box_rent_car()
    {
        $get_num_box = $this->input->get('num_box', true);
        if ($get_num_box) {
            $data['car_data'] = $this->car_data_model->all();
            $data['num_box']  = $get_num_box;
            $template         = $this->load->view('template/dashboard/car_rental/_box_rent_car', $data, true);
        } else {
            $template = '';
        }
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($template));
    }

    public function selected_car()
    {
        $id_selected_car = $this->input->get('id_selected_car', true);
        if ($id_selected_car) {
            $data = $this->car_data_model->first($id_selected_car);
        } else {
            $data = array();
        }
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

}
