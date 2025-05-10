<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('service')->insert([
            [
                'service_name' => 'Massage',
                'price' => 500000,
                'image' => 'massage.jpg',
                'description' => 'Dịch vụ massage thư giãn với các kỹ thuật chuyên nghiệp.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'service_name' => 'Spa',
                'price' => 700000,
                'image' => 'spa.jpg',
                'description' => 'Dịch vụ spa giúp thư giãn và làm đẹp da.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'service_name' => 'Tắm bùn',
                'price' => 600000,
                'image' => 'tam_bun.jpg',
                'description' => 'Dịch vụ tắm bùn khoáng giúp làn da khỏe mạnh và săn chắc.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
