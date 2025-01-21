<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\PureBodyBuildingSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (!User::where('email', env('ADMIN_EMAIL'))->exists()
            && env('ADMIN_EMAIL')
            && env('ADMIN_PASSWORD')
        ) {
            User::create(
                [
                    'email' => env('ADMIN_EMAIL'),
                    'name' => env('ADMIN_NAME'),
                    'password' => Hash::make(env('ADMIN_PASSWORD')),
                ]
            );
        }

        $this->call([
            PureBodyBuildingSeeder::class,
        ]);
    }
}
