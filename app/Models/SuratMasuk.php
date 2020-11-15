<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    protected $table = 'prescription';

    protected $fillable = [
            'mrn',
            'episode',
            'name',
            'regdatetime',
            'psno',
            'trxdate',
            'chgcode',
            'description',
            'qty' ,
            'unitprice',
            'amount',
            'type',
            'dosage',
            'freq',
            'duration',
            'instruction',
            'doctor',
        ];

    protected $dates = [
        'tanggal_terima'
    ];
}
