<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $couriers = [
            'JNE' => 'JNE',
            'Shopee' => 'SPX',
            'JNT' => 'JNT',
            'AntarAja' => 'AAJ',
            'SiCepat' => 'SCP',
            'Gosend' => 'GSD',
            'GrabExpress' => 'GRB',
        ];

        $towers = ['BASELLA', 'AZOLLA', 'CALDESIA', 'DAVALLIA'];
        $usedTrackingNumbers = [];

        $notesOptions = [
            'Paket diluar',
            'Titip ke satpam',
            'Sudah diterima oleh tetangga',
            'Mohon hubungi penerima',
            'Simpan di loker paket',
            'Paket fragile, harap hati-hati',
            'Terima kasih sudah mengantar',
            'Jangan ditumpuk',
            null,
            null,
        ];

        for ($i = 0; $i < 2000; $i++) {
            // Random courier
            $courier = array_rand($couriers);

            // Generate unique tracking number
            do {
                $tracking_number = $couriers[$courier] . strtoupper(Str::random(8));
            } while (in_array($tracking_number, $usedTrackingNumbers));

            $usedTrackingNumbers[] = $tracking_number;

            // Random floor (02 - 29)
            $floor = str_pad(rand(2, 29), 2, '0', STR_PAD_LEFT);

            // Random unit (floor + 2 digit)
            $unit = $floor . str_pad(rand(1, 30), 2, '0', STR_PAD_LEFT);

            $notes = $notesOptions[array_rand($notesOptions)];

            // Call stored procedure
            DB::select("SELECT InsertActivity(
                ?, ?, ?, ?, ?, ?, ?, ?, ?
            )", [
                $tracking_number,
                $courier,
                $faker->name,
                $towers[array_rand($towers)],
                $floor,
                $unit,
                $faker->numerify('08##########'),
                $notes,
                mt_rand(1, 10),
            ]);
        }
    }
}
