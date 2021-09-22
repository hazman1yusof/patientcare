<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use stdClass;
use App\User;
use DB;
use Carbon\Carbon;
use Auth;

class DoctornoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function table(Request $request)
    {   
        switch($request->action){
            case 'get_table_date_curr':          // for current
                return $this->get_table_date_curr($request);
            case 'get_table_date_past':     // for past history
                return $this->get_table_date_past($request);
            case 'get_table_doctornote':
                return $this->get_table_doctornote($request);
            case 'get_table_doctornote_div':
                return $this->get_table_doctornote_div($request);
            case 'dialog_icd':
                return $this->dialog_icd($request);

            default:
                return 'error happen..';
        }
    }


    public function form(Request $request)
    {   
        DB::enableQueryLog();
        switch($request->action){
            case 'save_table_doctornote':

                switch($request->oper){
                    case 'add':
                        return $this->add($request);
                    case 'edit':
                        return $this->edit($request);
                    default:
                        return 'error happen..';
                }

            case 'doctornote_save':
                return $this->add_notes($request);

            default:
                return 'error happen..';
        }
    }

    public function index(Request $request){ 
        // dd(Auth::user());

        // $navbar = $this->navbar();

        $emergency = DB::table('hisdb.episode')
                        ->whereMonth('reg_date', '=', now()->month)
                        ->whereYear('reg_date', '=', now()->year)
                        ->get();

        $events = $this->getEvent($emergency);

        if(!empty($request->username)){
            $user = DB::table('users')
                    ->where('username','=',$request->username);
            if($user->exists()){
                $user = User::where('username',$request->username);
                Auth::login($user->first());
            }
        }
        return view('doctornote',compact('events'));
    }

    public function get_table_doctornote($request){
        $table_patm = DB::table('hisdb.pat_mast') //ambil dari patmast balik
                ->select(['pat_mast.idno','pat_mast.CompCode','episode.MRN','episode.Episno','pat_mast.Name','pat_mast.Call_Name','pat_mast.addtype','pat_mast.Address1','pat_mast.Address2','pat_mast.Address3','pat_mast.Postcode','pat_mast.citycode','pat_mast.AreaCode','pat_mast.StateCode','pat_mast.CountryCode','pat_mast.telh','pat_mast.telhp','pat_mast.telo','pat_mast.Tel_O_Ext','pat_mast.ptel','pat_mast.ptel_hp','pat_mast.ID_Type','pat_mast.idnumber','pat_mast.Newic','pat_mast.Oldic','pat_mast.icolor','pat_mast.Sex','pat_mast.DOB','pat_mast.Religion','pat_mast.AllergyCode1','pat_mast.AllergyCode2','pat_mast.Century','pat_mast.Citizencode','pat_mast.OccupCode','pat_mast.Staffid','pat_mast.MaritalCode','pat_mast.LanguageCode','pat_mast.TitleCode','pat_mast.RaceCode','pat_mast.bloodgrp','pat_mast.Accum_chg','pat_mast.Accum_Paid','pat_mast.first_visit_date','pat_mast.Reg_Date','pat_mast.last_visit_date','pat_mast.last_episno','pat_mast.PatStatus','pat_mast.Confidential','pat_mast.Active','pat_mast.FirstIpEpisNo','pat_mast.FirstOpEpisNo','pat_mast.AddUser','pat_mast.AddDate','pat_mast.Lastupdate','pat_mast.LastUser','pat_mast.OffAdd1','pat_mast.OffAdd2','pat_mast.OffAdd3','pat_mast.OffPostcode','pat_mast.MRFolder','pat_mast.MRLoc','pat_mast.MRActive','pat_mast.OldMrn','pat_mast.NewMrn','pat_mast.Remarks','pat_mast.RelateCode','pat_mast.ChildNo','pat_mast.CorpComp','pat_mast.Email','pat_mast.Email_official','pat_mast.CurrentEpis','pat_mast.NameSndx','pat_mast.BirthPlace','pat_mast.TngID','pat_mast.PatientImage','pat_mast.pAdd1','pat_mast.pAdd2','pat_mast.pAdd3','pat_mast.pPostCode','pat_mast.DeptCode','pat_mast.DeceasedDate','pat_mast.PatientCat','pat_mast.PatType','pat_mast.PatClass','pat_mast.upduser','pat_mast.upddate','pat_mast.recstatus','pat_mast.loginid','pat_mast.pat_category','pat_mast.idnumber_exp','episode.reg_time','episode.payer'])
                ->leftJoin('hisdb.episode','episode.mrn','=','pat_mast.MRN')
                ->where('episode.reg_date' ,'=', $request->filterVal[0]);

        //////////paginate/////////
        $paginate = $table_patm->paginate($request->rows);

        $responce = new stdClass();
        $responce->page = $paginate->currentPage();
        $responce->total = $paginate->lastPage();
        $responce->records = $paginate->total();
        $responce->rows = $paginate->items();
        $responce->sql = $table_patm->toSql();
        $responce->sql_bind = $table_patm->getBindings();
        return json_encode($responce);

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

    public function transaction_save(Request $request){
        try {
            $table = DB::table('hisdb.chargetrx');

            if($request->oper == 'edit'){
                $table->where('mrn','=',$request->mrn)
                        ->where('episno','=',$request->episno)
                        ->where('auditno','=',$request->t_auditno);

                $array_edit = [
                    'chgcode' => $request->t_chgcode,
                    'quantity' => $request->t_quantity,
                    'lastuser' => Auth::user()->username,
                    'lastupdate' => Carbon::now("Asia/Kuala_Lumpur")
                ];

                $table->update($array_edit);
            }else{
                $array_insert = [
                    'compcode' => '9A',
                    'mrn' => $request->mrn,
                    'episno' => $request->episno,
                    'trxtype' => 'OE',
                    'trxdate' => $request->trxdate,
                    'chgcode' => $request->t_chgcode,
                    'billflag' => '0',
                    'isudept' => $request->isudept,
                    'quantity' => $request->t_quantity,
                    'trxtime' => Carbon::now("Asia/Kuala_Lumpur"),
                    'lastuser' => Auth::user()->username,
                    'lastupdate' => Carbon::now("Asia/Kuala_Lumpur")
                ];

                $table->insert($array_insert);
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


    public function add(Request $request){

        DB::beginTransaction();

        try {

            DB::table('hisdb.episode')
                ->where('mrn','=',$request->mrn_doctorNote)
                ->where('episno','=',$request->episno_doctorNote)
                // ->where('compcode','=',session('compcode'))
                ->update([
                    'remarks' => $request->remarks,
                    'diagfinal' => $request->diagfinal,
                    'lastuser'  => session('username'),
                    'lastupdate'  => Carbon::now("Asia/Kuala_Lumpur")->toDateString(),
                ]);

            DB::table('hisdb.patexam')
                    ->insert([
                        // 'compcode' => session('compcode'),
                        'mrn' => $request->mrn_doctorNote,
                        'episno' => $request->episno_doctorNote,
                        'examination' => $request->examination,
                        'adduser'  => session('username'),
                        'adddate'  => Carbon::now("Asia/Kuala_Lumpur")->toDateString(),
                        'lastuser'  => session('username'),
                        'lastupdate'  => Carbon::now("Asia/Kuala_Lumpur")->toDateString(),
                        'recorddate' => Carbon::now("Asia/Kuala_Lumpur"),
                        'recordtime' => Carbon::now("Asia/Kuala_Lumpur"),
                    ]);

            DB::table('hisdb.pathealth')
                    ->insert([
                        // 'compcode' => session('compcode'),
                        'mrn' => $request->mrn_doctorNote,
                        'episno' => $request->episno_doctorNote,
                        'clinicnote' => $request->clinicnote,
                        'followuptime' => $request->followuptime,
                        'followupdate' => $request->followupdate,
                        'plan_' => $request->plan_,
                        'height' => $request->height,
                        'weight' => $request->weight,
                        'bp_sys1' => $request->bp_sys1,
                        'bp_dias2' => $request->bp_dias2,
                        'pulse' => $request->pulse,
                        'temperature' => $request->temperature,
                        'respiration' => $request->respiration,
                        'adduser'  => session('username'),
                        'adddate'  => Carbon::now("Asia/Kuala_Lumpur")->toDateString(),
                        'lastuser'  => session('username'),
                        'lastupdate'  => Carbon::now("Asia/Kuala_Lumpur")->toDateString(),
                        'recordtime' => Carbon::now("Asia/Kuala_Lumpur"),
                    ]);

            DB::table('hisdb.pathistory')
                    ->insert([
                        // 'compcode' => session('compcode'),
                        'mrn' => $request->mrn_doctorNote,
                        'pmh' => $request->pmh,
                        'drugh' => $request->drugh,
                        'allergyh' => $request->allergyh,
                        'socialh' => $request->socialh,
                        'fmh' => $request->fmh,
                        'adduser'  => session('username'),
                        'adddate'  => Carbon::now("Asia/Kuala_Lumpur")->toDateString(),
                        'lastuser'  => session('username'),
                        'lastupdate'  => Carbon::now("Asia/Kuala_Lumpur")->toDateString(),
                        'recorddate' => Carbon::now("Asia/Kuala_Lumpur"),
                        'recordtime' => Carbon::now("Asia/Kuala_Lumpur"),
                    ]);

            DB::table('hisdb.episdiag')
                    ->insert([
                        // 'compcode' => session('compcode'),
                        'mrn' => $request->mrn_doctorNote,
                        'episno' => $request->episno_doctorNote,
                        'icdcode' => $request->icdcode,
                        'adduser'  => session('username'),
                        'adddate'  => Carbon::now("Asia/Kuala_Lumpur")->toDateString(),
                    ]);

            $queries = DB::getQueryLog();
            dump($queries);

            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();

            return response('Error DB rollback!'.$e, 500);
        }
    }

    public function edit(Request $request){

        DB::beginTransaction();

        try {

            DB::table('hisdb.episode')
                ->where('mrn','=',$request->mrn_doctorNote)
                ->where('episno','=',$request->episno_doctorNote)
                ->where('compcode','=',session('compcode'))
                ->update([
                    'remarks' => $request->remarks,
                    'diagfinal' => $request->diagfinal,
                    'lastuser'  => session('username'),
                    'lastupdate'  => Carbon::now("Asia/Kuala_Lumpur")->toDateString(),
                ]);

            DB::table('hisdb.pathealthadd')
                ->insert([
                    'compcode' => session('compcode'),
                    'mrn' => $request->mrn_doctorNote,
                    'episno' => $request->episno_doctorNote,
                    'additionalnote' => $request->additionalnote,
                ]);

            $patexam = DB::table('hisdb.patexam')
                ->where('mrn','=',$request->mrn_doctorNote)
                ->where('episno','=',$request->episno_doctorNote)
                ->where('recorddate','=',$request->recorddate)
                ->where('compcode','=',session('compcode'));

            $pathealth = DB::table('hisdb.pathealth')
                ->where('mrn','=',$request->mrn_doctorNote)
                ->where('episno','=',$request->episno_doctorNote)
                ->where('recordtime','=',$request->recordtime)
                ->where('compcode','=',session('compcode'));

            $pathistory = DB::table('hisdb.pathistory')
                ->where('mrn','=',$request->mrn_doctorNote)
                ->where('recorddate','=',$request->recorddate)
                ->where('compcode','=',session('compcode'));

            $episdiag = DB::table('hisdb.episdiag')
                ->where('mrn','=',$request->mrn_doctorNote)
                ->where('episno','=',$request->episno_doctorNote)
                ->where('compcode','=',session('compcode'));

            if($patexam->exists()){
                $patexam->update([
                        'examination' => $request->examination,
                        'lastuser'  => session('username'),
                        'lastupdate'  => Carbon::now("Asia/Kuala_Lumpur")->toDateString(),
                    ]);
            }else{
                DB::table('hisdb.patexam')
                    ->insert([
                        'compcode' => session('compcode'),
                        'mrn' => $request->mrn_doctorNote,
                        'episno' => $request->episno_doctorNote,
                        'examination' => $request->examination,
                        'adduser'  => session('username'),
                        'adddate'  => Carbon::now("Asia/Kuala_Lumpur")->toDateString(),
                        'lastuser'  => session('username'),
                        'lastupdate'  => Carbon::now("Asia/Kuala_Lumpur")->toDateString(),
                        'recorddate' => Carbon::now("Asia/Kuala_Lumpur"),
                        'recordtime' => Carbon::now("Asia/Kuala_Lumpur"),
                    ]);
            }

            if($pathealth->exists()){
                $pathealth
                    ->update([
                        'compcode' => session('compcode'),
                        'mrn' => $request->mrn_doctorNote,
                        'episno' => $request->episno_doctorNote,
                        'clinicnote' => $request->clinicnote,
                        'pmh' => $request->pmh,
                        'drugh' => $request->drugh,
                        'allergyh' => $request->allergyh,
                        'socialh' => $request->socialh,
                        'fmh' => $request->fmh,
                        'followuptime' => $request->followuptime,
                        'followupdate' => $request->followupdate,
                        'plan_' => $request->plan_,
                        'height' => $request->height,
                        'weight' => $request->weight,
                        'bp_sys1' => $request->bp_sys1,
                        'bp_dias2' => $request->bp_dias2,
                        'pulse' => $request->pulse,
                        'temperature' => $request->temperature,
                        'respiration' => $request->respiration,
                        'adduser'  => session('username'),
                        'adddate'  => Carbon::now("Asia/Kuala_Lumpur")->toDateString(),
                        'lastuser'  => session('username'),
                        'lastupdate'  => Carbon::now("Asia/Kuala_Lumpur")->toDateString(),
                        'recordtime' => Carbon::now("Asia/Kuala_Lumpur"),
                    ]);
            }else{
                DB::table('hisdb.pathealth')
                    ->insert([
                        'compcode' => session('compcode'),
                        'mrn' => $request->mrn_doctorNote,
                        'episno' => $request->episno_doctorNote,
                        'clinicnote' => $request->clinicnote,
                        'pmh' => $request->pmh,
                        'drugh' => $request->drugh,
                        'allergyh' => $request->allergyh,
                        'socialh' => $request->socialh,
                        'fmh' => $request->fmh,
                        'followuptime' => $request->followuptime,
                        'followupdate' => $request->followupdate,
                        'plan_' => $request->plan_,
                        'height' => $request->height,
                        'weight' => $request->weight,
                        'bp_sys1' => $request->bp_sys1,
                        'bp_dias2' => $request->bp_dias2,
                        'pulse' => $request->pulse,
                        'temperature' => $request->temperature,
                        'respiration' => $request->respiration,
                        'adduser'  => session('username'),
                        'adddate'  => Carbon::now("Asia/Kuala_Lumpur")->toDateString(),
                        'lastuser'  => session('username'),
                        'lastupdate'  => Carbon::now("Asia/Kuala_Lumpur")->toDateString(),
                        'recordtime' => Carbon::now("Asia/Kuala_Lumpur"),
                    ]);
            }

            if($pathistory->exists()){
                $pathistory
                    ->update([
                        'pmh' => $request->pmh,
                        'drugh' => $request->drugh,
                        'allergyh' => $request->allergyh,
                        'socialh' => $request->socialh,
                        'fmh' => $request->fmh,
                        'lastuser'  => session('username'),
                        'lastupdate'  => Carbon::now("Asia/Kuala_Lumpur")->toDateString(),
                    ]);
            }else{
                DB::table('hisdb.pathistory')
                    ->insert([
                        'compcode' => session('compcode'),
                        'mrn' => $request->mrn_doctorNote,
                        'pmh' => $request->pmh,
                        'drugh' => $request->drugh,
                        'allergyh' => $request->allergyh,
                        'socialh' => $request->socialh,
                        'fmh' => $request->fmh,
                        'adduser'  => session('username'),
                        'adddate'  => Carbon::now("Asia/Kuala_Lumpur")->toDateString(),
                        'lastuser'  => session('username'),
                        'lastupdate'  => Carbon::now("Asia/Kuala_Lumpur")->toDateString(),
                        'recorddate' => Carbon::now("Asia/Kuala_Lumpur"),
                        'recordtime' => Carbon::now("Asia/Kuala_Lumpur"),
                    ]);
            }

            if($episdiag->exists()){
                $episdiag
                    ->update([
                        'icdcode' => $request->icdcode,
                    ]);
            }else{
                DB::table('hisdb.episdiag')
                    ->insert([
                        'compcode' => session('compcode'),
                        'mrn' => $request->mrn_doctorNote,
                        'episno' => $request->episno_doctorNote,
                        'icdcode' => $request->icdcode,
                        'adduser'  => session('username'),
                        'adddate'  => Carbon::now("Asia/Kuala_Lumpur")->toDateString(),
                    ]);
            }

            $queries = DB::getQueryLog();
            dump($queries);
            
            DB::commit();

            $patexam_obj = DB::table('hisdb.patexam')
                ->select('idno','recorddate AS date')
                ->where('mrn','=',$request->mrn_doctorNote)
                ->where('episno','=',$request->episno_doctorNote)
                ->where('recorddate','=',$request->recorddate)
                ->where('compcode','=',session('compcode'))
                ->first();


            $responce = new stdClass();
            $responce->idno = $patexam_obj->idno;
            $responce->date = $patexam_obj->date;

            return json_encode($responce);


        } catch (\Exception $e) {
            DB::rollback();

            return response('Error DB rollback!'.$e, 500);
        }
    }

    public function get_table_date_curr(Request $request){

        $responce = new stdClass();

        $patexam_obj = DB::table('hisdb.patexam')
            ->select('idno','recorddate AS date','adduser')
            ->where('mrn','=',$request->mrn)
            ->where('episno','=',$request->episno);

        if($patexam_obj->exists()){
            $patexam_obj = $patexam_obj->get();
            $responce->data = $patexam_obj;
        }else{
            $responce->data = [];
        }

        return json_encode($responce);
    }

    public function get_table_date_past(Request $request){

        $responce = new stdClass();

        $patexam_obj = DB::table('hisdb.patexam')
            ->select('idno','recorddate AS date','adduser')
            ->where('mrn','=',$request->mrn);

        if($patexam_obj->exists()){
            $patexam_obj = $patexam_obj->get();
            $responce->data = $patexam_obj;
        }else{
            $responce->data = [];
        }

        return json_encode($responce);
    }

    public function get_table_doctornote_div(Request $request){

        $responce = new stdClass();


        $episode_obj = DB::table('hisdb.episode')
            ->select('remarks','diagfinal')
            // ->where('compcode','=',session('compcode'))
            ->where('mrn','=',$request->mrn)
            ->where('episno','=',$request->episno);

        $pathealth_obj = DB::table('hisdb.pathealth')
            // ->where('compcode','=',session('compcode'))
            ->where('mrn','=',$request->mrn)
            ->where('episno','=',$request->episno)
            ->orderBy('recordtime','desc');

        $pathistory_obj = DB::table('hisdb.pathistory')
            // ->where('compcode','=',session('compcode'))
            ->where('mrn','=',$request->mrn)
            ->where('recorddate','=',$request->recorddate);

        $patexam_obj = DB::table('hisdb.patexam')
            // ->where('compcode','=',session('compcode'))
            ->where('mrn','=',$request->mrn)
            ->where('episno','=',$request->episno)
            ->where('recorddate','=',$request->recorddate);

        $episdiag_obj = DB::table('hisdb.episdiag')
            // ->where('compcode','=',session('compcode'))
            ->where('mrn','=',$request->mrn)
            ->where('episno','=',$request->episno);

        $pathealthadd_obj = DB::table('hisdb.pathealthadd')
            // ->where('compcode','=',session('compcode'))
            ->where('mrn','=',$request->mrn)
            ->where('episno','=',$request->episno);

        if($episode_obj->exists()){
            $episode_obj = $episode_obj->first();
            $responce->episode = $episode_obj;
        }

        if($pathealth_obj->exists()){
            $pathealth_obj = $pathealth_obj->first();
            $responce->pathealth = $pathealth_obj;
        }

        if($pathistory_obj->exists()){
            $pathistory_obj = $pathistory_obj->first();
            $responce->pathistory = $pathistory_obj;
        }

        if($patexam_obj->exists()){
            $patexam_obj = $patexam_obj->first();
            $responce->patexam = $patexam_obj;
        }

        if($episdiag_obj->exists()){
            $episdiag_obj = $episdiag_obj->first();
            $responce->episdiag = $episdiag_obj;
        }

        if($pathealthadd_obj->exists()){
            $pathealthadd_obj = $pathealthadd_obj->first();
            $responce->pathealthadd = $pathealthadd_obj;
        }

        return json_encode($responce);
    }

    public function dialog_icd(Request $request){

        $icdver = DB::table('sysdb.sysparam')
                        ->select('pvalue1')
                        // ->where('compcode','=',session('compcode'))
                        ->where('source','=','MR')
                        ->where('trantype','=','ICD')
                        ->first();

        $table = DB::table('hisdb.diagtab')
                    ->where('type','=',$icdver->pvalue1)
                    ->orderBy('idno','asc');

        if(!empty($request->searchCol)){
            $searchCol_array = $request->searchCol;

            $count = array_count_values($searchCol_array);
            // dump($count);

            foreach ($count as $key => $value) {
                $occur_ar = $this->index_of_occurance($key,$searchCol_array);

                $table = $table->where(function ($table) use ($request,$searchCol_array,$occur_ar) {
                    foreach ($searchCol_array as $key => $value) {
                        $found = array_search($key,$occur_ar);
                        if($found !== false){
                            $table->Where($searchCol_array[$key],'like',$request->searchVal[$key]);
                        }
                    }
                });
            }
        }
        
        $paginate = $table->paginate($request->rows);

        $responce = new stdClass();
        $responce->page = $paginate->currentPage();
        $responce->total = $paginate->lastPage();
        $responce->records = $paginate->total();
        $responce->rows = $paginate->items();
        $responce->sql = $table->toSql();
        $responce->sql_bind = $table->getBindings();

        return json_encode($responce);
    }

    public function add_notes(Request $request){

        DB::beginTransaction();

        try {

            DB::table('hisdb.pathealthadd')
                ->insert([  
                    // 'compcode' => session('compcode'),
                    'mrn' => $request->mrn,
                    'episno' => $request->episno,
                    'additionalnote' => $request->additionalnote,
                    'adduser'  => session('username'),
                    'adddate'  => Carbon::now("Asia/Kuala_Lumpur")
                    
                ]);

             DB::commit();

        } catch (\Exception $e) {
            DB::rollback();

            return response($e->getMessage(), 500);
        }
    }

}
