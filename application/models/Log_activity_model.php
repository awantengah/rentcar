<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Log_activity_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->table       = 'log_activity';
        $this->primary_key = 'id';
    }

}
