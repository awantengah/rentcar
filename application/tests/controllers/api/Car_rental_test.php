<?php

class Car_rental_test extends TestCase
{
    public function setUp(): void
    {
        $this->resetInstance();
        $this->CI->load->model('car_data_model');
        $this->obj = $this->CI->car_data_model;
    }

    public function test_selected_car()
    {
        $actual   = $this->obj->first(1)->car_name;
        $expected = 'Honda Mobilio';
        $this->assertEquals($expected, $actual);
    }
}
