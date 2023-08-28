<?php

namespace App\Exports;

use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use DateTime;
use Carbon\Carbon;

class pat_monthly implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($request)
    {
        $this->mrn = $request->mrn;
        $this->episno = $request->episno;
        $this->month = $request->month;
        $this->year = $request->year;
        // $this->comp = DB::table('hisdb.pat_mast as p')
        //                 ->select('p.mrn','p.Sex','p.RaceCode','p.Religion','p.Citizencode','p.AreaCode','p.Postcode','e.regdept','e.admdoctor','e.attndoctor','e.pay_type','epy.payercode')
        //                 ->leftJoin('hisdb.episode as e', function($join) use ($request){
        //                     $join = $join->on('e.mrn', '=', 'p.mrn')
        //                                 ->on('e.episno','=','p.episno')
        //                                 ->where('e.compcode','13A');
        //                 })
        //                 ->leftJoin('hisdb.epispayer as epy', function($join) use ($request){
        //                     $join = $join->on('epy.mrn', '=', 'p.mrn')
        //                                 ->on('epy.episno','=','p.episno')
        //                                 ->where('epy.compcode','13A');
        //                 })
        //                 ->where('p.active','=','1')
        //                 ->where('p.compcode','=','13A')
        //                 ->get();
                
    }

    public function collection()
    {
        $mrn = $this->mrn;
        $episno = $this->episno;
        $month = $this->month;
        $year = $this->year;

        $pat_mast = DB::table('hisdb.pat_mast as p')
                        ->select('p.mrn','p.Name','p.addtype','p.Address1','p.Address2','p.Address3','p.Postcode','p.citycode','p.StateCode','p.telh','p.telhp','p.telhp2','p.idnumber','p.Newic','p.Oldic','p.Sex','p.DOB','p.Religion','p.Citizencode','p.OccupCode','p.Staffid','p.MaritalCode','p.LanguageCode','p.TitleCode','p.RaceCode','p.Reg_Date','p.last_visit_date','p.PatStatus','p.AddUser','p.AddDate','p.AreaCode','e.regdept','e.admdoctor','e.attndoctor','e.pay_type','epy.payercode','d.visit_date','d.start_time','d.prev_post_weight','d.machine_no','d.dialysate_ca','d.dialyser','d.last_visit','d.pre_weight','d.heparin_type','d.dialysate_flow','d.no_of_use','d.duration_of_hd','d.idwg','d.heparin_bolus','d.conductivity','d.dry_weight','d.target_weight','d.heparin_maintainance','d.check_for_residual','d.target_uf','d.prime_by','d.initiated_by','d.verified_by','d.prehd_systolic','d.prehd_diastolic','d.prehd_temperature','d.prehd_pulse','d.prehd_respiratory','d.eye','d.neck','d.abdomen','d.skin','d.lower_limb','d.access_placeholder','d.access','d.type','d.site','d.bruit','d.thrill','d.dressing','d.respiratory','d.cond_avf_ext_site','d.general_assesment','d.1_tc','d.1_bp','d.1_pulse','d.1_dh','d.1_bfr','d.1_vp','d.1_tmp','d.1_uv','d.1_f','d.user_1','d.1_remarks','d.2_tc','d.2_bp','d.2_pulse','d.2_dh','d.2_bfr','d.2_vp','d.2_tmp','d.2_uv','d.2_f','d.user_2','d.2_remarks','d.3_tc','d.3_bp','d.3_pulse','d.3_dh','d.3_bfr','d.3_vp','d.3_tmp','d.3_uv','d.3_f','d.user_3','d.3_remarks','d.4_tc','d.4_bp','d.4_pulse','d.4_dh','d.4_bfr','d.4_vp','d.4_tmp','d.4_uv','d.4_f','d.user_4','d.4_remarks','d.5_tc','d.5_bp','d.5_pulse','d.5_dh','d.5_bfr','d.5_vp','d.5_tmp','d.5_uv','d.5_f','d.user_5','d.5_remarks','d.post_hd_assesment','d.posthd_systolic','d.posthd_diastolic','d.posthd_temperatue','d.posthd_pulse','d.posthd_respiratory','d.time_complete','d.delivered_duration','d.post_weight','d.weight_loss','d.i_complication','d.hd_adequancy','d.ktv','d.urr','d.terminate_by')
                        ->join('hisdb.episode as e', function($join) use ($mrn,$episno,$month,$year){
                            $join = $join->where('e.mrn', '=', $mrn)
                                        ->whereMonth('e.reg_date', $month)
                                        ->whereYear('e.reg_date', $year)
                                        ->where('e.compcode','13A');
                        })->join('hisdb.dialysis as d', function($join) use ($mrn,$episno,$month,$year){
                            $join = $join->where('d.mrn', '=', $mrn)
                                        ->whereMonth('d.visit_date', $month)
                                        ->whereYear('d.visit_date', $year)
                                        ->where('d.compcode','13A');
                        })
                        ->leftJoin('hisdb.epispayer as epy', function($join){
                            $join = $join->on('epy.mrn', '=', 'p.mrn')
                                        ->on('epy.episno','=','p.episno')
                                        ->where('epy.compcode','13A');
                        })
                        ->where('p.mrn','=',$mrn)
                        ->where('p.active','=','1')
                        ->where('p.compcode','=','13A')
                        ->get();

        return $pat_mast;
    }

    public function headings(): array
    {
        return [
            'MRN','Name','addtype','Address1','Address2','Address3','Postcode','citycode','StateCode','telh','telhp','telhp2','idnumber','Newic','Oldic','Sex','DOB','Religion','Citizencode','OccupCode','Staffid','MaritalCode','LanguageCode','TitleCode','RaceCode','Reg Date','last visit date','PatStatus','AddUser','AddDate','AreaCode','regdept','admdoctor','attndoctor','pay type','payercode','visit date','start time','prev post weight','machine no','dialysate ca','dialyser','last visit','pre weight','heparin type','dialysate flow','no of use','duration of hd','idwg','heparin bolus','conductivity','dry weight','target weight','heparin maintainance','check for residual','target uf','prime by','initiated by','verified by','prehd systolic','prehd diastolic','prehd temperature','prehd pulse','prehd respiratory','eye','neck','abdomen','skin','lower limb','access placeholder','access','type','site','bruit','thrill','dressing','respiratory','cond avf ext site','general assesment','1st Hour Time','1st Hour bp','1st Hour pulse','1st Hour dh','1st Hour bfr','1st Hour vp','1st Hour tmp','1st Hour uv','1st Hour fluids','1st Added by','1st Hour remarks','2nd Hour Time','2nd Hour bp','2nd Hour pulse','2nd Hour dh','2nd Hour bfr','2nd Hour vp','2nd Hour tmp','2nd Hour uv','2nd Hour fluids','2nd Hour Added by','2nd Hour remarks','3rd Hour Time','3rd Hour bp','3rd Hour pulse','3rd Hour dh','3rd Hour bfr','3rd Hour vp','3rd Hour tmp','3rd Hour uv','3rd Hour fluids','3rd Hour Added by','3rd Hour remarks','4th Hour Time','4th Hour bp','4th Hour pulse','4th Hour dh','4th Hour bfr','4th Hour vp','4th Hour tmp','4th Hour uv','4th Hour fluids','4th Hour Added by','4th Hour remarks','5th Hour Time','5th Hour bp','5th Hour pulse','5th Hour dh','5th Hour bfr','5th Hour vp','5th Hour tmp','5th Hour uv','5th Hour fluids','5th Hour Added by','5th Hour remarks','post hd assesment','posthd systolic','posthd diastolic','posthd temperatue','posthd pulse','posthd respiratory','time complete','delivered duration','post weight','weight loss','complication','hd adequancy','ktv','urr','terminate by'
        ];
    }

    public function columnWidths(): array
    {
        // return [
        //     'A' => 15,
        //     'B' => 50,    
        //     'C' => 20
               
        // ];
    }

    public function columnFormats(): array
    {
        // return [
        //    'B' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        // ];
    }


    public function registerEvents(): array
    {


        return [
            // AfterSheet::class => function(AfterSheet $event) {
            //     // set up a style array for cell formatting
            //     $style_header = [
            //         'font' => [
            //             'bold' => true,
            //         ],
            //         'alignment' => [
            //             'horizontal' => Alignment::HORIZONTAL_CENTER
            //         ]
            //     ];

            //     $style_address = [
            //         'font' => [
            //             'bold' => true,
            //         ],
            //         'alignment' => [
            //             'horizontal' => Alignment::HORIZONTAL_RIGHT
            //         ]
            //     ];

            //     $style_address1 = [
            
            //         'alignment' => [
            //             'wrapText' => true
            //         ]
            //     ];

            //     // at row 1, insert 2 rows
            //     $event->sheet->insertNewRowBefore(1, 6);

            //     // assign cell values
            //     $event->sheet->setCellValue('A1','PRINTED DATE:');
            //     $event->sheet->setCellValue('B1', Carbon::now("Asia/Kuala_Lumpur")->format('d-m-Y'));
            //     $event->sheet->setCellValue('A2','PRINTED TIME:',);
            //     $event->sheet->setCellValue('B2', Carbon::now("Asia/Kuala_Lumpur")->format('H:i'));
            //     $event->sheet->setCellValue('A3','PRINTED BY:');
            //     $event->sheet->setCellValue('B3', session('username'));
            //     $event->sheet->setCellValue('C1','GL MASTER REPORT');
            //     $event->sheet->setCellValue('G1',$this->comp->name);
            //     $event->sheet->setCellValue('G2',$this->comp->address1);
            //     $event->sheet->setCellValue('G3',$this->comp->address2);
            //     $event->sheet->setCellValue('G4',$this->comp->address3);
            //     $event->sheet->setCellValue('G5',$this->comp->address4);

            //     // assign cell styles
            //     $event->sheet->getStyle('C1:C2')->applyFromArray($style_header);
            //     $event->sheet->getStyle('G1:G5')->applyFromArray($style_address);
            //     $event->sheet->getStyle('C:D')->getAlignment()->setWrapText(true);

            //     //getAlignment()->setWrapText(true);
            //     // $drawing = new Drawing();
            //     // $drawing->setName('Logo');
            //     // $drawing->setDescription('This is my logo');
            //     // $drawing->setPath(public_path('/img/logo.jpg'));
            //     // $drawing->setHeight(80);
            //     // $drawing->setCoordinates('E1');
            //     // $drawing->setOffsetX(40);
            //     // $drawing->setWorksheet($event->sheet->getDelegate());

            // },
        ];
    }


}
