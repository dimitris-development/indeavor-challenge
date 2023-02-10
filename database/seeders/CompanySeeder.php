<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->insert([
            [
                'id' => 1,
                'name' => 'Indeavor',
                'uuid' => (string) Str::uuid()
            ],
            [
                'id' => 2,
                'name' => 'Test Company',
                'uuid' => (string) Str::uuid()
            ]
        ]);
    }
}
