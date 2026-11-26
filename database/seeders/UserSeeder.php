<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@kursusku.test'],
            [
                'name' => 'Administrator KursusKu',
                'role' => 'admin',
                'password' => Hash::make('AdminKursusKu123!'),
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'user@kursusku.test'],
            [
                'name' => 'Pengguna KursusKu',
                'role' => 'user',
                'password' => Hash::make('UserKursusKu123!'),
                'email_verified_at' => now(),
            ]
        );
    }
}
