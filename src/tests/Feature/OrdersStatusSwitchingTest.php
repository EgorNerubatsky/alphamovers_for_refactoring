<?php

namespace Tests\Feature;

use App\Models\ClientBase;
use App\Models\ClientContact;
use App\Models\ClientContactPersonDetail;
use App\Models\Lead;
use App\Models\Order;
use App\Models\User;
use Database\Seeders\ClientBaseTableSeeder;
use Database\Seeders\ClientContactPersonDetailTableSeeder;
use Database\Seeders\ClientContactTableSeeder;
use Database\Seeders\DocumentsPathSeeder;
use Database\Seeders\LeadTableSeeder;
use Database\Seeders\OrderTableSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

/**
 * @property $faker
 */
class OrdersStatusSwitchingTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'is_executive'=> true
        ]);

        $this->test_client = ClientBase::factory()->create();

        $this->test_client_contact = ClientContactPersonDetail::factory(2)
            ->create([
                'client_base_id'=>$this->test_client->id,
            ]);

        $this->test_order = Order::factory()->create([
            'client_id'=>$this->test_client->id,
        ]);
    }

    public function test_order_status_cancellation(): void
    {
        $this->test_order->update([
            'status' => 'В роботі',
        ]);

        $response = $this->actingAs($this->user)->assertAuthenticated();
        $response->get(route('erp.executive.orders.cancellation', ['order' => $this->test_order->id]))->assertStatus(302);
        $this->assertEquals('Скасовано', $this->test_order->fresh()->status);
    }

    public function test_order_status_return(): void
    {
        $this->test_order->update([
            'status' => 'Скасовано',
        ]);

        $response = $this->actingAs($this->user)->assertAuthenticated();
        $response->get(route('erp.executive.orders.return', ['order' => $this->test_order->id]))->assertStatus(302);
        $this->assertEquals('Попереднє замовлення', $this->test_order->fresh()->status);
    }

    public function test_order_status_delete(): void
    {
        $this->test_order->update([
            'status' => 'Попереднє замовлення',
        ]);

        $response = $this->actingAs($this->user)->assertAuthenticated();
        $response->get(route('erp.executive.orders.delete', ['order' => $this->test_order->id]))->assertStatus(302);
        $this->assertSoftDeleted('orders', ['id' => $this->test_order->id]);
    }

}
