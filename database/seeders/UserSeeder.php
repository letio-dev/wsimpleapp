<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk User.
     *
     * @return void
     */
    public function run(): void
    {
        // Insert 10 data user tanpa model, menggunakan DB Facade
        for ($i = 0; $i < 10; $i++) {
            DB::table('users')->insert([
                // 'sfId' => Str::uuid()->getBytes(),  // Menggunakan UUID dalam format BINARY(16)
                'username' => fake()->userName(),
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'email_verified_at' => now(),  // Mengatur tanggal verifikasi email
                'password' => Hash::make('password'),  // Mengatur password terenkripsi
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
