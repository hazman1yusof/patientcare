<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use stdClass;
use DB;
use File;
use Carbon\Carbon;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Storage;

class MycardController extends Controller
{   

    public function __construct()
    {
    }

    public function mykadFP(Request $request)
    {  
        return view('hisdb.mykadfp.mykadfp');
    }

    public function mykadfp_store(Request $request){

        $company = DB::table('sysdb.company')
                    ->where('compcode',session('compcode'))
                    ->first();

        $path_txt = $company->mykadfolder."\mykad".Carbon::now("Asia/Kuala_Lumpur")->format('Y-m-d').'.txt';
        $path_img = $company->mykadfolder."\myphoto\\".$request->icnum.".png";

        $myfile = fopen($path_txt, "a") or die("Unable to open file!");

        $text = $request->name.'|'.$request->icnum.'|'.$request->gender.'|'.$request->dob.'|'.$request->birthplace.'|'.$request->race.'|'.$request->religion.'|'.$request->address1.'|'.$request->address2.'|'.$request->address3.'|'.$request->city.'|'.$request->state.'|'.$request->postcode;

        fwrite($myfile, "\n".$text);
        fclose($myfile);


        $img = base64_decode($request->base64);
        file_put_contents($path_img, $img);
    }

    public function get_mykad_local(Request $request){
        $responce = new stdClass();
        $pre_pat_mast = DB::table('hisdb.pre_pat_mast')
                        ->where('CompCode',session('compcode'))
                        ->where('rng',$request->rng);

        if($pre_pat_mast->exists()){
            $responce->exists = true;

            $pat_mast = DB::table('hisdb.pat_mast')
                        ->where('CompCode',session('compcode'))
                        ->where('Newic',$pre_pat_mast->first()->Newic);

            if($pat_mast->exists()){
                $responce->pm_exists = true;
                $responce->data = $pat_mast->first();
            }else{
                $responce->pm_exists = false;
                $responce->data = $pre_pat_mast->first();
            }

        }else{
            $responce->exists = false;
        }

        $pre_pat_mast->delete();
        echo json_encode($responce);
    }

    public function save_mykad_local(Request $request){
        DB::table('hisdb.pre_pat_mast')
                ->insert([
                    'CompCode' => $request->CompCode,
                    'Newic' => $request->Newic,
                    'DOB' => $request->DOB,
                    'Name' => $request->Name,
                    'Religion' => $request->Religion,
                    'Sex' => $request->Sex,
                    'RaceCode' => $request->RaceCode,
                    'Address1' => $request->Address1,
                    'Address2' => $request->Address2,
                    'Address3' => $request->Address3,
                    'Postcode' => $request->Postcode,
                    'Citizencode' => $request->Citizencode,
                    'ID_Type' => 'O',
                    'PatientImage' => $request->PatientImage,
                    'rng' => $request->rng,
                    'read_date' => Carbon::now("Asia/Kuala_Lumpur")
                ]);
    }

}