<?php

namespace Database\Factories;

use App\Models\ClientBase;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Order::class;

    public function definition(): array
    {
        return [
//            'client_id' => $this->faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
            'client_id'=> $this->faker->randomElement(ClientBase::all()->pluck('id')->toArray()),
            'execution_date' => $this->faker->dateTimeBetween(now()->addMonth(), now()->addMonths(2)),
            'number_of_workers' => $this->faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]),
            'city' => $this->faker->randomElement(['Харкiв', 'Київ', 'Львів', 'Днепр']),
            'street' => $this->faker->randomElement(['Вулиця 1', 'Вулиця 2', 'Вулиця 3', 'Вулиця 4']),
            'house' => $this->faker->randomElement(['34а', '56б', '23г', '17']),
            'service_type' => $this->faker->randomElement(['Розвантаження-завантаження', 'Прибирання будівельного сміття', 'Перевезення великогабаритних об\'єктів']),
            'task_description' => $this->faker->text(50),
            'straps' => $this->faker->randomElement([false, true]),
            'tools' => $this->faker->randomElement([false, true]),
            'respirators' => $this->faker->randomElement([false, true]),
            'transport' => $this->faker->randomElement(['Легкова 1', 'Легкова 2', 'Грузова 1', 'Грузова 2']),
            'price_to_customer' => $this->faker->randomFloat(2, 10, 99),
            'price_to_workers' => $this->faker->randomFloat(2, 10, 99),
            'min_order_amount' => $minOrderAmount = $this->faker->randomFloat(2, 10, 99),
            'min_order_hrs' => $this->faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]),
            'order_hrs' => $minOrderHrs = $this->faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]),
            'total_price' => $minOrderAmount * $minOrderHrs,
            'payment_note' => $this->faker->text(50),
            'review' => $this->faker->paragraphs(1, true),
            'status' => $this->faker->randomElement(['Попереднє замовлення', 'Виконано', 'Скасовано', 'В роботі']),
            'order_source' => $this->faker->randomElement(['Сайт', 'ОЛХ', 'Зовнішня реклама', 'Рекомендація знайомих', 'Активні продажі', 'Повторне замовлення']),
            'payment_form' => $this->faker->randomElement(['Фізична особа (готівковий розрахунок)', 'Фізична особа (на карту)', 'Юридична особа (безготівковий розрахунок)']),
        ];
    }
}

