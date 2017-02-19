<?php

namespace App\Http\Controllers;

use Auth;
//use Carbon\Carbon;
use Input;
use Illuminate\Http\Request;

//use App\Http\Requests;

class ExportController extends Controller
{
    private $user;
    protected $rules = [
        'year' => ['required'],
        'description' => ['required','min:10'],
    ];
    
    public function __construct()
    {
        $this->user = Auth::user();
        $this->middleware('auth');
    }
    
    public function index()
    {
        $dates = Auth::user()->workouts()->lists('date');
        $arYr = [];
        foreach($dates as $date) {
            $strYr = substr($date,0,4);
            if(!in_array($strYr, $arYr)) {
                $arYr[$strYr] = $strYr;
            }
        }
        $Data = [];
        $Data['years'] = $arYr;
        return view('export.index', $Data);
    }
    
    public function export(Request $request)
    {
        $frmData = Input::all();
        $this->validate($request, $this->rules);
        $year = $frmData['year'];
        $description = $frmData['description'];
        $frmData['user_id'] = $this->user->id;
        
        $workouts = $this->user->workouts()->where('date', 'LIKE', $year.'%' )
            ->orderBy('date')->get();
        dd($workouts);
        
        
    }
}
