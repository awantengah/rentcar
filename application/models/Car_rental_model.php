<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Car_rental_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->table       = 'car_rental';
        $this->primary_key = 'id';
    }

}
