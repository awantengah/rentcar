<?php

defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    protected $auth   = true;
    protected $layout = 'template';
    protected $now;
    protected $rules;

    public $page_title;
    public $_sidebar_active;

    public $ci;
    public $limit = 10;

    public $_user_login;
    public $_created;
    public $_updated;
    public $_deleted;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');

        $this->now = date('Y-m-d H:i:s');
        $this->ci  = &get_instance();

        $this->_user_login = $this->user_model->first(
            array('id' => $this->session->userdata('id_user'))
        );
    }

    public function check_validation($level_logged = 'dashboard')
    {
        if (!is_null($level_logged)) {
            $level  = $this->session->userdata('level');
            $status = $this->session->userdata('status');

            if (!is_null($level) && !is_null($status)) {
                if ($status != '1') {
                    //Check active or not
                    $this->session->set_flashdata('message', array('message' => 'Your account not active..', 'class' => 'alert-info'));
                    redirect('login');
                }

                $redirect = 'dashboard';

                if ($redirect != $level_logged) {
                    $this->session->set_flashdata('message', array('message' => 'You don\'t allowed to access..', 'class' => 'alert-info'));
                    redirect('login');
                }
            } else {
                $this->session->set_flashdata('message', array('message' => 'You must login to continue..', 'class' => 'alert-info'));
                redirect('login');
            }
        } else {
            $this->session->set_flashdata('message', array('message' => 'You must login to continue..', 'class' => 'alert-info'));
            redirect('login');
        }
    }

    public function render($page, $data = null)
    {
        $reflect    = new ReflectionClass($this);
        $properties = $reflect->getProperties(ReflectionProperty::IS_PUBLIC);
        foreach ($properties as $prop) {
            $data[$prop->name] = $this->{$prop->name};
        }
        $data['_main_content'] = $this->load->view($this->layout . '/' . $page, $data, true);
        $this->load->view($this->layout . '/layout', $data);
        // $this->output->enable_profiler(true);
    }

}
