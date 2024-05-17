<?php

namespace Feature;

use App\Models\ClientBase;
use App\Models\ClientContactPersonDetail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ClientBaseSearchAndSortingTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->test_user = User::factory()->create([
            'is_manager' => true,
        ]);

        $this->test_client = ClientBase::create([
            'company' => "АТ 'Credo'",
            'type' => 'Юридична особа',
            'debt_ceiling' => 228.59,
            'identification_number' => 'UA603241872561',
            'code_of_the_reason_for_registration' => 'UA0323394',
            'main_state_registration_number' => 'UA719881734699',
            'director_name' => 'Костяний Петро Олександрович',
            'contact_person_position' => 'Голова правлiння',
            'acting_on_the_basis_of' => 'Договiр № 69871',
            'registered_address' => 'Харкiв, вул.4',
            'zip_code' => '27831',
            'postal_address' => '4567 Харкiв',
            'payment_account' => 'UA285232153653',
            'bank_name' => 'АТ ПРИ Банк',
            'bank_identification_code' => 'UA526692',
        ]);

        $this->test_client_contact_first = ClientContactPersonDetail::create([
            'client_base_id' => $this->test_client->id,
            'complete_name' => 'Дмитро Олександрович Шипуль',
            'client_phone' => '+380305743523',
            'position' => 'Менеджер',
            'email' => 'test111@test.com',
        ]);
        $this->test_client_contact_second = ClientContactPersonDetail::create([
            'client_base_id' => $this->test_client->id,
            'complete_name' => 'Олександр Олександрович Тамогавк',
            'client_phone' => '+380305748888',
            'position' => 'Зам. директора',
            'email' => 'test222@test.com',
        ]);

        $this->validSearch = [
            "Credo",
            '603241872561',
            'Харкiв',
            'вул.4',
            '0305743523',
        ];

        $this->invalidSearch = [
            "C@#$%^o",
            '6@#$%^872561',
            "<script>alert('Executing JS')</script>",
            '@#$%^',
            '://www.mysite.com',
        ];

        $this->longTextSearch = [
            str_repeat('A', 70),
            str_repeat('A', 301),
            str_repeat('A', 5000),
        ];

        $this->absenteesSearch = [
            "RTY",
            '603241888555',
            'Днепр',
            'вул.345',
            '0305743555',
        ];
        $this->irrelevantFilterData = [
            'company' => "RRT",
            'director_name' => "RRT",
            'contact_person_position'=>'Менеджер'
        ];

    }

    public function test_client_search_json_results_with_valid_data(): void
    {

        foreach ($this->validSearch as $search) {
            $response = $this->actingAs($this->test_user)->getJson(route('erp.manager.clients.search', ['search' => $search]));
            $response->assertStatus(200)
                ->assertJson(fn(AssertableJson $json) => $json
                    ->where("clients.data.0.id", $this->test_client->id)
                    ->where("clients.data.0.identification_number", $this->test_client->identification_number)
                    ->where("clients.data.0.company", $this->test_client->company)
                    ->where("clientContacts.0.client_phone", $this->test_client_contact_first->client_phone)
                    ->etc()
                );
        }
    }

    public function test_client_search_json_results_with_absentees_data(): void
    {
        foreach ($this->absenteesSearch as $search) {
            $response = $this->actingAs($this->test_user)->getJson(route('erp.manager.clients.search', ['search' => $search]));
            $response->assertStatus(200)
                ->assertJsonMissingPath("clients.data.0")
                ->assertJsonMissingPath("clients.data.0.id");
        }
    }

    public function test_client_search_json_results_with_invalid_data(): void
    {
        foreach ($this->invalidSearch as $search) {
            $response = $this->actingAs($this->test_user)->getJson(route('erp.manager.clients.search', ['search' => $search]));
            $response->assertStatus(422);
            $response->assertJson(['message' => 'The search field format is invalid.']);
        }

    }

    public function test_client_search_json_results_with_long_text(): void
    {
        foreach ($this->longTextSearch as $search) {
            $response = $this->actingAs($this->test_user)->getJson(route('erp.manager.clients.search', ['search' => $search]));
            $response->assertStatus(422);
            $response->assertJson(['message' => 'The search field must not be greater than 50 characters.']);
        }
    }


    public function test_client_filter_by_start_contract_date_in_the_range_results(): void
    {
        $this->test_client->date_of_contract = '2023-12-27 09:00:01';
        $this->test_client->save();

        $response = $this->actingAs($this->test_user)->getJson(route('erp.manager.clients.index', ['start_date' => '2023-12-26 09:00:02']));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("clients.data.0.id", $this->test_client->id)
                ->where("clients.data.0.company", $this->test_client->company)
                ->where("clients.data.0.postal_address", $this->test_client->postal_address)
                ->etc()
            );


    }

    public function test_client_filter_by_start_contract_date_out_of_range_results(): void
    {
        $this->test_client->date_of_contract = '2023-12-26 09:00:02';
        $this->test_client->save();

        $response = $this->actingAs($this->test_user)->getJson(route('erp.manager.clients.index', ['start_date' => '2023-12-27 09:00:01']));
        $response->assertStatus(200)
            ->assertJsonMissing([
                "clients.data.0.id" => $this->test_client->id,
                "clients.data.0.company" => $this->test_client->company,
                "clients.data.0.postal_address" => $this->test_client->postal_address,
            ]);
    }


    public function test_client_filter_by_end_contract_date_in_the_range_results(): void
    {

        $this->test_client->date_of_contract = '2024-01-25 09:00:01';
        $this->test_client->save();

        $response = $this->actingAs($this->test_user)->getJson(route('erp.manager.clients.index', ['end_date' => '2024-01-26 09:00:02']));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("clients.data.0.id", $this->test_client->id)
                ->where("clients.data.0.company", $this->test_client->company)
                ->where("clients.data.0.postal_address", $this->test_client->postal_address)
                ->etc()
            );
    }

    public function test_client_filter_by_end_contract_date_out_of_range_results(): void
    {

        $this->test_client->date_of_contract = '2024-01-26 09:00:02';
        $this->test_client->save();

        $response = $this->actingAs($this->test_user)->getJson(route('erp.manager.clients.index', ['end_date' => '2024-01-25 09:00:01']));
        $response->assertStatus(200)
            ->assertJsonMissing([
                "clients.data.0.id" => $this->test_client->id,
                "clients.data.0.company" => $this->test_client->company,
                "clients.data.0.postal_address" => $this->test_client->postal_address,
            ]);
    }

    public function test_client_filter_by_start_and_end_contract_dates_out_of_range_results(): void
    {

        $this->test_client->date_of_contract = '2023-12-28 09:44:54';
        $this->test_client->save();

        $response = $this->actingAs($this->test_user)->getJson(route('erp.manager.clients.index', ['start_date' => '2023-12-29 09:44:54', 'end_date' => '2024-01-15 09:44:54']));
        $response->assertStatus(200)
            ->assertJsonMissing([
                "clients.data.0.id" => $this->test_client->id,
                "clients.data.0.company" => $this->test_client->company,
                "clients.data.0.postal_address" => $this->test_client->postal_address,
            ]);
    }

    public function test_client_filter_by_start_and_end_contract_dates_in_the_range_results(): void
    {

        $this->test_client->date_of_contract = '2023-12-30 09:44:54';
        $this->test_client->save();

        $response = $this->actingAs($this->test_user)->getJson(route('erp.manager.clients.index', ['start_date' => '2023-12-29 09:44:54', 'end_date' => '2024-01-15 09:44:54']));
        $response->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("clients.data.0.id", $this->test_client->id)
                ->where("clients.data.0.company", $this->test_client->company)
                ->where("clients.data.0.postal_address", $this->test_client->postal_address)
                ->etc()
            );
    }

    public function test_client_filter_by_actual_type_results(): void
    {

//        $this->test_order->execution_date = '2023-12-27 09:00:01';
//        $this->test_order->save();

        $response = $this->actingAs($this->test_user)->getJson(route('erp.manager.clients.index', ['type' => $this->test_client->type]));
        $response->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("clients.data.0.id", $this->test_client->id)
                ->where("clients.data.0.company", $this->test_client->company)
                ->where("clients.data.0.postal_address", $this->test_client->postal_address)
                ->etc()
            );
    }

    public function test_client_filter_by_other_type_results(): void
    {

//        $this->test_order->execution_date = '2023-12-27 09:00:01';
//        $this->test_order->save();

        $response = $this->actingAs($this->test_user)->getJson(route('erp.manager.clients.index', ['type' => $this->test_client->type]));
        $response->assertOk()
            ->assertJsonMissing([
                "clients.data.0.id" => $this->test_client->id,
                "clients.data.0.company" => $this->test_client->company,
                "clients.data.0.postal_address" => $this->test_client->postal_address,
            ]);
    }

    public function test_client_filter_by_actual_company_results(): void
    {

        $response = $this->actingAs($this->test_user)->getJson(route('erp.manager.clients.index', ['company' => $this->test_client->company]));
        $response->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("clients.data.0.id", $this->test_client->id)
                ->where("clients.data.0.company", $this->test_client->company)
                ->where("clients.data.0.postal_address", $this->test_client->postal_address)
                ->etc()
            );
    }

    public function test_client_filter_by_other_company_results(): void
    {

        $response = $this->actingAs($this->test_user)->getJson(route('erp.manager.clients.index', ['company' => $this->irrelevantFilterData['company']]));
        $response->assertOk()
            ->assertJsonMissing([
                "clients.data.0.id" => $this->test_client->id,
                "clients.data.0.company" => $this->test_client->company,
                "clients.data.0.postal_address" => $this->test_client->postal_address,
            ]);
    }

    public function test_client_filter_by_actual_director_name_results(): void
    {

        $response = $this->actingAs($this->test_user)->getJson(route('erp.manager.clients.index', ['director_name' => $this->test_client->director_name]));
        $response->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("clients.data.0.id", $this->test_client->id)
                ->where("clients.data.0.company", $this->test_client->company)
                ->where("clients.data.0.postal_address", $this->test_client->postal_address)
                ->etc()
            );
    }

    public function test_client_filter_by_other_director_name_results(): void
    {

        $response = $this->actingAs($this->test_user)->getJson(route('erp.manager.clients.index', ['director_name' => $this->irrelevantFilterData['director_name']]));
        $response->assertOk()
            ->assertJsonMissing([
                "clients.data.0.id" => $this->test_client->id,
                "clients.data.0.company" => $this->test_client->company,
                "clients.data.0.postal_address" => $this->test_client->postal_address,
            ]);
    }
public function test_client_filter_by_actual_contact_person_position_results(): void
    {

        $response = $this->actingAs($this->test_user)->getJson(route('erp.manager.clients.index', ['contact_person_position' => $this->test_client->contact_person_position]));
        $response->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("clients.data.0.id", $this->test_client->id)
                ->where("clients.data.0.company", $this->test_client->company)
                ->where("clients.data.0.postal_address", $this->test_client->postal_address)
                ->etc()
            );
    }

    public function test_client_filter_by_other_contact_person_position_results(): void
    {

        $response = $this->actingAs($this->test_user)->getJson(route('erp.manager.clients.index', ['contact_person_position' => $this->irrelevantFilterData['contact_person_position']]));
        $response->assertOk()
            ->assertJsonMissing([
                "clients.data.0.id" => $this->test_client->id,
                "clients.data.0.company" => $this->test_client->company,
                "clients.data.0.postal_address" => $this->test_client->postal_address,
            ]);
    }

}
