<?php namespace App\Http\Controllers;

use Auth;

class FilesController extends Controller {
    
    public function __construct() {
        $this->middleware('auth');
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function upload()
	{
		return view('files.upload');
	}
}
