<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Lang;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HomeTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
    }
    
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/')->assertStatus(302);
        
        $user = User::find(1);
        
        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200)->assertSeeText(Lang::get('jrl.welcome_to_jrl'));
        
    }
}
