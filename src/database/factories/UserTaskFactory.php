<?php

namespace Database\Factories;

use App\Models\UserTask;
use DateInterval;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UserTask>
 */
class UserTaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = UserTask::class;

    public function definition(): array
    {
        $startTask = $this->faker->dateTimeBetween(now(), now()->addDays(15));
        $endTask = (clone $startTask)->add(new DateInterval('P2D'));
        $faker = \Faker\Factory::create('uk_UA');

        return [
            'user_id' => $this->faker->numberBetween(1,6),
            'task_to_user_id' => $this->faker->numberBetween(1,6),
            'task' => $faker->text(10),
            'start_task' => $startTask,
            'end_task' => $endTask,
            'status' => 'Нове',
        ];
    }
}
