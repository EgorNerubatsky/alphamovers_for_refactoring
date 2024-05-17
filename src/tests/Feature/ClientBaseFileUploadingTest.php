<?php

namespace Tests\Feature;


use App\Models\ClientBase;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class ClientBaseFileUploadingTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    use RefreshDatabase;
    use WithFaker;


    public function setUp(): void
    {
        parent::setUp();

        $this->test_user = User::factory()->create([
            'is_executive' => true,
        ]);
        Storage::fake('public');
        $this->validFile = UploadedFile::fake()->create('test.pdf', 1400);
        $this->invalidFile = UploadedFile::fake()->create('test.pdf', 15400);
        $this->invalidFileExtension = UploadedFile::fake()->create('test.odf', 1400);
        $this->test_client = ClientBase::factory()->create();
        $this->test_order = Order::factory()->create([
            'client_id' => $this->test_client->id,
        ]);

        $id = $this->test_client->id;
        $this->paths = [
            'deed' => "uploads/deeds/$id/test.pdf",
            'invoice' => "uploads/invoices/$id/test.pdf",
            'act' => "uploads/acts/$id/test.pdf",
        ];

        $this->descriptions = [
            'deed' => 'Договiр',
            'invoice' => 'Рахунок',
            'act' => 'Акт',
        ];

        $this->testFilesRequest = [
            'deed_file' => $this->validFile,
            'deed_file_order' => $this->test_order->id,
            'invoice_file' => $this->validFile,
            'invoice_file_order' => $this->test_order->id,
            'act_file' => $this->validFile,
            'act_file_order' => $this->test_order->id,
        ];

    }

    public function test_uploading_valid_client_deed_file(): void
    {
        $this->filesUploading('deed_file', 'deed_file_order', 'deeds', 'Договiр','Завантаження Договору:  ', 'deed');
    }

    public function test_uploading_valid_client_invoice_file(): void
    {
        $this->filesUploading('invoice_file', 'invoice_file_order', 'invoices', 'Рахунок','Завантаження Рахунку:  ', 'invoice');
    }

    public function test_uploading_valid_client_act_file(): void
    {
        $this->filesUploading('act_file', 'act_file_order', 'acts', 'Акт','Завантаження Акту:  ', 'act');
    }


    private function filesUploading($fileType, $fileOrder, $path, $description, $nemValueDescription, $reason): void
    {
        $this->actingAs($this->test_user);
        $response = $this->post(route('erp.executive.clients.addFiles', ['id' => $this->test_client->id]), [
            $fileType => $this->validFile, $fileOrder => $this->test_order->id,
        ]);
        $response->assertStatus(302);
        $id = $this->test_client->id;
        Storage::disk('public')->assertExists("uploads/$path/$id/test.pdf");
        $this->assertDatabaseHas('documents_paths', [
            'order_id' => $this->test_order->id,
            'path' => "uploads/$path/$id/test.pdf",
            'description' => $description,
            'status' => 'Завантажено',
        ]);

        $this->assertDatabaseHas('changes_histories', [
            'order_id' => $this->test_order->id,
            'client_id' => $this->test_client->id,
            'old_value' => null,
            'new_value' => $nemValueDescription.'test.pdf',
            'user_id' => $this->test_user->id,
            'reason' => $reason,
        ]);

    }


    public function test_multi_uploading_valid_client_files(): void
    {

        $this->actingAs($this->test_user);

        $response = $this->post(route('erp.executive.clients.addFiles', ['id' => $this->test_client->id]),
            $this->testFilesRequest
        );
        $response->assertStatus(302);

        foreach ($this->paths as $key => $path) {
            Storage::disk('public')->assertExists($path);

            $this->assertDatabaseHas('documents_paths', [
                'order_id' => $this->test_order->id,
                'path' => $path,
                'description' => $this->descriptions[$key],
                'status' => 'Завантажено',
            ]);

            $this->assertDatabaseHas('changes_histories', [
                'order_id' => $this->test_order->id,
                'client_id' => $this->test_client->id,
                'old_value' => null,
                'user_id' => $this->test_user->id,
                'reason' => $key,

            ]);
        }
    }

    public function test_multi_uploading_invalid_deed_and_valid_others_client_files(): void
    {
        $this->uploadingInvalidFiles('deed_file', 'deed');
    }

    public function test_multi_uploading_invalid_invoice_and_valid_others_client_files(): void
    {
        $this->uploadingInvalidFiles('invoice_file', 'invoice');
    }

    public function test_multi_uploading_invalid_act_and_valid_others_client_files(): void
    {
        $this->uploadingInvalidFiles('act_file', 'act');
    }


    private function uploadingInvalidFiles($fileType, $file): void
    {
        $this->testFilesRequest[$fileType] = $this->invalidFileExtension;


        $this->actingAs($this->test_user);
        $response = $this->post(route('erp.executive.clients.addFiles', ['id' => $this->test_client->id]), $this->testFilesRequest);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([$fileType => "The $file file field must be a file of type: pdf, doc, docx."]);

        foreach ($this->paths as $key => $path) {

            Storage::disk('public')->assertMissing($path);

            $this->assertDatabaseMissing('documents_paths', [
                'order_id' => $this->test_order->id,
                'path' => $path,
                'description' => $this->descriptions[$key],
                'status' => 'Завантажено',
            ]);
        }
    }

    public function test_multi_uploading_invalid_size_deed_and_valid_others_client_files(): void
    {
        $this->uploadingInvalidSizeFiles('deed_file', 'deed');
    }

    public function test_multi_uploading_invalid_size_invoice_and_valid_others_client_files(): void
    {
        $this->uploadingInvalidSizeFiles('invoice_file', 'invoice');
    }

    public function test_multi_uploading_invalid_size_act_and_valid_others_client_files(): void
    {
        $this->uploadingInvalidSizeFiles('act_file', 'act');
    }

    private function uploadingInvalidSizeFiles($fileType, $file): void
    {
        $this->testFilesRequest[$fileType] = $this->invalidFile;


        $this->actingAs($this->test_user);
        $response = $this->post(route('erp.executive.clients.addFiles', ['id' => $this->test_client->id]), $this->testFilesRequest);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([$fileType => "The $file file field must not be greater than 15360 kilobytes."]);

        foreach ($this->paths as $key => $path) {

            Storage::disk('public')->assertMissing($path);

            $this->assertDatabaseMissing('documents_paths', [
                'order_id' => $this->test_order->id,
                'path' => $path,
                'description' => $this->descriptions[$key],
                'status' => 'Завантажено',
            ]);
        }
    }

}
