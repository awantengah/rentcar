<?php

defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->table       = 'user';
        $this->primary_key = 'id';
    }

}
