<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate([
            'name' => 'Simon',
            'email' => 'sr@mgk.dev',
            'password' => bcrypt(1234),
            'email_verified_at' => now(),
        ]);
    }
}
