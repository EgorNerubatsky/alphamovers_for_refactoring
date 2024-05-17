<?php

namespace Database\Factories;

use App\Models\OrderFile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderFile>
 */
class OrderFileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = OrderFile::class;
    public function definition(): array
    {
        return [
            'order_id' =>null,
            
        ];
    }
}
