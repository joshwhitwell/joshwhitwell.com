<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'id' => 1,
            'name' => env('ADMIN_NAME'),
            'email' => env('ADMIN_EMAIL'),
            'password' => bcrypt(env('ADMIN_PASSWORD')),
            'email_verified_at' => now(),
        ]);

        $this->command->call('app:import-workout-program', [
            'filename' => 'Intermediate-Advanced | 5-6X:Week Powerbuilding System.csv',
        ]);
    }
}
