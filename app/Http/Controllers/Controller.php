<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function navbar(){//guna table id, tak fixpost
    	$navbar = DB::table('sysdb.programtab')
    					->where('programmenu','=','patient')
    					->get();
    	return $navbar;
    }

}
