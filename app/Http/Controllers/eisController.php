<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use stdClass;
use DB;
use Auth;
use Carbon\Carbon;
use DateTime;
use Session;

class eisController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Request $request)
    {
        return view('eis.eis');
    }

	public function reveis(Request $request)
    {
        return view('eis.reveis');
    }

    public function table(Request $request){
        switch ($request->action) {
            case 'get_json_pivot_epis':
                return $this->get_json_pivot_epis($request);
                break;
            case 'get_json_pivot_rev':
                return $this->get_json_pivot_rev($request);
                break;
            case 'get_month':
                return $this->get_month($request);
                break;
            default:
                # code...
                break;
        }
    }

    public function get_json_pivot_epis(Request $request){
        // DB::enableQueryLog();
        $dt = Carbon::now("Asia/Kuala_Lumpur");
        $year = [$dt->year];
        $datetype = $request->datetype;
        if(!empty($request->dbtosearch)){
            $dbtosearch = explode(",", $request->dbtosearch);
        }else{
            $dbtosearch = [];
        }
        foreach ($dbtosearch as $value) {
            $date_ = explode("-", $value);
            if(!in_array($date_[0],$year)){
                array_push($year,$date_[0]);
            }
            
        }
        $object = new stdClass();
        foreach ($year as $value) {
            $date_ = explode("-", $value);
            // $month = ($value == $dt->year)?['M'.str_pad($dt->month, 2, '0', STR_PAD_LEFT)]:[];
            $month = [];
            foreach ($dbtosearch as $value2) {
                $date_ = explode("-", $value2);
                if($date_[0] == $value){
                    array_push($month,'M'.$date_[1]);
                }
            }
            $object->$value = $month;
        }

        $all_collection = collect();
        foreach ($object as $key => $value) {
            $pateis = DB::table('hisdb.pateis_epis')
                    ->select('units','epistype','gender','race','religion','payertype','regdept','admdoctor','admdate','discdate','admsrc','docdiscipline','docspeciality','agerange','citizen','area','postcode','placename','patient','state','country','year','quarter','month','datetype')
                    ->where('datetype','=',$datetype)
                    ->where('year','=','Y'.$key)
                    ->whereIn('month',$value);
                
            $all_collection = $all_collection->merge($pateis->get());
        }

        $responce = new stdClass();
        $responce->queries = $this->getQueries($pateis);
        $responce->data = $all_collection;

        echo json_encode($responce);



        // $object = (object) ['property' => 'Here we go'];
        // $datefrom = new Carbon($request->datefrom);
        // $dateto = new Carbon($request->dateto);
        // $dateto = $dateto->day($dateto->daysInMonth);

        // $init = $request->init;
        // $pateis = DB::table('pateis_epis')
        //             ->select('units','epistype','gender','race','religion','payertype','regdept','admdoctor','admdate','admsrc','docdiscipline','docspeciality','agerange','citizen','area','postcode','placename','state','country','year','quarter','month','datetype')
        //             ->where('datetype','=',$datetype)
        //             ->whereBetween('admdate', [$datefrom, $dateto]);
        // if($init == 'init'){
        //     $dt = Carbon::now("Asia/Kuala_Lumpur");
        //     $pateis = $pateis->where('year','=','Y'.$dt->year);
        //     $pateis = $pateis->where('month','=','M'.str_pad($dt->month, 2, '0', STR_PAD_LEFT));
        // }else{
        // }
        // $pateis = $pateis;

        // $queries = DB::getQueryLog();
    }

    public function get_json_pivot_rev(Request $request){
        $dt = Carbon::now("Asia/Kuala_Lumpur");
        $year = [$dt->year];
        $datetype = $request->datetype;
        if(!empty($request->dbtosearch)){
            $dbtosearch = explode(",", $request->dbtosearch);
        }else{
            $dbtosearch = [];
        }
        foreach ($dbtosearch as $value) {
            $date_ = explode("-", $value);
            if(!in_array($date_[0],$year)){
                array_push($year,$date_[0]);
            }
            
        }
        $object = new stdClass();
        foreach ($year as $value) {
            $date_ = explode("-", $value);
            // $month = ($value == $dt->year)?['M'.str_pad($dt->month, 2, '0', STR_PAD_LEFT)]:[];
            $month = [];
            foreach ($dbtosearch as $value2) {
                $date_ = explode("-", $value2);
                if($date_[0] == $value){
                    array_push($month,'M'.$date_[1]);
                }
            }
            $object->$value = $month;
        }

        $all_collection = collect();
        foreach ($object as $key => $value) {
            $pateis = DB::table('hisdb.pateis_rev')
                    ->select('units','epistype','chgcode','chgdesc','groupdesc','typedesc','quantity','unitprice','amount','month','quarter','year','regdate','disdate','datetype')
                    ->where('datetype','=',$datetype)
                    ->where('year','=','Y'.$key)
                    ->whereIn('month',$value);
                
            $all_collection = $all_collection->merge($pateis->get());
        }

        $responce = new stdClass();
        $responce->queries = $this->getQueries($pateis);
        $responce->data = $all_collection;

        echo json_encode($responce);
    }

    public function dashboard(Request $request)
    {
        $month = 6;
        $ip_rev = DB::table('hisdb.patepissum')
                    ->where('month','=',$month)
                    ->where('patient','=',"IP")
                    ->where('type','=',"REV")
                    ->first();

        $op_rev = DB::table('hisdb.patepissum')
                    ->where('month','=',$month)
                    ->where('patient','=',"OP")
                    ->where('type','=',"REV")
                    ->first();

        $ip_epis = DB::table('hisdb.patepissum')
                    ->where('month','=',$month)
                    ->where('patient','=',"IP")
                    ->where('type','=',"epis")
                    ->first();

        $op_epis = DB::table('hisdb.patepissum')
                    ->where('month','=',$month)
                    ->where('patient','=',"OP")
                    ->where('type','=',"epis")
                    ->first();

        $ip_month = [$ip_rev->week1,$ip_rev->week2,$ip_rev->week3,$ip_rev->week4];
        $op_month = [$op_rev->week1,$op_rev->week2,$op_rev->week3,$op_rev->week4];

        $ip_month_epis =  [$ip_epis->week1,$ip_epis->week2,$ip_epis->week3,$ip_epis->week4];
        $op_month_epis = [$op_epis->week1,$op_epis->week2,$op_epis->week3,$op_epis->week4];

        $groupdesc_ = DB::table('hisdb.pateis_rev')->distinct()->get(['groupdesc']);

        $groupdesc = [];
        $groupdesc_val_op = [];
        $groupdesc_val_ip = [];
        $groupdesc_cnt_op = [];
        $groupdesc_cnt_ip = [];
        $groupdesc_val = [];

        $patrevsum = DB::table('hisdb.patrevsum')
                        ->where('month','=',$month)
                        ->get();

        foreach ($patrevsum as $key => $value) {
            array_push($groupdesc,$value->group);
            array_push($groupdesc_val_op,$value->opsum);
            array_push($groupdesc_val_ip,$value->ipsum);
            array_push($groupdesc_cnt_op,$value->opcnt);
            array_push($groupdesc_cnt_ip,$value->ipcnt);
            array_push($groupdesc_val,$value->totalsum);
        }

        return view('eis.dashboard',compact('ip_month','op_month','ip_month_epis','op_month_epis','groupdesc','groupdesc_val_op','groupdesc_val_ip','groupdesc_cnt_op','groupdesc_cnt_ip','groupdesc_val'));
    }

    public function store_dashb(Request $request){
        $month = 6;

        $firstdate = Carbon::createFromDate(2021, $month, 1);
        $seconddate = Carbon::createFromDate(2021, $month, 1)->addDays(6);
        $thirddate = Carbon::createFromDate(2021, $month, 1)->addDays(12+1);
        $fourthdate = Carbon::createFromDate(2021, $month, 1)->addDays(18+2);
        $fiftthdate = Carbon::createFromDate(2021, $month, 1)->endOfMonth();

        $week1ip = DB::table('hisdb.pateis_rev')
                    ->where('year','=','Y2021')
                    ->where('month','=','M06')
                    ->where('epistype','=','IP')
                    ->where('units','=','ABC')
                    ->where('datetype','=','DIS')
                    ->whereBetween('disdate', [$firstdate, $seconddate])
                    ->sum('amount');

        $week2ip = DB::table('hisdb.pateis_rev')
                    ->where('year','=','Y2021')
                    ->where('month','=','M06')
                    ->where('epistype','=','IP')
                    ->where('units','=','ABC')
                    ->where('datetype','=','DIS')
                    ->whereBetween('disdate', [$seconddate, $thirddate])
                    ->sum('amount');

        $week3ip = DB::table('hisdb.pateis_rev')
                    ->where('year','=','Y2021')
                    ->where('month','=','M06')
                    ->where('epistype','=','IP')
                    ->where('units','=','ABC')
                    ->where('datetype','=','DIS')
                    ->whereBetween('disdate', [$thirddate, $fourthdate])
                    ->sum('amount');

        $week4ip = DB::table('hisdb.pateis_rev')
                    ->where('year','=','Y2021')
                    ->where('month','=','M06')
                    ->where('epistype','=','IP')
                    ->where('units','=','ABC')
                    ->where('datetype','=','DIS')
                    ->whereBetween('disdate', [$fourthdate, $fiftthdate])
                    ->sum('amount');

        $patepissum = DB::table('hisdb.patepissum')
                        ->where('month','=',$month)
                        ->where('type','=','REV')
                        ->where('patient','=','IP');

        if($patepissum->exists()){
            $patepissum->update([
                'week1' => $week1ip,
                'week2' => $week2ip,
                'week3' => $week3ip,
                'week4' => $week4ip
            ]);
        }else{
            $patepissum->insert([
                'month' => $month,
                'type' => 'REV',
                'patient' => 'IP',
                'week1' => $week1ip,
                'week2' => $week2ip,
                'week3' => $week3ip,
                'week4' => $week4ip
            ]);
        }

        $week1op = DB::table('hisdb.pateis_rev')
                    ->where('year','=','Y2021')
                    ->where('month','=','M06')
                    ->where('epistype','=','OP')
                    ->where('units','=','ABC')
                    ->where('datetype','=','DIS')
                    ->whereBetween('disdate', [$firstdate, $seconddate])
                    ->sum('amount');

        $week2op = DB::table('hisdb.pateis_rev')
                    ->where('year','=','Y2021')
                    ->where('month','=','M06')
                    ->where('epistype','=','OP')
                    ->where('units','=','ABC')
                    ->where('datetype','=','DIS')
                    ->whereBetween('disdate', [$seconddate, $thirddate])
                    ->sum('amount');

        $week3op = DB::table('hisdb.pateis_rev')
                    ->where('year','=','Y2021')
                    ->where('month','=','M06')
                    ->where('epistype','=','OP')
                    ->where('units','=','ABC')
                    ->where('datetype','=','DIS')
                    ->whereBetween('disdate', [$thirddate, $fourthdate])
                    ->sum('amount');

        $week4op = DB::table('hisdb.pateis_rev')
                    ->where('year','=','Y2021')
                    ->where('month','=','M06')
                    ->where('epistype','=','OP')
                    ->where('units','=','ABC')
                    ->where('datetype','=','DIS')
                    ->whereBetween('disdate', [$fourthdate, $fiftthdate])
                    ->sum('amount');


        $patepissum = DB::table('hisdb.patepissum')
                        ->where('month','=',$month)
                        ->where('type','=','REV')
                        ->where('patient','=','OP');

        if($patepissum->exists()){
            $patepissum->update([
                'week1' => $week1op,
                'week2' => $week2op,
                'week3' => $week3op,
                'week4' => $week4op
            ]);
        }else{
            $patepissum->insert([
                'month' => $month,
                'type' => 'REV',
                'patient' => 'OP',
                'week1' => $week1op,
                'week2' => $week2op,
                'week3' => $week3op,
                'week4' => $week4op
            ]);
        }


        $week1ip_pt = DB::table('hisdb.pateis_epis')
                    ->where('year','=','Y2021')
                    ->where('month','=','M06')
                    ->where('epistype','=','IN-PATIENT')
                    ->where('units','=','ABC')
                    ->where('datetype','=','DIS')
                    ->whereBetween('admdate', [$firstdate, $seconddate])
                    ->count();

        $week2ip_pt = DB::table('hisdb.pateis_epis')
                    ->where('year','=','Y2021')
                    ->where('month','=','M06')
                    ->where('epistype','=','IN-PATIENT')
                    ->where('units','=','ABC')
                    ->where('datetype','=','DIS')
                    ->whereBetween('admdate', [$seconddate, $thirddate])
                    ->count();

        $week3ip_pt = DB::table('hisdb.pateis_epis')
                    ->where('year','=','Y2021')
                    ->where('month','=','M06')
                    ->where('epistype','=','IN-PATIENT')
                    ->where('units','=','ABC')
                    ->where('datetype','=','DIS')
                    ->whereBetween('admdate', [$thirddate, $fourthdate])
                    ->count();

        $week4ip_pt = DB::table('hisdb.pateis_epis')
                    ->where('year','=','Y2021')
                    ->where('month','=','M06')
                    ->where('epistype','=','IN-PATIENT')
                    ->where('units','=','ABC')
                    ->where('datetype','=','DIS')
                    ->whereBetween('admdate', [$fourthdate, $fiftthdate])
                    ->count();

        $patepissum = DB::table('hisdb.patepissum')
                        ->where('month','=',$month)
                        ->where('type','=','epis')
                        ->where('patient','=','IP');

        if($patepissum->exists()){
            $patepissum->update([
                'week1' => $week1ip_pt,
                'week2' => $week2ip_pt,
                'week3' => $week3ip_pt,
                'week4' => $week4ip_pt
            ]);
        }else{
            $patepissum->insert([
                'month' => $month,
                'type' => 'epis',
                'patient' => 'IP',
                'week1' => $week1ip_pt,
                'week2' => $week2ip_pt,
                'week3' => $week3ip_pt,
                'week4' => $week4ip_pt
            ]);
        }

        $week1op_pt = DB::table('hisdb.pateis_epis')
                    ->where('year','=','Y2021')
                    ->where('month','=','M06')
                    ->where('epistype','=','OUT-PATIENT')
                    ->where('units','=','ABC')
                    ->where('datetype','=','DIS')
                    ->whereBetween('admdate', [$firstdate, $seconddate])
                    ->count();

        $week2op_pt = DB::table('hisdb.pateis_epis')
                    ->where('year','=','Y2021')
                    ->where('month','=','M06')
                    ->where('epistype','=','OUT-PATIENT')
                    ->where('units','=','ABC')
                    ->where('datetype','=','DIS')
                    ->whereBetween('admdate', [$seconddate, $thirddate])
                    ->count();

        $week3op_pt = DB::table('hisdb.pateis_epis')
                    ->where('year','=','Y2021')
                    ->where('month','=','M06')
                    ->where('epistype','=','OUT-PATIENT')
                    ->where('units','=','ABC')
                    ->where('datetype','=','DIS')
                    ->whereBetween('admdate', [$thirddate, $fourthdate])
                    ->count();

        $week4op_pt = DB::table('hisdb.pateis_epis')
                    ->where('year','=','Y2021')
                    ->where('month','=','M06')
                    ->where('epistype','=','OUT-PATIENT')
                    ->where('units','=','ABC')
                    ->where('datetype','=','DIS')
                    ->whereBetween('admdate', [$fourthdate, $fiftthdate])
                    ->count();

        $patepissum = DB::table('hisdb.patepissum')
                        ->where('month','=',$month)
                        ->where('type','=','epis')
                        ->where('patient','=','OP');

        if($patepissum->exists()){
            $patepissum->update([
                'week1' => $week1op_pt,
                'week2' => $week2op_pt,
                'week3' => $week3op_pt,
                'week4' => $week4op_pt
            ]);
        }else{
            $patepissum->insert([
                'month' => $month,
                'type' => 'epis',
                'patient' => 'OP',
                'week1' => $week1op_pt,
                'week2' => $week2op_pt,
                'week3' => $week3op_pt,
                'week4' => $week4op_pt
            ]);
        }

        $groupdesc_ = DB::table('hisdb.pateis_rev')->distinct()->get(['groupdesc']);

        $groupdesc = [];
        $groupdesc_val_op = [];
        $groupdesc_val_ip = [];
        $groupdesc_val = [];
        foreach ($groupdesc_ as $key => $value) {
            $groupdesc[$key] = $value->groupdesc;
            $groupdesc_op = DB::table('hisdb.pateis_rev')
                            ->where('year','=','Y2021')
                            ->where('month','=','M06')
                            ->where('epistype','=','OP')
                            ->where('groupdesc','=',$value->groupdesc)
                            ->where('units','=','ABC')
                            ->where('datetype','=','DIS');

            $groupdesc_op_sum = $groupdesc_op->sum('amount');
            $groupdesc_op_cnt = $groupdesc_op->count();

            $groupdesc_val_op[$key] = $groupdesc_op_sum;
            $groupdesc_cnt_op[$key] = $groupdesc_op_cnt;

            $groupdesc_ip = DB::table('hisdb.pateis_rev')
                            ->where('year','=','Y2021')
                            ->where('month','=','M06')
                            ->where('epistype','=','IP')
                            ->where('groupdesc','=',$value->groupdesc)
                            ->where('units','=','ABC')
                            ->where('datetype','=','DIS');

            $groupdesc_ip_sum = $groupdesc_ip->sum('amount');
            $groupdesc_ip_cnt = $groupdesc_ip->count();

            $groupdesc_val_ip[$key] = $groupdesc_ip_sum;
            $groupdesc_cnt_ip[$key] = $groupdesc_ip_cnt;
            $groupdesc_val[$key] = $groupdesc_op_sum + $groupdesc_ip_sum;

        }

        $patrevsum = DB::table('hisdb.patrevsum')
                        ->where('month','=',$month);

        if($patrevsum->exists()){
            $patrevsum = DB::table('hisdb.patrevsum')
                            ->where('month','=',$month);
            foreach ($groupdesc_ as $key => $value) {
                $patrevsum->where('group','=',$value->groupdesc)
                            ->update([
                                'ipcnt' => $groupdesc_cnt_ip[$key],
                                'opcnt' => $groupdesc_cnt_op[$key],
                                'ipsum' => $groupdesc_val_ip[$key],
                                'opsum' => $groupdesc_val_op[$key],
                                'totalsum' => $groupdesc_val[$key],
                            ]);
            }
        }else{
            foreach ($groupdesc_ as $key => $value) {
                $patrevsum->insert([
                                'month' => $month,
                                'group' => $value->groupdesc,
                                'ipcnt' => $groupdesc_cnt_ip[$key],
                                'opcnt' => $groupdesc_cnt_op[$key],
                                'ipsum' => $groupdesc_val_ip[$key],
                                'opsum' => $groupdesc_val_op[$key],
                                'totalsum' => $groupdesc_val[$key],
                            ]);
            }
        }

    }

    public function getQueries($builder){
        $addSlashes = str_replace('?', "'?'", $builder->toSql());
        return vsprintf(str_replace('?', '%s', $addSlashes), $builder->getBindings());
    }
}
