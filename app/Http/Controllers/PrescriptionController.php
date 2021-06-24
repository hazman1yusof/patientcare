<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use stdClass;
use DB;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use Response;
use Auth;
use App\Models\SuratMasuk;

class PrescriptionController extends Controller
{   
    
    public function __construct()
    {

        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        
        $navbar = $this->navbar();
        // $filter_unit = $request->filter_unit;
        // $filter_kategori = $request->filter_kategori;
        // $filter_year = $request->filter_year;
        // $filter_month = $request->filter_month;
        // $filter_text = strtolower($request->filter_text);

        // $suratMasuk = SuratMasuk::with('unit', 'kategori', 'tahap')
        //     ->where(function($q) use($filter_unit, $filter_kategori, $filter_text, $filter_year, $filter_month){
        //         if($filter_unit){
        //             $q->where('unit_id', $filter_unit);
        //         }
        //         if($filter_kategori){
        //             $q->where('kategori_id', $filter_kategori);
        //         }
        //         if($filter_text){
        //             $q->whereRaw(DB::raw("(
        //                 LOWER(nomor) LIKE '%".$filter_text."%'
        //                 OR LOWER(perihal) LIKE '%".$filter_text."%'
        //             )"));
        //         }
        //         if($filter_year){
        //             $q->whereRaw(DB::raw("(
        //                 DATE_FORMAT(tanggal_terima,'%Y') = '".$filter_year."'
        //             )"));
        //         }
        //         if($filter_month){
        //             $q->whereRaw(DB::raw("(
        //                 DATE_FORMAT(tanggal_terima,'%m') = '".$filter_month."'
        //             )"));
        //         }
        //     })
        //     ->orderBy('trxdate', 'asc')
        //     ->paginate(5);

        // $jenis = [
        //     "Dokumen", 
        //     "Surat Rangga", 
        //     "Surat Harian",
        // ];

        // $unit = unit::orderBy('id', 'asc')
        //     ->where(function($q) use($role, $unit_id){
        //         if($role == 'Staf'){
        //             $q->where('id', $unit_id);
        //         }
        //     })
        //     ->get();
            
        // $kategori = kategori::orderBy('jenis', 'asc')
        //     ->orderBy('id', 'asc')
        //     ->get();

        // $tahap = tahap::orderBy('jenis', 'asc')
        //     ->orderBy('nama', 'asc')
        //     ->get();

        $filter_unit = $request->filter_unit;
        $filter_kategori = $request->filter_kategori;
        $filter_year = $request->filter_year;
        $filter_month = $request->filter_month;
        $filter_text = strtolower($request->filter_text);

        $table_prescription = DB::table('phisdb.prescription')->paginate(5);
        // dd($table_prescription);

        return view('prescription', compact('table_prescription','filter_unit','filter_kategori','filter_year','filter_month','filter_text'));
    }

    public function detail($id,Request $request)
    {

        return view('pres_detail');
    }

}