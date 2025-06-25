<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menus')->delete(); // opsional

        $menus = [
            // Main Course
            [
                'name' => 'Nasi Goreng',
                'description' => 'Fried rice with egg and chicken.',
                'image' => 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?q=80&w=1025&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'price' => 25000,
                'rating' => 4.8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mie Ayam',
                'description' => 'Chicken noodle with savory broth.',
                'image' => 'https://plus.unsplash.com/premium_photo-1664475934279-2631a25c42ce?q=80&w=880&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'price' => 22000,
                'rating' => 4.6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sate Ayam',
                'description' => 'Grilled chicken skewers with peanut sauce.',
                'image' => 'https://images.unsplash.com/photo-1645696301019-35adcc18fc21?q=80&w=1329&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'price' => 28000,
                'rating' => 4.9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Drinks
            [
                'name' => 'Es Teh',
                'description' => 'Sweet iced tea, refreshing and cold.',
                'image' => 'https://images.unsplash.com/photo-1499638673689-79a0b5115d87?q=80&w=764&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'price' => 7000,
                'rating' => 4.2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jus Jeruk',
                'description' => 'Freshly squeezed orange juice.',
                'image' => 'https://plus.unsplash.com/premium_photo-1675667390417-d9d23160f4a6?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'price' => 9000,
                'rating' => 4.5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kopi Susu',
                'description' => 'Sweet iced milk coffee.',
                'image' => 'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?q=80&w=1169&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'price' => 15000,
                'rating' => 4.7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Snacks
            [
                'name' => 'Kentang Goreng',
                'description' => 'Crispy french fries with chili sauce.',
                'image' => 'https://images.unsplash.com/photo-1541592106381-b31e9677c0e5',
                'price' => 12000,
                'rating' => 4.5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Siomay',
                'description' => 'Steamed fish dumplings with peanut sauce.',
                'image' => 'https://images.unsplash.com/photo-1727403254476-06ce6f420f99?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'price' => 14000,
                'rating' => 4.3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pisang Goreng',
                'description' => 'Fried banana with crispy batter.',
                'image' => 'https://plus.unsplash.com/premium_photo-1714246610193-47ab117771a9?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'price' => 10000,
                'rating' => 4.4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        DB::table('menus')->insert($menus);
    }
}
