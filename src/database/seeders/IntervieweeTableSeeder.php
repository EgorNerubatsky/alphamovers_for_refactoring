<?php

namespace Database\Seeders;

use App\Models\Interviewee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IntervieweeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Interviewee::factory(6)->create();
    }
}
