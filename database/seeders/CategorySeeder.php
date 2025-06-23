<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->delete(); // opsional

        $categories = [
            [
                'name' => 'Main Course',
                'description' => 'Main dishes like rice and noodles.',
                'image' => 'https://images.unsplash.com/photo-1529566652340-2c41a1eb6d93?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Drinks',
                'description' => 'Beverages including juices and soft drinks.',
                'image' => 'https://images.unsplash.com/photo-1481671703460-040cb8a2d909?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Snacks',
                'description' => 'Light bites and appetizers.',
                'image' => 'https://images.unsplash.com/photo-1699666397768-0126340e880a?q=80&w=688&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('categories')->insert($categories);
    }
}
