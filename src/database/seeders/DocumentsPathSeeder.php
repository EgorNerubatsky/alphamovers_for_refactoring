<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Lead;
use App\Models\DocumentsPath;


class DocumentsPathSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Lead::all()->each(function ($lead){
            $DocumentsPath = DocumentsPath::factory()->count(1)->create();
            $lead->documentsPaths()->saveMany($DocumentsPath);
        });
    }
}
