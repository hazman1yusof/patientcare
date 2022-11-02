<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use stdClass;
use DB;
use Carbon\Carbon;
use Response;
use Auth;
use Storage;

class testController extends Controller
{   
    
    public function __construct()
    {

    }

    // public function test(Request $request){

    //     $array = [
    //         ['381229015174','BAITULMAL'],
    //         ['570402105716','CASH'],
    //         ['450710055072','JKOASW'],
    //         ['591202015508','BAITULMAL'],
    //         ['610430105872','JPA'],
    //         ['641003045504','BAITULMAL'],
    //         ['020805060595','BAITULMAL'],
    //         ['650102025677','BAITULMAL'],
    //         ['920703145831','BAITULMAL'],
    //         ['700521086071','UKM'],
    //         ['670111045619','BAITULMAL'],
    //         ['620903045355','JPA'],
    //         ['620425085677','JKOASW'],
    //         ['501213055247','BAITULMAL'],
    //         ['610218025445','BAITULMAL'],
    //         ['860404565332','BAITULMAL'],
    //         ['720409145287','BAITULMAL'],
    //         ['511002085584','JPA'],
    //         ['721129085106','BAITULMAL'],
    //         ['001105070668','BAITULMAL'],
    //         ['520713045508','BAITULMAL'],
    //         ['750109035366','BAITULMAL'],
    //         ['610216106038','MAIS'],
    //         ['541127086342','JPA'],
    //         ['750625105818','BAITULMAL'],
    //         ['550113105076','BAITULMAL'],
    //         ['500604105251','BAITULMAL'],
    //         ['680422015897','BAITULMAL'],
    //         ['820905085648','BAITULMAL'],
    //         ['730213145022','BAITULMAL'],
    //         ['670419045404','BAITULMAL'],
    //         ['620105065140','JPA'],
    //         ['570224016488','JPA'],
    //         ['700522105094','BAITULMAL'],
    //         ['550205035298','BAITULMAL'],
    //         ['591017085774','BAITULMAL']
    //     ];

    //     DB::beginTransaction();

    //     try {

    //         foreach ($array as $key => $value) {
    //             $debtorcode = trim($value[1]);
    //             $newic = trim($value[0]);
    //             echo $newic;
    //             switch ($debtorcode) {
    //                 case 'BAITULMAL':
    //                         $epis_fin = 'BM';
    //                     break;
    //                 case 'JPA':
    //                         $epis_fin = 'JK';
    //                     break;
    //                 case 'PERKESO':
    //                         $epis_fin = 'PS';
    //                     break;
    //                 case 'DBKL':
    //                         $epis_fin = 'JK';
    //                     break;
    //                 case 'UKM':
    //                         $epis_fin = 'JK';
    //                     break;
    //                 case 'JHEV':
    //                         $epis_fin = 'JK';
    //                     break;
    //                 case 'MAIS':
    //                         $epis_fin = 'MA';
    //                     break;
    //                 case 'RAMPAI':
    //                         $epis_fin = 'JK';
    //                     break;
    //                 case 'KPM':
    //                         $epis_fin = 'JK';
    //                     break;
    //                 default:
    //                         $epis_fin = 'JK';
    //                     break;
    //             }

    //             $pat_mast = DB::table('hisdb.pat_mast')
    //                             ->where('Newic',$newic)
    //                             ->where('compcode','13A')
    //                             ->orderBy('idno','DESC');

    //             if($pat_mast->exists()){
    //                 $pat_mast_data = $pat_mast->first();
    //             }

    //             $newepisno = 2;
    //             $name = $pat_mast_data->Name;
    //             $mrn = $pat_mast_data->MRN;

    //             $episode = DB::table('hisdb.episode')
    //                             ->where('compcode','13A')
    //                             ->where('mrn',$mrn)
    //                             ->where('episno',$newepisno);

    //             if($episode->exists()){
    //                 continue;
    //             }

    //             $pat_mast
    //                 ->update([
    //                     'episno' => $newepisno,
    //                     'patstatus' => 1,
    //                     'last_visit_date' => '2022-10-01',
    //                     'Lastupdate' => Carbon::now("Asia/Kuala_Lumpur"),
    //                     'LastUser' => 'system'
    //                 ]);

    //             DB::table("hisdb.episode")
    //                 ->insert([
    //                     "compcode" => '13A',
    //                     "mrn" => $mrn,
    //                     "episno" => $newepisno,
    //                     "epistycode" => 'OP',
    //                     "reg_date" => '2022-10-01',
    //                     "reg_time" => Carbon::now("Asia/Kuala_Lumpur"),
    //                     "regdept" => 'BM',
    //                     "admsrccode" => 'APPT',
    //                     "case_code" => 'HDS',
    //                     "admdoctor" => 'HALIM',
    //                     "attndoctor" => 'AZMAN',
    //                     "pay_type" => $epis_fin,
    //                     "pyrmode" => 'PANEL',
    //                     "billtype" => 'OP',
    //                     "payer" => $debtorcode,
    //                     "followupNP" => 1,
    //                     "adddate" => Carbon::now("Asia/Kuala_Lumpur"),
    //                     "adduser" => 'system',
    //                     "episactive" => 1,
    //                     "allocpayer" => 1,
    //                     'episstatus' => 'CURRENT',
    //                 ]);

    //             DB::table('hisdb.epispayer')
    //                 ->insert([
    //                     'CompCode' => '13A',
    //                     'MRN' => $mrn,
    //                     'Episno' => $newepisno,
    //                     'EpisTyCode' => 'OP',
    //                     'LineNo' => '1',
    //                     'BillType' => 'OP',
    //                     'PayerCode' => $debtorcode,
    //                     'Pay_Type' => $epis_fin,
    //                     'AddDate' => Carbon::now("Asia/Kuala_Lumpur"),
    //                     'AddUser' => 'system',
    //                     'Lastupdate' => Carbon::now("Asia/Kuala_Lumpur"),
    //                     'LastUser' => 'system'
    //                 ]);

    //             $queue_obj = DB::table('sysdb.sysparam')
    //                     ->where('compcode','=','13A')
    //                     ->where('source','=','QUE')
    //                     ->where('trantype','=','OP');

    //             $queue_data = $queue_obj->first();

    //             //ni start kosong balik bila hari baru
    //             if($queue_data->pvalue2 != Carbon::now("Asia/Kuala_Lumpur")->toDateString()){
    //                 $queue_obj
    //                     ->update([
    //                         'pvalue1' => 1,
    //                         'pvalue2' => Carbon::now("Asia/Kuala_Lumpur")->toDateString()
    //                     ]);

    //                 $current_pvalue1 = 1;
    //             }else{
    //                 $current_pvalue1 = intval($queue_data->pvalue1);
    //             }


    //             //tambah satu dkt queue sysparam
    //             $queue_obj
    //                 ->update([
    //                     'pvalue1' => $current_pvalue1+1
    //                 ]);

    //             DB::table('hisdb.queue')
    //                 ->insert([
    //                     'AdmDoctor' => 'HALIM',
    //                     'AttnDoctor' => 'AZMAN',
    //                     'BedType' => '',
    //                     'Case_Code' => "MED",
    //                     'CompCode' => '13A',
    //                     'Episno' => $newepisno,
    //                     'EpisTyCode' => 'OP',
    //                     'LastTime' => Carbon::now("Asia/Kuala_Lumpur")->toTimeString(),
    //                     'Lastupdate' => Carbon::now("Asia/Kuala_Lumpur")->toDateString(),
    //                     'Lastuser' => 'system',
    //                     'MRN' => $mrn,
    //                     'Reg_Date' => Carbon::now("Asia/Kuala_Lumpur")->toDateString(),
    //                     'Reg_Time' => Carbon::now("Asia/Kuala_Lumpur")->toDateTimeString(),
    //                     'Bed' => '',
    //                     'Room' => '',
    //                     'QueueNo' => $current_pvalue1,
    //                     'Deptcode' => 'ALL',
    //                     // 'DOB' => $this->null_date($patmast_data->DOB),
    //                     'NAME' => $name,
    //                     'Newic' => $newic,
    //                     // 'Oldic' => $patmast_data->Oldic,
    //                     // 'Sex' => $patmast_data->Sex,
    //                     // 'Religion' => $patmast_data->Religion,
    //                     // 'RaceCode' => $patmast_data->RaceCode,
    //                     'EpisStatus' => '',
    //                     'chggroup' => 'OP'
    //                 ]);

    //             DB::table('hisdb.queue')
    //                 ->insert([
    //                     'AdmDoctor' => 'HALIM',
    //                     'AttnDoctor' => 'AZMAN',
    //                     'BedType' => '',
    //                     'Case_Code' => "MED",
    //                     'CompCode' => '13A',
    //                     'Episno' => $newepisno,
    //                     'EpisTyCode' => "OP",
    //                     'LastTime' => Carbon::now("Asia/Kuala_Lumpur")->toTimeString(),
    //                     'Lastupdate' => Carbon::now("Asia/Kuala_Lumpur")->toDateString(),
    //                     'Lastuser' => session('username'),
    //                     'MRN' => $mrn,
    //                     'Reg_Date' => Carbon::now("Asia/Kuala_Lumpur")->toDateString(),
    //                     'Reg_Time' => Carbon::now("Asia/Kuala_Lumpur")->toDateTimeString(),
    //                     'Bed' => '',
    //                     'Room' => '',
    //                     'QueueNo' => $current_pvalue1,
    //                     'Deptcode' => 'SPEC',
    //                     // 'DOB' => $this->null_date($patmast_data->DOB),
    //                     'NAME' => $name,
    //                     'Newic' => $newic,
    //                     // 'Oldic' => $patmast_data->Oldic,
    //                     // 'Sex' => $patmast_data->Sex,
    //                     // 'Religion' => $patmast_data->Religion,
    //                     // 'RaceCode' => $patmast_data->RaceCode,
    //                     'EpisStatus' => '',
    //                     'chggroup' => 'OP'
    //                 ]);

    //         }

    //         DB::commit();
    //     } catch (Exception $e) {
    //         DB::rollback();
    //         dd($e);
    //         // return response('Error'.$e, 500);
    //     }

    // }

    // public function test2(Request $request){

    //     $dialysis = DB::table('hisdb.dialysis')
    //                     ->whereNull('compcode')
    //                     ->whereNull('visit_date')
    //                     ->whereNotNull('visit_date_2')
    //                     ->get();

    //     foreach ($dialysis as $key => $value) {
    //         if(empty($value->visit_date_2)){
    //             continue;
    //         }
    //         $newvisit = explode('/',$value->visit_date_2);
    //         $visit_date = $newvisit[2].'-'.$newvisit[1].'-'.$newvisit[0];
            
    //         DB::table('hisdb.dialysis')
    //                 ->where('idno',$value->idno)
    //                 ->update([
    //                     'visit_date' => $visit_date
    //                 ]);
    //     }

    // }

    // public function test3(Request $request){

    //     $array = [
    //         ['302','66.5','4'],
    //         ['274','55.5','4'],
    //         ['177','52','4'],
    //         ['301','47.5','4'],
    //         ['290','72.5','4'],
    //         ['186','49','4'],
    //         ['201','49.5','4'],
    //         ['250','68','4'],
    //         ['187','71.5','4'],
    //         ['248','74.5','4'],
    //         ['188','61.5','4'],
    //         ['282','40.5','4'],
    //         ['207','76','4'],
    //         ['277','71.5','4'],
    //         ['208','71','4'],
    //         ['270','88','4'],
    //         ['179','57.5','4'],
    //         ['238','74','4'],
    //         ['156','82.5','4'],
    //         ['296','68.5','4'],
    //         ['289','69','4'],
    //         ['299','40.5','4'],
    //         ['158','56','4'],
    //         ['241','65','4'],
    //         ['284','79.5','4'],
    //         ['223','51','4'],
    //         ['199','48.5','4'],
    //         ['234','109','4'],
    //         ['269','66','4'],
    //         ['168','56','4'],
    //         ['246','49.5','4'],
    //         ['245','52','4'],
    //         ['225','59.5','4'],
    //         ['172','63.5','4'],
    //         ['235','62.5','4'],
    //         ['278','82.5','4'],
    //         ['185','57.5','4'],
    //         ['305','56.5','4'],
    //         ['257','64.5','4'],
    //         ['262','54','4'],
    //         ['165','60','4'],
    //         ['212','55','4'],
    //         ['203','62','4'],
    //         ['279','117','4']
    //     ];

    //     DB::beginTransaction();

    //     try {

    //         foreach ($array as $key => $value) {
    //             $mrn = trim($value[0]);
    //             $dry_weight = trim($value[1]);
    //             $duration_hd = trim($value[2]);

    //             $episode = DB::table('hisdb.episode')
    //                         ->where('compcode','13A')
    //                         ->where('mrn',$mrn);

    //             if($episode->exists()){
    //                 $episode->update([
    //                     'dry_weight' => $dry_weight,
    //                     'duration_hd' => $duration_hd
    //                 ]);
    //             }
    //         }

    //         DB::commit();
    //     } catch (Exception $e) {
    //         DB::rollback();
    //         dd($e);
    //         // return response('Error'.$e, 500);
    //     }
    // }


    // public function betulkan_episode(){
    //     $episode = DB::table('hisdb.episode')
    //                     ->where('compcode','13A')
    //                     ->where('episactive','1')
    //                     ->where('adduser','system');

    //     if($episode->exists()){
    //         $episode = $episode->get();

    //         foreach ($episode as $key => $value) {
    //             $lastepisno = intval($value->episno) - 1;


    //             $lastepisode = DB::table('hisdb.episode')
    //                             ->where('compcode','13A')
    //                             ->where('MRN',$value->mrn)
    //                             ->where('episno',$lastepisno);

    //             if($lastepisode->exists()){
    //                 $lastepisode = $lastepisode->first();
    //                 DB::table('hisdb.episode')
    //                     ->where('compcode','13A')
    //                     ->where('MRN',$value->mrn)
    //                     ->where('episno',$value->episno)
    //                     ->update([
    //                         "admsrccode" => $lastepisode->admsrccode, //
    //                         "case_code" => $lastepisode->case_code, //
    //                         "admdoctor" => $lastepisode->admdoctor, //
    //                         "attndoctor" => $lastepisode->attndoctor, //
    //                         "reg_date" => '2022-11-01'
    //                     ]);
    //             }       

    //         }


    //     }
    // }

}