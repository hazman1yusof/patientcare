<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use stdClass;
use App\User;
use DB;
use Carbon\Carbon;

class EmergencyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index(Request $request){

        $navbar = $this->navbar();

        $emergency = DB::table('episode')
        				->whereMonth('reg_date', '=', now()->month)
        				->get();

        $events = $this->getEvent($emergency);

        return view('emergency',compact('navbar','events'));
    }

    public function getEvent($obj){
    	$events = [];

    	for ($i=1; $i <= 31; $i++) {
    		$days = 0;
    		$reg_date;
    		foreach ($obj as $key => $value) {
	    		$day = Carbon::createFromFormat('Y-m-d',$value->reg_date);
	    		if($day->day == $i){
	    			$reg_date = $value->reg_date;
	    			$days++;
	    		}
	    	}
	    	if($days != 0){
	    		$event = new stdClass();
	    		$event->title = $days.' patients';
	    		$event->start = $reg_date;
	    		array_push($events, $event);
	    	}
    	}

    	return $events;

    }
}
