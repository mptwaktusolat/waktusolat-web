<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class JadualWaktuSolat extends Model
{
    protected $fillable = [
        'zone',
        'tahun',
        'bulan',
        'hari',
        'subuh',
        'syuruk',
        'zohor',
        'asar',
        'maghrib',
        'isyak'
    ];

    public function jakimZone()
    {
        return $this->belongsTo(Zon::class, 'zone', 'jakim_code');
    }

    public function getSubuhAttribute($value)
    {
        return Carbon::createFromTimestamp($value)->timezone('Asia/Kuala_Lumpur')->format('h:i A');
    }

    public function getZohorAttribute($value)
    {
        return Carbon::createFromTimestamp($value)->timezone('Asia/Kuala_Lumpur')->format('h:i A');
    }

    public function getAsarAttribute($value)
    {
        return Carbon::createFromTimestamp($value)->timezone('Asia/Kuala_Lumpur')->format('h:i A');
    }

    public function getMaghribAttribute($value)
    {
        return Carbon::createFromTimestamp($value)->timezone('Asia/Kuala_Lumpur')->format('h:i A');
    }

    public function getIsyakAttribute($value)
    {
        return Carbon::createFromTimestamp($value)->timezone('Asia/Kuala_Lumpur')->format('h:i A');
    }
}
