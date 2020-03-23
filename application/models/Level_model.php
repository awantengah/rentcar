<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Level_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->table       = 'level';
        $this->primary_key = 'id';
    }

}
