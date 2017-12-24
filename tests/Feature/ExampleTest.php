<?php

namespace Tests\Feature;

use Lang;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/')->assertStatus(302);

        $user = factory(\App\User::class)->make();

        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200)
                ->assertSeeText(Lang::get('jrl.welcome_to_jrl'))
                ->assertViewIs('home');
    }
}
