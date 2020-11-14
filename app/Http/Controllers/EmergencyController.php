<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use stdClass;
use App\User;
use DB;

class EmergencyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index(Request $request){

        $navbar = $this->navbar();
        return view('emergency',compact('navbar'));
    }    
}
