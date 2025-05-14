<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvoiceServiceSeeder extends Seeder
{
    public function run()
    {
        $data = [];

        $invoiceIds = range(1, 20);
        $serviceIds = range(1, 5);

        foreach ($invoiceIds as $invoiceId) {
            $servicesForInvoice = array_rand($serviceIds, rand(1, 3));
            if (!is_array($servicesForInvoice)) {
                $servicesForInvoice = [$servicesForInvoice];
            }

            foreach ($servicesForInvoice as $serviceId) {
                $data[] = [
                    'invoice_id' => $invoiceId,
                    'service_id' => $serviceIds[$serviceId],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('invoice_service')->insert($data);
    }
}
