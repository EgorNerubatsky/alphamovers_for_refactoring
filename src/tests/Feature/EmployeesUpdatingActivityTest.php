<?php

namespace Feature;


use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class EmployeesUpdatingActivityTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'is_executive' => true,
        ]);

        $this->test_employee = User::factory()->create([
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
        ]);

        $this->updatedData = [
            'name' => 'Антон',
            'lastname' => 'Кмийка',
            'middle_name' => 'Степанович',
            'birth_date' => '2003-07-19 00:00:00',
            'gender' => 'чол',
            'address' => 'Днепро, Вулиця 4',
            'phone' => '+380951234666',
            'email' => 'emailtest@test.com',
            'is_manager' => 0,
            'is_executive' => 1,
            'is_brigadier' => 0,
            'is_hr' => 0,
            'is_accountant' => 0,
            'is_logist' => 0,
            'bank_card' => '4567678975348888',
            'passport_number' => '667488',
            'passport_series' => 'АП',
        ];

        $this->invalidData = [
            'name' => 'Ан#$#%йка',
            'lastname' => 'Км#$%ийка',
            'middle_name' => 'Вол"№;%:?"рович',
            'birth_date' => '20503-07-19 00:00:00',
            'gender' => '#$%',
            'address' => 'Дн@#$%епро, Вулиця 4',
            'phone' => '+38095@#$4666',
            'email' => 'emailtesttest.com',
            'is_manager' => 0,
            'is_executive' => 0,
            'is_brigadier' => 0,
            'is_hr' => 'e',
            'is_accountant' => 0,
            'is_logist' => 0,
            'bank_card' => str_repeat('Aa', 260),
            'passport_number' => str_repeat('Aa', 260),
            'passport_series' => 'АП',
        ];
    }

    public function test_update_employee_with_valid_data(): void
    {
        $this->actingAs($this->user);
        $response = $this->put(route('erp.executive.employees.update', ['id' => $this->test_employee->id]), $this->updatedData);
        $response->assertStatus(302);
        $this->assertDatabaseHas('users', $this->updatedData);
    }

    public function test_try_update_employee_with_invalid_data(): void
    {
        $this->actingAs($this->user);

        $response = $this->put(route('erp.executive.employees.update', ['id' => $this->test_employee->id]), $this->invalidData);
        $response->assertSessionHasErrors([
            'name' => 'The name field format is invalid.',
            'lastname' => 'The lastname field format is invalid.',
            'middle_name' => 'The middle name field format is invalid.',
            'gender' => 'The gender field format is invalid.',
            'address' => 'The address field format is invalid.',
            'phone' => 'The phone field format is invalid.',
            'email' => 'The email field must be a valid email address.',
            'is_hr' => 'The is hr field must be true or false.',
            'bank_card' => 'The bank card field must be 16 digits.',
            'passport_number' => 'The passport number field must be 6 digits.',
        ]);

        $this->assertDatabaseMissing('users', $this->invalidData);
    }

    public function test_try_update_employee_without_required_email_fullname_phone(): void
    {
        $this->actingAs($this->user);

        unset($this->updatedData['name']);
        unset($this->updatedData['lastname']);
        unset($this->updatedData['middle_name']);
        unset($this->updatedData['phone']);

        $response = $this->put(route('erp.executive.employees.update', ['id' => $this->test_employee->id]), $this->updatedData);
        $response->assertSessionHasErrors([
            'name' => 'The name field is required.',
            'lastname' => 'The lastname field is required.',
            'middle_name' => 'The middle name field is required.',
            'phone' => 'The phone field is required.',
        ]);

        $this->assertDatabaseMissing('users', $this->updatedData);
    }

    public function test_employee_soft_delete(): void
    {
        $this->actingAs($this->user);
        $response = $this->get(route('erp.executive.employees.delete', ['id' => $this->test_employee->id]));
        $response->assertStatus(302);

        $this->assertSoftDeleted('users', ['id' => $this->test_employee->id]);
    }

}
