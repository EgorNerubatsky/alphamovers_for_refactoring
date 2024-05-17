<?php

namespace Feature;


use App\Models\ClientBase;
use App\Models\ClientContactPersonDetail;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class ArrearsCreatingActivityTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->logist_user = User::factory()->create([
            'is_logist' => true,
        ]);

        $this->test_client = ClientBase::factory()
            ->has(ClientContactPersonDetail::factory()->count(2))
            ->create();

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
    }

    public function test_arrears_creation_from_an_order(): void
    {
        $this->actingAs($this->logist_user);

        $response = $this->get(route('erp.logist.orders.completion', ['id' => $this->test_order->id, 'request'=>'Виконано']));
        $response->assertStatus(302);

        $this->assertDatabaseHas('arrears', [
            'client_id' => $this->test_order->client->id,
            'order_id' => $this->test_order->id,
            'work_debt' => $this->test_order->total_price,
            'current_year_revenue' => $this->test_order->total_price,
            'total_revenue' => $this->test_order->total_price,
            'contract_date' => $this->test_order->created_at,
            'comment' => 'Замовлення завершано, рахунок не оплачено замовником',
        ]);

        $this->assertDatabaseHas('orders', [
            'id' => $this->test_order->id,
            'status' => 'Виконано',
        ]);
    }

}
