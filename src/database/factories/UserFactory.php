<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = User::class;
    public function definition(): array
    {
        $faker = \Faker\Factory::create('uk_UA');


        return [
//            'fullname' => $faker->lastName . ' ' . $faker->firstName . ' ' . $faker->lastName,
            'name' => $faker->firstName,
            'lastname' => $faker->lastName,
            'middle_name' => $faker->lastName,

            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'remember_token' => Str::random(10),
            'birth_date' => $this->faker->dateTimeBetween('1981-01-01', '2005-01-01'),
            'gender' => $this->faker->randomElement(['чол', 'жін']),
            'address' => $this->faker->randomElement(['Харків, Вулиця 1', 'Харків, Вулиця 2', 'Харків, Вулиця 3', 'Харків, Вулиця 4']),
            'phone' => '+380' . $this->faker->regexify('[0-9]{9}'),
            'bank_card' => $this->faker->regexify('[0-9]{16}'),
            'passport_number' => $this->faker->regexify('[0-9]{6}'),
            'passport_series' => $this->faker->randomElement(['БР', 'ВА', 'ГШ', 'СМ', 'ДР', 'МТ', 'АЖ']),
            'photo_path'=> 'img/photo_plug.png',
            'is_admin' => false,
            'is_manager' => false,
            'is_executive' => false,
            'is_hr' => false,
            'is_accountant' => false,
            'is_logist' => false,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
