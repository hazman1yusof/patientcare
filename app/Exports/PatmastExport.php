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

class PatmastExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct()
    {

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
        $pat_mast = DB::table('hisdb.pat_mast as p')
                        ->select('p.mrn','p.Name','p.addtype','p.Address1','p.Address2','p.Address3','p.Postcode','p.citycode','p.StateCode','p.telh','p.telhp','p.telhp2','p.idnumber','p.Newic','p.Oldic','p.Sex','p.DOB','p.Religion','p.Citizencode','p.OccupCode','p.Staffid','p.MaritalCode','p.LanguageCode','p.TitleCode','p.RaceCode','p.Reg_Date','p.last_visit_date','p.PatStatus','p.AddUser','p.AddDate','p.Sex','p.AreaCode','e.regdept','e.admdoctor','e.attndoctor','e.pay_type','epy.payercode')
                        ->leftJoin('hisdb.episode as e', function($join){
                            $join = $join->on('e.mrn', '=', 'p.mrn')
                                        ->on('e.episno','=','p.episno')
                                        ->where('e.compcode','13A');
                        })
                        ->leftJoin('hisdb.epispayer as epy', function($join){
                            $join = $join->on('epy.mrn', '=', 'p.mrn')
                                        ->on('epy.episno','=','p.episno')
                                        ->where('epy.compcode','13A');
                        })
                        ->where('p.active','=','1')
                        ->where('p.compcode','=','13A')
                        ->get();

        return $pat_mast;
    }

    public function headings(): array
    {
        return [
            'MRN','Name','addtype','Address1','Address2','Address3','Postcode','citycode','StateCode','telh','telhp','telhp2','idnumber','Newic','Oldic','Sex','DOB','Religion','Citizencode','OccupCode','Staffid','MaritalCode','LanguageCode','TitleCode','RaceCode','Reg_Date','last_visit_date','PatStatus','AddUser','AddDate','Sex','AreaCode','regdept','admdoctor','attndoctor','pay_type','payercode'
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
