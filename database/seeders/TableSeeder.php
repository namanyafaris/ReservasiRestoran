<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TableSeeder extends Seeder
{
    public function run()
    {
        $locations = ['front', 'inside', 'outside'];

        $tables = [];

        for ($i = 1; $i <= 20; $i++) {
            $tables[] = [
                'name' => 'Table ' . $i,
                'guest_number' => rand(2, 10),
                'status' => 'available',
                'location' => $locations[array_rand($locations)],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('tables')->insert($tables);
    }
}
