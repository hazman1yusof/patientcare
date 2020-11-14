<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use stdClass;
use App\User;
use DB;
use Auth;
use Hash;
use Session;

class WebserviceController extends Controller
{
    public function __construct()
    {

    }

    public function episode(Request $request){

        $field = ['compcode','mrn','episno','admsrccode','epistycode','case_code','ward','bedtype','room','bed','admdoctor','attndoctor','refdoctor','prescribedays','pay_type','pyrmode','climitauthid','crnumber','depositreq','deposit','pkgcode','billtype','remarks','episstatus','episactive','adddate','adduser','reg_date','reg_time','dischargedate','dischargeuser','dischargetime','dischargedest','allocdoc','allocbed','allocnok','allocpayer','allocicd','lastupdate','lastuser','lasttime','procode','dischargediag','lodgerno','regdept','diet1','diet2','diet3','diet4','diet5','glauthid','treatcode','diagcode','complain','diagfinal','clinicalnote','conversion','newcaseP','newcaseNP','followupP','followupNP','bed2','bed3','bed4','bed5','bed6','bed7','bed8','bed9','bed10','diagprov','visitcase','PkgAutoNo','AgreementID','AdminFees','EDDept'];
        echo $request['mrn'];

        $exists = DB::table('hisdb.episode')
                ->where('mrn','=',$request['mrn'])
                ->where('episno','=',$request['episno'])
                ->exists();

        if(!$exists){
            $array_insert = [];
            foreach($field as $key => $value){
                $array_insert[$value] = $request[strtolower($value)];
            }

            DB::table('hisdb.episode')->insert($array_insert);
        }else{
            $array_insert = [];
            foreach($field as $key => $value){
                $array_insert[$value] = $request[strtolower($value)];
            }

            DB::table('hisdb.episode')
                ->where('mrn','=',$request['mrn'])
                ->where('episno','=',$request['episno'])
                ->update($array_insert);
        }
    }

    public function patmast(Request $request){

        $field = ['CompCode','MRN','Episno','Name','Call_Name','addtype','Address1','Address2','Address3','Postcode','citycode','AreaCode','StateCode','CountryCode','telh','telhp','telo','Tel_O_Ext','ptel','ptel_hp','ID_Type','idnumber','Newic','Oldic','icolor','Sex','DOB','Religion','AllergyCode1','AllergyCode2','Century','Citizencode','OccupCode','Staffid','MaritalCode','LanguageCode','TitleCode','RaceCode','bloodgrp','Accum_chg','Accum_Paid','first_visit_date','Reg_Date','last_visit_date','last_episno','PatStatus','Confidential','Active','FirstIpEpisNo','FirstOpEpisNo','AddUser','AddDate','Lastupdate','LastUser','OffAdd1','OffAdd2','OffAdd3','OffPostcode','MRFolder','MRLoc','MRActive','OldMrn','NewMrn','Remarks','RelateCode','ChildNo','CorpComp','Email','Email_official','CurrentEpis','NameSndx','BirthPlace','TngID','PatientImage','pAdd1','pAdd2','pAdd3','pPostCode','DeptCode','DeceasedDate','PatientCat','PatType','upduser','upddate','recstatus','loginid'];
        echo $request['name'];

        $exists = DB::table('hisdb.pat_mast')
                ->where('mrn','=',$request['mrn'])
                ->exists();
        echo $exists;

        if(!$exists){
            $array_insert = [];
            foreach($field as $key => $value){
                $array_insert[$value] = $request[strtolower($value)];
            }

            $table = DB::table('hisdb.pat_mast')->insert($array_insert);

        }else{
            $array_insert = [];
            foreach($field as $key => $value){
                $array_insert[$value] = $request[strtolower($value)];
            }

            DB::table('hisdb.pat_mast')
                ->where('mrn','=',$request['mrn'])
                ->update($array_insert);
        }
    }

    public function ticket(Request $request)
    {   
        $remember = false;

        $user = User::where('username',request('username'));

        if($user->count() > 0){
            if ($request->password == $user->first()->password) {
                Auth::login($user->first(),$remember);
                return redirect('/ticket');
            }else{
                $this->edit_user_pw($request);
                return redirect('/ticket');
            }
        }else{
            $this->create_user($request);
            return redirect('/ticket');
        }
    }

    public function create_user(Request $request){
        $user = new User;

        $user->compcode = '9A';
        $user->username = $request->username;
        $user->groupid = 'doctor';
        $user->password = $request->password;
        $user->remember_token = str_random(10);

        $user->save();

        Auth::login($user->first(),false);

    }

    public function edit_user_pw(Request $request){
        DB::table('sysdb.users')
            ->where('username',$request->username)
            ->update(['password' => $request->password]);

        $user = User::where('username',request('username'));

        Auth::login($user->first(),false);

    }
    
}
