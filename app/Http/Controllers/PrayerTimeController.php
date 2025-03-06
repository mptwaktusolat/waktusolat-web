<?php

namespace App\Http\Controllers;

use App\Models\JadualWaktuSolat;
use App\Models\Zon;
use Illuminate\Http\Request;

class PrayerTimeController extends Controller
{
    public function index(string $zone, Request $request)
    {
        $inputZone = strtoupper($zone);

        $inputYear = (int) ($request->input('year') ?? date('Y'));
        $inputMonth = (int) ($request->input('month') ?? date('m'));
        $inputDay = (int) ($request->input('day') ?? date('d'));

        $prayerTimes = JadualWaktuSolat::where('zone', $inputZone)
            ->where('tahun', $inputYear)
            ->where('bulan', $inputMonth)
            ->where('hari', $inputDay)
            ->first();

        $zones = Zon::all();

        return inertia('Home', compact('prayerTimes', 'zones', 'inputZone', 'inputYear', 'inputMonth', 'inputDay'));
    }
}
