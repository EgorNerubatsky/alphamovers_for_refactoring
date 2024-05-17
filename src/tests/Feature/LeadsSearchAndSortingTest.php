<?php

namespace Feature;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class LeadsSearchAndSortingTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'is_executive'=>true,
        ]);

        $this->test_lead = Lead::factory()->create([
            'id' => 121,
            'company' => "АТ 'Берегаиня'",
            'fullname' => 'Джиром Береза',
            'phone' => '+380954567898',
            'email' => 'testmail@mail.com',
            'comment' => 'Тестовий коментар',
            'status' => 'новый',
        ]);

    }

    public function test_lead_search_json_results_with_valid_date(): void
    {
        $expectedLeadId = $this->test_lead->id;

        $this->assertSuccessfulLeadSearch('Берегаиня', '+380954567898', "АТ 'Берегаиня'", $expectedLeadId);
        $this->assertSuccessfulLeadSearch('Джиром', '+380954567898', "АТ 'Берегаиня'", $expectedLeadId);
        $this->assertSuccessfulLeadSearch('09545678', '+380954567898', "АТ 'Берегаиня'", $expectedLeadId);
        $this->assertSuccessfulLeadSearch('testmail', '+380954567898', "АТ 'Берегаиня'", $expectedLeadId);
    }

    private function assertSuccessfulLeadSearch(string $searchQuery, string $expectedLeadPhone, string $expectedLeadCompany, $expectedLeadId): void
    {
        $response = $this->actingAs($this->user)->getJson(route('erp.executive.leads.search', ['search' => "$searchQuery"]));

        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("leads.data.0.id", $expectedLeadId)
                ->where("leads.data.0.phone", $expectedLeadPhone)
                ->where("leads.data.0.company", $expectedLeadCompany)
                ->etc()
            );
    }

    public function test_lead_search_json_results_with_absentees_date(): void
    {
        $this->assertAbsenteesLeadSearch('444444');
        $this->assertAbsenteesLeadSearch('Барег');
        $this->assertAbsenteesLeadSearch('09845678');
        $this->assertAbsenteesLeadSearch('tesnmail');
    }

    private function assertAbsenteesLeadSearch(string $searchQuery): void
    {
        $response = $this->actingAs($this->user)->getJson(route('erp.executive.leads.search', ['search' => "{$searchQuery}"]));
        $response->assertStatus(200)
            ->assertJsonMissingPath("leads.data.0")
            ->assertJsonMissingPath("leads.data.0.id");
    }

    public function test_lead_search_json_results_with_invalid_date(): void
    {
        $this->assertInvalidLeadSearch('!@#$%');
        $this->assertInvalidLeadSearch("<blink>Hello there</blink>");
        $this->assertInvalidLeadSearch("Robert'); DROP TABLE Students;--");
        $this->assertInvalidLongTextLeadSearch(str_repeat('A', 301));

    }

    private function assertInvalidLeadSearch(string $searchQuery): void
    {
        $response = $this->actingAs($this->user)->get(route('erp.executive.leads.search', ['search' => $searchQuery]));
        $response->assertStatus(302);
        $response->assertSessionHasErrors('search', 'The search field format is invalid.');
    }

    private function assertInvalidLongTextLeadSearch(string $searchQuery): void
    {
        $response = $this->actingAs($this->user)->getJson(route('erp.executive.leads.search', ['search' => $searchQuery]));
        $response->assertStatus(422);
        $response->assertJson(['message'=>'The search field must not be greater than 50 characters.']);

    }


    public function test_lead_filter_by_start_date_results(): void
    {

        $this->test_lead['created_at'] = '2023-12-27 09:00:01';
        $this->test_lead->save();

        $response = $this->actingAs($this->user)->getJson(route('erp.executive.leads.index', ['start_date' => '2023-12-26 09:00:02']));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
//                ->where("leads.data.0.id", $this->test_lead->id)
                ->where("leads.data.0.phone", $this->test_lead->phone)
                ->where("leads.data.0.company", $this->test_lead->company)
                ->etc()
            );

    }

    public function test_lead_filter_by_end_date_results(): void
    {

        $this->test_lead['created_at']  = '2024-01-25 09:00:01';
        $this->test_lead->save();


        $response = $this->actingAs($this->user)->getJson(route('erp.executive.leads.index', ['end_date' => '2024-01-26 09:00:02']));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("leads.data.0.id", $this->test_lead->id)
                ->where("leads.data.0.phone", $this->test_lead->phone)
                ->where("leads.data.0.company", $this->test_lead->company)
                ->etc()
            );
    }

    public function test_lead_filter_by_start_end_dates_results(): void
    {

        $this->test_lead['created_at']  = '2023-12-28 09:44:54';
        $this->test_lead->save();

        $response = $this->actingAs($this->user)->getJson(route('erp.executive.leads.index', ['start_date' => '2023-12-21 09:44:54', 'end_date' => '2023-12-31 09:44:54']));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("leads.data.0.id", $this->test_lead->id)
                ->where("leads.data.0.phone", $this->test_lead->phone)
                ->where("leads.data.0.company", $this->test_lead->company)
                ->etc()
            );
    }

    public function test_lead_filter_by_status_results(): void
    {
        Lead::query()->delete();

        $newLead = Lead::factory()->create([
            'status' => 'новый',
        ]);
        $rejectionLead = Lead::factory()->create([
            'status' => 'отказ',
        ]);
        $atWorkLead = Lead::factory()->create([
            'status' => 'в работе',
        ]);
        $deletedLead = Lead::factory()->create([
            'status' => 'удален',
        ]);

        $response = $this->actingAs($this->user)->getJson(route('erp.executive.leads.index', ['status' => 'новый']));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("leads.data.0.id", $newLead->id)
                ->where("leads.data.0.phone", $newLead->phone)
                ->where("leads.data.0.company", $newLead['company'])
                ->etc()
            )
            ->assertJsonMissingExact([
                $rejectionLead['fullname'],
                $rejectionLead['phone'],
                $rejectionLead['company'],
                $atWorkLead['fullname'],
                $deletedLead['fullname'],
            ]);
    }


}
