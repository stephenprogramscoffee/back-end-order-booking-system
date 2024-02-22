<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderBookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::insert([
            [
                'customer_code' => 'CUSNUM01',
                'customer_name' => 'Customer 1'
            ],
            [
                'customer_code' => 'CUSNUM02',
                'customer_name' => 'Customer 2'
            ]
        ]);

        Product::insert([
            [
                'product_code' => 'PRDNUM01',
                'product_name' => 'P1',
                'price' => 50
            ],
            [
                'product_code' => 'PRDNUM02',
                'product_name' => 'P2',
                'price' => 50
            ]
        ]);
    }
}
