<?php

namespace Database\Seeders;

use App\Models\Kanban;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KanbanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kanban::factory(25)->create();
    }
}
