<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employees')->insert([
            [
                'id' => 1,
                'uuid' => (string) Str::uuid(),
                'first_name' => 'Aggelikh',
                'last_name' => 'Karatza',
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'id' => 2,
                'uuid' => (string) Str::uuid(),
                'first_name' => 'Anastasia',
                'last_name' => 'Karatza',
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'id' => 3,
                'uuid' => (string) Str::uuid(),
                'first_name' => 'Philip',
                'last_name' => 'Karatzas',
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'id' => 4,
                'uuid' => (string) Str::uuid(),
                'first_name' => 'Konstantinos',
                'last_name' => 'Maglinhs',
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ]
        ]);

        DB::table('employee_skills')->insert([
            [
                'id' => 1,
                'skill_id' => 1,
                'employee_id' => 1
            ],
            [
                'id' => 2,
                'skill_id' => 2,
                'employee_id' => 2
            ],
            [
                'id' => 3,
                'skill_id' => 3,
                'employee_id' => 3
            ],
            [
                'id' => 4,
                'skill_id' => 4,
                'employee_id' => 4
            ],
            [
                'id' => 5,
                'skill_id' => 1,
                'employee_id' => 1
            ],
            [
                'id' => 6,
                'skill_id' => 2,
                'employee_id' => 2
            ],
        ]);
    }
}
