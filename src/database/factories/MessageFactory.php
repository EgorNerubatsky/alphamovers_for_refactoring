<?php

namespace Database\Factories;

use App\Models\Message;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Message::class;

    public function definition(): array
    {
        return [
            'sender_user_id' => $this->faker->numberBetween(1, 6),
            'recipient_user_id' => $this->faker->numberBetween(1, 6),
            'message' => $this->faker->text(50),
            'read' => $this->faker->randomElement([true, false]),
        ];
    }
}
