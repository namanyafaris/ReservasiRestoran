<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category_menu')->delete(); // Optional: Clear existing relations
        $relations = [
            ['category_id' => 1, 'menu_id' => 1],
            ['category_id' => 1, 'menu_id' => 2],
            ['category_id' => 1, 'menu_id' => 3],

            ['category_id' => 2, 'menu_id' => 4],
            ['category_id' => 2, 'menu_id' => 5],
            ['category_id' => 2, 'menu_id' => 6],

            ['category_id' => 3, 'menu_id' => 7],
            ['category_id' => 3, 'menu_id' => 8],
            ['category_id' => 3, 'menu_id' => 9],
        ];

        DB::table('category_menu')->insert($relations);
    }
}
