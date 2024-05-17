<?php

namespace Feature;


use App\Models\Order;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class OrdersFileUploadingTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    use RefreshDatabase;
    use WithFaker;


    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'is_executive' => true,
        ]);
        Storage::fake('public');
        $this->validFile = UploadedFile::fake()->create('test.pdf', 1400);
        $this->invalidFile = UploadedFile::fake()->create('test.pdf', 15400);
        $this->invalidFileExtension = UploadedFile::fake()->create('test.odf', 1400);
        $this->test_order = Order::factory()->create();

    }

    public function test_uploading_valid_order_deed_file(): void
    {

        $this->actingAs($this->user);
        $response = $this->post(route('erp.executive.orders.addFiles', ['id' => $this->test_order->id]), [
            'deed_file' => $this->validFile,
        ]);
        $response->assertStatus(302);
        $id = $this->test_order->id;

        Storage::disk('public')->assertExists("uploads/deeds/$id/test.pdf");

        $this->assertDatabaseHas('documents_paths', [
            'order_id' => $this->test_order['id'],
            'path' => "uploads/deeds/$id/test.pdf",
            'description' => 'Договiр',
            'status' => 'Завантажено',
        ]);
    }

    public function test_multi_uploading_valid_order_files(): void
    {

        $this->actingAs($this->user);
        $order_id = $this->test_order->id;
        $paths = [
            'deed'=>"uploads/deeds/$order_id/test.pdf",
            'invoice'=>"uploads/invoices/$order_id/test.pdf",
            'act'=>"uploads/acts/$order_id/test.pdf",
        ];

        $descriptions = [
            'deed' => 'Договiр',
            'invoice' => 'Рахунок',
            'act' => 'Акт',
        ];

        $response = $this->post(route('erp.executive.orders.addFiles', ['id' => $this->test_order->id]), [
            'deed_file' => $this->validFile,
            'invoice_file'=>$this->validFile,
            'act_file'=>$this->validFile,
        ]);
        $response->assertStatus(302);

        foreach($paths as $key=> $path){
            Storage::disk('public')->assertExists($path);

            $this->assertDatabaseHas('documents_paths', [
                'order_id' => $order_id,
                'path' => $path,
                'description' => $descriptions[$key],
                'status' => 'Завантажено',
            ]);
        }
    }

    public function test_multi_uploading_invalid_deed_and_valid_others_order_files(): void
    {

        $this->actingAs($this->user);
        $order_id = $this->test_order->id;
        $paths = [
            'deed_file'=>"uploads/deeds/$order_id/test.pdf",
            'invoice_file'=>"uploads/invoices/$order_id/test.pdf",
            'act_file'=>"uploads/acts/$order_id/test.pdf",
        ];

        $descriptions = [
            'deed_file' => 'Договiр',
            'invoice_file' => 'Рахунок',
            'act_file' => 'Акт',
        ];

        $fileTypes = [
            'deed_file' => $this->invalidFileExtension,
            'invoice_file' => $this->validFile,
            'act_file' => $this->validFile,
        ];

        $response = $this->post(route('erp.executive.orders.addFiles', ['id' => $this->test_order->id]), $fileTypes);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['deed_file' => 'The deed file field must be a file of type: pdf, doc, docx.']);

        foreach($paths as $key=> $path){

            Storage::disk('public')->assertMissing($path);

            $this->assertDatabaseMissing('documents_paths', [
                'order_id' => $order_id,
                'path' => $path,
                'description' => $descriptions[$key],
                'status' => 'Завантажено',
            ]);
        }
    }

    public function test_uploading_invalid_size_order_file(): void
    {

        $this->actingAs($this->user);
        $response = $this->post(route('erp.executive.orders.addFiles', ['id' => $this->test_order->id]), [
            'deed_file' => $this->invalidFile,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['deed_file' => 'The deed file field must not be greater than 15360 kilobytes.']);
        $order_id = $this->test_order->id;
        Storage::disk('public')->assertMissing("uploads/deeds/$order_id/test.pdf");


        $this->assertDatabaseMissing('documents_paths', [
            'lead_id' => $this->test_order['id'],
            'path' => "uploads/deeds/$order_id/test.pdf",
            'description' => 'Договiр',
            'status' => 'Завантажено',
        ]);
    }

    public function test_uploading_invalid_extension_order_file(): void
    {
        $this->actingAs($this->user);
        $response = $this->post(route('erp.executive.orders.addFiles', ['id' => $this->test_order->id]), [
            'deed_file' => $this->invalidFileExtension,

        ]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['deed_file' => 'The deed file field must be a file of type: pdf, doc, docx.']);
        $order_id = $this->test_order->id;
        Storage::disk('public')->assertMissing("uploads/deeds/$order_id/test.pdf");

        $this->assertDatabaseMissing('documents_paths', [
            'lead_id' => $this->test_order['id'],
            'path' => "uploads/deeds/$order_id/test.pdf",
            'description' => 'Договiр',
            'status' => 'Завантажено',
        ]);
    }

}
