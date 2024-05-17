<?php

namespace Database\Factories;

use App\Models\Applicant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Applicant>
 */
class ApplicantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Applicant::class;

    public function definition(): array
    {
        $birthDate = $this->faker->dateTimeBetween('-40 years', '-20 years');
        $faker = \Faker\Factory::create('uk_UA'); // Создание экземпляра Faker с украинской локалью


        return [
//            'fullname' => $this->faker->randomElement([
//                'Авдєєв Леонід Олександрович',
//                'Акімов Євген Маркович',
//                'Алешин Данило Ярославович',
//
//                'Баранов Всеволод Макарович',
//                'Богданов Руслан Кирилович',
//                'Васильєв Іван Андрійович',
//
//                'Волкова Василиса Дмитрівна',
//                'Гаврилова Софія Матвіївна',
//                'Галкін Савелій Степанович',

            'fullname' => $faker->lastName . ' ' . $faker->firstName . ' ' . $faker->lastName,


//            ]),
            'birth_date' => $birthDate,

            'phone' => '+380' . $this->faker->regexify('[0-9]{9}'),
            'desired_position' => $this->faker->randomElement(['Грузчик', 'Сантехник', 'Слесарь', 'Бухгалтер', 'Водитель', 'Бригадир', 'HR']),
            'comment' => $this->faker->text(50),


        ];
    }
}
