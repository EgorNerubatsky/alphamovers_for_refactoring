<?php

namespace Feature;

use App\Models\Applicant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ApplicantsSearchAndSortingTest extends TestCase
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

        $this->test_applicant = Applicant::factory()->create([
            'fullname' => 'Авдєєв Леонід Олександрович',
            'phone' => '+380951234569',
            'desired_position' => 'Грузчик',
            'comment' => 'Дуже чудова людина',
        ]);

    }

    public function test_applicant_search_json_results_with_valid_date(): void
    {
//        $expectedApplicantId = $this->test_applicant->id;

        $this->assertSuccessfulSearch('Авдєєв', 'Авдєєв Леонід Олександрович', "+380951234569", $this->test_applicant->id);
        $this->assertSuccessfulSearch('0951234', 'Авдєєв Леонід Олександрович', "+380951234569", $this->test_applicant->id);
        $this->assertSuccessfulSearch('Грузчик', 'Авдєєв Леонід Олександрович', "+380951234569", $this->test_applicant->id);
        $this->assertSuccessfulSearch('чудова', 'Авдєєв Леонід Олександрович', "+380951234569", $this->test_applicant->id);
    }

    private function assertSuccessfulSearch(string $searchQuery, string $expectedName, string $expectedPhone, $expectedId): void
    {
        $response = $this->actingAs($this->user)->getJson(route('erp.executive.applicants.search', ['search' => $searchQuery]));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("applicants.data.0.id", $expectedId)
                ->where("applicants.data.0.fullname", $expectedName)
                ->where("applicants.data.0.phone", $expectedPhone)
                ->etc()
            );
    }

    public function test_applicant_search_json_results_with_absentees_date(): void
    {
        $this->assertAbsenteesSearch('444444');
        $this->assertAbsenteesSearch('Барег');
        $this->assertAbsenteesSearch('09845678');
        $this->assertAbsenteesSearch('tesnmail');
    }

    private function assertAbsenteesSearch(string $searchQuery): void
    {
        $response = $this->actingAs($this->user)->getJson(route('erp.executive.applicants.search', ['search' => $searchQuery]));
        $response->assertStatus(200)
            ->assertJsonMissingPath("applicants.data.0")
            ->assertJsonMissingPath("applicants.data.0.id");
    }

    public function test_applicant_search_json_results_with_invalid_date(): void
    {
        $this->assertInvalidSearch('!@#$%');
        $this->assertInvalidSearch("<blink>Hello there</blink>");
        $this->assertInvalidSearch("Robert'); DROP TABLE Students;--");
    }

    private function assertInvalidSearch(string $searchQuery): void
    {
        $response = $this->actingAs($this->user)->get(route('erp.executive.applicants.search', ['search' => $searchQuery]));
        $response->assertStatus(302);
        $response->assertSessionHasErrors('search', 'The search field format is invalid.');
    }

    public function test_applicant_search_json_results_with_long_text_date(): void
    {
        $response = $this->actingAs($this->user)->getJson(route('erp.executive.applicants.search', ['search' => str_repeat('A', 301)]));
        $response->assertStatus(422);
        $response->assertJson(['message' => 'The search field must not be greater than 50 characters.']);

    }


    public function test_applicant_filter_by_start_date_results(): void
    {

        $this->test_applicant['created_at'] = '2023-12-27 09:00:01';
        $this->test_applicant->save();


        $this->actingAs($this->user);
        $response = $this->getJson(route('erp.executive.applicants.index', ['start_date' => '2023-12-26 09:00:02']));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("applicants.data.0.id", $this->test_applicant->id)
                ->where("applicants.data.0.fullname", $this->test_applicant->fullname)
                ->where("applicants.data.0.phone", $this->test_applicant->phone)
                ->etc()
            );

    }

    public function test_applicant_filter_by_end_date_results(): void
    {

        $this->test_applicant['created_at'] = '2024-01-25 09:00:01';
        $this->test_applicant->save();


        $response = $this->actingAs($this->user)->getJson(route('erp.executive.applicants.index', ['end_date' => '2024-01-26 09:00:02']));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("applicants.data.0.id", $this->test_applicant->id)
                ->where("applicants.data.0.fullname", $this->test_applicant->fullname)
                ->where("applicants.data.0.phone", $this->test_applicant->phone)
                ->etc()
            );
    }

    public function test_applicant_filter_by_start_end_dates_results(): void
    {

        $this->test_applicant['created_at'] = '2023-12-28 09:44:54';
        $this->test_applicant->save();

        $response = $this->actingAs($this->user)->getJson(route('erp.executive.applicants.index', ['start_date' => '2023-12-21 09:44:54', 'end_date' => '2023-12-31 09:44:54']));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("applicants.data.0.id", $this->test_applicant->id)
                ->where("applicants.data.0.fullname", $this->test_applicant->fullname)
                ->where("applicants.data.0.phone", $this->test_applicant->phone)
                ->etc()
            );
    }
    public function test_applicant_filter_by_name_results(): void
    {
        $this->actingAs($this->user);
        $response = $this->getJson(route('erp.executive.applicants.index', ['fullname' => $this->test_applicant->fullname]));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("applicants.data.0.id", $this->test_applicant->id)
                ->where("applicants.data.0.fullname", $this->test_applicant->fullname)
                ->where("applicants.data.0.phone", $this->test_applicant->phone)
                ->etc()
            );
    }


    public function test_applicant_filter_by_desired_position_results(): void
    {
        $this->actingAs($this->user);
        $response = $this->getJson(route('erp.executive.applicants.index', ['desired_position' => $this->test_applicant->desired_position]));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("applicants.data.0.id", $this->test_applicant->id)
                ->where("applicants.data.0.fullname", $this->test_applicant->fullname)
                ->where("applicants.data.0.phone", $this->test_applicant->phone)
                ->etc()
            );
    }
}
