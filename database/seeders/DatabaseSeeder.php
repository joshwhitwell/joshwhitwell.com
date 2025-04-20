<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\WorkoutProgramSeeder;

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

        // $this->call([
        //     WorkoutProgramSeeder::class,
        // ]);

        $this->command->call('app:import-workout-program', [
            'filename' => 'the-essentials-program-5x.csv',
        ]);
    }
}
