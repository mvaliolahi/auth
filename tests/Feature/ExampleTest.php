<?php

namespace Tests\Feature;


use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function testExample()
    {
        $this->get('/auth/login')->assertSuccessful();
    }
}
