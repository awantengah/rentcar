<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->check_validation();

        $this->layout = 'template/dashboard';
    }

    public function index()
    {
        $this->render('index');
    }

}
