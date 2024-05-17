<?php

namespace Feature;

use App\Models\BankOperation;
use App\Models\ClientBase;
use App\Models\ClientContactPersonDetail;
use App\Models\DocumentsPath;
use App\Models\Finance;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class FinancesSearchAndSortingTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->test_user = User::factory()->create([
            'is_accountant' => true,
        ]);

        $this->test_client = ClientBase::factory()
            ->has(ClientContactPersonDetail::factory()->count(2))
            ->create([
                'company' => 'RRY',
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
            'status' => 'Виконано',
            'order_source' => 'Сайт',
            'payment_form' => 'Юридична особа (безготівковий розрахунок)',
        ]);

        $companyBalance = $this->test_order->total_price - $this->test_order->price_to_workers;

        $this->test_documents_paths = DocumentsPath::create([
            'order_id' => $this->test_order->id,
            'client_id' => $this->test_client->id,
            'description' => 'Рахунок',
            'status' => 'Завантажено',
        ]);

        $this->test_fifances = Finance::create([
            'amount' => $this->test_order->total_price,
            'company_balance' => $companyBalance,
            'transaction_date' => '2024-08-26 12:00',
        ]);

        $this->test_bank_operation = BankOperation::create([
            'order_id' => $this->test_order->id,
            'amount' => $this->test_order->total_price,
            'beneficiary' => "АТ 'Alphamovers'",
            'payer' => $this->test_client->company,
            'payment_purpose' => $this->test_order->service_type,
            'document_number' => $this->test_documents_paths->id . '/' . date('Y/m'),
            'transaction_date' => now(),
        ]);

        $this->validSearch = [
            "RRY",
            $this->test_bank_operation->document_number,
            "АТ 'Alphamovers'",
            '546',
            'Прибирання будівельного',
        ];
        $this->invalidSearch = [
            "C@#$%^o",
            '6@#$%^872561',
            "<script>alert('Executing JS')</script>",
            '@#$%^',
            '://www.mysite.com',
        ];

        $this->absenteesSearch = [
            "RTY",
            '603241888555',
            'Днепр',
            'вул.345',
            '0305743555',
        ];

        $this->longTextSearch = [
            str_repeat('A', 70),
            str_repeat('A', 301),
            str_repeat('A', 5000),
        ];


    }

    public function test_finances_search_json_results_with_valid_data(): void
    {
        foreach ($this->validSearch as $search) {
            $response = $this->actingAs($this->test_user)->getJson(route('erp.accountant.finances.search', ['search' => $search]));
            $response->assertStatus(200)
                ->assertJson(fn(AssertableJson $json) => $json
                    ->where("bankOperations.data.0.id", $this->test_bank_operation->id)
                    ->where("bankOperations.data.0.payment_purpose", $this->test_bank_operation->payment_purpose)
                    ->where("bankOperations.data.0.payer", $this->test_bank_operation->payer)
                    ->etc()
                );
        }

    }

    public function test_finances_search_json_results_with_absentees_data(): void
    {
        foreach ($this->absenteesSearch as $search) {
            $response = $this->actingAs($this->test_user)->getJson(route('erp.accountant.finances.search', ['search' => $search]));
            $response->assertStatus(200)
                ->assertJsonMissingPath('bankOperations.data.0.id')
                ->assertJsonMissingPath('bankOperations.data.0.payment_purpose')
                ->assertJsonMissingPath('bankOperations.data.0.payer');
        }

    }

    public function test_finances_search_json_results_with_invalid_data(): void
    {
        foreach ($this->invalidSearch as $search) {
            $response = $this->actingAs($this->test_user)->getJson(route('erp.accountant.finances.search', ['search' => $search]));
            $response->assertStatus(422);
            $response->assertJson(['message' => 'The search field format is invalid.']);
        }

    }

    public function test_finances_search_json_long_text(): void
    {
        foreach ($this->longTextSearch as $search) {
            $response = $this->actingAs($this->test_user)->getJson(route('erp.accountant.finances.search', ['search' => $search]));
            $response->assertStatus(422);
            $response->assertJson(['message' => 'The search field must not be greater than 50 characters.']);
        }

    }


    public function test_finances_filter_by_create_from_date_in_the_range_results(): void
    {
        $this->test_bank_operation->created_at = '2023-12-27 09:00:01';
        $this->test_bank_operation->save();

        $response = $this->actingAs($this->test_user)->getJson(route('erp.accountant.finances.index', ['start_date' => '2023-12-26 09:00:02']));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("bankOperations.data.0.id", $this->test_bank_operation->id)
                ->where("bankOperations.data.0.payment_purpose", $this->test_bank_operation->payment_purpose)
                ->where("bankOperations.data.0.payer", $this->test_bank_operation->payer)
                ->etc()
            );
    }

    public function test_finances_filter_by_create_from_date_out_of_range_results(): void
    {
        $this->test_bank_operation->created_at = '2023-12-26 09:00:02';
        $this->test_bank_operation->save();

        $response = $this->actingAs($this->test_user)->getJson(route('erp.accountant.finances.index', ['start_date' => '2023-12-27 09:00:01']));
        $response->assertStatus(200)
            ->assertJsonMissingPath('bankOperations.data.0.id')
            ->assertJsonMissingPath('bankOperations.data.0.payment_purpose')
            ->assertJsonMissingPath('bankOperations.data.0.payer');
    }


    public function test_finances_filter_by_create_to_date_in_the_range_results(): void
    {
        $this->test_bank_operation->created_at = '2024-01-25 09:00:01';
        $this->test_bank_operation->save();

        $response = $this->actingAs($this->test_user)->getJson(route('erp.accountant.finances.index', ['end_date' => '2024-01-26 09:00:02']));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("bankOperations.data.0.id", $this->test_bank_operation->id)
                ->where("bankOperations.data.0.payment_purpose", $this->test_bank_operation->payment_purpose)
                ->where("bankOperations.data.0.payer", $this->test_bank_operation->payer)
                ->etc()
            );
    }

    public function test_finances_filter_by_create_to_date_out_of_range_results(): void
    {
        $this->test_bank_operation->created_at = '2024-01-26 09:00:02';
        $this->test_bank_operation->save();

        $response = $this->actingAs($this->test_user)->getJson(route('erp.accountant.finances.index', ['end_date' => '2024-01-25 09:00:01']));
        $response->assertStatus(200)
            ->assertJsonMissingPath('bankOperations.data.0.id')
            ->assertJsonMissingPath('bankOperations.data.0.payment_purpose')
            ->assertJsonMissingPath('bankOperations.data.0.payer');
    }

    public function test_finances_filter_by_start_and_end_create_dates_out_of_range_results(): void
    {
        $this->test_bank_operation->created_at = '2023-12-28 09:44:54';
        $this->test_bank_operation->save();

        $response = $this->actingAs($this->test_user)->getJson(route('erp.accountant.finances.index', ['start_date' => '2023-12-29 09:44:54', 'end_date' => '2024-01-15 09:44:54']));
        $response->assertStatus(200)
            ->assertJsonMissingPath('bankOperations.data.0.id')
            ->assertJsonMissingPath('bankOperations.data.0.payment_purpose')
            ->assertJsonMissingPath('bankOperations.data.0.payer');
    }

    public function test_finances_filter_by_start_and_end_create_dates_in_the_range_results(): void
    {
        $this->test_bank_operation->created_at = '2023-12-30 09:44:54';
        $this->test_bank_operation->save();

        $response = $this->actingAs($this->test_user)->getJson(route('erp.accountant.finances.index', ['start_date' => '2023-12-29 09:44:54', 'end_date' => '2024-01-15 09:44:54']));
        $response->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("bankOperations.data.0.id", $this->test_bank_operation->id)
                ->where("bankOperations.data.0.payment_purpose", $this->test_bank_operation->payment_purpose)
                ->where("bankOperations.data.0.payer", $this->test_bank_operation->payer)
                ->etc()
            );
    }

    public function test_finances_filter_by_payer_type_in_the_range_results(): void
    {
        $response = $this->actingAs($this->test_user)->getJson(route('erp.accountant.finances.index', ['payer' => $this->test_bank_operation->payer]));
        $response->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("bankOperations.data.0.id", $this->test_bank_operation->id)
                ->where("bankOperations.data.0.payment_purpose", $this->test_bank_operation->payment_purpose)
                ->where("bankOperations.data.0.payer", $this->test_bank_operation->payer)
                ->etc()
            );
    }

    public function test_finances_filter_by_client_type_out_of_range_results(): void
    {
        $response = $this->actingAs($this->test_user)->getJson(route('erp.accountant.finances.index', ['payer' => 'ERY']));
        $response->assertOk()
            ->assertJsonMissingPath('bankOperations.data.0.id')
            ->assertJsonMissingPath('bankOperations.data.0.payment_purpose')
            ->assertJsonMissingPath('bankOperations.data.0.payer');
    }

    public function test_finances_filter_by_amount_from_in_the_range_results(): void
    {
        $response = $this->actingAs($this->test_user)->getJson(route('erp.accountant.finances.index', ['amount_from' => 540]));
        $response->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("bankOperations.data.0.id", $this->test_bank_operation->id)
                ->where("bankOperations.data.0.payment_purpose", $this->test_bank_operation->payment_purpose)
                ->where("bankOperations.data.0.payer", $this->test_bank_operation->payer)
                ->etc()
            );
    }

    public function test_finances_filter_by_amount_from_out_of_range_results(): void
    {

        $response = $this->actingAs($this->test_user)->getJson(route('erp.accountant.finances.index', ['amount_from' => 550]));
        $response->assertOk()
            ->assertJsonMissingPath('bankOperations.data.0.id')
            ->assertJsonMissingPath('bankOperations.data.0.payment_purpose')
            ->assertJsonMissingPath('bankOperations.data.0.payer');
    }

    public function test_finances_filter_by_amount_to_in_the_range_results(): void
    {

        $response = $this->actingAs($this->test_user)->getJson(route('erp.accountant.finances.index', ['amount_to' => 547]));

        $response->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("bankOperations.data.0.id", $this->test_bank_operation->id)
                ->where("bankOperations.data.0.payment_purpose", $this->test_bank_operation->payment_purpose)
                ->where("bankOperations.data.0.payer", $this->test_bank_operation->payer)
                ->etc()
            );
    }

    public function test_finances_filter_by_amount_to_out_of_range_results(): void
    {
        $this->test_order->total_price = 148.34;
        $this->test_order->save();

        $response = $this->actingAs($this->test_user)->getJson(route('erp.accountant.finances.index', ['amount_to' => 540]));
        $response->assertOk()
            ->assertJsonMissingPath('bankOperations.data.0.id')
            ->assertJsonMissingPath('bankOperations.data.0.payment_purpose')
            ->assertJsonMissingPath('bankOperations.data.0.payer');
    }

    public function test_finances_filter_between_amount_from_and_amount_to_in_the_range_results(): void
    {
        $response = $this->actingAs($this->test_user)->getJson(route('erp.accountant.finances.index', ['amount_from' => 540.001, 'amount_to' => 550.001]));
        $response->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("bankOperations.data.0.id", $this->test_bank_operation->id)
                ->where("bankOperations.data.0.payment_purpose", $this->test_bank_operation->payment_purpose)
                ->where("bankOperations.data.0.payer", $this->test_bank_operation->payer)
                ->etc()
            );
    }

    public function test_finances_filter_between_amount_from_and_amount_to_out_of_range_results(): void
    {
        $response = $this->actingAs($this->test_user)->getJson(route('erp.accountant.finances.index', ['amount_from' => 500.001, 'amount_to' => 520.001]));
        $response->assertOk()
            ->assertJsonMissingPath('bankOperations.data.0.id')
            ->assertJsonMissingPath('bankOperations.data.0.payment_purpose')
            ->assertJsonMissingPath('bankOperations.data.0.payer');
    }
}
