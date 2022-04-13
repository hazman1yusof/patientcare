<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\defaultController;
use stdClass;
use DB;
use Carbon\Carbon;

class physioController extends defaultController
{   

    public function __construct()
    {   
        $this->middleware('auth');
    }

    public function show(Request $request)
    {   
        return view('hisdb.phys.phys');
    }

    public function table(Request $request)
    {   
        switch($request->action){
            case 'get_table_date_phys':    // for table date and doctor name    
                return $this->get_table_date_phys($request);

            default:
                return 'error happen..';
        }
    }

    public function form(Request $request)
    {   
        DB::enableQueryLog();
        switch($request->action){
            case 'save_table_phys':

                switch($request->oper){
                    case 'add':
                        return $this->add($request);
                    case 'edit':
                        return $this->edit($request);
                    default:
                        return 'error happen..';
                }

            case 'get_table_phys':
                return $this->get_table_phys($request);


            default:
                return 'error happen..';
        }
    }

    public function add(Request $request){

        DB::beginTransaction();

        try {

            DB::table('hisdb.patrehab')
                    ->insert([
                        'compcode' => session('compcode'),
                        'mrn' => $request->mrn_phys,
                        'episno' => $request->episno_phys,
                        'category' => $request->category,
                        'complain' => $request->complain,
                        'history' => $request->history,
                        'past' => $request->past,
                        'mh' => $request->mh,
                        'sh' => $request->sh,
                        'investigation' => $request->investigation,
                        'function_' => $request->function_,
                        'drmgmt' => $request->drmgmt,
                        'genobserv' => $request->genobserv,
                        'localobserv' => $request->localobserv,
                        'rom' => $request->rom,
                        'mmt' => $request->mmt,
                        'palpation' => $request->palpation,
                        'test' => $request->test,
                        'neuro' => $request->neuro,
                        'analysis' => $request->analysis,
                        'short' => $request->short,
                        'long_' => $request->long_,
                        'plan_' => $request->plan_,
                        'evaluation' => $request->evaluation,
                        'reassesment' => $request->reassesment,
                        'vas' => $request->vas,
                        'aggr' => $request->aggr,
                        'easing' => $request->easing,
                        'pain' => $request->pain,
                        'behaviour' => $request->behaviour,
                        'irritability' => $request->irritability,
                        'severity' => $request->severity,
                        'recorddate' => Carbon::now("Asia/Kuala_Lumpur"),
                        'recordtime' => Carbon::now("Asia/Kuala_Lumpur"),
                        'adduser'  => session('username'),
                        'adddate'  => Carbon::now("Asia/Kuala_Lumpur")->toDateString(),
                    ]);

            DB::commit();
            
            $responce = new stdClass();
            $responce->mrn = $request->mrn_phys;
            return json_encode($responce);

        } catch (\Exception $e) {
            DB::rollback();

            return response('Error DB rollback!'.$e, 500);
        }
    }

    public function edit(Request $request){

        DB::beginTransaction();

        try {

            DB::table('hisdb.patrehab')
                ->where('compcode','=',session('compcode'))
                ->where('mrn','=',$request->mrn_phys)
                ->where('episno','=',$request->episno_phys)
                ->update([
                    'category' => $request->category,
                    'complain' => $request->complain,
                    'history' => $request->history,
                    'past' => $request->past,
                    'mh' => $request->mh,
                    'sh' => $request->sh,
                    'investigation' => $request->investigation,
                    'function_' => $request->function_,
                    'drmgmt' => $request->drmgmt,
                    'genobserv' => $request->genobserv,
                    'localobserv' => $request->localobserv,
                    'rom' => $request->rom,
                    'mmt' => $request->mmt,
                    'palpation' => $request->palpation,
                    'test' => $request->test,
                    'neuro' => $request->neuro,
                    'analysis' => $request->analysis,
                    'short' => $request->short,
                    'long_' => $request->long_,
                    'plan_' => $request->plan_,
                    'evaluation' => $request->evaluation,
                    'reassesment' => $request->reassesment,
                    'vas' => $request->vas,
                    'aggr' => $request->aggr,
                    'easing' => $request->easing,
                    'pain' => $request->pain,
                    'behaviour' => $request->behaviour,
                    'irritability' => $request->irritability,
                    'severity' => $request->severity,
                ]);

            // $queries = DB::getQueryLog();
            // dump($queries);
            
            DB::commit();

            $responce = new stdClass();
            $responce->mrn = $request->mrn_phys;

            return json_encode($responce);

        } catch (\Exception $e) {
            DB::rollback();

            return response('Error DB rollback!'.$e, 500);
        }
    }

    public function get_table_phys(Request $request){
        
        $patrehab_obj = DB::table('hisdb.patrehab')
                    ->where('compcode','=',session('compcode'))
                    ->where('mrn','=',$request->mrn)
                    ->where('episno','=',$request->episno);

        $responce = new stdClass();

        if($patrehab_obj->exists()){
            $patrehab_obj = $patrehab_obj->first();
            $responce->patrehab = $patrehab_obj;
        }

        return json_encode($responce);

    }

    public function get_table_date_phys(Request $request){
        $responce = new stdClass();

        $phys_obj = DB::table('hisdb.patrehab as p')
            ->select('e.mrn','e.episno','p.recordtime','p.recorddate','p.adduser','p.adddate')
            ->leftJoin('hisdb.episode as e', function($join) use ($request){
                $join = $join->on('p.mrn', '=', 'e.mrn');
                $join = $join->on('p.episno', '=', 'e.episno');
                $join = $join->on('p.compcode', '=', 'e.compcode');
            })
            ->where('e.compcode','=',session('compcode'))
            ->where('e.mrn','=',$request->mrn);

        if($request->type == 'Current'){
            $phys_obj = $phys_obj->where('e.episno','=',$request->episno)->orderBy('p.adddate','desc');
        }else{
            $phys_obj = $phys_obj->orderBy('p.adddate','desc');
        }

            

        if($phys_obj->exists()){
            $phys_obj = $phys_obj->get();

            $data = [];

            foreach ($phys_obj as $key => $value) {
                if(!empty($value->recorddate)){
                    $date['date'] =  Carbon::createFromFormat('Y-m-d', $value->recorddate)->format('d-m-Y').' '.$value->recordtime;
                }else{
                    $date['date'] =  '-';
                }
                $date['mrn'] = $value->mrn;
                $date['episno'] = $value->episno;
                if(!empty($value->adduser)){
                    $date['adduser'] = $value->adduser;
                }else{
                    $date['adduser'] =  '-';
                }

                array_push($data,$date);
            }

            $responce->data = $data;
        }else{
            $responce->data = [];
        }

        return json_encode($responce);
    }

}