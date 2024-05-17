<?php

namespace Database\Factories;

use App\Models\OrderFilePath;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderFilePath>
 */
class OrderFilePathFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = OrderFilePath::class;
    public function definition(): array
    {
        return [
            'path'=> $this->faker->randomElement(['\files\Acts\file.docx','\files\Deeds\file.docx','\files\Invoices\file.docx']),
            'description'=>$this->faker->randomElement(['Акт', 'Рахунок','Договiр']),
            'status'=>$this->faker->randomElement(['Завантажено','Вiдправлено','Отримано скан']),
            'scan_recieved_date'=>$this->faker->dateTime(),
            'scan_sent_date'=>$this->faker->dateTime(),

        ];
    }
}
