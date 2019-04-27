<?php

namespace Tests\Feature;

use App\Models\Route;
use App\Models\User;
use App\Models\Workout;
use Carbon\Carbon;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class WorkoutsControllerTest extends TestCase
{
    
    
    /**
     * Mini-seeder to 'fake' a form submit.
     *
     * @param Carbon $ts
     * @param array  $params
     * @return array
     */
    private function _getSampleWorkout(Carbon $ts, array $params = [])
    {
        $arWrk = [
            'route_id' => 1,
            'name' => 'A sample workout',
            'distance' => 10.1,
            'date' => $ts->toDateString(),
            'start_time' => $ts->toTimeString(),
            'time_in_seconds' => 45 * 60,
            'finished' => 1,
            'description' => '<p>Ipse lorem etcetera</p>',
            'mood' => 5,
            'health' => 4
        ];
        foreach ($params as $key => $val) {
            $arWrk[$key] = $val;
        }
        return $arWrk;
    }
    
    public function setUp(): void
    {
        parent::setUp();
        factory(Route::class, 3)->create(['user_id' => 1]);
    }
    
    public function testMustBeLoggedIn()
    {
        $this->get('/workouts')->assertStatus(302);
        $oUser = User::find(1);
        $this->actingAs($oUser)->get('/workouts')->assertSuccessful()
            ->assertSee(Lang::get('jrl.no_workouts_defined',
                ['url' => URL::route('workouts.create')]));
    }
    
    public function testCreateWorkout()
    {
        $oUser = User::find(1);
        $this->actingAs($oUser)->get('/workouts/create')->assertStatus(200);
        $this->actingAs($oUser)->post('/workouts', $this->_getSampleWorkout(Carbon::now()))
            ->assertStatus(302)
            ->assertSessionHas('message', Lang::get('jrl.workout_saved'))
            ->assertHeader('Location', url('/workouts'));
        $this->assertDatabaseHas('workouts', ['name' => 'A sample workout']);
        $this->assertCount(1, $oUser->workouts);
    }
    
    public function testEditWorkout()
    {
        $oUser = User::find(1);
        $oWorkout = factory(\App\Models\Workout::class)->create(['name' => 'A workout', 'user_id' => 1]);
        $this->actingAs($oUser)->get('/workouts')
            ->assertSuccessful()
            ->assertSee($oWorkout->name);
        $oWorkout = Workout::find($oWorkout->id);  //
        
        $this->actingAs($oUser)->get('workouts/' . $oWorkout->slug . '/edit')
            ->assertStatus(200)
            ->assertSee($oWorkout->name)
            ->assertViewHas('workout', $oWorkout);
        
        $oRoute = Route::find(1);
        $response = $this->actingAs($oUser)->put('workouts/' . $oWorkout->slug,
            $this->_getSampleWorkout(Carbon::now(), ['route_id' => 1, 'name' => 'An updated workout']));
        $oWorkout = $oWorkout->find($oWorkout->id);
        $response->assertStatus(302)
            ->assertSessionHas('message', Lang::get('jrl.workout_saved'))
            ->assertSee($oWorkout->slug);
        $this->actingAs($oUser)->get('workouts/' . $oWorkout->slug)
            ->assertSee($oWorkout->name)
            ->assertSee($oRoute->name);
    }
    
    public function testUserCanOnlySeeTheirOwnWorkouts()
    {
        $oWorkout = factory(Workout::class)->create(['name' => 'A workout by another user', 'user_id' => 2]);
        $oUser = User::find(1);
        $ownWorkouts = $oUser->workouts;
        $this->actingAs($oUser)->get('/workouts')
            ->assertDontSee($oWorkout->name);
        $this->assertCount(0, $ownWorkouts);
        $oWorkout = factory(workout::class)->create(['name' => 'Own workout', 'user_id' => 1]);
        $ownWorkouts = $oUser->workouts()->get();
        $this->assertCount(1, $ownWorkouts);
        $this->actingAs($oUser)->get('/workouts')
            ->assertSee($oWorkout->name);
    }
    
    public function testUserCanDeleteOwnRoutes()
    {
        $oWorkout = factory(Workout::class)->create(['name' => 'Kenny workout', 'user_id' => 1]);
        $oOtherUser = User::find(2);
        $this->actingAs($oOtherUser)->delete('/workouts/' . $oWorkout->slug)
            ->assertStatus(302)
            ->assertSessionHas('message', Lang::get('jrl.workout_not_authorized'));
        $oUser = User::find(1);
        $this->actingAs($oUser)->delete('/workouts/' . $oWorkout->slug)
            ->assertStatus(302)
            ->assertSessionHas('message', Lang::get('jrl.workout_deleted'));
    }
    
    public function tearDown(): void
    {
        parent::tearDown();
    }
}
