<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use Carbon\Carbon;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        //     $customers = [
        //         [
        //             'full_name' => 'Nguyễn Văn A',
        //             'email' => 'nguyenvana@gmail.com',
        //             'phone' => '0901234567',
        //             'address' => '123 Đường Láng, Hà Nội',
        //             'birth_day' => '1990-01-01',
        //             'registration_date' => Carbon::now(),
        //         ],
        //         [
        //             'full_name' => 'Trần Thị B',
        //             'email' => 'tranthib@gmail.com',
        //             'phone' => '0901234568',
        //             'address' => '456 Nguyễn Huệ, TP.HCM',
        //             'birth_day' => '1995-05-10',
        //             'registration_date' => Carbon::now(),
        //         ],
        //         [
        //             'full_name' => 'Lê Văn C',
        //             'email' => 'levanc@gmail.com',
        //             'phone' => '0901234569',
        //             'address' => '789 Lê Lợi, Đà Nẵng',
        //             'birth_day' => '1988-12-20',
        //             'registration_date' => Carbon::now(),
        //         ],
        //     ];

        //     foreach ($customers as $customer) {
        //         Customer::create($customer);
        //     }
    }
}
