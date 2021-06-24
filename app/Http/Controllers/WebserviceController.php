<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use stdClass;
use App\User;
use DB;
use Auth;
use Hash;
use Session;

class WebserviceController extends Controller
{
    public function __construct()
    {

    }

    public function login(Request $request){//http://patientcare.test/webservice/login?page=dialysis&username=farid&dept=webservice
        switch ($request->page) {
            case 'upload':
                $goto = '/emergency';
                break;
            case 'dialysis':
                $goto = '/dialysis';
                break;
            default:
                $goto = '/emergency';
                break;
        }

        if(Auth::check()){
            $this->update_dept($request);
            return redirect($goto)->with('navbar','navbar');//maksudnya hide navbar
        }else{

            $user = User::where('username',request('username'));
            if($user->count() > 0){

                $this->update_dept($request);
                Auth::login($user->first(),false);
                return redirect($goto)->with('navbar','navbar');

            }else{

                $this->create_new_user($request);
                $user = User::where('username',request('username'));
                Auth::login($user->first(),false);
                return redirect($goto)->with('navbar','navbar');

            }
        }
    }

    public function update_dept(Request $request){
        $user = User::where('username',request('username'));
        if(empty($user->dept)){
            DB::table('sysdb.users')
                ->where('username','=',request('username'))
                ->update([
                    'dept' => $request->dept
                ]);
        }
    }

    public function create_new_user(Request $request){
        DB::table('sysdb.users')
            ->insert([
                'username' => $request->username,
                'name' => $request->username,
                'password' => $request->username,
                'dept' => $request->dept
            ]);
    }
    
}
