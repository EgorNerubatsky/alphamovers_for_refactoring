<?php

namespace Database\Factories;


use App\Models\DocumentsPath;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DocumentsPath>
 */
class DocumentsPathFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = DocumentsPath::class;
    public function definition(): array
    {
        return [
            // 'path'=> 'uploads\leads\01\Акт.docx'
            'path'=>$this->faker->randomElement(['uploads\leads\01\Акт.docx', 'uploads\leads\02\Акт.docx', 'uploads\leads\03\Акт.docx', 'uploads\leads\04\Акт.docx', 'uploads\leads\05\Акт.docx']),
            'description'=>'Документ вiд замовника',
        ];
    }
}
