<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Enums\UserRoleEnum;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'Dimitris',
                'uuid' => (string) Str::uuid(),
                'email' => 'dimitris@example.com',
                'password' => Hash::make('123456'),
                'role' => UserRoleEnum::Scheduler,
            ],
            [
                'id' => 2,
                'name' => 'Admin',
                'uuid' => (string) Str::uuid(),
                'email' => 'admin@example.com',
                'password' => Hash::make('123456'),
                'role' => UserRoleEnum::Admin,
            ]
        ]);
    }
}
