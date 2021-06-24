<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use stdClass;
use DB;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use Response;
use Auth;
use App\Models\SuratMasuk;

class ChatController extends Controller
{   
    
    public function __construct()
    {

        $this->middleware('auth');
    }

    public function show(Request $request)
    {
        $doctors = DB::table('sysdb.users')
                        ->where('groupid','=','doctor')
                        ->where('username','!=',Auth::user()->username)
                        ->get();
                        
        return view('chat',compact('doctors'));
    }

    public function show2(Request $request)
    {

        $doctors = DB::table('sysdb.users')
                        ->where('groupid','=','doctor')
                        ->where('username','!=',Auth::user()->username)
                        ->get();

        return view('chat2',compact('doctors'));
    }
}