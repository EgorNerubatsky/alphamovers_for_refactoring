<?php

namespace Database\Factories;

use App\Models\ClientContactPersonDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ClientContactPersonDetail>
 */
class ClientContactPersonDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = ClientContactPersonDetail::class;
    public function definition(): array
    {
        return [
            // 'name'=>$this->faker->name,
            // 'last_name'=>$this->faker->lastName,
            'complete_name'=>$this->faker->randomElement(['Егор', 'Сергей', 'Владимир']).' '.$this->faker->randomElement(['Владимирович', 'Сергеевич', 'Степанович']).' '.$this->faker->randomElement(['Дерипаска', 'Зинченко', 'Степаненко']),
            'position'=>$this->faker->randomElement(['Директор', 'Менеджер']),
            'client_phone' => '+380' . $this->faker->regexify('[0-9]{9}'),
            'email'=>$this->faker->email,
        ];
    }
}
