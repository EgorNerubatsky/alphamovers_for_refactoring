<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\File;
use App\Models\FilePath;


class FilePathTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        File::all()->each(function ($file){
            $filePath = FilePath::factory()->count(3)->create();
            $file->FilePaths()->saveMany($filePath);
        });
    }
}
