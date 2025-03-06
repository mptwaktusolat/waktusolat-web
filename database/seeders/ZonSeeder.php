<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Zon;
use Illuminate\Support\Facades\Http;

class ZonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data in the Zon table
        Zon::truncate();

        // Fetch zones from the API
        $response = Http::get('https://api.waktusolat.app/zones');

        if ($response->successful()) {
            $zones = $response->json();

            // Insert zones into database
            foreach ($zones as $zone) {
                Zon::create([
                    'jakim_code' => $zone['jakimCode'],
                    'negeri' => $zone['negeri'],
                    'daerah' => $zone['daerah'],
                ]);
            }

            $this->command->info('Zones seeded successfully!');
        } else {
            $this->command->error('Failed to fetch zones from API.');
        }
    }
}
