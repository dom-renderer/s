<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'roles' => ['admin'],
                'user' => [
                    'name' => 'Super Admin',
                    'email' => 'admin@gmail.com',
                    'dial_code' => 91,
                    'status' => 1,
                    'phone_number' => 9999999999,
                    'password' => 12345678,
                    'added_by' => 1
                ]
            ],
            [
                'roles' => ['manager'],
                'user' => [
                    'name' => 'Adriana Lima',
                    'email' => 'adlima@gmail.com',
                    'dial_code' => 1,
                    'status' => 1,
                    'phone_number' => 246123456,
                    'password' => 12345678,
                    'added_by' => 1
                ]
            ],
            [
                'roles' => ['manager'],
                'user' => [
                    'name' => 'Peter griffin',
                    'email' => 'petergriffin@gmail.com',
                    'dial_code' => 1,
                    'status' => 1,
                    'phone_number' => 246649784,
                    'password' => 12345678,
                    'added_by' => 1
                ]
            ],
            [
                'roles' => ['manager'],
                'user' => [
                    'name' => "Kendall Jenner",
                    'email' => 'kendallj@gmail.com',
                    'dial_code' => 1,
                    'status' => 1,
                    'phone_number' => 2469876547,
                    'password' => 12345678,
                    'added_by' => 1
                ]
            ]
        ];

        foreach ($users as $user) {
            User::updateOrCreate(['email' => $user['user']['email']], $user['user'])->syncRoles($user['roles']);
        }
    }
}
