<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Menu_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->table       = 'menu';
        $this->primary_key = 'id';
    }

}
