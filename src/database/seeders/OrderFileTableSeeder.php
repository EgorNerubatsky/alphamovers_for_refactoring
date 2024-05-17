<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OrderFile;
use App\Models\Order;

class OrderFileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::all()->each(function($order){
            $orderfile = OrderFile::factory()->create();
            $order->orderfiles()->save($orderfile);
        });
    }
}
