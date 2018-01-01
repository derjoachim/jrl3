<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $users = factory(\App\Models\User::class,3)->create();
        $service = factory(\App\Models\FitnessService::class)
            ->create(['name' => 'Strava', 'slug' => 'strava']);
    }


    public function tearDown()
    {
        parent::tearDown();
    }
}
