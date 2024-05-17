<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OrderFile;
use App\Models\OrderFilePath;

class OrderFilePathTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderFile::all()->each(function ($orderfile) {
            $orderfilepath = OrderFilePath::factory()->count(3)->create(['file_id'=>$orderfile->id]);
            // $orderfile->orderfilepaths()->saveMany($orderfilepath);
        });
    }
}