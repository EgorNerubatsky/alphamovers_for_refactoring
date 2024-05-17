<?php

namespace Tests\Feature;

use App\Models\ClientBase;
use App\Models\ClientContactPersonDetail;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class OrdersSearchAndSortingTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'is_manager' => true,
        ]);

        $this->test_client = ClientBase::factory()
            ->create(['company' => 'АО Юрава']);

        $this->test_order = Order::factory()->create([
            'city' => 'Днепр',
            'status' => 'Попереднє замовлення',
            'street' => 'Вулиця 4',
        ]);

        $this->test_client_contact = ClientContactPersonDetail::factory()->create([
            'client_base_id' => $this->test_client->id,
            'client_phone' => '+380997776655',
        ]);

        $this->validSearch = [
            "Юрава",
            'Днепр',
            'Вулиця 4',
            '09977766',
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
            "Звер",
            'Волинь',
            'Вулиця 44',
            '4567',
        ];

    }

    public function test_order_search_json_results_with_valid_data(): void
    {

        foreach ($this->validSearch as $search) {
            $response = $this->actingAs($this->user)->getJson(route('erp.manager.orders.search', ['search' => $search]));
            $response->assertStatus(200)
                ->assertJson(fn(AssertableJson $json) => $json
                    ->where("orders.data.0.id", $this->test_order->id)
                    ->where("orders.data.0.city", $this->test_order->city)
                    ->where("clients.0.company", $this->test_client->company)
                    ->where("clientContacts.0.client_phone", $this->test_client_contact->client_phone)
                    ->etc()
                );
        }

    }

    public function test_order_search_json_results_with_absentees_data(): void
    {
        foreach ($this->absenteesSearch as $search) {
            $response = $this->actingAs($this->user)->getJson(route('erp.manager.orders.search', ['search' => $search]));

            $response->assertStatus(200)
                ->assertJsonMissingPath("orders.data.0")
                ->assertJsonMissingPath("orders.data.0.id")
                ->assertJsonMissingPath("orders.data.0.city");
        }

    }

    public function test_order_search_json_results_with_invalid_data(): void
    {
        foreach ($this->invalidSearch as $search) {
            $response = $this->actingAs($this->user)->getJson(route('erp.manager.orders.search', ['search' => $search]));
            $response->assertStatus(422);
            $response->assertJson(['message' => 'The search field format is invalid.']);
        }

    }

    public function test_order_search_json_results_with_long_text_data(): void
    {
        foreach ($this->longTextSearch as $search) {
            $response = $this->actingAs($this->user)->getJson(route('erp.manager.orders.search', ['search' => $search]));
            $response->assertStatus(422);
            $response->assertJson(['message' => 'The search field must not be greater than 50 characters.']);
        }
    }


    public function test_order_filter_by_start_date_in_the_range_results(): void
    {
        $this->test_order->created_at = '2023-12-27 09:00:01';
        $this->test_order->save();

        $response = $this->actingAs($this->user)->getJson(route('erp.manager.orders.index', ['start_date' => '2023-12-26 09:00:02']));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("orders.data.0.id", $this->test_order->id)
                ->where("orders.data.0.street", $this->test_order->street)
                ->where("orders.data.0.city", $this->test_order->city)
                ->etc()
            );
    }

    public function test_order_filter_by_start_date_out_of_range_results(): void
    {

        $this->test_order->created_at = '2023-12-26 09:00:02';
        $this->test_order->save();

        $response = $this->actingAs($this->user)->getJson(route('erp.manager.orders.index', ['start_date' => '2023-12-27 09:00:01']));
        $response->assertStatus(200)
            ->assertJsonMissing([
                "orders.data.0.id" => $this->test_order->id,
                "orders.data.0.street" => $this->test_order->street,
                "orders.data.0.city" => $this->test_order->city,
            ]);
    }


    public function test_lead_filter_by_end_date_in_the_range_results(): void
    {

        $this->test_order->created_at = '2024-01-25 09:00:01';
        $this->test_order->save();

        $response = $this->actingAs($this->user)->getJson(route('erp.manager.orders.index', ['end_date' => '2024-01-26 09:00:02']));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("orders.data.0.id", $this->test_order->id)
                ->where("orders.data.0.street", $this->test_order->street)
                ->where("orders.data.0.city", $this->test_order->city)
                ->etc()
            );
    }

    public function test_lead_filter_by_end_date_out_of_range_results(): void
    {

        $this->test_order->created_at = '2024-01-26 09:00:02';
        $this->test_order->save();

        $response = $this->actingAs($this->user)->getJson(route('erp.manager.orders.index', ['end_date' => '2024-01-25 09:00:01']));
        $response->assertStatus(200)
            ->assertJsonMissing([
                "orders.data.0.id" => $this->test_order->id,
                "orders.data.0.street" => $this->test_order->street,
                "orders.data.0.city" => $this->test_order->city,
            ]);
    }

    public function test_lead_filter_by_start_and_end_dates_out_of_range_results(): void
    {

        $this->test_order->created_at = '2023-12-28 09:44:54';
        $this->test_order->save();

        $response = $this->actingAs($this->user)->getJson(route('erp.manager.orders.index', ['start_date' => '2023-12-29 09:44:54', 'end_date' => '2024-01-15 09:44:54']));
        $response->assertStatus(200)
            ->assertJsonMissing([
                "orders.data.0.id" => $this->test_order->id,
                "orders.data.0.street" => $this->test_order->street,
                "orders.data.0.city" => $this->test_order->city,
            ]);
    }

    public function test_lead_filter_by_start_and_end_dates_in_the_range_results(): void
    {

        $this->test_order->created_at = '2023-12-30 09:44:54';
        $this->test_order->save();

        $response = $this->actingAs($this->user)->getJson(route('erp.manager.orders.index', ['start_date' => '2023-12-29 09:44:54', 'end_date' => '2024-01-15 09:44:54']));
        $response->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("orders.data.0.id", $this->test_order->id)
                ->where("orders.data.0.street", $this->test_order->street)
                ->where("orders.data.0.city", $this->test_order->city)
                ->etc()
            );
    }

    public function test_order_filter_by_start_of_execution_date_in_the_range_results(): void
    {

        $this->test_order->execution_date = '2023-12-27 09:00:01';
        $this->test_order->save();

        $response = $this->actingAs($this->user)->getJson(route('erp.manager.orders.index', ['start_execution_date' => '2023-12-26 09:00:02']));
        $response->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("orders.data.0.id", $this->test_order->id)
                ->where("orders.data.0.street", $this->test_order->street)
                ->where("orders.data.0.city", $this->test_order->city)
                ->etc()

            );
    }

    public function test_order_filter_by_start_of_execution_date_out_of_range_results(): void
    {

        $this->test_order->execution_date = '2023-12-26 09:00:02';
        $this->test_order->save();

        $response = $this->actingAs($this->user)->getJson(route('erp.manager.orders.index', ['start_execution_date' => '2023-12-27 09:00:01']));
        $response->assertOk()
            ->assertJsonMissing([
                'execution_date' => $this->test_order->execution_date,
                'city' => $this->test_order->city,
                'street' => $this->test_order->street])
            ->assertJsonMissingPath("orders.data.0.review");
    }

    public function test_lead_filter_by_end_of_execution_date_in_the_range_results(): void
    {

        $this->test_order->execution_date = '2024-01-25 09:00:01';
        $this->test_order->save();

        $response = $this->actingAs($this->user)->getJson(route('erp.manager.orders.index', ['end_execution_date' => '2024-01-26 09:00:02']));

        $response->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("orders.data.0.id", $this->test_order->id)
                ->where("orders.data.0.street", $this->test_order->street)
                ->where("orders.data.0.city", $this->test_order->city)
                ->etc()
            );
    }

    public function test_lead_filter_by_after_end_of_execution_date_out_of_range_results(): void
    {
        $this->test_order->execution_date = '2024-01-26 09:00:02';
        $this->test_order->save();

        $response = $this->actingAs($this->user)->getJson(route('erp.manager.orders.index', ['end_execution_date' => '2024-01-25 09:00:01']));
        $response->assertOk()
            ->assertJsonMissing([
                'execution_date' => $this->test_order->execution_date,
                'city' => $this->test_order->city,
                'street' => $this->test_order->street,
            ])
            ->assertJsonMissingPath("orders.data.0.review");
    }

    public function test_lead_filter_between_start_and_end_execution_date_in_the_range_results(): void
    {
        $this->test_order->execution_date = '2023-12-28 09:44:54';
        $this->test_order->save();

        $response = $this->actingAs($this->user)->getJson(route('erp.manager.orders.index', ['start_execution_date' => '2023-12-21 09:44:54', 'end_execution_date' => '2023-12-31 09:44:54']));
        $response->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("orders.data.0.id", $this->test_order->id)
                ->where("orders.data.0.city", $this->test_order->city)
                ->where("orders.data.0.street", $this->test_order->street)
                ->etc()
            );
    }

    public function test_lead_filter_between_start_and_end_execution_date_out_of_range_results(): void
    {
        $this->test_order->execution_date = '2023-12-20 09:44:54';
        $this->test_order->save();

        $response = $this->actingAs($this->user)->getJson(route('erp.manager.orders.index', ['start_execution_date' => '2023-12-21 09:44:54', 'end_execution_date' => '2023-12-31 09:44:54']));
        $response->assertOk()
            ->assertJsonMissing([
                'execution_date' => $this->test_order->execution_date,
                'city' => $this->test_order->city,
                'street' => $this->test_order->street])
            ->assertJsonMissingPath("orders.data.0.review");
    }


    public function test_order_filter_by_pre_order_status_results(): void
    {

        $newPreOrder = Order::factory()->create([
            'status' => 'Попереднє замовлення',
            'city' => 'Канев',
            'street' => 'Вулиця 3456',
        ]);
        $atWorkOrder = Order::factory()->create([
            'status' => 'В роботі',
            'user_manager_id' => $this->user->id,

            'city' => 'Ужгород',
            'street' => 'Вулиця 678',

        ]);
        $completedOrder = Order::factory()->create([
            'status' => 'Виконано',
            'user_manager_id' => $this->user->id,

            'city' => 'Волочиськ',
            'street' => 'Вулиця 345',

        ]);
        $rejectionOrder = Order::factory()->create([
            'status' => 'Скасовано',
            'user_manager_id' => $this->user->id,

            'city' => 'Мерчик',
            'street' => 'Вулиця 890',

        ]);
        $this->assertFilteredByStatus('Попереднє замовлення', $newPreOrder, $atWorkOrder, $completedOrder, $rejectionOrder);
    }

    public function test_order_filter_by_at_work_status_results(): void
    {


        $newPreOrder = Order::factory()->create([
            'status' => 'Попереднє замовлення',
            'city' => 'Николаев',
            'street' => 'Вулиця 9345',
        ]);

        $atWorkOrder = Order::factory()->create([
            'status' => 'В роботі',
            'user_manager_id' => $this->user->id,
            'city' => 'Винница',
            'street' => 'Вулиця 235',
        ]);

        $this->test_order->update([
            'status' => 'В роботі',
            'user_manager_id' => $this->user->id,
            'city' => 'Ошакив',
            'street' => 'Вулиця 555',
        ]);

        $completedOrder = Order::factory()->create([
            'status' => 'Виконано',
            'city' => 'Град',
            'user_manager_id' => $this->user->id,
            'street' => 'Вулиця 0943',
        ]);

        $rejectionOrder = Order::factory()->create([
            'status' => 'Скасовано',
            'city' => 'Мерефа',
            'user_manager_id' => $this->user->id,
            'street' => 'Вулиця 450',
        ]);
        $this->assertFilteredByStatus('В роботі', $atWorkOrder, $completedOrder, $newPreOrder, $rejectionOrder);
    }

    public function test_order_filter_by_completed_order_status_results(): void
    {


        $newPreOrder = Order::factory()->create([
            'status' => 'Попереднє замовлення',
            'city' => 'Мерчик',
            'street' => 'Вулиця 23',
        ]);
        $atWorkOrder = Order::factory()->create([
            'status' => 'В роботі',
            'user_manager_id' => $this->user->id,
            'city' => 'Тополь',
            'street' => 'Вулиця 78',
        ]);
        $completedOrder = Order::factory()->create([
            'status' => 'Виконано',
            'user_manager_id' => $this->user->id,
            'city' => 'Водолага',
            'street' => 'Вулиця 90',
        ]);

        $this->test_order->update([
            'status' => 'Виконано',
            'user_manager_id' => $this->user->id,
            'city' => 'Гринев',
            'street' => 'Вулиця 456',
        ]);

        $rejectionOrder = Order::factory()->create([
            'status' => 'Скасовано',
            'user_manager_id' => $this->user->id,
            'city' => 'Новий Мерчик',
            'street' => 'Вулиця 11',
        ]);

        $this->assertFilteredByStatus('Виконано', $completedOrder, $newPreOrder, $atWorkOrder, $rejectionOrder);
    }

    private function assertFilteredByStatus($status, $orderSecond, $orderThird, $orderFourth, $orderFifth): void
    {

        $response = $this->actingAs($this->user)->getJson(route('erp.manager.orders.index', ['status' => "$status"]));
        $response->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("orders.data.0.street", $this->test_order->street)
                ->where("orders.data.0.city", $this->test_order->city)
                ->etc()
            )
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("orders.data.1.id", $orderSecond->id)
                ->where("orders.data.1.street", $orderSecond->street)
                ->where("orders.data.1.city", $orderSecond->city)
                ->etc()
            )
            ->assertJsonMissing([
                'city' => $orderThird->city,
                'street' => $orderThird->street,
            ])
            ->assertJsonMissing([
                'city' => $orderFourth->city,
                'street' => $orderFourth->street,
            ])
            ->assertJsonMissing([
                'city' => $orderFifth->city,
                'street' => $orderFifth->street,
            ]);
    }


    public function test_order_filter_by_rejection_order_status_results(): void
    {
        $newPreOrder = Order::factory()->create([
            'status' => 'Попереднє замовлення',
            'city' => 'Мерчик',
            'street' => 'Вулиця 23',
        ]);
        $atWorkOrder = Order::factory()->create([
            'status' => 'В роботі',
            'user_manager_id' => $this->user->id,
            'city' => 'Тополь',
            'street' => 'Вулиця 78',
        ]);
        $completedOrder = Order::factory()->create([
            'status' => 'Виконано',
            'user_manager_id' => $this->user->id,
            'city' => 'Водолага',
            'street' => 'Вулиця 90',
        ]);
        $rejectionOrder = Order::factory()->create([
            'status' => 'Скасовано',
            'user_manager_id' => $this->user->id,
            'city' => 'Новий Мерчик',
            'street' => 'Вулиця 11',
        ]);

        $this->test_order->update([
            'status' => 'Скасовано',
            'user_manager_id' => $this->user->id,
            'city' => 'Новий Немзик',
            'street' => 'Вулиця 299',
        ]);

        $this->assertFilteredByStatus('Скасовано', $rejectionOrder, $atWorkOrder, $completedOrder, $newPreOrder);
    }

    public function test_order_filter_by_amount_from_in_the_range_results(): void
    {

        $this->test_order->total_price = 621.96;
        $this->test_order->save();

        $response = $this->actingAs($this->user)->getJson(route('erp.manager.orders.index', ['amount_from' => 620]));
        $response->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("orders.data.0.id", $this->test_order->id)
                ->where("orders.data.0.street", $this->test_order->street)
                ->where("orders.data.0.city", $this->test_order->city)
                ->etc()

            );
    }

    public function test_order_filter_by_amount_from_out_of_range_results(): void
    {

        $this->test_order->total_price = 620.96;
        $this->test_order->save();

        $response = $this->actingAs($this->user)->getJson(route('erp.manager.orders.index', ['amount_from' => 621.96]));
        $response->assertOk()
            ->assertJsonMissing([
                'execution_date' => $this->test_order->execution_date,
                'city' => $this->test_order->city,
                'street' => $this->test_order->street])
            ->assertJsonMissingPath("orders.data.0.review");
    }

    public function test_lead_filter_by_amount_to_in_the_range_results(): void
    {

        $this->test_order->total_price = 145.67;
        $this->test_order->save();

        $response = $this->actingAs($this->user)->getJson(route('erp.manager.orders.index', ['amount_to' => 146.89]));

        $response->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("orders.data.0.id", $this->test_order->id)
                ->where("orders.data.0.street", $this->test_order->street)
                ->where("orders.data.0.city", $this->test_order->city)
                ->etc()
            );
    }

    public function test_lead_filter_by_amount_to_out_of_range_results(): void
    {
        $this->test_order->total_price = 148.34;
        $this->test_order->save();

        $response = $this->actingAs($this->user)->getJson(route('erp.manager.orders.index', ['amount_to' => 147.56]));
        $response->assertOk()
            ->assertJsonMissing([
                'execution_date' => $this->test_order->execution_date,
                'city' => $this->test_order->city,
                'street' => $this->test_order->street,
            ])
            ->assertJsonMissingPath("orders.data.0.review");
    }

    public function test_lead_filter_between_amount_from_and_amount_to_in_the_range_results(): void
    {
        $this->test_order->total_price = 125000.897;
        $this->test_order->save();

        $response = $this->actingAs($this->user)->getJson(route('erp.manager.orders.index', ['amount_from' => 125000.001, 'amount_to' => 125100.001]));
        $response->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("orders.data.0.id", $this->test_order->id)
                ->where("orders.data.0.city", $this->test_order->city)
                ->where("orders.data.0.street", $this->test_order->street)
                ->etc()
            );
    }

    public function test_lead_filter_between_amount_from_and_amount_to_out_of_range_results(): void
    {
        $this->test_order->total_price = 34000.78;
        $this->test_order->save();

        $response = $this->actingAs($this->user)->getJson(route('erp.manager.orders.index', ['amount_from' => 34001, 'amount_to' => 35000]));
        $response->assertOk()
            ->assertJsonMissing([
                'execution_date' => $this->test_order->execution_date,
                'city' => $this->test_order->city,
                'street' => $this->test_order->street])
            ->assertJsonMissingPath("orders.data.0.review");
    }

}
