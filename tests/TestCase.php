<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
//    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        Artisan::call('migrate');
    }


    public function tearDown()
    {
        echo 'Teardown' . PHP_EOL;
        Artisan::call('migrate:reset');
    }
}
