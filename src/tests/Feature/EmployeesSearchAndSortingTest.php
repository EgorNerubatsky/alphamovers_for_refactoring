<?php

namespace Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class EmployeesSearchAndSortingTest extends TestCase
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
            'password' => 'Aa123456',
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

    }

    public function test_employee_search_json_results_with_valid_date(): void
    {
        $expectedEmployeeId = $this->test_employee->id;

        $this->assertSuccessfulSearch('Кмийка', '4567678975346742', "email@test.com", $expectedEmployeeId);
        $this->assertSuccessfulSearch('667479', '4567678975346742', "email@test.com", $expectedEmployeeId);
        $this->assertSuccessfulSearch('0951234567', '4567678975346742', "email@test.com", $expectedEmployeeId);
        $this->assertSuccessfulSearch('email@test.com', '4567678975346742', "email@test.com", $expectedEmployeeId);
    }

    private function assertSuccessfulSearch(string $searchQuery, string $expectedBankCard, string $expectedEmail, $expectedEmployeeId): void
    {
        $response = $this->actingAs($this->user)->getJson(route('erp.executive.employees.search', ['search' => $searchQuery]));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("employees.data.0.id", $expectedEmployeeId)
                ->where("employees.data.0.bank_card", $expectedBankCard)
                ->where("employees.data.0.email", $expectedEmail)
                ->etc()
            );
    }

    public function test_employee_search_json_results_with_absentees_date(): void
    {
        $this->assertAbsenteesSearch('444444');
        $this->assertAbsenteesSearch('Барег');
        $this->assertAbsenteesSearch('09845678');
        $this->assertAbsenteesSearch('tesnmail');
    }

    private function assertAbsenteesSearch(string $searchQuery): void
    {
        $response = $this->actingAs($this->user)->getJson(route('erp.executive.employees.search', ['search' => $searchQuery]));
        $response->assertStatus(200)
            ->assertJsonMissingPath("employees.data.0")
            ->assertJsonMissingPath("employees.data.0.id");
    }

    public function test_employee_search_json_results_with_invalid_date(): void
    {
        $this->assertInvalidSearch('!@#$%');
        $this->assertInvalidSearch("<blink>Hello there</blink>");
        $this->assertInvalidSearch("Robert'); DROP TABLE Students;--");
    }

    private function assertInvalidSearch(string $searchQuery): void
    {
        $response = $this->actingAs($this->user)->get(route('erp.executive.employees.search', ['search' => $searchQuery]));
        $response->assertStatus(302);
        $response->assertSessionHasErrors('search', 'The search field format is invalid.');
    }

    public function test_employee_search_json_results_with_long_text_date(): void
    {
        $response = $this->actingAs($this->user)->getJson(route('erp.executive.employees.search', ['search' => str_repeat('A', 301)]));
        $response->assertStatus(422);
        $response->assertJson(['message' => 'The search field must not be greater than 50 characters.']);

    }


    public function test_employee_filter_by_start_date_results(): void
    {

        $this->test_employee['created_at'] = '2023-12-27 09:00:01';
        $this->test_employee->save();
        $this->user['created_at'] = '2023-12-25 09:00:01';
        $this->user->save();

        $this->actingAs($this->user);
        $response = $this->getJson(route('erp.executive.employees.index', ['start_date' => '2023-12-26 09:00:02']));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("employees.data.0.id", $this->test_employee->id)
                ->where("employees.data.0.bank_card", $this->test_employee->bank_card)
                ->where("employees.data.0.phone", $this->test_employee->phone)
                ->etc()
            );

    }

    public function test_employee_filter_by_end_date_results(): void
    {

        $this->test_employee['created_at'] = '2024-01-25 09:00:01';
        $this->test_employee->save();
        $this->user['created_at'] = '2024-01-27 09:00:01';
        $this->user->save();

        $response = $this->actingAs($this->user)->getJson(route('erp.executive.employees.index', ['end_date' => '2024-01-26 09:00:02']));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("employees.data.0.id", $this->test_employee->id)
                ->where("employees.data.0.bank_card", $this->test_employee->bank_card)
                ->where("employees.data.0.phone", $this->test_employee->phone)
                ->etc()
            );
    }

    public function test_employee_filter_by_start_end_dates_results(): void
    {

        $this->test_employee['created_at'] = '2023-12-28 09:44:54';
        $this->test_employee->save();
        $this->user['created_at'] = '2023-12-19 09:00:01';
        $this->user->save();

        $response = $this->actingAs($this->user)->getJson(route('erp.executive.employees.index', ['start_date' => '2023-12-21 09:44:54', 'end_date' => '2023-12-31 09:44:54']));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("employees.data.0.id", $this->test_employee->id)
                ->where("employees.data.0.bank_card", $this->test_employee->bank_card)
                ->where("employees.data.0.phone", $this->test_employee->phone)
                ->etc()
            );
    }

    public function test_employee_filter_by_status_results(): void
    {

        $hr = User::factory()->create([
            'is_hr' => true,
        ]);
        $logist = User::factory()->create([
            'is_logist' => true,
        ]);
        $accountant = User::factory()->create([
            'is_accountant' => true,
        ]);

        $manager = $this->test_employee;
        $executive = $this->user;

        $this->rolesFilters($hr, 'is_hr', $logist, $accountant, $manager, $executive);
        $this->rolesFilters($logist, 'is_logist', $hr, $accountant, $manager, $executive);
        $this->rolesFilters($accountant, 'is_accountant', $hr, $logist, $manager, $executive);
        $this->rolesFilters($manager, 'is_manager', $hr, $logist, $accountant, $executive);
        $this->rolesFilters($executive, 'is_executive', $hr, $logist, $accountant, $manager);
        $hr->delete();
        $logist->delete();
        $accountant->delete();
        $manager->delete();
    }

    private function rolesFilters($currentRole, $role, $roleOne, $roleTwo, $roleThree, $roleFour): void
    {
        $response = $this->actingAs($this->user)->getJson(route('erp.executive.employees.index', ['position' => $role]));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("employees.data.0.id", $currentRole->id)
                ->where("employees.data.0.phone", $currentRole->phone)
                ->where("employees.data.0.bank_card", $currentRole->bank_card)
                ->etc()
            )
            ->assertJsonMissingExact([
                $roleOne['bank_card'],
                $roleTwo['bank_card'],
                $roleThree['bank_card'],
                $roleFour['bank_card'],
            ]);
    }


    public function test_employee_filter_by_start_age_results(): void
    {

        $this->user['birth_date'] = '1981-12-27 09:00:01';
        $this->user->save();


        $this->actingAs($this->user);
        $response = $this->getJson(route('erp.executive.employees.index', ['age_from' => '40']));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("employees.data.0.id", $this->user->id)
                ->where("employees.data.0.bank_card", $this->user->bank_card)
                ->where("employees.data.0.phone", $this->user->phone)
                ->etc()
            );

    }

    public function test_employee_filter_by_end_age_results(): void
    {

        $this->user['birth_date'] = '1986-02-28 09:00:01';
        $this->user->save();

        $this->actingAs($this->user);

        $response = $this->getJson(route('erp.executive.employees.index', ['age_to' => '40']));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("employees.data.0.id", $this->user->id)
                ->where("employees.data.0.bank_card", $this->user->bank_card)
                ->where("employees.data.0.phone", $this->user->phone)
                ->etc()
            );
    }

    public function test_employee_filter_by_start_end_age_results(): void
    {

        $this->user['birth_date'] = '1999-12-28 09:44:54';
        $this->user->save();

        $this->actingAs($this->user);
        $response = $this->getJson(route('erp.executive.employees.index', ['age_from' => '20', 'age_to' => '30']));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("employees.data.0.id", $this->user->id)
                ->where("employees.data.0.bank_card", $this->user->bank_card)
                ->where("employees.data.0.phone", $this->user->phone)
                ->etc()
            );
    }

}
