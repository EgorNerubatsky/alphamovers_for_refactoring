<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Mover;

/**
 * @extends Factory<Mover>
 */
class MoverFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Mover::class;

    public function definition(): array
    {
        $faker = \Faker\Factory::create('uk_UA');

        return [
            'name' => $faker->firstName,
            'lastname' => $faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'note' => $this->faker->randomElement(['кат. 1', 'кат. 2', 'кат. 3', 'кат. 4', 'кат. 5']),
            'advantages' => $this->faker->randomElement(['Водiй А,В,С,D', 'Механік', 'Автонавантажувач', 'Альпініст', 'Електрик']),
            'birth_date' => $this->faker->dateTimeBetween('1981-01-01', '2005-01-01'),
            'gender' => $this->faker->randomElement(['чол', 'жін']),
            'address' => $this->faker->randomElement(['Харків, Вулиця 1', 'Харків, Вулиця 2', 'Харків, Вулиця 3', 'Харків, Вулиця 4']),
            'phone' => '+380' . $this->faker->regexify('[0-9]{9}'),
            'bank_card' => $this->faker->regexify('[0-9]{16}'),
            'passport_number' => $this->faker->regexify('[0-9]{6}'),
            'passport_series' => $this->faker->randomElement(['БР', 'ВА', 'ГШ', 'СМ', 'ДР', 'МТ', 'АЖ']),

        ];
    }
}
