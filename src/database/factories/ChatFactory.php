<?php

namespace Database\Factories;

use App\Models\Chat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Chat>
 */
class ChatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Chat::class;

    public function definition(): array
    {
        return [
            'chat_name' => $this->faker->text(10),
            'chat_cover' => 'img/movers_logo_mini.png',
        ];
    }
}
