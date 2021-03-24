<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use stdClass;
use App\User;
use DB;
use Carbon\Carbon;
use Auth;

class DialysisController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function get_data_dialysis(Request $request){

        switch ($request->action) {
            case 'get_dia_monthly':
                return $this->get_dia_monthly($request);
                break;

            case 'get_dia_weekly':
                return $this->get_dia_weekly($request);
                break;

            case 'get_dia_daily':
                return $this->get_dia_daily($request);
                break;
        }
        
    }

    public function get_dia_monthly(Request $request){
        $carbon = new Carbon($request->date);

        $post = DB::table('dialysis')
                ->whereYear('start_date', '=', $carbon->year)
                ->whereMonth('start_date', '=', $carbon->month)
                ->get();

        $responce = new stdClass();
        $responce->data = $post;
        return json_encode($responce);
    }

    public function get_dia_weekly(Request $request){
        
    }

    public function get_dia_daily(Request $request){
        
    }

    public function save_dialysis(Request $request){

        $table = DB::table('dialysis');

        $array_insert = [
                'mrn'=>$request->mrn,
                'episno'=>$request->episno,
                'start_date'=>Carbon::now("Asia/Kuala_Lumpur")
                ];

        foreach ($_POST as $key => $value) {
            if(!empty($value)){
                $array_insert[$key] = $value;
            }
        }

        try {
            $table->insert($array_insert);

            $responce = new stdClass();
            $responce->success = 'success';
            echo json_encode($responce);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            return response('Error'.$e, 500);
        }
        
    }

}
