<?php

namespace Feature;


use App\Models\ClientBase;
use App\Models\ClientContactPersonDetail;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class OrdersUpdatingActivityTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'is_manager'=> true
        ]);
        $this->logist_id = User::factory()->create([
            'is_logist'=> true
        ])->id;

        $this->test_client = ClientBase::factory()
            ->has(ClientContactPersonDetail::factory()->count(2))
            ->create();

        $this->invalidData = [
            'execution_date' => '#$%^',
            'number_of_workers' => "6",
            'city' => 'Вугл@#$%^!едар',
            'street' => 'Пер@#$%^!емоги',
            'house' => '4@#$%^!а',
            'service_type' => '@#$%^!Прибирання будівельного сміття',
            'task_description' => '@#$%^!Тестовий опис для Прибирання будівельного сміття',
            'straps' => 're',
            'tools' => '@#$%^!',
            'respirators' => "1",
            'transport' => 'Легк@#$%^!ова 1',
            'price_to_customer' => '@#$%^!7.14',
            'price_to_workers' => '3@#$%^!3.90',
            'min_order_amount' => '9@#$%^!0.10',
            'min_order_hrs' => '9@#$%^!.00',
            'order_hrs' => '4.00',
            'payment_note' => 'Тестовий опис',
            'review' => 'Тестовий опис',
            'status' => '@#$%^!',
            'order_source' => '@#$%^!',
            'payment_form' => 'Юр@#$%^!идична особа (безготівко@#$%^!вий розрахунок)',
            'user_logist_id' => $this->logist_id,
        ];

        $this->updatedData = [
            'client_id' => $this->test_client->id,
            'execution_date' => '2024-11-26 09:00',
            'number_of_workers' => 6,
            'city' => 'Вугледар',
            'street' => 'Перемоги',
            'house' => '4а',
            'service_type' => 'Прибирання будівельного сміття',
            'task_description' => 'Тестовий опис для Прибирання будівельного сміття',
            'straps' => 0,
            'tools' => 1,
            'respirators' => 1,
            'transport' => 'Легкова 1',
            'price_to_customer' => 87.14,
            'price_to_workers' => 33.90,
            'min_order_amount' => 90.10,
            'min_order_hrs' => 9.00,
            'order_hrs' => 4.00,
            'payment_note' => 'Тестовий опис',
            'review' => 'Тестовий опис',
            'status' => 'В роботі',
            'order_source' => 'Сайт',
            'payment_form' => 'Юридична особа (безготівковий розрахунок)',
            'user_logist_id' => $this->logist_id,
        ];

        $this->test_order = Order::factory()->create([
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
            'payment_note' => 'Тестовий опис payment_note',
            'review' => 'Тестовий опис review',
            'status' => 'В роботі',
            'order_source' => 'Сайт',
            'payment_form' => 'Юридична особа (безготівковий розрахунок)',
            'user_logist_id' => $this->logist_id,
        ]);

        $this->updatedClientData = [
            'client' => $this->test_client->id,
            'fullname' => 'Владимир Владимирович Дерипаска',
            'phone' => '+380978645812',
        ];
    }

    public function test_update_order_with_valid_data(): void
    {
        $response = $this->actingAs($this->user)->assertAuthenticated();

        $response->put(route('erp.manager.orders.update', ['order' => $this->test_order]),
            $this->updatedData)->assertStatus(302);

        $this->assertDatabaseHas('orders', $this->updatedData);
    }

    public function test_update_order_client_data_with_valid_data(): void
    {
        $response = $this->actingAs($this->user)->assertAuthenticated();

        $response->put(route('erp.manager.orders.update', ['order' => $this->test_order]),
            array_merge($this->updatedData + $this->updatedClientData)

        )->assertStatus(302);

        $this->assertDatabaseHas('orders', $this->updatedData);
        $this->assertDatabaseHas('client_contact_person_details', [
            'complete_name' => 'Владимир Владимирович Дерипаска',
            'client_phone' => '+380978645812',
            'client_base_id' => $this->test_client->id,
        ]);
    }

    public function test_try_update_order_without_required_fields(): void
    {
        $response = $this->actingAs($this->user)->assertAuthenticated();

        unset($this->updatedData['city']);
        unset($this->updatedData['street']);
        unset($this->updatedData['house']);
        unset($this->updatedData['min_order_amount']);

        $response->put(route('erp.manager.orders.update', ['order' => $this->test_order]), $this->updatedData)
            ->assertSessionHasErrors([
                'city' => 'The city field is required.',
                'street' => 'The street field is required.',
                'house' => 'The house field is required.',
                'min_order_amount' => 'The min order amount field is required.',
            ]);
        $this->assertDatabaseMissing('orders', $this->updatedData);
    }

    public function test_try_update_order_with_invalid_data(): void
    {
        $response = $this->actingAs($this->user)->assertAuthenticated();

        $response->put(route('erp.manager.orders.update', ['order' => $this->test_order]),
            $this->invalidData)->assertSessionHasErrors([
            'execution_date' => 'The execution date field must be a valid date.',
            'order_source' => 'The order source field format is invalid.',
            'status' => 'The status field format is invalid.',
            'payment_form' => 'The payment form field format is invalid.',
            'city' => 'The city field format is invalid.',
            'street' => 'The street field format is invalid.',
            'house' => 'The house field format is invalid.',
            'transport' => 'The transport field format is invalid.',
            'task_description' => 'The task description field format is invalid.',
            'straps' => 'The straps field must be true or false.',
            'tools' => 'The tools field must be true or false.',
            'min_order_amount' => 'The min order amount field must be a number.',
            'min_order_hrs' => 'The min order hrs field must be a number.',
            'price_to_customer' => 'The price to customer field must be a number.',
            'price_to_workers' => 'The price to workers field must be a number.',
        ]);
        $this->assertDatabaseMissing('orders', $this->invalidData);
    }

    public function test_order_soft_delete(): void
    {
        $response = $this->actingAs($this->user)->get(route('erp.manager.orders.delete', ['order' => $this->test_order]));
        $response->assertStatus(302);

        $this->assertSoftDeleted('orders', [
            'id'=>$this->test_order->id,
            'client_id' => $this->test_client->id,
            'execution_date' => '2024-08-26 09:00',
            'number_of_workers' => 4,
            'city' => 'Кремень',
            'street' => 'Перемоги 4',
            'house' => '5а',
        ]);
    }

}
