<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Car_data_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->table       = 'car_data';
        $this->primary_key = 'id';
    }

}
