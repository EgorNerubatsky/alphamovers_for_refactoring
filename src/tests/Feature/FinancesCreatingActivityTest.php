<?php

namespace Feature;


use App\Models\ClientBase;
use App\Models\ClientContactPersonDetail;
use App\Models\DocumentsPath;
use App\Models\Finance;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class FinancesCreatingActivityTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->test_user = User::factory()->create([
            'is_accountant' => true,
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
            'status' => 'Виконано',
            'order_source' => 'Сайт',
            'payment_form' => 'Юридична особа (безготівковий розрахунок)',
        ]);

        $this->test_documents_paths = DocumentsPath::create([
            'order_id' => $this->test_order->id,
            'client_id' => $this->test_client->id,
            'description' => 'Рахунок',
            'status' => 'Завантажено',
        ]);


    }

    public function test_arrears_creation_from_an_order(): void
    {
        $this->actingAs($this->test_user);
        $response = $this->put(route('erp.accountant.orders.toBankOperations', ['id' => $this->test_documents_paths->id]));
        $response->assertStatus(302);

        $companyBalance = $this->test_order->total_price - $this->test_order->price_to_workers;
        $finances = Finance::where('amount', $this->test_order->total_price)->first();

        $this->assertDatabaseHas('finances', [
            'amount' => $this->test_order->total_price,
            'company_balance'=>$companyBalance,
            'transaction_date'=>$finances->transaction_date,
        ]);
        $this->assertDatabaseHas('bank_operations',[
            'order_id' => $this->test_order->id,
            'amount' => $this->test_order->total_price,
            'beneficiary' => "АТ 'Alphamovers'",
            'payer' => $this->test_client->company,
            'payment_purpose' => $this->test_order->service_type,
            'document_number' => $this->test_documents_paths->id . '/' . date('Y/m'),
            'transaction_date' => $finances->transaction_date,
        ]);

    }

}
