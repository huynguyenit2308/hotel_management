<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RatingSeeder extends Seeder
{
    public function run()
    {
        $data = [];

        for ($i = 1; $i <= 20; $i++) {
            $rating = rand(1, 5); // Điểm đánh giá ngẫu nhiên từ 1 đến 5
            $comment = $rating > 3 ? 'Dịch vụ tuyệt vời!' : 'Cần cải thiện chất lượng dịch vụ!';

            $data[] = [
                'customer_id' => rand(1, 5), // ID khách hàng từ 1 đến 5 (phụ thuộc vào bảng `customer`)
                'rating' => $rating,
                'comment' => $comment,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('ratings')->insert($data);
    }
}
