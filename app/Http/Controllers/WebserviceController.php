<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use stdClass;
use App\User;
use DB;
use Auth;
use Carbon\Carbon;
use Hash;
use Session;

class WebserviceController extends Controller
{
    public function __construct()
    {

    }

    public function store_dashb(Request $request){
        $month = ltrim($request->month, '0');
        $year = $request->year;

        $firstdate = Carbon::createFromDate($year, $month, 1);
        $seconddate = Carbon::createFromDate($year, $month, 1)->addDays(6);
        $thirddate = Carbon::createFromDate($year, $month, 1)->addDays(12+1);
        $fourthdate = Carbon::createFromDate($year, $month, 1)->addDays(18+2);
        $fiftthdate = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        $units = DB::table('pateis_rev')->select('units')->distinct()->get();

        foreach ($units as $key => $unit) {
            $week1ip = DB::table('pateis_rev')
                    ->where('year','=','Y'.$year)
                    ->where('month','=','M'.str_pad($month,2,"0",STR_PAD_LEFT))
                    ->where('epistype','=','IP')
                    ->where('units','=', $unit->units)
                    ->where('datetype','=','DIS')
                    ->whereBetween('disdate', [$firstdate, $seconddate])
                    ->sum('amount');

            $week2ip = DB::table('pateis_rev')
                        ->where('year','=','Y'.$year)
                        ->where('month','=','M'.str_pad($month,2,"0",STR_PAD_LEFT))
                        ->where('epistype','=','IP')
                        ->where('units','=', $unit->units)
                        ->where('datetype','=','DIS')
                        ->whereBetween('disdate', [$seconddate, $thirddate])
                        ->sum('amount');

            $week3ip = DB::table('pateis_rev')
                        ->where('year','=','Y'.$year)
                        ->where('month','=','M'.str_pad($month,2,"0",STR_PAD_LEFT))
                        ->where('epistype','=','IP')
                        ->where('units','=', $unit->units)
                        ->where('datetype','=','DIS')
                        ->whereBetween('disdate', [$thirddate, $fourthdate])
                        ->sum('amount');

            $week4ip = DB::table('pateis_rev')
                        ->where('year','=','Y'.$year)
                        ->where('month','=','M'.str_pad($month,2,"0",STR_PAD_LEFT))
                        ->where('epistype','=','IP')
                        ->where('units','=', $unit->units)
                        ->where('datetype','=','DIS')
                        ->whereBetween('disdate', [$fourthdate, $fiftthdate])
                        ->sum('amount');

            $patsumepis = DB::table('patsumepis')
                            ->where('month','=',$month)
                            ->where('year','=',$year)
                            ->where('units','=', $unit->units)
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
                    'units' => $unit->units,
                    'type' => 'REV',
                    'patient' => 'IP',
                    'week1' => $week1ip,
                    'week2' => $week2ip,
                    'week3' => $week3ip,
                    'week4' => $week4ip
                ]);
            }
        }

        
        foreach ($units as $key => $unit) {
            $week1op = DB::table('pateis_rev')
                    ->where('year','=','Y'.$year)
                    ->where('month','=','M'.str_pad($month,2,"0",STR_PAD_LEFT))
                    ->where('epistype','=','OP')
                    ->where('units','=', $unit->units)
                    ->where('datetype','=','DIS')
                    ->whereBetween('disdate', [$firstdate, $seconddate])
                    ->sum('amount');

            $week2op = DB::table('pateis_rev')
                        ->where('year','=','Y'.$year)
                        ->where('month','=','M'.str_pad($month,2,"0",STR_PAD_LEFT))
                        ->where('epistype','=','OP')
                        ->where('units','=', $unit->units)
                        ->where('datetype','=','DIS')
                        ->whereBetween('disdate', [$seconddate, $thirddate])
                        ->sum('amount');

            $week3op = DB::table('pateis_rev')
                        ->where('year','=','Y'.$year)
                        ->where('month','=','M'.str_pad($month,2,"0",STR_PAD_LEFT))
                        ->where('epistype','=','OP')
                        ->where('units','=', $unit->units)
                        ->where('datetype','=','DIS')
                        ->whereBetween('disdate', [$thirddate, $fourthdate])
                        ->sum('amount');

            $week4op = DB::table('pateis_rev')
                        ->where('year','=','Y'.$year)
                        ->where('month','=','M'.str_pad($month,2,"0",STR_PAD_LEFT))
                        ->where('epistype','=','OP')
                        ->where('units','=', $unit->units)
                        ->where('datetype','=','DIS')
                        ->whereBetween('disdate', [$fourthdate, $fiftthdate])
                        ->sum('amount');


            $patsumepis = DB::table('patsumepis')
                            ->where('month','=',$month)
                            ->where('year','=',$year)
                            ->where('units','=', $unit->units)
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
                    'units' => $unit->units,
                    'type' => 'REV',
                    'patient' => 'OP',
                    'week1' => $week1op,
                    'week2' => $week2op,
                    'week3' => $week3op,
                    'week4' => $week4op
                ]);
            }
        }
        


        $units = DB::table('pateis_epis')->select('units')->distinct()->get();

        foreach ($units as $key => $unit) {
            $week1ip_pt = DB::table('pateis_epis')
                    ->where('year','=','Y'.$year)
                    ->where('month','=','M'.str_pad($month,2,"0",STR_PAD_LEFT))
                    ->where('epistype','=','IN-PATIENT')
                    ->where('units','=', $unit->units)
                    ->where('datetype','=','DIS')
                    ->whereBetween('admdate', [$firstdate, $seconddate])
                    ->count();

            $week2ip_pt = DB::table('pateis_epis')
                        ->where('year','=','Y'.$year)
                        ->where('month','=','M'.str_pad($month,2,"0",STR_PAD_LEFT))
                        ->where('epistype','=','IN-PATIENT')
                        ->where('units','=', $unit->units)
                        ->where('datetype','=','DIS')
                        ->whereBetween('admdate', [$seconddate, $thirddate])
                        ->count();

            $week3ip_pt = DB::table('pateis_epis')
                        ->where('year','=','Y'.$year)
                        ->where('month','=','M'.str_pad($month,2,"0",STR_PAD_LEFT))
                        ->where('epistype','=','IN-PATIENT')
                        ->where('units','=', $unit->units)
                        ->where('datetype','=','DIS')
                        ->whereBetween('admdate', [$thirddate, $fourthdate])
                        ->count();

            $week4ip_pt = DB::table('pateis_epis')
                        ->where('year','=','Y'.$year)
                        ->where('month','=','M'.str_pad($month,2,"0",STR_PAD_LEFT))
                        ->where('epistype','=','IN-PATIENT')
                        ->where('units','=', $unit->units)
                        ->where('datetype','=','DIS')
                        ->whereBetween('admdate', [$fourthdate, $fiftthdate])
                        ->count();

            $patsumepis = DB::table('patsumepis')
                            ->where('year','=',$year)
                            ->where('month','=',$month)
                            ->where('units','=', $unit->units)
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
                    'units' => $unit->units,
                    'type' => 'epis',
                    'patient' => 'IP',
                    'week1' => $week1ip_pt,
                    'week2' => $week2ip_pt,
                    'week3' => $week3ip_pt,
                    'week4' => $week4ip_pt
                ]);
            }
        }
        

        foreach ($units as $key => $unit) {
            $week1op_pt = DB::table('pateis_epis')
                        ->where('year','=','Y'.$year)
                        ->where('month','=','M'.str_pad($month,2,"0",STR_PAD_LEFT))
                        ->where('epistype','=','OUT-PATIENT')
                        ->where('units','=', $unit->units)
                        ->where('datetype','=','DIS')
                        ->whereBetween('admdate', [$firstdate, $seconddate])
                        ->count();

            $week2op_pt = DB::table('pateis_epis')
                        ->where('year','=','Y'.$year)
                        ->where('month','=','M'.str_pad($month,2,"0",STR_PAD_LEFT))
                        ->where('epistype','=','OUT-PATIENT')
                        ->where('units','=', $unit->units)
                        ->where('datetype','=','DIS')
                        ->whereBetween('admdate', [$seconddate, $thirddate])
                        ->count();

            $week3op_pt = DB::table('pateis_epis')
                        ->where('year','=','Y'.$year)
                        ->where('month','=','M'.str_pad($month,2,"0",STR_PAD_LEFT))
                        ->where('epistype','=','OUT-PATIENT')
                        ->where('units','=', $unit->units)
                        ->where('datetype','=','DIS')
                        ->whereBetween('admdate', [$thirddate, $fourthdate])
                        ->count();

            $week4op_pt = DB::table('pateis_epis')
                        ->where('year','=','Y'.$year)
                        ->where('month','=','M'.str_pad($month,2,"0",STR_PAD_LEFT))
                        ->where('epistype','=','OUT-PATIENT')
                        ->where('units','=', $unit->units)
                        ->where('datetype','=','DIS')
                        ->whereBetween('admdate', [$fourthdate, $fiftthdate])
                        ->count();

            $patsumepis = DB::table('patsumepis')
                            ->where('year','=',$year)
                            ->where('month','=',$month)
                            ->where('units','=', $unit->units)
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
                    'units' => $unit->units,
                    'type' => 'epis',
                    'patient' => 'OP',
                    'week1' => $week1op_pt,
                    'week2' => $week2op_pt,
                    'week3' => $week3op_pt,
                    'week4' => $week4op_pt
                ]);
            }
        }

        $units = DB::table('pateis_rev')->select('units')->distinct()->get();
        $groupdesc_ = DB::table('pateis_rev')->distinct()->get(['groupdesc']);

        foreach ($units as $key_units => $unit) {

            $groupdesc_val_op = [];
            $groupdesc_val_ip = [];
            $groupdesc_val = [];

            foreach ($groupdesc_ as $key => $value) {
                $groupdesc_op = DB::table('pateis_rev')
                                ->where('year','=','Y'.$year)
                                ->where('month','=','M'.str_pad($month,2,"0",STR_PAD_LEFT))
                                ->where('epistype','=','OP')
                                ->where('groupdesc','=',$value->groupdesc)
                                ->where('units','=', $unit->units)
                                ->where('datetype','=','DIS');

                $groupdesc_op_sum = $groupdesc_op->sum('amount');
                $groupdesc_op_cnt = $groupdesc_op->count();

                $groupdesc_val_op[$key] = $groupdesc_op_sum;
                $groupdesc_cnt_op[$key] = $groupdesc_op_cnt;

                $groupdesc_ip = DB::table('pateis_rev')
                                ->where('year','=','Y'.$year)
                                ->where('month','=','M'.str_pad($month,2,"0",STR_PAD_LEFT))
                                ->where('epistype','=','IP')
                                ->where('groupdesc','=',$value->groupdesc)
                                ->where('units','=', $unit->units)
                                ->where('datetype','=','DIS');

                $groupdesc_ip_sum = $groupdesc_ip->sum('amount');
                $groupdesc_ip_cnt = $groupdesc_ip->count();

                $groupdesc_val_ip[$key] = $groupdesc_ip_sum;
                $groupdesc_cnt_ip[$key] = $groupdesc_ip_cnt;
                $groupdesc_val[$key] = $groupdesc_op_sum + $groupdesc_ip_sum;

            }

            $patsumrev = DB::table('patsumrev')
                            ->where('month','=',$month)
                            ->where('year','=',$year)
                            ->where('units','=', $unit->units);

            if($patsumrev->exists()){
                $patsumrev = DB::table('patsumrev')
                                ->where('month','=',$month)
                                ->where('year','=',$year)
                                ->where('units','=', $unit->units);

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
                                    'units' => $unit->units,
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

    }
    
}
