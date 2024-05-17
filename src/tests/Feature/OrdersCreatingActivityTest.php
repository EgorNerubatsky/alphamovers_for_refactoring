<?php

namespace Feature;


use App\Models\ClientBase;
use App\Models\ClientContactPersonDetail;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class OrdersCreatingActivityTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(UserSeeder::class);

        $this->user = User::where('is_manager', true)->first();
        $this->logist_id = User::where('is_logist', true)->first()->id;

        $this->test_client = ClientBase::factory()
            ->has(ClientContactPersonDetail::factory()->count(2))
            ->create();

        $this->invalidData = [
            'client' => $this->test_client->id,
            'execution_date_date' => '2024--06-26',
            'execution_date_time' => '18--00',
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
        ];

        $this->creatingData = [

            'client' => $this->test_client->id,
            'execution_date_date' => '2024-06-26',
            'execution_date_time' => '18:00',
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
            'logist' => $this->logist_id,
        ];

    }

    public function test_create_order_with_valid_data(): void
    {
        $response = $this->actingAs($this->user)->assertAuthenticated();

        $response->post(route('erp.manager.orders.store', $this->creatingData))->assertStatus(302);

        unset($this->creatingData['client']);
        unset($this->creatingData['execution_date_date']);
        unset($this->creatingData['execution_date_time']);
        unset($this->creatingData['logist']);

        $this->assertDatabaseHas('orders', $this->creatingData);
    }

    public function test_create_order_with_invalid_data(): void
    {
        $response = $this->actingAs($this->user)->assertAuthenticated();

        $response->post(route('erp.manager.orders.store', $this->invalidData))
            ->assertSessionHasErrors([
                'execution_date_date' => 'The execution date date field must match the format Y-m-d.',
                'execution_date_time' => 'The execution date time field must match the format H:i.',
                'order_source' => 'The order source field format is invalid.',
                'service_type' => 'The service type field format is invalid.',
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

        $this->assertDatabaseMissing('orders', [
            'city' => 'Вугл@#$%^!едар',
            'street' => 'Пер@#$%^!емоги',
            'house' => '4@#$%^!а',
        ]);
    }

    public function test_create_order_without_required_data(): void
    {
        $response = $this->actingAs($this->user)->assertAuthenticated();

        $this->creatingData['price_to_workers'] = 456.45;
        $this->creatingData['price_to_customer'] = 237.34;
        $this->creatingData['min_order_amount'] = 25.89;

        unset($this->creatingData['client']);
        unset($this->creatingData['execution_date_date']);
        unset($this->creatingData['execution_date_time']);
        unset($this->creatingData['order_source']);
        unset($this->creatingData['status']);
        unset($this->creatingData['service_type']);
        unset($this->creatingData['city']);
        unset($this->creatingData['street']);
        unset($this->creatingData['house']);
        unset($this->creatingData['logist']);


        $response->post(route('erp.manager.orders.store', $this->creatingData))->assertStatus(302)
            ->assertSessionHasErrors([
                'city' => 'The city field is required.',
                'street' => 'The street field is required.',
                'house' => 'The house field is required.',
                'execution_date_date' => 'The execution date date field is required.',
                'execution_date_time' => 'The execution date time field is required.',
                'order_source' => 'The order source field is required.',
                'status' => 'The status field is required.',
                'service_type' => 'The service type field is required.',
            ]);
        $this->assertDatabaseMissing('orders', $this->creatingData);
    }


//
//    public function test_lead_soft_delete(): void
//    {
//        $response = $this->actingAs($this->user)->get(route('erp.executive.leads.delete', ['lead' => $this->test_lead]));
//        $response->assertStatus(302);
//
//        $this->assertSoftDeleted('leads', ['id' => $this->test_lead->id]);
//    }


}
