<?php

namespace Database\Factories;

use App\Models\Interviewee;
use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Message>
 */
class IntervieweeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Interviewee::class;

    public function definition(): array
    {
        $birthDate = $this->faker->dateTimeBetween('-40 years', '-20 years');
        $faker = \Faker\Factory::create('uk_UA'); // Создание экземпляра Faker с украинской локалью


        return [
            'call_date' => $this->faker->dateTimeBetween('2023-10-01', '2023-12-01'),
            'interview_date' => $this->faker->dateTimeBetween('2023-10-01', '2023-12-01'),
//            'fullname' => $this->faker->randomElement([
//                'Авдєєв Леонід Олександрович',
//                'Акімов Євген Маркович',
//                'Алешин Данило Ярославович',
//                'Баранов Всеволод Макарович',
//                'Богданов Руслан Кирилович',
//                'Васильєв Іван Андрійович',
//                'Волкова Василиса Дмитрівна',
//                'Гаврилова Софія Матвіївна',
//                'Галкін Савелій Степанович',
//            ]),
            'fullname' => $faker->lastName . ' ' . $faker->firstName . ' ' . $faker->lastName,
            'birth_date' => $birthDate,

            'gender' => $this->faker->randomElement(['чол', 'жін']),
            'address' => $this->faker->randomElement(['Харків, Вулиця 1', 'Харків, Вулиця 2', 'Харків, Вулиця 3', 'Харків, Вулиця 4']),
            'phone' => '+380' . $this->faker->regexify('[0-9]{9}'),
            'email' => $this->faker->unique()->safeEmail,
            'position' => $this->faker->randomElement(['Грузчик', 'Сантехник', 'Слесарь', 'Бухгалтер', 'Водитель', 'Бригадир', 'HR']),
            'comment' => $this->faker->text(50),
        ];
    }
}
