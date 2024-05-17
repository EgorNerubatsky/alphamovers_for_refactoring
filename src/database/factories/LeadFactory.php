<?php

namespace Database\Factories;

use App\Models\Lead;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lead>
 */
class LeadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Lead::class;
    public function definition(): array
    {
        return [
            'company'=>$this->faker->randomElement(["АТ 'Берега'", "АТ 'Дубрава'", "АТ 'Орфей'", "АТ 'Динекс'", "АТ 'Размус'", "АТ 'Нирко'", "АТ 'Дерсо'", "АТ 'Ринза'", "ПАТ 'Робин'", "ПАТ 'Гомель'"]),
            'fullname'=>$this->faker->name,
            'phone'=>'+380'.$this->faker->regexify('[0-9]{9}'),
            'email'=>$this->faker->unique()->safeEmail,
            'comment'=>$this->faker->text(50),
            'status'=>$this->faker->randomElement(['новый', 'в работе', 'отказ', 'удален']),
        ];
    }
}