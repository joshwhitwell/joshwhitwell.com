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
        $shouldSeedAdminUser = env('ADMIN_NAME')
            && env('ADMIN_EMAIL')
            && env('ADMIN_PASSWORD')
            && !User::where('email', env('ADMIN_EMAIL'))->exists();

        if ($shouldSeedAdminUser) {
            User::create([
                'name' => env('ADMIN_NAME'),
                'email' => env('ADMIN_EMAIL'),
                'email_verified_at' => now(),
                'password' => bcrypt(env('ADMIN_PASSWORD')),
            ]);
        }
    }
}
