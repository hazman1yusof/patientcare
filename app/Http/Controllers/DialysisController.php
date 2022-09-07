<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use stdClass;
use App\User;
use DB;
use Carbon\Carbon;
use Auth;
use Session;

class DialysisController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request){ 
        return view('dialysis');
    }

    public function table(Request $request)
    {   
        switch($request->action){
            
            //transaction stuff
            case 'get_transaction_table':
                return $this->get_transaction_table($request);
            case 'get_chgcode':
                return $this->get_chgcode($request);
            case 'get_drugindcode':
                return $this->get_drugindcode($request);
            case 'get_freqcode':
                return $this->get_freqcode($request);
            case 'get_dosecode':
                return $this->get_dosecode($request);
            case 'get_inscode':
                return $this->get_inscode($request);
            case 'get_table_patmedication_trx':
                return $this->get_table_patmedication_trx($request);
            case 'get_table_patmedication':
                return $this->get_table_patmedication($request);

            default:
                return 'error happen..';
        }
    }

    public function form(Request $request)
    {   
        switch($request->action){
            case 'patmedication_save':
                return $this->patmedication_save($request);

            default:
                return 'error happen..';
        }
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
                    // ->where('episno','=',$request->episno)
                    ->whereYear('visit_date', '=', $carbon->year)
                    ->whereMonth('visit_date', '=', $carbon->month)
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
                    ->where('compcode',session('compcode'))
                    ->where('mrn','=',$request->mrn)
                    ->where('episno','=',$request->episno)
                    ->whereBetween('visit_date', [$datefrom, $dateto])
                    ->take(3)
                    ->get();
        }

        $responce = new stdClass();
        $responce->data = $post;
        return json_encode($responce);
    }

    public function get_dia_daily(Request $request){
        $post = [];
        if(!empty($request->idno)){
            $post = DB::table('hisdb.dialysis')
                    ->where('idno','=',$request->idno)
                    ->first();
        }

        $responce = new stdClass();
        $responce->data = $post;
        return json_encode($responce);
    }

    public function save_dialysis(Request $request){

        $table = DB::table('hisdb.dialysis');
        $responce = new stdClass();
        try {

            $visit_date = new Carbon($request->visit_date_post);

            if($request->oper == 'add'){
                $array_insert = [
                    'compcode'=>session('compcode'),
                    'mrn'=>$request->mrn_post,
                    'episno'=>$request->episno_post,
                    'arrivalno'=>$request->arrivalno_post,
                    'visit_date'=>$visit_date
                ];


                $except_post = ['compcode','mrn','episno','arrivalno','visit_date','idno'];

                foreach ($_POST as $key => $value) {
                    if(!in_array($key, $except_post)){
                        if(strlen(trim($value)) > 0){
                            $array_insert[$key] = $value;
                        }
                    }
                }
        
                $idno = $table->insertGetId($array_insert);
                $responce->idno = $idno;
                $responce->arrivalno = $request->arrivalno_post;

            }else if($request->oper == 'edit'){
                if(empty($request->idno_post)){
                    throw new \Exception('Error edit because of no idno', 500);
                }

                $table->where('idno','=',$request->idno_post);

                $array_update = [];

                $except_post = ['compcode','mrn','episno','arrivalno','visit_date','idno'];

                foreach ($_POST as $key => $value) {
                    if(!in_array($key, $except_post)){
                        if(!empty($value)){
                            $array_update[$key] = $value;
                        }
                    }
                }
        
                $table->update($array_update);
            }

            $responce->success = 'success';
            echo json_encode($responce);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            return response('Error'.$e, 500);
        }
        
    }

    public function save_dialysis_completed(Request $request){

        $table = DB::table('hisdb.dialysis');
        try {
            if(empty($request->idno_post)){
                throw new \Exception('Error edit because of no idno', 500);
            }
            
            $table->where('idno','=',$request->idno_post);

            $array_update = [];

            $except_post = ['compcode','mrn','episno','arrivalno','visit_date','idno'];

            foreach ($_POST as $key => $value) {
                if(!in_array($key, $except_post)){
                    if(!empty($value)){
                        $array_update[$key] = $value;
                    }
                }
            }
    
            $table->update($array_update);

            //update dialysis_episode complete
            $dialysis_episode = DB::table('hisdb.dialysis_episode')
                                    ->where('idno',$request->arrivalno_post)
                                    ->where('complete',0);

            if($dialysis_episode->exists()){
                DB::table('hisdb.dialysis_episode')
                    ->where('idno',$request->arrivalno_post)
                    ->update([
                        'complete' => 1
                    ]);
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

            $episode = DB::table('hisdb.episode')
                        ->where('compcode','=',session('compcode'))
                        ->where('mrn','=',$request->mrn)
                        ->where('episno','=',$request->episno)
                        ->first();
                        
            $isudept = $episode->regdept;


            if($chgmast->chggroup == 'HD'){
                //check duplicate dialysis
                $chgtrx = DB::table('hisdb.chargetrx')
                            ->where('mrn','=',$request->mrn)
                            ->where('episno','=',$request->episno)
                            ->where('compcode','=',session('compcode'))
                            ->where('trxdate','=',Carbon::now("Asia/Kuala_Lumpur")->format('Y-m-d'))
                            ->where('chggroup','=','HD');

                if($chgtrx->exists()){
                    throw new \Exception('Patient already have dialysis for date: '.Carbon::parse($request->arrival_date)->format('d-m-Y'), 500);
                }
            }

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
                    'chgtype' =>  $chgmast->chgtype,
                    'instruction' => $request->ins_desc,
                    'doscode' => $request->dos_desc,
                    'frequency' => $request->fre_desc,
                    'drugindicator' => $request->dru_desc,
                    'remarks' => $request->remarks,
                    'billflag' => '0',
                    'quantity' => $request->quantity,
                    'isudept' => $isudept,
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
                        'chggroup' => $chgmast->chggroup,
                        'chgtype' => $chgmast->chgtype,
                        'billflag' => '0',
                        'quantity' => 1,
                        'isudept' => $isudept,
                        'trxtime' => Carbon::now("Asia/Kuala_Lumpur"),
                        'lastuser' => Auth::user()->username,
                        'lastupdate' => Carbon::now("Asia/Kuala_Lumpur")
                    ];

                    $table->insert($array_insert);
                }

                //check utk epo3
                if($chgmast->chggroup == 'HD'){
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
                            'chggroup' => $chgmast->chggroup,
                            'chgtype' => $chgmast->chgtype,
                            'billflag' => '0',
                            'quantity' => 1,
                            'isudept' => $isudept,
                            'trxtime' => Carbon::now("Asia/Kuala_Lumpur"),
                            'lastuser' => Auth::user()->username,
                            'lastupdate' => Carbon::now("Asia/Kuala_Lumpur")
                        ];

                        $table->insert($array_insert);
                    }
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

            return response($e->getMessage(), 500);
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

            return response($e->getMessage(), 500);
        }
    }

    public function save_epis_dialysis(Request $request){
        DB::beginTransaction();
        
        try {
            $table = DB::table('hisdb.dialysis_episode');
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
        
                $latest_idno = $table->insertGetId($array_insert);

                dd($latest_idno);

                DB::table('hisdb.episode')
                        ->where('mrn',$request->mrn)
                        ->where('episno',$request->episno)
                        ->update([
                            'lastarrivalno' => $latest_idno,
                            'lastarrivaldate' => $request->arrival_date,
                            'lastarrivaltime' => $request->arrival_time,
                        ]);

            }else if($request->oper == 'autoadd'){
                //check if date,mrn,episno duplicate
                $dialysis_epis = DB::table('hisdb.dialysis_episode')
                                    ->where('compcode',session('compcode'))
                                    ->where('mrn',$request->mrn)
                                    ->where('episno',$request->episno)
                                    ->whereDate('arrival_date',Carbon::now("Asia/Kuala_Lumpur")->format('Y-m-d'));

                if(!$dialysis_epis->exists()){
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
                        $packagecode = $dialysis_epis_latest->first()->packagecode;
                    }else{
                        $lineno_ = 1;
                        $mcrstat = 0;
                        $hdstat = 0;
                        $packagecode = 'EPO';
                    }

                    $array_insert = [
                        'compcode'=>session('compcode'),
                        'mrn'=>$request->mrn,
                        'episno'=>$request->episno,
                        'lineno_'=>$lineno_,
                        'mcrstat'=>$mcrstat,
                        'hdstat'=>$hdstat,
                        'arrival_date'=>Carbon::now("Asia/Kuala_Lumpur"),
                        'arrival_time'=>Carbon::now("Asia/Kuala_Lumpur"),
                        'packagecode'=>$packagecode,
                        'order'=>0,
                        'complete'=>0
                    ];
            
                    $latest_idno = $table->insertGetId($array_insert);

                    DB::table('hisdb.episode')
                        ->where('mrn',$request->mrn)
                        ->where('episno',$request->episno)
                        ->update([
                            'lastarrivalno' => $latest_idno,
                            'lastarrivaldate' => Carbon::now("Asia/Kuala_Lumpur"),
                            'lastarrivaltime' => Carbon::now("Asia/Kuala_Lumpur")
                        ]);
                }

                
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

        $dialysis_b4 = DB::table('hisdb.dialysis')
                        ->select('idno','visit_date')
                        ->where('mrn',$request->mrn)
                        ->where('episno',$request->episno)
                        ->where('arrivalno','!=',$request->dialysis_episode_idno)
                        ->orderBy('idno','DESC');

        if($dialysis_b4->exists()){
            $datab4 = [];
            foreach ($dialysis_b4->get() as $key => $value) {
                $obj_ = new stdClass();
                $obj_->idno = $value->idno;
                $obj_->visit_date = Carbon::parse($value->visit_date)->format('d-m-Y');
                array_push($datab4,$obj_);
            }
            $responce->datab4 = $datab4;
        }
        
        //check dkt dialysis_episode ada order ke tak
        $dialysis_episode = DB::table('hisdb.dialysis_episode')
                            ->where('idno',$request->dialysis_episode_idno)
                            ->where('order',1);

        $other_data = $this->get_data_for_dialysis(
                                $request->mrn,
                                $request->episno,
                                $request->dialysis_episode_idno);

        $responce->other_data = $other_data;

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
                            ->where('pkgcode','micerra120');
            //                 ->where('chgcode',$request->chg_desc);

            // if($dialysis_pkgdtl->exists()){
            DB::table('hisdb.dialysis_episode')
                ->where('idno',$request->dialysis_episode_idno)
                ->update([
                    'mcrstat' => $mcrstat + 1
                ]);

            $responce->auto = true;
            $responce->chgcode = $dialysis_pkgdtl->first()->epocode;

            return $responce;
            // }
            
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

    public function get_data_for_dialysis($mrn,$episno,$dialysis_episode_idno){
        $responce = new stdClass();

        $episode = DB::table('hisdb.episode')
                    ->where('mrn',$mrn)
                    ->where('episno',$episno)
                    ->first();

        $responce->dry_weight = $episode->dry_weight;
        $responce->duration_hd = $episode->duration_hd;
        $responce->initiated_by = Auth::user()->username;
        $responce->prev_post_weight = 0;
        $responce->last_visit = '';

        $dialysis_episode = DB::table('hisdb.dialysis_episode')
                                ->where('idno',$dialysis_episode_idno)
                                ->first();

        $dialysis = DB::table('hisdb.dialysis')
                        ->where('arrivalno',$dialysis_episode_idno);

        if($dialysis->exists()){
            $dialysis = $dialysis->first();

            $responce->prev_post_weight = $dialysis->post_weight;
            $responce->last_visit = $dialysis->visit_date;

        }else{
            $dialysis = DB::table('hisdb.dialysis')
                                ->where('mrn',$dialysis_episode->mrn)
                                ->where('episno',$dialysis_episode->episno)
                                ->latest('visit_date');

            if($dialysis->exists()){
                $responce->prev_post_weight = $dialysis->first()->post_weight;
                $responce->last_visit = $dialysis->first()->visit_date;
            }
        }

        return $responce;               

    }

    public function verifyuser_dialysis(Request $request){
        $responce = new stdClass();

        $verify = DB::table('sysdb.users')
                    ->where('username',$request->username)
                    ->where('password',$request->password);

        if($verify->exists()){
            $responce->success = 'success';
        }else{
            $responce->success = 'fail';
        }

        echo json_encode($responce); 
    }

    public function get_transaction_table($request){
        if($request->rows == null){
            $request->rows = 100;
        }

        $table_chgtrx = DB::table('hisdb.chargetrx as trx') //ambil dari patmast balik
                            ->select('trx.id',
                                'trx.trxdate',
                                'trx.trxtime',
                                'trx.chgcode as chg_code',
                                'trx.quantity',
                                'trx.remarks',
                                'trx.instruction as ins_code',
                                'trx.doscode as dos_code',
                                'trx.frequency as fre_code',
                                'trx.drugindicator as dru_code',

                                'chgmast.description as chg_desc',
                                'instruction.description as ins_desc',
                                'dose.dosedesc as dos_desc',
                                'freq.freqdesc as fre_desc',
                                'drugindicator.drugindcode as dru_desc')

                            ->where('trx.mrn' ,'=', $request->mrn)
                            ->where('trx.episno' ,'=', $request->episno)
                            ->where('trx.compcode','=',session('compcode'));

        if($request->isudept != 'CLINIC'){
            $table_chgtrx->where('trx.isudept','=',$request->isudept);
        }

        $table_chgtrx = $table_chgtrx
                            ->leftJoin('hisdb.chgmast','chgmast.chgcode','=','trx.chgcode')
                            ->leftJoin('hisdb.instruction','instruction.inscode','=','trx.instruction')
                            ->leftJoin('hisdb.freq','freq.freqcode','=','trx.frequency')
                            ->leftJoin('hisdb.dose','dose.dosecode','=','trx.doscode')
                            ->leftJoin('hisdb.drugindicator','drugindicator.drugindcode','=','trx.drugindicator')
                            ->orderBy('trx.id','desc');

        //////////paginate/////////
        $paginate = $table_chgtrx->paginate($request->rows);

        $responce = new stdClass();
        $responce->page = $paginate->currentPage();
        $responce->total = $paginate->lastPage();
        $responce->records = $paginate->total();
        $responce->rows = $paginate->items();
        $responce->sql = $table_chgtrx->toSql();
        $responce->sql_bind = $table_chgtrx->getBindings();
        return json_encode($responce);

    }

    public function get_chgcode(Request $request){
        $data = DB::table('hisdb.chgmast as cm')
                    ->select('cm.chgcode as code','cm.description as description','cm.doseqty','cm.dosecode','d.dosedesc as dosecode_','cm.freqcode','f.freqdesc as freqcode_','cm.instruction','i.description as instruction_')
                    ->leftJoin('hisdb.dose as d','d.dosecode','=','cm.dosecode')
                    ->leftJoin('hisdb.freq as f','f.freqcode','=','cm.freqcode')
                    ->leftJoin('hisdb.instruction as i','i.inscode','=','cm.instruction')
                    ->whereIn('cm.chggroup',['HD','EP'])
                    ->where('cm.compcode','=',session('compcode'))
                    ->where('cm.active','=',1);

        // if(Session::has('chggroup')){
        //     $data = $data->where('chggroup','=',session('chggroup'));
        // }

        $data = $data->orderBy('chgcode', 'ASC');

        if(!empty($request->search)){
            $data = $data->where('description','LIKE','%'.$request->search.'%')->first();
        }else{
            $data = $data->get();
        }
        
        $responce = new stdClass();
        $responce->data = $data;
        return json_encode($responce);
        
    }

    public function get_drugindcode(Request $request){
        $data = DB::table('hisdb.drugindicator')
                ->select('drugindcode as code','description as description',DB::raw('null as doseqty'),DB::raw('null as dosecode'),DB::raw('null as dosecode_'),DB::raw('null as freqcode'),DB::raw('null as freqcode_'),DB::raw('null as instruction'),DB::raw('null as instruction_'));

        if(!empty($request->search)){
            $data = $data->where('description','LIKE','%'.$request->search.'%')->first();
        }else{
            $data = $data->get();
        }
        
        $responce = new stdClass();
        $responce->data = $data;
        return json_encode($responce);
        
    }

    public function get_freqcode(Request $request){
        $data = DB::table('hisdb.freq')
                ->select('freqcode as code','freqdesc as description',DB::raw('null as doseqty'),DB::raw('null as dosecode'),DB::raw('null as dosecode_'),DB::raw('null as freqcode'),DB::raw('null as freqcode_'),DB::raw('null as instruction'),DB::raw('null as instruction_'))
                ->where('compcode','=',session('compcode'));

        if(!empty($request->search)){
            $data = $data->where('freqdesc','LIKE','%'.$request->search.'%')->first();
        }else{
            $data = $data->get();
        }
        
        $responce = new stdClass();
        $responce->data = $data;
        return json_encode($responce);
        
    }

    public function get_dosecode(Request $request){
        $data = DB::table('hisdb.dose')
                ->select('dosecode as code','dosedesc as description',DB::raw('null as doseqty'),DB::raw('null as dosecode'),DB::raw('null as dosecode_'),DB::raw('null as freqcode'),DB::raw('null as freqcode_'),DB::raw('null as instruction'),DB::raw('null as instruction_'))
                ->where('compcode','=',session('compcode'));

        if(!empty($request->search)){
            $data = $data->where('dosedesc','LIKE','%'.$request->search.'%')->first();
        }else{
            $data = $data->get();
        }
        
        $responce = new stdClass();
        $responce->data = $data;
        return json_encode($responce);
        
    }

    public function get_inscode(Request $request){
        $data = DB::table('hisdb.instruction')
                ->select('inscode as code','description as description',DB::raw('null as doseqty'),DB::raw('null as dosecode'),DB::raw('null as dosecode_'),DB::raw('null as freqcode'),DB::raw('null as freqcode_'),DB::raw('null as instruction'),DB::raw('null as instruction_'))
                ->where('compcode','=',session('compcode'));

        if(!empty($request->search)){
            $data = $data->where('description','LIKE','%'.$request->search.'%')->first();
        }else{
            $data = $data->get();
        }
        
        $responce = new stdClass();
        $responce->data = $data;
        return json_encode($responce);
        
    }

    public function get_table_patmedication_trx(Request $request){

        $table_patmedication_trx = DB::table('hisdb.chargetrx as trx') //ambil dari patmast balik
                            ->select('trx.id',
                                'trx.mrn',
                                'trx.episno',
                                'chgmast.description as chg_desc',
                                'trx.chgcode as chg_code',
                                'trx.quantity',
                                'trx.instruction as ins_code',
                                'trx.doscode as dos_code',
                                'trx.frequency as fre_code',
                                'instruction.description as ins_desc',
                                'dose.dosedesc as dos_desc',
                                'freq.freqdesc as fre_desc')
                            ->leftJoin('hisdb.chgmast','chgmast.chgcode','=','trx.chgcode')
                            ->leftJoin('hisdb.instruction','instruction.inscode','=','trx.instruction')
                            ->leftJoin('hisdb.freq','freq.freqcode','=','trx.frequency')
                            ->leftJoin('hisdb.dose','dose.dosecode','=','trx.doscode')
                            ->where('trx.mrn' ,'=', $request->mrn)
                            ->where('trx.episno' ,'=', $request->episno)
                            ->where('trx.compcode','=',session('compcode'))
                            ->where('trx.chgtype' ,'=', 'EP01')
                            ->whereNull('trx.patmedication')
                            ->whereNull('trx.patmedication')
                            ->whereDate('trx.trxdate',Carbon::now("Asia/Kuala_Lumpur")->format('Y-m-d'))
                            ->orderBy('trx.id','desc');

        $responce = new stdClass();
        $responce->data = $table_patmedication_trx->get();

        return json_encode($responce);
        
    }

    public function get_table_patmedication(Request $request){

        $table_patmedication = DB::table('hisdb.patmedication as ptm') //ambil dari patmast balik
                            ->select('ptm.idno',
                                'ptm.chgcode as chg_code',
                                'chgmast.description as chg_desc',
                                'ptm.enteredby',
                                'ptm.verifiedby',
                                'instruction.description as ins_desc',
                                'dose.dosedesc as dos_desc',
                                'freq.freqdesc as fre_desc',
                                'ptm.qty as quantity',
                                'ptm.idno as status')
                            ->leftJoin('hisdb.chgmast','chgmast.chgcode','=','ptm.chgcode')
                            ->leftJoin('hisdb.instruction','instruction.inscode','=','ptm.instruction')
                            ->leftJoin('hisdb.freq','freq.freqcode','=','ptm.freq')
                            ->leftJoin('hisdb.dose','dose.dosecode','=','ptm.dose')
                            ->where('ptm.mrn' ,'=', $request->mrn)
                            ->where('ptm.episno' ,'=', $request->episno)
                            ->whereDate('ptm.entereddate',Carbon::now("Asia/Kuala_Lumpur")->format('Y-m-d'))
                            ->where('ptm.compcode','=',session('compcode'))
                            ->orderBy('ptm.idno','desc');

        $responce = new stdClass();
        $responce->data = $table_patmedication->get();

        return json_encode($responce);
        
    } 

    public function patmedication_save(Request $request){
        DB::beginTransaction();

        try {
            if($request->oper == 'add'){
                $table = DB::table('hisdb.patmedication');


                $chargetrx = DB::table('hisdb.chargetrx')
                        ->where('id',$request->chgtrx_idno)
                        ->first();

                $array_insert = [
                    'compcode'=>session('compcode'),
                    'mrn'=>$request->mrn,
                    'episno'=>$request->episno,
                    'entereddate'=>Carbon::now("Asia/Kuala_Lumpur"),
                    'enteredtime'=>Carbon::now("Asia/Kuala_Lumpur"),
                    'enteredby'=>session('username'),
                    'adduser'=>session('username'),
                    'adddate'=>Carbon::now("Asia/Kuala_Lumpur"),
                    'qty'=>$chargetrx->quantity,
                    'verifiedby'=>$request->verifiedby,
                    'dose'=>$chargetrx->doscode,
                    'freq'=>$chargetrx->frequency,
                    'instruction'=>$chargetrx->instruction,
                    'chgcode'=>$chargetrx->chgcode
                ];
        
                $table->insert($array_insert);

                DB::table('hisdb.chargetrx')
                        ->where('id',$request->chgtrx_idno)
                        ->update([
                            'patmedication' => '1'
                        ]);

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



}
