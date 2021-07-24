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

        $firstdate = Carbon::createFromDate(2021, 6, 1);
        $seconddate = Carbon::createFromDate(2021, 6, 1)->addDays(6);
        $thirddate = Carbon::createFromDate(2021, 6, 1)->addDays(12+1);
        $fourthdate = Carbon::createFromDate(2021, 6, 1)->addDays(18+2);
        $fiftthdate = Carbon::createFromDate(2021, 6, 1)->endOfMonth();

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

        $ip_month = [$week1ip,$week2ip,$week3ip,$week4ip];
        $op_month = [$week1op,$week2op,$week3op,$week4op];

        $ip_month_epis = [$week1ip_pt,$week2ip_pt,$week3ip_pt,$week4ip_pt];
        $op_month_epis = [$week1op_pt,$week2op_pt,$week3op_pt,$week4op_pt];

        return view('eis.dashboard',compact('ip_month','op_month','ip_month_epis','op_month_epis','groupdesc','groupdesc_val_op','groupdesc_val_ip','groupdesc_cnt_op','groupdesc_cnt_ip','groupdesc_val'));
    }

    public function getQueries($builder){
        $addSlashes = str_replace('?', "'?'", $builder->toSql());
        return vsprintf(str_replace('?', '%s', $addSlashes), $builder->getBindings());
    }
}
