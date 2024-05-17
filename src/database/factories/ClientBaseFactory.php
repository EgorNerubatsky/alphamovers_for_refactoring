<?php

namespace Database\Factories;

use App\Models\ClientBase;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClientBase>
 */
class ClientBaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = ClientBase::class;
    public function definition(): array
    {
        return [
            'date_of_contract' => $this->faker->dateTime(),
            'company' => $this->faker->randomElement(["АТ 'Credo'","АТ 'Deros'","АТ 'Rhyo'","АТ 'HHO'","АТ 'TTY'","АТ 'DFF'","АТ 'AOO'","АТ 'NVV'","АТ 'ERTY'","АТ 'Злата'", "АТ 'Дубрава'", "АТ 'Ясень'", "АТ 'Вересень'", "АТ 'Ниява'", "АТ 'Кредо'", "АТ 'Ронзем'", "АТ 'Дендрик'", "ПАТ 'Робин'", "ПАТ 'Гомель'"]),
            'type' => $this->faker->randomElement(['Юридична особа', 'Фізична особа']),
            // 'contact_person' => $this->faker->name,
            // 'phone' => '+380' . $this->faker->regexify('[0-9]{9}'),
            'debt_ceiling' => $this->faker->randomFloat(3, 100, 999),
            'identification_number' => 'UA' . $this->faker->regexify('[0-9]{12}'),
            'code_of_the_reason_for_registration' => 'UA' . $this->faker->regexify('[0-9]{7}'),
            'main_state_registration_number' => 'UA' . $this->faker->regexify('[0-9]{12}'),
            'director_name' => $this->faker->name,
            'contact_person_position' => $this->faker->randomElement(['Технiчний директор', 'Голова правлiння', 'Директор', 'Зам. директора', 'Головний iнженер', 'Менеджер']),
            'acting_on_the_basis_of' => 'Договiр № ' . $this->faker->regexify('[0-9]{5}'),
            'registered_address' => $this->faker->randomElement(['Харкiв, вул.4', 'Харкiв, вул.5', 'Харкiв, вул.6', 'Харкiв, вул.23', 'Днепр, вул.8', 'Київ, вул.4', 'Львів, вул.1']),
            'zip_code' => $this->faker->regexify('[0-9]{5}'),
            'postal_address' => $this->faker->randomElement(['4567 Харкiв', '7834 Харкiв', '8909 Харкiв', '4367 Харкiв', '2367 Днепр', '2398 Київ', '8319 Львів']),
            'payment_account' => 'UA' . $this->faker->regexify('[0-9]{12}'),
            'bank_name' => $this->faker->randomElement(['АТ ПРИ Банк', 'АТ Спец Банк', 'АТ Дец Банк', 'АТ Мец Банк', 'АТ ДЕА Банк', 'АТ ЛЕН Банк']),
            'bank_identification_code' => 'UA' . $this->faker->regexify('[0-9]{6}'),
        ];
    }
}