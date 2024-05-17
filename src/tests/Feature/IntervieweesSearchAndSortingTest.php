<?php

namespace Feature;

use App\Models\Interviewee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class IntervieweesSearchAndSortingTest extends TestCase
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

        $this->test_interviewee = Interviewee::factory()->create([
            'call_date' => '2023-06-26 00:00:00',
            'interview_date' => '2023-07-26 00:00:00',
            'fullname' => 'Авдєєв Леонід Олександрович',
            'birth_date' => '2001-06-26 00:00:00',
            'gender' => 'чол',
            'address' => 'Харків, Вулиця 1',
            'phone' => '+380951234567',
            'email' => 'email123@test.com',
            'position' => 'Грузчик',
            'comment' => 'Дуже чудова людина',
        ]);

    }

    public function test_interviewee_search_json_results_with_valid_date(): void
    {
        $expectedId = $this->test_interviewee->id;

        $this->assertSuccessfulSearch('Авдєєв', '+380951234567', "email123@test.com", $expectedId);
        $this->assertSuccessfulSearch('80951234', '+380951234567', "email123@test.com", $expectedId);
        $this->assertSuccessfulSearch('email123', '+380951234567', "email123@test.com", $expectedId);
        $this->assertSuccessfulSearch('Леонід', '+380951234567', "email123@test.com", $expectedId);
    }

    private function assertSuccessfulSearch(string $searchQuery, string $expectedPhone, string $expectedEmail, $expectedId): void
    {
        $response = $this->actingAs($this->user)->getJson(route('erp.executive.interviewees.search', ['search' => $searchQuery]));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("interviewees.data.0.id", $expectedId)
                ->where("interviewees.data.0.phone", $expectedPhone)
                ->where("interviewees.data.0.email", $expectedEmail)
                ->etc()
            );
    }

    public function test_interviewee_search_json_results_with_absentees_date(): void
    {
        $this->assertAbsenteesSearch('444444');
        $this->assertAbsenteesSearch('Барег');
        $this->assertAbsenteesSearch('09845678');
        $this->assertAbsenteesSearch('tesnmail');
    }

    private function assertAbsenteesSearch(string $searchQuery): void
    {
        $response = $this->actingAs($this->user)->getJson(route('erp.executive.interviewees.search', ['search' => $searchQuery]));
        $response->assertStatus(200)
            ->assertJsonMissingPath("interviewees.data.0")
            ->assertJsonMissingPath("interviewees.data.0.id");
    }

    public function test_interviewee_search_json_results_with_invalid_date(): void
    {
        $this->assertInvalidSearch('!@#$%');
        $this->assertInvalidSearch("<blink>Hello there</blink>");
        $this->assertInvalidSearch("Robert'); DROP TABLE Students;--");
    }

    private function assertInvalidSearch(string $searchQuery): void
    {
        $response = $this->actingAs($this->user)->get(route('erp.executive.interviewees.search', ['search' => $searchQuery]));
        $response->assertStatus(302);
        $response->assertSessionHasErrors('search', 'The search field format is invalid.');
    }

    public function test_interviewee_search_json_results_with_long_text_date(): void
    {
        $response = $this->actingAs($this->user)->getJson(route('erp.executive.interviewees.search', ['search' => str_repeat('A', 301)]));
        $response->assertStatus(422);
        $response->assertJson(['message' => 'The search field must not be greater than 50 characters.']);

    }


    public function test_interviewee_filter_by_call_date_results(): void
    {

        $this->test_interviewee['call_date'] = '2023-12-27 09:00:01';
        $this->test_interviewee->save();

        $this->actingAs($this->user);
        $response = $this->getJson(route('erp.executive.interviewees.index', ['start_call_date' => '2023-12-26 09:00:02']));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("interviewees.data.0.id", $this->test_interviewee->id)
                ->where("interviewees.data.0.phone", $this->test_interviewee->phone)
                ->where("interviewees.data.0.email", $this->test_interviewee->email)
                ->etc()
            );

    }

    public function test_interviewee_filter_by_end_call_date_results(): void
    {

        $this->test_interviewee['call_date'] = '2024-01-25 09:00:01';
        $this->test_interviewee->save();

        $response = $this->actingAs($this->user)->getJson(route('erp.executive.interviewees.index', ['end_call_date' => '2024-01-26 09:00:02']));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("interviewees.data.0.id", $this->test_interviewee->id)
                ->where("interviewees.data.0.phone", $this->test_interviewee->phone)
                ->where("interviewees.data.0.email", $this->test_interviewee->email)
                ->etc()
            );
    }

    public function test_interviewee_filter_by_start_and_end_call_dates_results(): void
    {

        $this->test_interviewee['call_date'] = '2023-12-28 09:44:54';
        $this->test_interviewee->save();

        $response = $this->actingAs($this->user)->getJson(route('erp.executive.interviewees.index', ['start_call_date' => '2023-12-21 09:44:54', 'end_call_date' => '2023-12-31 09:44:54']));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("interviewees.data.0.id", $this->test_interviewee->id)
                ->where("interviewees.data.0.phone", $this->test_interviewee->phone)
                ->where("interviewees.data.0.email", $this->test_interviewee->email)
                ->etc()
            );
    }


    public function test_interviewee_filter_by_interview_date_results(): void
    {

        $this->test_interviewee['interview_date'] = '2023-12-27 09:00:01';
        $this->test_interviewee->save();

        $this->actingAs($this->user);
        $response = $this->getJson(route('erp.executive.interviewees.index', ['start_interview_date' => '2023-12-26 09:00:02']));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("interviewees.data.0.id", $this->test_interviewee->id)
                ->where("interviewees.data.0.phone", $this->test_interviewee->phone)
                ->where("interviewees.data.0.email", $this->test_interviewee->email)
                ->etc()
            );

    }

    public function test_interviewee_filter_by_end_interview_date_results(): void
    {

        $this->test_interviewee['interview_date'] = '2024-01-25 09:00:01';
        $this->test_interviewee->save();

        $response = $this->actingAs($this->user)->getJson(route('erp.executive.interviewees.index', ['end_interview_date' => '2024-01-26 09:00:02']));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("interviewees.data.0.id", $this->test_interviewee->id)
                ->where("interviewees.data.0.phone", $this->test_interviewee->phone)
                ->where("interviewees.data.0.email", $this->test_interviewee->email)
                ->etc()
            );
    }

    public function test_interviewee_filter_by_start_and_end_interview_dates_results(): void
    {

        $this->test_interviewee['interview_date'] = '2023-12-28 09:44:54';
        $this->test_interviewee->save();

        $response = $this->actingAs($this->user)->getJson(route('erp.executive.interviewees.index', ['start_interview_date' => '2023-12-21 09:44:54', 'end_interview_date' => '2023-12-31 09:44:54']));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("interviewees.data.0.id", $this->test_interviewee->id)
                ->where("interviewees.data.0.phone", $this->test_interviewee->phone)
                ->where("interviewees.data.0.email", $this->test_interviewee->email)
                ->etc()
            );
    }


    public function test_employee_filter_by_full_name_results(): void
    {
//        'fullname' => 'Авдєєв Леонід Олександрович',

        $response = $this->actingAs($this->user)->getJson(route('erp.executive.interviewees.index', ['fullname' => 'Авдєєв Леонід Олександрович']));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("interviewees.data.0.id", $this->test_interviewee->id)
                ->where("interviewees.data.0.phone", $this->test_interviewee->phone)
                ->where("interviewees.data.0.email", $this->test_interviewee->email)
                ->etc()
            );
    }

    public function test_employee_filter_by_other_full_name_results(): void
    {
        $response = $this->actingAs($this->user)->getJson(route('erp.executive.interviewees.index', ['fullname' => 'Сердюк Леонід Олександрович']));
        $response->assertStatus(200)
            ->assertJsonMissingPath("interviewees.data.0")
            ->assertJsonMissingPath("interviewees.data.0.id");
    }
    public function test_employee_filter_by_position_results(): void
    {
//        'fullname' => 'Авдєєв Леонід Олександрович',

        $response = $this->actingAs($this->user)->getJson(route('erp.executive.interviewees.index', ['position' => 'Грузчик']));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("interviewees.data.0.id", $this->test_interviewee->id)
                ->where("interviewees.data.0.phone", $this->test_interviewee->phone)
                ->where("interviewees.data.0.email", $this->test_interviewee->email)
                ->etc()
            );
    }

    public function test_employee_filter_by_other_position_results(): void
    {
        $response = $this->actingAs($this->user)->getJson(route('erp.executive.interviewees.index', ['position' => 'HR']));
        $response->assertStatus(200)
            ->assertJsonMissingPath("interviewees.data.0")
            ->assertJsonMissingPath("interviewees.data.0.id");
    }



//    private function fullnameFilter($currentRole, $role, $roleOne, $roleTwo, $roleThree, $roleFour): void
//    {
//        $response = $this->actingAs($this->user)->getJson(route('erp.executive.employees.index', ['position' => $role]));
//        $response->assertStatus(200)
//            ->assertJson(fn(AssertableJson $json) => $json
//                ->where("employees.data.0.id", $currentRole->id)
//                ->where("employees.data.0.phone", $currentRole->phone)
//                ->where("employees.data.0.bank_card", $currentRole->bank_card)
//                ->etc()
//            )
//            ->assertJsonMissingExact([
//                $roleOne['bank_card'],
//                $roleTwo['bank_card'],
//                $roleThree['bank_card'],
//                $roleFour['bank_card'],
//            ]);
//    }


    public function test_employee_filter_by_start_age_results(): void
    {

        $this->test_interviewee['birth_date'] = '1981-12-27 09:00:01';
        $this->test_interviewee->save();


        $this->actingAs($this->user);
        $response = $this->getJson(route('erp.executive.interviewees.index', ['age_from' => '40']));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("interviewees.data.0.id", $this->test_interviewee->id)
                ->where("interviewees.data.0.phone", $this->test_interviewee->phone)
                ->where("interviewees.data.0.email", $this->test_interviewee->email)
                ->etc()
            );

    }

    public function test_employee_filter_by_end_age_results(): void
    {

        $this->test_interviewee['birth_date'] = '1986-02-28 09:00:01';
        $this->test_interviewee->save();

        $this->actingAs($this->user);

        $response = $this->getJson(route('erp.executive.interviewees.index', ['age_to' => '40']));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("interviewees.data.0.id", $this->test_interviewee->id)
                ->where("interviewees.data.0.phone", $this->test_interviewee->phone)
                ->where("interviewees.data.0.email", $this->test_interviewee->email)
                ->etc()
            );
    }

    public function test_employee_filter_by_start_end_age_results(): void
    {

        $this->test_interviewee['birth_date'] = '1999-12-28 09:44:54';
        $this->test_interviewee->save();

        $this->actingAs($this->user);
        $response = $this->getJson(route('erp.executive.interviewees.index', ['age_from' => '20', 'age_to' => '30']));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("interviewees.data.0.id", $this->test_interviewee->id)
                ->where("interviewees.data.0.phone", $this->test_interviewee->phone)
                ->where("interviewees.data.0.email", $this->test_interviewee->email)
                ->etc()
            );
    }

}
