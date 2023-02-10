<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'id' => 1,
                'slug' => 'admin',
                'uuid' => (string) Str::uuid(),
            ],
            [
                'id' => 2,
                'slug' => 'scheduler',
                'uuid' => (string) Str::uuid(),
            ]
        ]);
    }
}
