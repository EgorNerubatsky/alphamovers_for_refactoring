<?php

namespace Database\Factories;

use App\Models\UsersChat;
use Illuminate\Database\Eloquent\Factories\Factory;


class UsersChatFactory extends Factory
{

    protected $model = UsersChat::class;

    public function definition(): array
    {
        $chatId = $this->faker->numberBetween(1, 20);
        $userId = $this->faker->numberBetween(1, 6);

//
        while(UsersChat::where('chat_id', $chatId)->where('user_id', $userId)->exists()){
            $chatId = $this->faker->numberBetween(1,20);
            $userId = $this->faker->numberBetween(1,6);
        }

//
//        $existingRecord = UsersChat::where('chat_id', $chatId)->where('user_id', $userId)->first();
//
//        if ($existingRecord){
//            return $this->definition();
//        }


        return [
            'chat_id' => $chatId,
            'user_id' => $userId,
        ];
    }

//    public function configure(): UsersChatFactory
//    {
//        return $this->afterCreating(function (UsersChat $usersChat) {
//            $existingRecord = UsersChat::where('chat_id', $usersChat->chat_id)
//                ->where('user_id', $usersChat->user_id)
//                ->exists();
//
//            if ($existingRecord) {
//                UsersChat::factory()->create();
////                return $this->definition();
//            }
//        });
//    }


}
