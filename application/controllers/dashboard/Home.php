<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Home extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->check_validation();

        $this->page_title = 'Dashboard';
        $this->layout     = 'template/dashboard';

        $this->_sidebar_active = 'home';
    }

    public function index()
    {
        $data['breadcrumb'] = [];
        $this->render('index', $data);
    }

}
