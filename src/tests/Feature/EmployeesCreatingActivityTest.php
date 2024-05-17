<?php

namespace Feature;


use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class EmployeesCreatingActivityTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->test_user = User::factory()->create([
            'is_executive' => true,
        ]);
        $this->creatingData = [

            'name' => 'Антон',
            'lastname' => 'Кмийка',
            'middle_name' => 'Володимирович',
            'birth_date' => '2001-06-26 00:00:00',
            'gender' => 'чол',
            'address' => 'Харків, Вулиця 1',
            'phone' => '+380951234567',
            'email' => 'email@test.com',
            'password' => 'Aa345678',
            'is_manager' => 1,
            'is_executive' => 0,
            'is_brigadier' => 0,
            'is_hr' => '0',
            'is_accountant' => 0,
            'is_logist' => 0,
            'bank_card' => '4567678975346742',
            'passport_number' => '667479',
            'passport_series' => 'CB',
        ];

        $this->invalidData = [
            'name' => 'Ант@#$%^!он',
            'lastname' => 'Кми@#$%^!йка',
            'middle_name' => 'Володи@#$%^мирович',
            'birth_date' => '2045401-06-26',
            'gender' => '@#',
            'address' => '@#$%^!, Вулиця 1',
            'phone' => '+380@#$%^!567',
            'email' => 'emailtest.com',
            'password' => 'Aa3@#$%45678',
            'is_manager' => 'g',
            'is_executive' => 0,
            'is_brigadier' => 0,
            'is_hr' => 0,
            'is_accountant' => 0,
            'is_logist' => 0,
            'bank_card' => '456743@#$%467425',
            'passport_number' => '65#$79',
            'passport_series' => '#$',
        ];
    }

    public function test_create_employee_with_valid_data(): void
    {
        $this->actingAs($this->test_user);

        $response = $this->post(route('erp.executive.employees.store', $this->creatingData));
        $response->assertStatus(302);
        unset($this->creatingData['password']);

        $this->assertDatabaseHas('users', $this->creatingData);
    }

    public function test_create_employee_with_invalid_data(): void
    {
        $this->actingAs($this->test_user);

        $response = $this->post(route('erp.executive.employees.store', $this->invalidData));

        $response->assertSessionHasErrors([
            'name' => 'The name field format is invalid.',
            'lastname' => 'The lastname field format is invalid.',
            'middle_name' => 'The middle name field format is invalid.',
            'gender' => 'The gender field format is invalid.',
            'address' => 'The address field format is invalid.',
            'phone' => 'The phone field format is invalid.',
            'email' => 'The email field must be a valid email address.',
            'is_manager' => 'The is manager field must be true or false.',
            'bank_card' => 'The bank card field must be 16 digits.',
            'passport_number' => 'The passport number field must be 6 digits.',

        ]);

        $this->assertDatabaseMissing('users', $this->invalidData);
    }

    public function test_create_employee_without_required_data(): void
    {
        $this->actingAs($this->test_user);

        unset($this->creatingData['name']);
        unset($this->creatingData['lastname']);
        unset($this->creatingData['middle_name']);
        unset($this->creatingData['phone']);

        $response = $this->post(route('erp.executive.employees.store', $this->creatingData));
        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'name' => 'The name field is required.',
            'lastname' => 'The lastname field is required.',
            'middle_name' => 'The middle name field is required.',
            'phone' => 'The phone field is required.',
        ]);
        $this->assertDatabaseMissing('users', $this->creatingData);
    }

}
