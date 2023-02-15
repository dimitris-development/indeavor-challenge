<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('skills')->insert([
            [
                'id' => 1,
                'name' => 'Positive attitude',
                'description' => 'Having a positive attitude means being optimistic about situations, interactions, and yourself.',
                'uuid' => (string) Str::uuid(),
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'id' => 2,
                'name' => 'Communication',
                'description' => 'Communication skills are the abilities you use when giving and receiving different kinds of information.',
                'uuid' => (string) Str::uuid(),
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'id' => 3,
                'name' => 'Resilience',
                'description' => 'Resilience means being able to adapt to life\'s misfortunes and setbacks.',
                'uuid' => (string) Str::uuid(),
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'id' => 4,
                'name' => 'PHP',
                'description' => 'PHP is a general-purpose scripting language geared toward web development.[7] It was originally created by Danish-Canadian programmer Rasmus Lerdorf in 1993 and released in 1995.',
                'uuid' => (string) Str::uuid(),
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ]
        ]);
    }
}
