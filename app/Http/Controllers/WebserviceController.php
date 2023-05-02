<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\defaultController;
use stdClass;
use App\User;
use DB;
use Auth;
use Carbon\Carbon;
use Hash;
use Session;

class WebserviceController extends defaultController
{
    public function __construct()
    {

    }

    public function table(Request $request)
    {   
        switch($request->action){
            case 'query':          // for current
                return $this->query($request);break;
            case 'query2':          // for current
                return $this->query2($request);break;
            case 'query2_betulkandate':          // for current
                return $this->query2_betulkandate($request);break;
            case 'auto_labresult':          // for current
                return $this->auto_labresult($request);break;
            default:
                return 'error happen..';
        }
    }
    
    public function localpreview(Request $request)
    {   

        $user = User::where('username','doctor');
        Auth::login($user->first(),false);

        if(!empty($request->mrn)){
            $user = DB::table('hisdb.pat_mast')->where('mrn','=',$request->mrn)->first();
        }else{
            return abort(404);
        }

        return view('preview',compact('user'));
    }

    public function login(Request $request){//http://patientcare.test/webservice/login?page=dialysis&username=farid&dept=webservice
        switch ($request->page) {
            case 'upload':
                $goto = '/emergency';
                break;
            case 'dialysis':
                $goto = '/dialysis';
                break;
            default:
                $goto = '/emergency';
                break;
        }

        if(Auth::check()){
            $this->update_dept($request);
            return redirect($goto)->with('navbar','navbar');//maksudnya hide navbar
        }else{



            $user = User::where('username',request('username'));
            if($user->count() > 0){

                $request->session()->put('username', request('username'));
                $request->session()->put('compcode', $user->first()->compcode);

                $this->update_dept($request);
                Auth::login($user->first(),false);
                return redirect($goto)->with('navbar','navbar');

            }else{

                
                $request->session()->put('username', request('username'));
                $request->session()->put('compcode', $user->first()->compcode);

                $this->create_new_user($request);
                $user = User::where('username',request('username'));
                Auth::login($user->first(),false);
                return redirect($goto)->with('navbar','navbar');

            }
        }
    }

    public function update_dept(Request $request){
        $user = User::where('username',request('username'));
        if(empty($user->dept)){
            DB::table('sysdb.users')
                ->where('username','=',request('username'))
                ->update([
                    'dept' => $request->dept
                ]);
        }
    }

    public function create_new_user(Request $request){
        DB::table('sysdb.users')
            ->insert([
                'username' => $request->username,
                'name' => $request->username,
                'password' => $request->username,
                'dept' => $request->dept
            ]);
    }



    public function store_dashb(Request $request){
        $month = $request->month;
        $year = $request->year;

        $firstdate = Carbon::createFromDate($year, $month, 1);
        $seconddate = Carbon::createFromDate($year, $month, 1)->addDays(6);
        $thirddate = Carbon::createFromDate($year, $month, 1)->addDays(12+1);
        $fourthdate = Carbon::createFromDate($year, $month, 1)->addDays(18+2);
        $fiftthdate = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        $week1ip = DB::table('hisdb.pateis_rev')
                    ->where('year','=','Y'.$year)
                    ->where('month','=','M'.str_pad($month,2,"0",STR_PAD_LEFT))
                    ->where('epistype','=','IP')
                    ->where('units','=','ABC')
                    ->where('datetype','=','DIS')
                    ->whereBetween('disdate', [$firstdate, $seconddate])
                    ->sum('amount');

        $week2ip = DB::table('hisdb.pateis_rev')
                    ->where('year','=','Y'.$year)
                    ->where('month','=','M'.str_pad($month,2,"0",STR_PAD_LEFT))
                    ->where('epistype','=','IP')
                    ->where('units','=','ABC')
                    ->where('datetype','=','DIS')
                    ->whereBetween('disdate', [$seconddate, $thirddate])
                    ->sum('amount');

        $week3ip = DB::table('hisdb.pateis_rev')
                    ->where('year','=','Y'.$year)
                    ->where('month','=','M'.str_pad($month,2,"0",STR_PAD_LEFT))
                    ->where('epistype','=','IP')
                    ->where('units','=','ABC')
                    ->where('datetype','=','DIS')
                    ->whereBetween('disdate', [$thirddate, $fourthdate])
                    ->sum('amount');

        $week4ip = DB::table('hisdb.pateis_rev')
                    ->where('year','=','Y'.$year)
                    ->where('month','=','M'.str_pad($month,2,"0",STR_PAD_LEFT))
                    ->where('epistype','=','IP')
                    ->where('units','=','ABC')
                    ->where('datetype','=','DIS')
                    ->whereBetween('disdate', [$fourthdate, $fiftthdate])
                    ->sum('amount');

        $patsumepis = DB::table('hisdb.patsumepis')
                        ->where('month','=',$month)
                        ->where('year','=',$year)
                        ->where('type','=','REV')
                        ->where('patient','=','IP');

        if($patsumepis->exists()){
            $patsumepis->update([
                'week1' => $week1ip,
                'week2' => $week2ip,
                'week3' => $week3ip,
                'week4' => $week4ip
            ]);
        }else{
            $patsumepis->insert([
                'month' => $month,
                'year' => $year,
                'type' => 'REV',
                'patient' => 'IP',
                'week1' => $week1ip,
                'week2' => $week2ip,
                'week3' => $week3ip,
                'week4' => $week4ip
            ]);
        }

        $week1op = DB::table('hisdb.pateis_rev')
                    ->where('year','=','Y'.$year)
                    ->where('month','=','M'.str_pad($month,2,"0",STR_PAD_LEFT))
                    ->where('epistype','=','OP')
                    ->where('units','=','ABC')
                    ->where('datetype','=','DIS')
                    ->whereBetween('disdate', [$firstdate, $seconddate])
                    ->sum('amount');

        $week2op = DB::table('hisdb.pateis_rev')
                    ->where('year','=','Y'.$year)
                    ->where('month','=','M'.str_pad($month,2,"0",STR_PAD_LEFT))
                    ->where('epistype','=','OP')
                    ->where('units','=','ABC')
                    ->where('datetype','=','DIS')
                    ->whereBetween('disdate', [$seconddate, $thirddate])
                    ->sum('amount');

        $week3op = DB::table('hisdb.pateis_rev')
                    ->where('year','=','Y'.$year)
                    ->where('month','=','M'.str_pad($month,2,"0",STR_PAD_LEFT))
                    ->where('epistype','=','OP')
                    ->where('units','=','ABC')
                    ->where('datetype','=','DIS')
                    ->whereBetween('disdate', [$thirddate, $fourthdate])
                    ->sum('amount');

        $week4op = DB::table('hisdb.pateis_rev')
                    ->where('year','=','Y'.$year)
                    ->where('month','=','M'.str_pad($month,2,"0",STR_PAD_LEFT))
                    ->where('epistype','=','OP')
                    ->where('units','=','ABC')
                    ->where('datetype','=','DIS')
                    ->whereBetween('disdate', [$fourthdate, $fiftthdate])
                    ->sum('amount');


        $patsumepis = DB::table('hisdb.patsumepis')
                        ->where('month','=',$month)
                        ->where('year','=',$year)
                        ->where('type','=','REV')
                        ->where('patient','=','OP');

        if($patsumepis->exists()){
            $patsumepis->update([
                'week1' => $week1op,
                'week2' => $week2op,
                'week3' => $week3op,
                'week4' => $week4op
            ]);
        }else{
            $patsumepis->insert([
                'month' => $month,
                'year' => $year,
                'type' => 'REV',
                'patient' => 'OP',
                'week1' => $week1op,
                'week2' => $week2op,
                'week3' => $week3op,
                'week4' => $week4op
            ]);
        }


        $week1ip_pt = DB::table('hisdb.pateis_epis')
                    ->where('year','=','Y'.$year)
                    ->where('month','=','M'.str_pad($month,2,"0",STR_PAD_LEFT))
                    ->where('epistype','=','IN-PATIENT')
                    ->where('units','=','ABC')
                    ->where('datetype','=','DIS')
                    ->whereBetween('admdate', [$firstdate, $seconddate])
                    ->count();

        $week2ip_pt = DB::table('hisdb.pateis_epis')
                    ->where('year','=','Y'.$year)
                    ->where('month','=','M'.str_pad($month,2,"0",STR_PAD_LEFT))
                    ->where('epistype','=','IN-PATIENT')
                    ->where('units','=','ABC')
                    ->where('datetype','=','DIS')
                    ->whereBetween('admdate', [$seconddate, $thirddate])
                    ->count();

        $week3ip_pt = DB::table('hisdb.pateis_epis')
                    ->where('year','=','Y'.$year)
                    ->where('month','=','M'.str_pad($month,2,"0",STR_PAD_LEFT))
                    ->where('epistype','=','IN-PATIENT')
                    ->where('units','=','ABC')
                    ->where('datetype','=','DIS')
                    ->whereBetween('admdate', [$thirddate, $fourthdate])
                    ->count();

        $week4ip_pt = DB::table('hisdb.pateis_epis')
                    ->where('year','=','Y'.$year)
                    ->where('month','=','M'.str_pad($month,2,"0",STR_PAD_LEFT))
                    ->where('epistype','=','IN-PATIENT')
                    ->where('units','=','ABC')
                    ->where('datetype','=','DIS')
                    ->whereBetween('admdate', [$fourthdate, $fiftthdate])
                    ->count();

        $patsumepis = DB::table('hisdb.patsumepis')
                        ->where('year','=',$year)
                        ->where('month','=',$month)
                        ->where('type','=','epis')
                        ->where('patient','=','IP');

        if($patsumepis->exists()){
            $patsumepis->update([
                'week1' => $week1ip_pt,
                'week2' => $week2ip_pt,
                'week3' => $week3ip_pt,
                'week4' => $week4ip_pt
            ]);
        }else{
            $patsumepis->insert([
                'month' => $month,
                'year' => $year,
                'type' => 'epis',
                'patient' => 'IP',
                'week1' => $week1ip_pt,
                'week2' => $week2ip_pt,
                'week3' => $week3ip_pt,
                'week4' => $week4ip_pt
            ]);
        }

        $week1op_pt = DB::table('hisdb.pateis_epis')
                    ->where('year','=','Y'.$year)
                    ->where('month','=','M'.str_pad($month,2,"0",STR_PAD_LEFT))
                    ->where('epistype','=','OUT-PATIENT')
                    ->where('units','=','ABC')
                    ->where('datetype','=','DIS')
                    ->whereBetween('admdate', [$firstdate, $seconddate])
                    ->count();

        $week2op_pt = DB::table('hisdb.pateis_epis')
                    ->where('year','=','Y'.$year)
                    ->where('month','=','M'.str_pad($month,2,"0",STR_PAD_LEFT))
                    ->where('epistype','=','OUT-PATIENT')
                    ->where('units','=','ABC')
                    ->where('datetype','=','DIS')
                    ->whereBetween('admdate', [$seconddate, $thirddate])
                    ->count();

        $week3op_pt = DB::table('hisdb.pateis_epis')
                    ->where('year','=','Y'.$year)
                    ->where('month','=','M'.str_pad($month,2,"0",STR_PAD_LEFT))
                    ->where('epistype','=','OUT-PATIENT')
                    ->where('units','=','ABC')
                    ->where('datetype','=','DIS')
                    ->whereBetween('admdate', [$thirddate, $fourthdate])
                    ->count();

        $week4op_pt = DB::table('hisdb.pateis_epis')
                    ->where('year','=','Y'.$year)
                    ->where('month','=','M'.str_pad($month,2,"0",STR_PAD_LEFT))
                    ->where('epistype','=','OUT-PATIENT')
                    ->where('units','=','ABC')
                    ->where('datetype','=','DIS')
                    ->whereBetween('admdate', [$fourthdate, $fiftthdate])
                    ->count();

        $patsumepis = DB::table('hisdb.patsumepis')
                        ->where('month','=',$month)
                        ->where('type','=','epis')
                        ->where('patient','=','OP');

        if($patsumepis->exists()){
            $patsumepis->update([
                'week1' => $week1op_pt,
                'week2' => $week2op_pt,
                'week3' => $week3op_pt,
                'week4' => $week4op_pt
            ]);
        }else{
            $patsumepis->insert([
                'month' => $month,
                'year' => $year,
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
                            ->where('year','=','Y'.$year)
                            ->where('month','=','M'.str_pad($month,2,"0",STR_PAD_LEFT))
                            ->where('epistype','=','OP')
                            ->where('groupdesc','=',$value->groupdesc)
                            ->where('units','=','ABC')
                            ->where('datetype','=','DIS');

            $groupdesc_op_sum = $groupdesc_op->sum('amount');
            $groupdesc_op_cnt = $groupdesc_op->count();

            $groupdesc_val_op[$key] = $groupdesc_op_sum;
            $groupdesc_cnt_op[$key] = $groupdesc_op_cnt;

            $groupdesc_ip = DB::table('hisdb.pateis_rev')
                            ->where('year','=','Y'.$year)
                            ->where('month','=','M'.str_pad($month,2,"0",STR_PAD_LEFT))
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

        $patsumrev = DB::table('hisdb.patsumrev')
                        ->where('month','=',$month)
                        ->where('year','=',$year);

        if($patsumrev->exists()){
            $patsumrev = DB::table('hisdb.patsumrev')
                            ->where('month','=',$month)
                            ->where('year','=',$year);

            foreach ($groupdesc_ as $key => $value) {
                $patsumrev->where('group','=',$value->groupdesc)
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
                $patsumrev->insert([
                                'month' => $month,
                                'year' => $year,
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

    public function auto_register13A(){
        $array = [
            ['1','BAITULMAL ','550704-10-5617'],
            ['3','DBKL','550507-01-5225'],
            ['6','BAITULMAL ','811002-14-6249'],
            ['8','BAITULMAL ','551206-10-5723'],
            ['10','BAITULMAL','670507-10-6166'],
            ['11','BAITULMAL ','600923-71-5127'],
            ['16','JPA','640209-71-5353'],
            ['19','BAITULMAL','531030-05-5276'],
            ['20','BAITULMAL ','880820-11-5224'],
            ['21','BAITULMAL ','B 9566-51-4'],
            ['22','BAITULMAL ','640923-71-5166'],
            ['27','BAITULMAL ','941001-14-6517'],
            ['29','BAITULMAL ','491002-02-5973'],
            ['31','BAITULMAL ','720519-08-5393'],
            ['32','BAITULMAL ','661205-04-5543'],
            ['33','BAITULMAL ','660108-71-5088'],
            ['36','BAITULMAL ','820425-14-5381'],
            ['39','BAITULMAL ','560505-10-5955'],
            ['40','DBKL','560226-10-5848'],
            ['41','BAITULMAL ','571102-10-6148'],
            ['42','BAITULMAL ','381229-01-5174'],
            ['43','BAITULMAL ','530112-04-5309'],
            ['45','JPA','570831-10-6207'],
            ['50','BAITULMAL ','520821-04-5249'],
            ['52','BAITULMAL','931018-03-6593'],
            ['55','PERKESO','750926-10-5571'],
            ['56','BAITULMAL','780713-14-5331'],
            ['58','BAITULMAL ','690310-10-7059'],
            ['59','BAITULMAL ','470525-05-5263'],
            ['60','DBKL ','550710-04-5171'],
            ['64','BAITULMAL ','920511-11-5435'],
            ['65','BAITULMAL ','010108-14-1577'],
            ['68','BAITULMAL ','770509-05-5719'],
            ['70','PERKESO','621220-10-7718'],
            ['71','BAITULMAL ','601016-03-5632'],
            ['74','DBKL ','530427-05-5376'],
            ['76','BAITULMAL ','711006-04-5172'],
            ['77','BAITULMAL ','701102-10-6415'],
            ['80','BAITULMAL ','400321-08-5758'],
            ['82','BAITULMAL ','550907-05-5402'],
            ['87','BAITULMAL ','670110-10-6766'],
            ['88','BAITULMAL ','630930-71-5122'],
            ['90','BAITULMAL ','671016-10-5841'],
            ['91','PERKESO','550928-05-5049'],
            ['93','BAITULMAL ','700126-01-6014'],
            ['94','BAITULMAL ','501107-03-5322'],
            ['95','JPA','591217-10-5629'],
            ['96','BAITULMAL ','861010-56-5588'],
            ['98','BAITULMAL ','660614-08-6472'],
            ['100','BAITULMAL ','540628-04-5130'],
            ['101','BAITULMAL ','500611-06-5147'],
            ['102','BAITULMAL ','AU2316-20-'],
            ['103','BAITULMAL ','540609-02-5556'],
            ['106','BAITULMAL','511129-66-5068'],
            ['107','BAITULMAL','661022-01-5990'],
            ['111','BAITULMAL','760224-03-5360'],
            ['112','BAITULMAL ','550701-07-5491'],
            ['114','BAITULMAL ','721205-10-5122'],
            ['115','BAITULMAL ','770424-01-5304']
        ];

        DB::beginTransaction();

        try {

            foreach ($array as $key => $value) {
                $mrn = $value[0];
                $debtorcode = trim($value[1]);
                $newic = trim($value[2]);
                switch ($debtorcode) {
                    case 'BAITULMAL':
                            $epis_fin = 'BM';
                        break;
                    case 'JPA':
                            $epis_fin = 'JK';
                        break;
                    case 'PERKESO':
                            $epis_fin = 'PS';
                        break;
                    case 'DBKL':
                            $epis_fin = 'JK';
                        break;
                    default:
                            $epis_fin = 'CO';
                        break;
                }

                $pat_mast = DB::table('hisdb.pat_mast')
                                ->where('mrn',$mrn)
                                ->where('compcode','13A');

                if($pat_mast->exists()){
                    $pat_mast_data = $pat_mast->first();
                }

                $newepisno = intval($pat_mast_data->episno) + 1;

                $pat_mast
                    ->update([
                        'episno' => $newepisno,
                        'patstatus' => 1,
                        'last_visit_date' => '2022-10-01',
                        'Lastupdate' => Carbon::now("Asia/Kuala_Lumpur"),
                        'LastUser' => 'system'
                    ]);

                DB::table("hisdb.episode")
                    ->insert([
                        "compcode" => '13A',
                        "mrn" => $mrn,
                        "episno" => $newepisno,
                        "epistycode" => 'OP',
                        "reg_date" => '2022-10-01',
                        "reg_time" => Carbon::now("Asia/Kuala_Lumpur"),
                        "regdept" => 'JP',
                        "admsrccode" => 'APPT',
                        "case_code" => 'HDS',
                        "admdoctor" => 'NIRMALA',
                        "attndoctor" => 'AZMAN',
                        "pay_type" => $epis_fin,
                        "pyrmode" => 'PANEL',
                        "billtype" => 'OP',
                        "payer" => $debtorcode,
                        "followupNP" => 1,
                        "adddate" => Carbon::now("Asia/Kuala_Lumpur"),
                        "adduser" => 'system',
                        "episactive" => 1,
                        "allocpayer" => 1,
                        'episstatus' => 'CURRENT',
                    ]);

                DB::table('hisdb.epispayer')
                    ->insert([
                        'CompCode' => '13A',
                        'MRN' => $mrn,
                        'Episno' => $newepisno,
                        'EpisTyCode' => 'OP',
                        'LineNo' => '1',
                        'BillType' => 'OP',
                        'PayerCode' => $debtorcode,
                        'Pay_Type' => $epis_fin,
                        'AddDate' => Carbon::now("Asia/Kuala_Lumpur"),
                        'AddUser' => 'system',
                        'Lastupdate' => Carbon::now("Asia/Kuala_Lumpur"),
                        'LastUser' => 'system'
                    ]);

                $queue_obj = DB::table('sysdb.sysparam')
                        ->where('compcode','=','13A')
                        ->where('source','=','QUE')
                        ->where('trantype','=','OP');

                $queue_data = $queue_obj->first();

                //ni start kosong balik bila hari baru
                if($queue_data->pvalue2 != Carbon::now("Asia/Kuala_Lumpur")->toDateString()){
                    $queue_obj
                        ->update([
                            'pvalue1' => 1,
                            'pvalue2' => Carbon::now("Asia/Kuala_Lumpur")->toDateString()
                        ]);

                    $current_pvalue1 = 1;
                }else{
                    $current_pvalue1 = intval($queue_data->pvalue1);
                }


                //tambah satu dkt queue sysparam
                $queue_obj
                    ->update([
                        'pvalue1' => $current_pvalue1+1
                    ]);

                DB::table('hisdb.queue')
                    ->insert([
                        'AdmDoctor' => 'NIRMALA',
                        'AttnDoctor' => 'AZMAN',
                        'BedType' => '',
                        'Case_Code' => "MED",
                        'CompCode' => '13A',
                        'Episno' => $newepisno,
                        'EpisTyCode' => 'OP',
                        'LastTime' => Carbon::now("Asia/Kuala_Lumpur")->toTimeString(),
                        'Lastupdate' => Carbon::now("Asia/Kuala_Lumpur")->toDateString(),
                        'Lastuser' => 'system',
                        'MRN' => $mrn,
                        'Reg_Date' => Carbon::now("Asia/Kuala_Lumpur")->toDateString(),
                        'Reg_Time' => Carbon::now("Asia/Kuala_Lumpur")->toDateTimeString(),
                        'Bed' => '',
                        'Room' => '',
                        'QueueNo' => $current_pvalue1,
                        'Deptcode' => 'ALL',
                        // 'DOB' => $this->null_date($patmast_data->DOB),
                        // 'NAME' => $patmast_data->Name,
                        'Newic' => $newic,
                        // 'Oldic' => $patmast_data->Oldic,
                        // 'Sex' => $patmast_data->Sex,
                        // 'Religion' => $patmast_data->Religion,
                        // 'RaceCode' => $patmast_data->RaceCode,
                        'EpisStatus' => '',
                        'chggroup' => 'OP'
                    ]);

                DB::table('hisdb.queue')
                    ->insert([
                        'AdmDoctor' => 'NIRMALA',
                        'AttnDoctor' => 'AZMAN',
                        'BedType' => '',
                        'Case_Code' => "MED",
                        'CompCode' => '13A',
                        'Episno' => $newepisno,
                        'EpisTyCode' => "OP",
                        'LastTime' => Carbon::now("Asia/Kuala_Lumpur")->toTimeString(),
                        'Lastupdate' => Carbon::now("Asia/Kuala_Lumpur")->toDateString(),
                        'Lastuser' => session('username'),
                        'MRN' => $mrn,
                        'Reg_Date' => Carbon::now("Asia/Kuala_Lumpur")->toDateString(),
                        'Reg_Time' => Carbon::now("Asia/Kuala_Lumpur")->toDateTimeString(),
                        'Bed' => '',
                        'Room' => '',
                        'QueueNo' => $current_pvalue1,
                        'Deptcode' => 'SPEC',
                        // 'DOB' => $this->null_date($patmast_data->DOB),
                        // 'NAME' => $patmast_data->Name,
                        'Newic' => $newic,
                        // 'Oldic' => $patmast_data->Oldic,
                        // 'Sex' => $patmast_data->Sex,
                        // 'Religion' => $patmast_data->Religion,
                        // 'RaceCode' => $patmast_data->RaceCode,
                        'EpisStatus' => '',
                        'chggroup' => 'OP'
                    ]);

            }

            // DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
            // return response('Error'.$e, 500);
        }
    }

    public function query(){
        DB::beginTransaction();

        try {

            $start = new Carbon('first day of last month');
            $end = Carbon::now(); 

            $episode = DB::table('hisdb.episode')
                                ->where('compcode','13A')
                                ->whereDate('reg_date','>=',$start->format('Y-m-d'))
                                ->whereDate('reg_date','<=',$end->format('Y-m-d'))
                                ->get();

            foreach ($episode as $key => $value) {
                $count = DB::table('hisdb.chargetrx')
                                    ->where('compcode','13A')
                                    ->where('mrn',$value->mrn)
                                    ->where('episno',$value->episno)
                                    ->where('chgcode','EP010002')
                                    ->where('recstatus','1')
                                    ->count();

                if($count>1){
                    $first_occ = DB::table('hisdb.chargetrx')
                                            ->where('compcode','13A')
                                            ->where('mrn',$value->mrn)
                                            ->where('episno',$value->episno)
                                            ->where('chgcode','EP010002')
                                            ->where('recstatus','1')
                                            ->first();
                        
                    echo '('.Carbon::now().') For mrn: '.$value->mrn.' ~ episno: '.$value->episno.' ~ only keep id: '.$first_occ->id;

                    DB::table('hisdb.chargetrx')
                        ->where('compcode','13A')
                        ->where('mrn',$value->mrn)
                        ->where('episno',$value->episno)
                        ->where('chgcode','EP010002')
                        ->where('recstatus','1')
                        ->where('id','!=',$first_occ->id)
                        ->update([
                            'recstatus' => '0',
                            'lastuser' => 'system/delete',
                            'lastupdate' => Carbon::now("Asia/Kuala_Lumpur")
                        ]);

                }

            } 

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
            // return response('Error'.$e, 500);
        }

    }

    public function query2(){
        DB::beginTransaction();

        try {

            $start = new Carbon('first day of last month');
            $end = new Carbon('last day of this month');

            $episode = DB::table('hisdb.episode')
                                ->where('compcode','13A')
                                ->whereDate('reg_date','>=',$start->format('Y-m-d'))
                                ->whereDate('reg_date','<=',$end->format('Y-m-d'))
                                ->get();

            foreach ($episode as $key => $value) {
                dump('-MRN: '.$value->mrn .'- -Episno: '.$value->episno.'-');
                $hdstillgot = DB::table('hisdb.chargetrx')
                                ->where('mrn','=',$value->mrn)
                                ->where('episno','=',$value->episno)
                                ->whereIn('chgcode',['HD020001','HD010001','HD020002'])
                                ->where('recstatus',1);

                if($hdstillgot->exists()){
                    $got_auto = DB::table('hisdb.chargetrx')
                            ->where('mrn','=',$value->mrn)
                            ->where('episno','=',$value->episno)
                            ->where('chgcode','EP010002')
                            ->where('recstatus',1);

                    if(!$got_auto->exists()){
                        $chgmast_hd = DB::table('hisdb.chgmast')
                                ->where('compcode','=',session('compcode'))
                                ->where('chgcode','=','EP010002')
                                ->first();

                        $array_insert = [
                            'compcode' => session('compcode'),
                            'mrn' => $value->mrn,
                            'episno' => $value->episno,
                            'trxtype' => 'OE',
                            'trxdate' => $value->reg_date,
                            'chgcode' => 'EP010002',
                            'chggroup' => $chgmast_hd->chggroup,
                            'chgtype' => $chgmast_hd->chgtype,
                            'billflag' => '0',
                            'quantity' => 1,
                            'isudept' => $value->regdept,
                            'trxtime' => Carbon::now("Asia/Kuala_Lumpur"),
                            'lastuser' => 'SYSTEM',
                            'lastupdate' => Carbon::now("Asia/Kuala_Lumpur"),
                            'recstatus' => 1
                        ];

                        DB::table('hisdb.chargetrx')->insert($array_insert);

                        dump('Added EP010002');
                    }
                }

            } 

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
            // return response('Error'.$e, 500);
        }

    }

    public function query2_betulkandate(){
        DB::beginTransaction();

        try {

            $start = new Carbon('first day of last month');
            $end = new Carbon('last day of this month');

            $episode = DB::table('hisdb.episode')
                                ->where('compcode','13A')
                                ->whereDate('reg_date','>=',$start->format('Y-m-d'))
                                ->whereDate('reg_date','<=',$end->format('Y-m-d'))
                                ->get();

            foreach ($episode as $key => $value) {
                dump('-MRN: '.$value->mrn .'- -Episno: '.$value->episno.'-');
                $hdstillgot = DB::table('hisdb.chargetrx')
                                ->where('mrn','=',$value->mrn)
                                ->where('episno','=',$value->episno)
                                ->whereIn('chgcode',['HD020001','HD010001','HD020002'])
                                ->where('recstatus',1);

                if($hdstillgot->exists()){
                    $got_auto = DB::table('hisdb.chargetrx')
                            ->where('mrn','=',$value->mrn)
                            ->where('episno','=',$value->episno)
                            ->where('chgcode','EP010002')
                            ->whereDate('trxdate','=',Carbon::now("Asia/Kuala_Lumpur")->format('Y-m-d'))
                            ->where('recstatus',1);

                    if($got_auto->exists()){
                        $got_auto_first = $got_auto->first();

                        $array_update = [
                            'trxdate' => $value->reg_date
                        ];

                        DB::table('hisdb.chargetrx')
                            ->where('id',$got_auto_first->id)
                            ->update($array_update);

                        dump('Update EP010002');
                    }
                }

            } 

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
            // return response('Error'.$e, 500);
        }

    }

    public function auto_episode(){

        $today = Carbon::now(); //returns current day
        if($today->day != 1){dump('not 1st day of month');return 0;}
        

        DB::beginTransaction();

        try {

            $episode = DB::table('hisdb.episode')
                            ->where('compcode','13A')
                            ->where('episactive','1')
                            ->whereDate('adddate','!=',Carbon::now("Asia/Kuala_Lumpur"));

            if($episode->exists()){
                $episode = $episode->get();

                foreach ($episode as $key => $value) {
                    $newepisno = intval($value->episno) + 1;

                    DB::table("hisdb.episode")
                        ->insert([
                            "compcode" => '13A',
                            "mrn" => $value->mrn,
                            "episno" => $newepisno,
                            "epistycode" => $value->epistycode,
                            "reg_date" => Carbon::now("Asia/Kuala_Lumpur"),
                            "reg_time" => Carbon::now("Asia/Kuala_Lumpur"),
                            "regdept" => $value->regdept,
                            "admsrccode" => $value->admsrccode, //
                            "case_code" => $value->case_code, //
                            "admdoctor" => $value->admdoctor, //
                            "attndoctor" => $value->attndoctor, //
                            "pay_type" => $value->pay_type,
                            "pyrmode" => $value->pyrmode,
                            "billtype" => $value->billtype,
                            "payer" => $value->payer,
                            "followupNP" => 1,
                            "adddate" => Carbon::now("Asia/Kuala_Lumpur"),
                            "adduser" => 'system',
                            "episactive" => 1,
                            "allocpayer" => 1,
                            'episstatus' => 'CURRENT',
                        ]);

                    DB::table('hisdb.epispayer')
                        ->insert([
                            'CompCode' => '13A',
                            'MRN' => $value->mrn,
                            'Episno' => $newepisno,
                            'EpisTyCode' => 'OP',
                            'LineNo' => '1',
                            'BillType' => 'OP',
                            'PayerCode' => $value->payer,
                            'Pay_Type' => $value->pay_type,
                            'AddDate' => Carbon::now("Asia/Kuala_Lumpur"),
                            'AddUser' => 'system',
                            'Lastupdate' => Carbon::now("Asia/Kuala_Lumpur"),
                            'LastUser' => 'system'
                        ]);

                    DB::table('hisdb.pat_mast')
                        ->where('mrn',$value->mrn)
                        ->where('compcode','13A')
                        ->update([
                            'episno' => $newepisno,
                            'patstatus' => 1,
                            'last_visit_date' => Carbon::now("Asia/Kuala_Lumpur"),
                            'Lastupdate' => Carbon::now("Asia/Kuala_Lumpur"),
                            'LastUser' => 'system'
                        ]);

                    DB::table('hisdb.queue')
                        ->where('MRN',$value->mrn)
                        ->where('CompCode','13A')
                        ->update([
                            'Episno' => $newepisno,
                            'LastTime' => Carbon::now("Asia/Kuala_Lumpur")->toTimeString(),
                            'Lastupdate' => Carbon::now("Asia/Kuala_Lumpur")->toDateString(),
                            'Reg_Date' => Carbon::now("Asia/Kuala_Lumpur")->toDateString(),
                            'Reg_Time' => Carbon::now("Asia/Kuala_Lumpur")->toDateTimeString(),
                        ]);

                    DB::table('hisdb.episode')
                        ->where('compcode','13A')
                        ->where('MRN',$value->mrn)
                        ->where('episno',$value->episno)
                        ->update([
                            "episactive" => '0',
                        ]);

                }
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
            // return response('Error'.$e, 500);
        }

        
    }

    public function auto_labresult(){
        DB::beginTransaction();

        try {

            $labresult = DB::table('hisdb.labresult')
                        ->where('compcode','13A')
                        ->where('upload','0');

            if($labresult->exists()){
                $labresult = $labresult->get();

                foreach ($labresult as $key => $value) {
                    $this->labresult_store($value);


                    DB::table('hisdb.labresult')
                        ->where('auditno',$value->auditno)
                        ->update([
                            'upload' => '1'
                        ]);
                
                }

            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
        }
    }

    public function labresult_store($obj){
        // $dialysis_path = 'D:\laragon\www\patientcare\public\uploads';
        $dialysis_path = 'C:\laragon\www\dialysis\uploads';

        $file = fopen($dialysis_path.'/'.$obj->attachmentfile, "r");

        $lineno = 0;
        while(!feof($file)) {
            $line = fgets($file). "<br>";
            if($lineno > 1){
                $lines = explode(",",$line);
                if(count($lines) != 73){
                    continue;
                }

                DB::table('hisdb.blood_data')
                            ->insert([
                                'auditno' => $obj->auditno,
                                'no' => trim(trim($lines[0],'"')),
                                'clientid' => trim(trim($lines[1],'"')),
                                'ourlabno' => trim(trim($lines[2],'"')),
                                'name' => trim(trim($lines[3],'"')),
                                'icno' => trim(trim($lines[4],'"')),
                                'age' => trim(trim($lines[5],'"')),
                                'sex' => trim(trim($lines[6],'"')),
                                'sampledate' => Carbon::createFromFormat('d/m/Y', trim(trim($lines[7],'"'))),
                                'esr' => trim(trim($lines[8],'"')),
                                'trbc' => trim(trim($lines[9],'"')),
                                'hb' => trim(trim($lines[10],'"')),
                                'pcv' => trim(trim($lines[11],'"')),
                                'mcv' => trim(trim($lines[12],'"')),
                                'mch' => trim(trim($lines[13],'"')),
                                'mchc' => trim(trim($lines[14],'"')),
                                'pc' => trim(trim($lines[15],'"')),
                                'twbc' => trim(trim($lines[16],'"')),
                                'dc' => trim(trim($lines[17],'"')),
                                'preurea' => trim(trim($lines[18],'"')),
                                'posturea' => trim(trim($lines[19],'"')),
                                'creatinine' => trim(trim($lines[20],'"')),
                                'calcium' => trim(trim($lines[21],'"')),
                                'inorganicphosphate' => trim(trim($lines[22],'"')),
                                'uricacid' => trim(trim($lines[23],'"')),
                                'sodium' => trim(trim($lines[24],'"')),
                                'potassium' => trim(trim($lines[25],'"')),
                                'chloride' => trim(trim($lines[26],'"')),
                                'glucose' => trim(trim($lines[27],'"')),
                                'hc03' => trim(trim($lines[28],'"')),
                                'totalcholesteral' => trim(trim($lines[29],'"')),
                                'hdlcholesteral' => trim(trim($lines[30],'"')),
                                'ldlcholesteral' => trim(trim($lines[31],'"')),
                                'triglycerides' => trim(trim($lines[32],'"')),
                                'hdlratio' => trim(trim($lines[33],'"')),
                                'totalprotein' => trim(trim($lines[34],'"')),
                                'albumin' => trim(trim($lines[35],'"')),
                                'globulin' => trim(trim($lines[36],'"')),
                                'albuminglobulinratio' => trim(trim($lines[37],'"')),
                                'totalbilirubin' => trim(trim($lines[38],'"')),
                                'alkalinephosphatase' => trim(trim($lines[39],'"')),
                                'ast' => trim(trim($lines[40],'"')),
                                'alt' => trim(trim($lines[41],'"')),
                                'ggt' => trim(trim($lines[42],'"')),
                                'afp' => trim(trim($lines[43],'"')),
                                'vdrl' => trim(trim($lines[44],'"')),
                                'hbsantibody' => trim(trim($lines[45],'"')),
                                'hbsantigen' => trim(trim($lines[46],'"')),
                                'hiv12' => trim(trim($lines[47],'"')),
                                'hepatitiscantibody' => trim(trim($lines[48],'"')),
                                'pthintact' => trim(trim($lines[49],'"')),
                                'hba1c' => trim(trim($lines[50],'"')),
                                'imm' => trim(trim($lines[51],'"')),
                                'hbvdnarealtimepcr' => trim(trim($lines[52],'"')),
                                'hepatitisbcoreantibody' => trim(trim($lines[53],'"')),
                                'tsh' => trim(trim($lines[54],'"')),
                                'freet4' => trim(trim($lines[55],'"')),
                                'freet3' => trim(trim($lines[56],'"')),
                                'neutrophil' => trim(trim($lines[57],'"')),
                                'lymphocyte' => trim(trim($lines[58],'"')),
                                'monocyte' => trim(trim($lines[59],'"')),
                                'eosinophil' => trim(trim($lines[60],'"')),
                                'basophil' => trim(trim($lines[61],'"')),
                                'atypicallymphocyte' => trim(trim($lines[62],'"')),
                                'tibc' => trim(trim($lines[63],'"')),
                                'ferritin' => trim(trim($lines[64],'"')),
                                'serumiron' => trim(trim($lines[65],'"')),
                                'patientname' => trim(trim($lines[66],'"')),
                                'controltime' => trim(trim($lines[67],'"')),
                                'inr' => trim(trim($lines[68],'"')),
                                'bloodgroup' => trim(trim($lines[69],'"')),
                                'tppa' => trim(trim($lines[70],'"')),
                                'transferrinsaturation' => trim(trim($lines[71],'"')),
                                'vitaminb12' => $this->lab_hujung(trim(trim($lines[72],'"<br>')))
                            ]);
            }
            $lineno++;
        }

        fclose($file);
    }

    public function lab_hujung($strlab){
        if($strlab == '"'){
            return '';
        }else{
            return $strlab;
        }
    }

    
}
