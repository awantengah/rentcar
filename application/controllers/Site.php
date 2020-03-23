<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Site extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');

        $this->layout = 'template';
        $this->auth   = false;
    }

    public function index()
    {
        redirect('login');
    }

    public function login()
    {
        $this->_include_header = false;
        $this->_include_footer = false;
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'username', 'required');
        $this->form_validation->set_rules('password', 'password', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/login');
        } else {
            $validate = $this->user_model->all(
                array(
                    'where' => array(
                        'username' => $this->input->post('username', true),
                        'password' => sha1($this->input->post('password', true)),
                    ),
                ),
                false
            );
            if ($validate) {
                $sess = array(
                    'id_user' => $validate->id,
                    'level'   => $validate->id_level,
                    'status'  => $validate->status,
                );
                $this->session->set_userdata($sess);
                if ($validate->id_level == '1' || $validate->id_level == '2') {
                    redirect('dashboard');
                } else {
                    show_404();
                }
            } else {
                $this->session->set_flashdata('message', array('message' => 'Username and/or password not correct.', 'class' => 'alert-danger'));
                redirect('login');
            }
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
}
