<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use stdClass;
use Artisan;

class BackupController extends Controller
{	

	function create(){
		$exitCode = Artisan::call('backup:mysql-dump');

		return back();
	}
    
	function view(){
		$storage = Storage::allFiles('public\backups');
		$files = [];

		foreach ($storage as $key => $value) {
    		$obj = new stdClass();
			$filename = substr($value, strrpos($value, "/") + 1);
			$obj->filepath = $value;
			$obj->filename =$filename;
			array_push($files, $obj);   
		}

		return view('backup',compact('files'));
	}

	function download(Request $request){
		return Storage::download($request->filepath);
	}

	function restore(Request $request){

		define('STDIN',fopen("php://stdin","r"));

		$exitCode = Artisan::call('backup:mysql-restore', [
	        '--filename' => $request->filepath, '--yes' => 'default'
	    ]);

		return back();
	}

	function delete(Request $request){
		Storage::delete($request->filepath);

		return back();
	}

}
