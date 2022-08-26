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

    public function index(Request $request){ 
        // dd(Auth::user());

        // $navbar = $this->navbar();

        // // $emergency = DB::table('episode')
        // //                 ->whereMonth('reg_date', '=', now()->month)
        // //                 ->get();

        // // $events = $this->getEvent($emergency);

        // if(!empty($request->username)){
        //     $user = DB::table('users')
        //             ->where('username','=',$request->username);
        //     if($user->exists()){
        //         $user = User::where('username',$request->username);
        //         Auth::login($user->first());
        //     }
        // }
        return view('dialysis');
    }

    public function dialysis_event(Request $request){
        $emergency = DB::table('hisdb.episode')
                        ->whereRaw(
                          "(reg_date >= ? AND reg_date <= ?)", 
                          [
                             $request->start, 
                             $request->end
                         ])->get();
        
        $events = [];

        for ($i=1; $i <= 31; $i++) {
            $days = 0;
            $reg_date;
            foreach ($emergency as $key => $value) {
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
        $post = [];
        if(!empty($request->date)){
            $carbon = new Carbon($request->date);

            $post = DB::table('hisdb.dialysis')
                    ->where('mrn','=',$request->mrn)
                    ->whereYear('start_date', '=', $carbon->year)
                    ->whereMonth('start_date', '=', $carbon->month)
                    ->get();
        }

        $responce = new stdClass();
        $responce->data = $post;
        return json_encode($responce);
    }

    public function get_dia_weekly(Request $request){
        $post = [];
        if(!empty($request->datefrom)){
            $datefrom = new Carbon($request->datefrom);
            $dateto = new Carbon($request->dateto);

            $post = DB::table('hisdb.dialysis')
                    ->where('mrn','=',$request->mrn)
                    ->whereBetween('start_date', [$datefrom, $dateto])
                    ->take(3)
                    ->get();
        }

        $responce = new stdClass();
        $responce->data = $post;
        return json_encode($responce);
    }

    public function get_dia_daily(Request $request){
        $post = [];
        if(!empty($request->date)){
            $carbon = new Carbon($request->date);

            $post = DB::table('hisdb.dialysis')
                    ->where('mrn','=',$request->mrn)
                    ->whereDate('start_date', '=', $carbon)
                    ->get();
        }

        $responce = new stdClass();
        $responce->data = $post;
        return json_encode($responce);
    }

    public function save_dialysis(Request $request){

        $table = DB::table('hisdb.dialysis');
        try {
            if($request->oper == 'add'){
                $array_insert = [
                    'mrn'=>$request->mrn,
                    'episno'=>$request->episno,
                    'start_date'=>new Carbon($request->seldate)
                ];

                foreach ($_POST as $key => $value) {
                    if(!empty($value)){
                        $array_insert[$key] = $value;
                    }
                }
        
                $table->insert($array_insert);

            }else if($request->oper == 'edit'){
                $table
                    ->where('mrn','=',$request->mrn)
                    ->where('episno','=',$request->episno);

                $array_update = [];

                foreach ($_POST as $key => $value) {
                    if(!empty($value)){
                        $array_update[$key] = $value;
                    }
                }
        
                $table->update($array_update);
            }

            $responce = new stdClass();
            $responce->success = 'success';
            echo json_encode($responce);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            return response('Error'.$e, 500);
        }
        
    }

    public function dialysis_transaction_save(Request $request){

        DB::beginTransaction();
        try {
            $table = DB::table('hisdb.chargetrx');

            $chgmast = DB::table('hisdb.chgmast')
                        ->where('compcode','=',session('compcode'))
                        ->where('chgcode','=',$request->chg_desc)
                        ->first();

            if($request->oper == 'edit'){
                $table->where('mrn','=',$request->mrn)
                        ->where('episno','=',$request->episno)
                        ->where('id','=',$request->id);

                $array_edit = [
                    'chgcode' => $request->chg_desc,
                    'chggroup' =>  $chgmast->chggroup,
                    'quantity' => $request->quantity,
                    'instruction' => $request->ins_desc,
                    'doscode' => $request->dos_desc,
                    'frequency' => $request->fre_desc,
                    'drugindicator' => $request->dru_desc,
                    'remarks' => $request->remarks,
                    'lastuser' => Auth::user()->username,
                    'lastupdate' => Carbon::now("Asia/Kuala_Lumpur")
                ];

                $table->update($array_edit);
            }else if($request->oper == 'add'){

                $array_insert = [
                    'compcode' => session('compcode'),
                    'mrn' => $request->mrn,
                    'episno' => $request->episno,
                    'trxtype' => 'OE',
                    'trxdate' => Carbon::now("Asia/Kuala_Lumpur"),
                    'chgcode' => $request->chg_desc,
                    'chggroup' =>  $chgmast->chggroup,
                    'instruction' => $request->ins_desc,
                    'doscode' => $request->dos_desc,
                    'frequency' => $request->fre_desc,
                    'drugindicator' => $request->dru_desc,
                    'remarks' => $request->remarks,
                    'billflag' => '0',
                    'quantity' => $request->quantity,
                    'isudept' => $request->isudept,
                    'trxtime' => Carbon::now("Asia/Kuala_Lumpur"),
                    'lastuser' => Auth::user()->username,
                    'lastupdate' => Carbon::now("Asia/Kuala_Lumpur")
                ];

                $table->insert($array_insert);

                //check utk hd1 hd2
                $check_hd = $this->check_hd($request);
                if($check_hd->auto == true){

                    $chgmast = DB::table('hisdb.chgmast')
                        ->where('compcode','=',session('compcode'))
                        ->where('chgcode','=',$check_hd->chgcode)
                        ->first();

                    $array_insert = [
                        'compcode' => session('compcode'),
                        'mrn' => $request->mrn,
                        'episno' => $request->episno,
                        'trxtype' => 'OE',
                        'trxdate' => Carbon::now("Asia/Kuala_Lumpur"),
                        'chgcode' => $check_hd->chgcode,
                        'chggroup' =>  $chgmast->chggroup,
                        'billflag' => '0',
                        'quantity' => 1,
                        'isudept' => $request->isudept,
                        'trxtime' => Carbon::now("Asia/Kuala_Lumpur"),
                        'lastuser' => Auth::user()->username,
                        'lastupdate' => Carbon::now("Asia/Kuala_Lumpur")
                    ];

                    $table->insert($array_insert);
                }

                //check utk epo3
                $check_mcr = $this->check_mcr($request);
                if($check_mcr->auto == true){

                    $chgmast = DB::table('hisdb.chgmast')
                        ->where('compcode','=',session('compcode'))
                        ->where('chgcode','=',$check_mcr->chgcode)
                        ->first();

                    $array_insert = [
                        'compcode' => session('compcode'),
                        'mrn' => $request->mrn,
                        'episno' => $request->episno,
                        'trxtype' => 'OE',
                        'trxdate' => Carbon::now("Asia/Kuala_Lumpur"),
                        'chgcode' => $check_mcr->chgcode,
                        'chggroup' =>  $chgmast->chggroup,
                        'billflag' => '0',
                        'quantity' => 1,
                        'isudept' => $request->isudept,
                        'trxtime' => Carbon::now("Asia/Kuala_Lumpur"),
                        'lastuser' => Auth::user()->username,
                        'lastupdate' => Carbon::now("Asia/Kuala_Lumpur")
                    ];

                    $table->insert($array_insert);
                }

                $this->updateorder($request);

            }else if($request->oper == 'del'){
                $table->where('mrn','=',$request->mrn)
                        ->where('episno','=',$request->episno)
                        ->where('id','=',$request->id)->delete();
            }
        
            $responce = new stdClass();
            $responce->success = 'success';
            echo json_encode($responce);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            return response('Error'.$e, 500);
        }
    }

    public function change_status(Request $request){
        try {
            $table = DB::table('hisdb.episode')
                        ->where('mrn','=',$request->mrn)
                        ->where('episno','=',$request->episno)
                        ->update([
                            'ordercomplete' => 1,
                        ]);
            

            $responce = new stdClass();
            $responce->success = 'success';
            echo json_encode($responce);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            return response('Error'.$e, 500);
        }
    }

    public function save_epis_dialysis(Request $request){
        $table = DB::table('hisdb.dialysis_episode');
        try {
            if($request->oper == 'add'){

                //check if date,mrn,episno duplicate
                $dialysis_epis = DB::table('hisdb.dialysis_episode')
                                    ->where('compcode',session('compcode'))
                                    ->where('mrn',$request->mrn)
                                    ->where('episno',$request->episno)
                                    ->whereDate('arrival_date',$request->arrival_date);


                if($dialysis_epis->exists()){
                    throw new \Exception('Patient already arrive for date: '.Carbon::parse($request->arrival_date)->format('d-m-Y'), 500);
                }

                $dialysis_epis = DB::table('hisdb.dialysis_episode')
                                    ->where('compcode',session('compcode'))
                                    ->where('mrn',$request->mrn)
                                    ->where('episno',$request->episno);

                if($dialysis_epis->exists()){
                    $lineno_ = intval($dialysis_epis->max('lineno_')) + 1;

                    $dialysis_epis_latest = DB::table('hisdb.dialysis_episode')
                                    ->where('compcode',session('compcode'))
                                    ->where('mrn',$request->mrn)
                                    ->where('episno',$request->episno)
                                    ->where('lineno_',intval($dialysis_epis->max('lineno_')));

                    $mcrstat = $dialysis_epis_latest->first()->mcrstat;
                    $hdstat = $dialysis_epis_latest->first()->hdstat;
                }else{
                    $lineno_ = 1;
                    $mcrstat = 0;
                    $hdstat = 0;
                }

                $array_insert = [
                    'compcode'=>session('compcode'),
                    'mrn'=>$request->mrn,
                    'episno'=>$request->episno,
                    'lineno_'=>$lineno_,
                    'mcrstat'=>$mcrstat,
                    'hdstat'=>$hdstat,
                    'arrival_date'=>$request->arrival_date,
                    'arrival_time'=>$request->arrival_time,
                    'packagecode'=>$request->packagecode,
                    'order'=>0,
                    'complete'=>0
                ];
        
                $table->insert($array_insert);

            }else if($request->oper == 'edit'){
                $table
                    ->where('idno','=',$request->idno);

                $array_update = [
                    'packagecode'=>$request->packagecode,
                    'arrival_date'=>$request->arrival_date,
                    'arrival_time'=>$request->arrival_time,
                ];
        
                $table->update($array_update);
            }

            $responce = new stdClass();
            $responce->success = 'success';
            echo json_encode($responce);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            return response($e->getMessage(), 500);
        }
    }

    public function check_pt_mode(Request $request){

        $responce = new stdClass();
        
        //check dkt dialysis_episode ada order ke tak
        $dialysis_episode = DB::table('hisdb.dialysis_episode')
                            ->where('idno',$request->dialysis_episode_idno)
                            ->where('order',1);


        if($dialysis_episode->exists()){
            //check dkt dialysis ada data ke tak hari tu
            $dialysis = DB::table('hisdb.dialysis')
                            ->where('arrivalno',$request->dialysis_episode_idno);
                            
            if($dialysis->exists()){
                //populate data hari tu
                $responce->mode = 'edit';
                $responce->data = $dialysis->first();

            }else{
                //add new dialysis daily
                $responce->mode = 'add';
            }

        }else{
            //kalu xde order xboleh add dialysis daily
            $responce->mode = 'disableAll';
        }


        echo json_encode($responce); 
    }

    public static function mydump($obj,$line='null'){
        dd([
            $line,
            $obj->toSql(),
            $obj->getBindings()
        ]);

    }

    public function updateorder(Request $request){
        //update dialysis_episode charges
        $dialysis_episode = DB::table('hisdb.dialysis_episode')
                                ->where('idno',$request->dialysis_episode_idno)
                                ->where('order',0);

        if($dialysis_episode->exists()){
            DB::table('hisdb.dialysis_episode')
                ->where('idno',$request->dialysis_episode_idno)
                ->update([
                    'order' => 1
                ]);
        }
    }

    public function check_hd(Request $request){
        $responce = new stdClass();      

        $dialysis_episode = DB::table('hisdb.dialysis_episode')
                            ->where('idno',$request->dialysis_episode_idno)
                            ->first();  

        //check ada dlm case
        $dialysis_pkgdtl = DB::table('hisdb.dialysis_pkgdtl')
                            ->where('pkgcode','EPO')
                            ->where('chgcode',$request->chg_desc);

        if($dialysis_pkgdtl->exists()){

            if($dialysis_episode->hdstat == 0){

                DB::table('hisdb.dialysis_episode')
                    ->where('idno',$request->dialysis_episode_idno)
                    ->update([
                        'hdstat' => 1
                    ]);

                $responce->auto = true;
                $responce->chgcode = $dialysis_pkgdtl->first()->epocode;

                return $responce;

            }
        }

        $responce->auto = false;
        return $responce;

    }


    public function check_mcr(Request $request){
        $responce = new stdClass();

        $dialysis_episode = DB::table('hisdb.dialysis_episode')
                                ->where('idno',$request->dialysis_episode_idno)
                                ->first();

        $mcrstat = $dialysis_episode->mcrstat;

        if(1<=$mcrstat && $mcrstat<5 ){

            $dialysis_pkgdtl = DB::table('hisdb.dialysis_pkgdtl')
                            ->where('pkgcode',$dialysis_episode->packagecode);

            DB::table('hisdb.dialysis_episode')
                    ->where('idno',$request->dialysis_episode_idno)
                    ->update([
                        'mcrstat' => $mcrstat + 1
                    ]);

            $responce->auto = true;
            $responce->chgcode = $dialysis_pkgdtl->first()->epocode;

            return $responce;

        }else if($mcrstat == 0){

            //check ada dlm case
            $dialysis_pkgdtl = DB::table('hisdb.dialysis_pkgdtl')
                            ->where('pkgcode','micerra120')
                            ->where('chgcode',$request->chg_desc);

            if($dialysis_pkgdtl->exists()){

                DB::table('hisdb.dialysis_episode')
                    ->where('idno',$request->dialysis_episode_idno)
                    ->update([
                        'mcrstat' => 1
                    ]);

                $responce->auto = false;
                return $responce;
                
            }

        }

        $responce->auto = false;
        return $responce;
    }

}
