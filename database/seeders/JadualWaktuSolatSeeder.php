<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\JadualWaktuSolat;
use App\Models\Zon;
use DateTime;

class JadualWaktuSolatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Uncomment statement below to clear the table before seeding
        JadualWaktuSolat::truncate();

        // Check if Zone table is populated
        if (Zon::count() === 0) {
            $this->command->error('Zone table is empty. Please run ZonSeeder first.');
            return;
        }

        $zones = Zon::all();
        $year = 2025;

        foreach ($zones as $zone) {
            for ($month = 1; $month <= 12; $month++) {
                $response = Http::get("https://api.waktusolat.app/v2/solat/{$zone->jakim_code}", [
                    'year' => $year,
                    'month' => $month
                ]);

                if ($response->successful()) {
                    $data = $response->json();

                    // Assuming the API returns prayer times in the response
                    if (isset($data['prayers'])) {
                        foreach ($data['prayers'] as $prayerTime) {
                            $date = DateTime::createFromFormat('U', $prayerTime['dhuhr']);
                            JadualWaktuSolat::create([
                                'zone' => $zone->jakim_code,
                                'tahun' => (int)$date->format('Y'),
                                'bulan' => (int)$date->format('m'),
                                'hari' => (int)$date->format('d'),
                                'subuh' => $prayerTime['fajr'],
                                'syuruk' => $prayerTime['syuruk'],
                                'zohor' => $prayerTime['dhuhr'],
                                'asar' => $prayerTime['asr'],
                                'maghrib' => $prayerTime['maghrib'],
                                'isyak' => $prayerTime['isha'],
                            ]);
                        }
                    }

                    $this->command->info('Fetched prayer times for zone: ' . $zone->jakim_code . ' month: ' . $month . ' year: ' . $year . ' successfully!');
                }

                // Add a small delay to prevent API rate limiting
                sleep(.8);
            }
        }
    }
}
