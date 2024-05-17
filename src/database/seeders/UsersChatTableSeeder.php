<?php

namespace Database\Seeders;

use App\Models\UsersChat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersChatTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */


    public function run(): void
    {
        UsersChat::factory(50)->create();
    }
}
