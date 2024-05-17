<?php

namespace Database\Seeders;

use App\Models\ChatsActivity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChatsActivityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ChatsActivity::factory(200)->create();
    }
}
