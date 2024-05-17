<?php

namespace Database\Factories;

use App\Models\Kanban;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kanban>
 */
class KanbanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Kanban::class;

    public function definition(): array
    {
        return [
            'kanban_title' => $this->faker->text(20),
            'title_color' => $this->faker->randomElement([
                'primary',
                'secondary',
                'success',
                'danger',
                'info',
            ]),
            'user_id' => $this->faker->numberBetween(1, 6),
        ];
    }
}
