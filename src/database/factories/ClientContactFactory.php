<?php

namespace Database\Factories;

use App\Models\ClientBase;
use App\Models\ClientContact;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClientContact>
 */
class ClientContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = ClientContact::class;
    public function definition(): array
    {
        return [
            'client_base_id'=>null,
//            'client_base_id' => ClientBase::factory(),

        ];
    }
}
