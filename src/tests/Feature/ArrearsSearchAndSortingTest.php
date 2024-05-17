<?php

namespace Feature;

use App\Models\Arrear;
use App\Models\ClientBase;
use App\Models\ClientContactPersonDetail;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ArrearsSearchAndSortingTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->test_user = User::factory()->create([
            'is_executive' => true,
        ]);
        $this->logist_user = User::factory()->create([
            'is_logist' => true,
        ]);

        $this->test_client = ClientBase::factory()
            ->has(ClientContactPersonDetail::factory()->count(2))
            ->create([
                'company' => "АТ 'Credo'",
                'type' => 'Юридична особа',
                'director_name' => 'Вано Дирадзе',
            ]);

        $this->test_order = Order::create([
            'client_id' => $this->test_client->id,
            'execution_date' => '2024-08-26 09:00',
            'number_of_workers' => 4,
            'city' => 'Кремень',
            'street' => 'Перемоги 4',
            'house' => '5а',
            'service_type' => 'Прибирання будівельного сміття',
            'task_description' => 'Тестовий опис для test_order',
            'straps' => 1,
            'tools' => 1,
            'respirators' => 0,
            'transport' => 'Легкова 1',
            'price_to_customer' => 45.14,
            'price_to_workers' => 23.90,
            'min_order_amount' => 91.10,
            'min_order_hrs' => 25.00,
            'order_hrs' => 6.00,
            'total_price' => 546.06,
            'payment_note' => 'Тестовий опис payment_note',
            'review' => 'Тестовий опис review',
            'status' => 'В роботі',
            'order_source' => 'Сайт',
            'payment_form' => 'Юридична особа (безготівковий розрахунок)',
            'user_logist_id' => $this->logist_user->id,
        ]);

        $this->test_arrear = Arrear::create([
            'client_id' => $this->test_client->id,
            'order_id' => $this->test_order->id,
            'work_debt' => $this->test_order->total_price,
            'current_year_revenue' => $this->test_order->total_price,
            'total_revenue' => $this->test_order->total_price,
            'contract_date' => $this->test_order->created_at,
            'comment' => 'Замовлення завершано, рахунок не оплачено замовником',
        ]);
    }

    public function test_arrears_search_json_results_with_valid_data(): void
    {
        $expectedId = $this->test_arrear->id;
        $this->assertSuccessfulSearch('Credo', $this->test_order->total_price, 'Замовлення завершано, рахунок не оплачено замовником', $expectedId);
        $this->assertSuccessfulSearch('Вано', $this->test_order->total_price, 'Замовлення завершано, рахунок не оплачено замовником', $expectedId);
        $this->assertSuccessfulSearch('Кремень', $this->test_order->total_price, 'Замовлення завершано, рахунок не оплачено замовником', $expectedId);
        $this->assertSuccessfulSearch('будівельного', $this->test_order->total_price, 'Замовлення завершано, рахунок не оплачено замовником', $expectedId);
        $this->assertSuccessfulSearch('Замовлення завершано', $this->test_order->total_price, 'Замовлення завершано, рахунок не оплачено замовником', $expectedId);
    }

    private function assertSuccessfulSearch(string $searchQuery, string $expectedPrice, string $expectedComment, int $expectedOrderId): void
    {

        $response = $this->actingAs($this->test_user)->getJson(route('erp.executive.arrears.search', ['search' => "$searchQuery"]));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("arrears.data.0.id", $expectedOrderId)
                ->where("arrears.data.0.total_revenue", $expectedPrice)
                ->where("arrears.data.0.comment", $expectedComment)
                ->etc()
            );
    }

    public function test_arrears_search_json_results_with_absentees_data(): void
    {
        $this->assertAbsenteesSearch('Звер');
        $this->assertAbsenteesSearch('Волинь');
        $this->assertAbsenteesSearch('Вулиця 44');
        $this->assertAbsenteesSearch('4567');
    }

    private function assertAbsenteesSearch(string $searchQuery): void
    {
        $response = $this->actingAs($this->test_user)->getJson(route('erp.executive.arrears.search', ['search' => "$searchQuery"]));

        $response->assertStatus(200)
            ->assertJsonMissingPath("arrears.data.0")
            ->assertJsonMissingPath("arrears.data.0.id");
    }

    public function test_arrears_search_json_results_with_invalid_data(): void
    {
        $this->assertInvalidSearch('!@#$%');
        $this->assertInvalidSearch("<blink>Hello there</blink>");
        $this->assertInvalidSearch("Robert'); DROP TABLE Students;--");
    }

    public function test_arrears_search_json_results_with_long_text(): void
    {
        $this->assertInvalidLongTextSearch(str_repeat('A', 301));
        $this->assertInvalidLongTextSearch(str_repeat('A', 51));
    }

    private function assertInvalidSearch(string $searchQuery): void
    {
        $response = $this->actingAs($this->test_user)->getJson(route('erp.executive.arrears.search', ['search' => "$searchQuery"]));
        $response->assertStatus(422);
        $response->assertJson(['message' => 'The search field format is invalid.']);
    }

    private function assertInvalidLongTextSearch(string $searchQuery): void
    {
        $response = $this->actingAs($this->test_user)->getJson(route('erp.executive.arrears.search', ['search' => "$searchQuery"]));
        $response->assertStatus(422);
        $response->assertJson(['message' => 'The search field must not be greater than 50 characters.']);
    }


    public function test_arrears_filter_by_start_contract_date_in_the_range_results(): void
    {
        $this->test_arrear->contract_date = '2023-12-27 09:00:01';
        $this->test_arrear->save();

        $response = $this->actingAs($this->test_user)->getJson(route('erp.executive.arrears.index', ['start_date' => '2023-12-26 09:00:02']));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("arrears.data.0.id", $this->test_arrear->id)
                ->where("arrears.data.0.total_revenue", '546.06')
                ->where("arrears.data.0.comment", $this->test_arrear->comment)
                ->etc()
            );
    }

    public function test_arrears_filter_by_start_contract_date_out_of_range_results(): void
    {
        $this->test_arrear->contract_date = '2023-12-26 09:00:02';
        $this->test_arrear->save();

        $response = $this->actingAs($this->test_user)->getJson(route('erp.executive.arrears.index', ['start_date' => '2023-12-27 09:00:01']));
        $response->assertStatus(200)
            ->assertJsonMissingPath("arrears.data.0")
            ->assertJsonMissingPath("arrears.data.0.id");
    }


    public function test_arrears_filter_by_end_contract_date_in_the_range_results(): void
    {
        $this->test_arrear->contract_date = '2024-01-25 09:00:01';
        $this->test_arrear->save();

        $response = $this->actingAs($this->test_user)->getJson(route('erp.executive.arrears.index', ['end_date' => '2024-01-26 09:00:02']));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("arrears.data.0.id", $this->test_arrear->id)
                ->where("arrears.data.0.total_revenue", '546.06')
                ->where("arrears.data.0.comment", $this->test_arrear->comment)
                ->etc()
            );
    }

    public function test_arrears_filter_by_end_contract_date_out_of_range_results(): void
    {
        $this->test_arrear->contract_date = '2024-01-26 09:00:02';
        $this->test_arrear->save();

        $response = $this->actingAs($this->test_user)->getJson(route('erp.executive.arrears.index', ['end_date' => '2024-01-25 09:00:01']));
        $response->assertStatus(200)
            ->assertJsonMissingPath("arrears.data.0")
            ->assertJsonMissingPath("arrears.data.0.id");
    }

    public function test_arrears_filter_by_start_and_end_contract_dates_out_of_range_results(): void
    {
        $this->test_arrear->contract_date = '2023-12-28 09:44:54';
        $this->test_arrear->save();

        $response = $this->actingAs($this->test_user)->getJson(route('erp.executive.arrears.index', ['start_date' => '2023-12-29 09:44:54', 'end_date' => '2024-01-15 09:44:54']));
        $response->assertStatus(200)
            ->assertJsonMissingPath("arrears.data.0")
            ->assertJsonMissingPath("arrears.data.0.id");
    }

    public function test_arrears_filter_by_start_and_end_contract_dates_in_the_range_results(): void
    {
        $this->test_arrear->contract_date = '2023-12-30 09:44:54';
        $this->test_arrear->save();

        $response = $this->actingAs($this->test_user)->getJson(route('erp.executive.arrears.index', ['start_date' => '2023-12-29 09:44:54', 'end_date' => '2024-01-15 09:44:54']));
        $response->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("arrears.data.0.id", $this->test_arrear->id)
                ->where("arrears.data.0.total_revenue", '546.06')
                ->where("arrears.data.0.comment", $this->test_arrear->comment)
                ->etc()
            );
    }

    public function test_arrears_filter_by_client_type_in_the_range_results(): void
    {
        $response = $this->actingAs($this->test_user)->getJson(route('erp.executive.arrears.index', ['type' => 'Юридична особа']));
        $response->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("arrears.data.0.id", $this->test_arrear->id)
                ->where("arrears.data.0.total_revenue", '546.06')
                ->where("arrears.data.0.comment", $this->test_arrear->comment)
                ->etc()
            );
    }

    public function test_arrears_filter_by_client_type_out_of_range_results(): void
    {
        $response = $this->actingAs($this->test_user)->getJson(route('erp.executive.arrears.index', ['type' => 'Фізична особа']));
        $response->assertOk()
            ->assertJsonMissingPath("arrears.data.0")
            ->assertJsonMissingPath("arrears.data.0.id");
    }

    public function test_arrears_filter_by_company_in_the_range_results(): void
    {
        $response = $this->actingAs($this->test_user)->getJson(route('erp.executive.arrears.index', ['company' => "АТ 'Credo'"]));
        $response->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("arrears.data.0.id", $this->test_arrear->id)
                ->where("arrears.data.0.total_revenue", '546.06')
                ->where("arrears.data.0.comment", $this->test_arrear->comment)
                ->etc()
            );
    }

    public function test_arrears_filter_by_company_out_of_the_range_results(): void
    {

        $response = $this->actingAs($this->test_user)->getJson(route('erp.executive.arrears.index', ['company' => "АТ 'Cred'"]));
        $response->assertOk()
            ->assertJsonMissingPath("arrears.data.0")
            ->assertJsonMissingPath("arrears.data.0.id");
    }

    public function test_order_filter_by_amount_from_in_the_range_results(): void
    {
        $response = $this->actingAs($this->test_user)->getJson(route('erp.executive.arrears.index', ['amount_from' => 540]));
        $response->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("arrears.data.0.id", $this->test_arrear->id)
                ->where("arrears.data.0.total_revenue", '546.06')
                ->where("arrears.data.0.comment", $this->test_arrear->comment)
                ->etc()
            );
    }

    public function test_arrears_filter_by_amount_from_out_of_range_results(): void
    {

        $response = $this->actingAs($this->test_user)->getJson(route('erp.executive.arrears.index', ['amount_from' => 550]));
        $response->assertOk()
            ->assertJsonMissingPath("arrears.data.0")
            ->assertJsonMissingPath("arrears.data.0.id");
    }

    public function test_arrears_filter_by_amount_to_in_the_range_results(): void
    {

        $response = $this->actingAs($this->test_user)->getJson(route('erp.executive.arrears.index', ['amount_to' => 547]));

        $response->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("arrears.data.0.id", $this->test_arrear->id)
                ->where("arrears.data.0.total_revenue", '546.06')
                ->where("arrears.data.0.comment", $this->test_arrear->comment)
                ->etc()
            );
    }

    public function test_arrears_filter_by_amount_to_out_of_range_results(): void
    {
        $this->test_order->total_price = 148.34;
        $this->test_order->save();

        $response = $this->actingAs($this->test_user)->getJson(route('erp.executive.arrears.index', ['amount_to' => 540]));
        $response->assertOk()
            ->assertJsonMissingPath("arrears.data.0")
            ->assertJsonMissingPath("arrears.data.0.id");
    }

    public function test_arrears_filter_between_amount_from_and_amount_to_in_the_range_results(): void
    {
        $response = $this->actingAs($this->test_user)->getJson(route('erp.executive.arrears.index', ['amount_from' => 540.001, 'amount_to' => 550.001]));

        $response->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("arrears.data.0.id", $this->test_arrear->id)
                ->where("arrears.data.0.total_revenue", '546.06')
                ->where("arrears.data.0.comment", $this->test_arrear->comment)
                ->etc()
            );
    }

    public function test_arrears_filter_between_amount_from_and_amount_to_out_of_range_results(): void
    {
        $response = $this->actingAs($this->test_user)->getJson(route('erp.executive.arrears.index', ['amount_from' => 500.001, 'amount_to' => 520.001]));
        $response->assertOk()
            ->assertJsonMissingPath("arrears.data.0")
            ->assertJsonMissingPath("arrears.data.0.id");
    }
}
