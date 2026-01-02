<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminName = env('ADMIN_NAME');
        $adminEmail = env('ADMIN_EMAIL');
        $adminPassword = env('ADMIN_PASSWORD');

        if (!empty($adminName) && !empty($adminEmail) && !empty($adminPassword)) {
            if (!User::where('email', $adminEmail)->exists()) {
                User::create([
                    'name' => $adminName,
                    'email' => $adminEmail,
                    'email_verified_at' => now(),
                    'password' => bcrypt($adminPassword),
                ]);
            }
        }
    }
}
