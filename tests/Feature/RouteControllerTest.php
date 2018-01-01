<?php

namespace Tests\Feature;

use App\Models\Route;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;
use Illuminate\Foundation\Testing\WithFaker;

class RouteControllerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        
    }
    
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testMustBeLoggedIn()
    {
        $this->get('/routes')->assertStatus(302);
        $user = User::find(1);
        $response = $this->actingAs($user)->get('/routes')->assertStatus(200);
        $response->assertSee(Lang::get('jrl.no_routes_defined', ['url' => URL::route('routes.create')]));
    }
    
    
    /**
     * @return void
     */
    public function testCreateRoute()
    {
        $user = User::find(1);
        $response = $this->actingAs($user)->get('/routes/create')->assertStatus(200);
        $response = $this->actingAs($user)->post('routes',
            ['name' => 'A sample route',
                'distance' => '10',
                'rating' => '3',
                'description' => 'an elaborate description']);
        $this->assertDatabaseHas('routes', ['name' => 'A sample route']);
        $response->assertStatus(302)
            ->assertSessionHas('message', Lang::get('jrl.route_saved'))
            ->assertHeader('Location', url('/routes'));
        $this->assertCount(1, $user->routes);
    }
    
    /**
     * @depends clone testCreateRoute
     */
    public function testEditRoute()
    {
        $iUserId = 1;
        factory(Route::class)->create(['user_id' => $iUserId, 'name' => 'A sample route']);
        
        $user = User::find($iUserId);
        $Routes = $user->routes;
        $this->assertCount(1, $Routes);
        $oRoute = $Routes[0];
        
        $this->actingAs($user)->get('/routes')
            ->assertStatus(200)
            ->assertSee($oRoute->name)
            ->assertViewHas('routes', $Routes);
        
        $this->actingAs($user)->get('/routes/' . $oRoute->slug)
            ->assertStatus(200)
            ->assertSee($oRoute->name)
            ->assertViewHas('route', $oRoute);
        
        $this->actingAs($user)->get('/routes/' . $oRoute->slug . '/edit')
            ->assertViewHas('route', $oRoute);
        
        $response = $this->actingAs($user)->put('routes/' . $oRoute->slug,
            ['name' => 'An updated route',
                'distance' => 12,
                'rating' => 4,
                'description' => 'A slightly more elaborate description']);
        $response->assertStatus(302)->assertSessionHas('message', Lang::get('jrl.route_saved'));
        $this->assertDatabaseHas('routes', ['name' => 'An updated route']);
        $Routes = $user->routes;
        $this->assertCount(1, $Routes);
    }
    
    /**
     * @test
     */
    public function testUserCanSeeOnlyTheirOwnRoutes()
    {
        $oRoute = factory(Route::class)->create(['user_id' => 1]);
        
        $oUser = User::find(2);
        $this->actingAs($oUser)->get('/routes')
            ->assertDontSee($oRoute->name);
        $response = $this->get('/routes/' . $oRoute->slug)
            ->assertStatus(302)
            ->assertSessionHas('message', Lang::get('jrl.route_not_authorized'));
        $oRoute = factory(Route::class)->create(['user_id' => 2]);
        $Routes = $oUser->routes;
        $this->actingAs($oUser)->get('/routes')->assertSee($oRoute->name)
            ->assertViewHas('routes', $Routes);
        $this->assertCount(1, $Routes);
        $this->actingAs($oUser)->get('/routes/' . $oRoute->slug)
            ->assertStatus(200)
            ->assertSee($oRoute->name);
    }
    
    /**
     * @test
     */
    public function testUserCanDeleteOwnRoutes()
    {
        $iUserId = 1;
        $oRoute = factory(Route::class)->create(['user_id' => 1]);
        $oUser = User::find($iUserId);
        $this->actingAs($oUser)->delete('/routes/' . $oRoute->slug)
            ->assertStatus(302)
            ->assertSessionHas('message',  Lang::get('jrl.route_deleted'));
        
        $oAnotherRoute = factory(Route::class)->create(['user_id' => 2]);
        $this->actingAs($oUser)->delete('/routes/' . $oAnotherRoute->slug)
            ->assertStatus(302)
            ->assertSessionHas('message', Lang::get('jrl.route_not_authorized'));
    }
    
}
