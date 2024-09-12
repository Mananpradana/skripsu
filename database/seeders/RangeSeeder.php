<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('range')->insert([
            ['id' => 1, 'name' => 'range', 'parah' => 40, 'sedang' => 25, 'rendah' => 10]           
        ]);
    }
}
