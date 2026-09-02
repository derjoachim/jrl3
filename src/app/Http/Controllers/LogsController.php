<?php

namespace App\Http\Controllers;

use App;
use App\Events\LogSaved;
use Auth;
use App\Models\Log as LogModel;
use App\Models\User;
use Illuminate\Http\Request;
use Redirect;

final class LogsController extends Controller
{
    
    protected $rules = [
      'description' => ['required','min:10'],
        'start_date' => ['required','date'],
        'end_date'=> ['required', 'date']
    ];
    
    public function __construct() {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $logs = User::find(Auth::id())->logs;
        return view('logs.index', compact('logs'));
    }
    
    
    public function show($id)
    {
        // nope
    }
    
    
    public function create()
    {
        return view('logs.create');
    }
    
    
    public function edit(LogModel $log,Request $request)
    {
         if ($log->user_id == $request->user()->id) {
            return view('logs.edit', compact('log'));
        }
        App::abort(403);
    }
    
    
    public function destroy($id)
    {
        $oLog = Logmodel::find($id);
        if(Auth::id() == $oLog->user_id ) {
            $oLog->delete();
            return Redirect::route('logs.index')->with('message', trans('jrl.log_deleted'));
        }
        App::abort(403);
    }
    
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);
        $input = $request->all();
        
        $oLog = new LogModel($input);
        $oLog->user_id = Auth::id();
        $oLog->save();
        event(new LogSaved($oLog));
        
        return Redirect::route('logs.index')->with('message', trans('jrl.log_saved'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, $this->rules);
        $oLog = LogModel::find($id);
        $input = array_except($request->all(), '_method');
        $oLog->update($input);
        $oLog->save();
        event(new LogSaved($oLog));
        return Redirect::route('logs.index')->with('message', trans('jrl.log_saved'));
    }
    
    public function download($id)
    {
        return response()->download(Logmodel::find($id)->getFullPath());
    }
}
