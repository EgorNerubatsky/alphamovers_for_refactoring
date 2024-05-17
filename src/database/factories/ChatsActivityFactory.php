<?php

namespace Database\Factories;

use App\Models\ChatsActivity;
use App\Models\UsersChat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\ChatsActivity>
 */
class ChatsActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = ChatsActivity::class;

    public function definition(): array
    {
        $chatId = $this->faker->numberBetween(1,20);
        $chatUsersIds = UsersChat::where('chat_id', $chatId)->pluck('user_id');

        return [
            'chat_id' => $chatId,
            'user_id' => $this->faker->randomElement($chatUsersIds),
            'message' => $this->faker->text(50),
        ];
    }
}
