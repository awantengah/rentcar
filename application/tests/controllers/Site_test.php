<?php

class Site_test extends TestCase
{
    public function test_index()
    {
        $output = $this->request('GET', 'site/login');
        $this->assertStringContainsString('<title>Rent Car App | Log in</title>', $output);
    }
}
