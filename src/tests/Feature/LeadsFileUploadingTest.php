<?php

namespace Feature;


use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class LeadsFileUploadingTest extends TestCase
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

        $this->test_lead = Lead::factory()->create([
            'company' => "АО 'Test Company'",
            'fullname' => 'Антон Кмийка',
            'email' => 'test456mail@mail.com',
            'phone' => '+380955567121',
            'comment' => 'Новий Тестовий коментар Тест',
            'status' => 'новый',
        ]);

        $this->updatedData = [
            'company' => "АО 'TTY'",
            'fullname' => 'Тимур Милий',
            'email' => 'test888mail@mail.com',
            'phone' => '+380955567888',
            'comment' => 'Новий Тестовий коментар 22',
            'status' => 'новый',
            'lead_file' => $this->validFile,
        ];
        $this->creatingData = [
            'company' => "АО 'ЛОТОС'",
            'fullname' => 'Олег Грива',
            'email' => 'test777mail@mail.com',
            'phone' => '+380955561111',
            'comment' => 'Новий Тестовий коментар 33',
            'status' => 'новый',
            'lead_file' => $this->validFile,
        ];
    }

    public function test_create_lead_with_invalid_file(): void
    {

        $this->actingAs($this->user);
        $this->creatingData['lead_file'] = $this->invalidFile;
        $response = $this->post(route('erp.executive.leads.store'), $this->creatingData);
        $response->assertStatus(302);

        $response->assertSessionHasErrors(['lead_file' => 'The lead file field must not be greater than 15360 kilobytes.']);
        $this->assertDatabaseMissing('leads', [
            'company' => "АО 'ЛОТОС'",
            'fullname' => 'Олег Грива',
            'email' => 'test777mail@mail.com',
            'phone' => '+380955561111',
            'comment' => 'Новий Тестовий коментар 33',
            'status' => 'новый',
        ]);
    }

    public function test_uploading_invalid_lead_file_extension(): void
    {
        $this->actingAs($this->user);
        $this->creatingData['lead_file'] = $this->invalidFileExtension;
        $response = $this->post(route('erp.executive.leads.store'), $this->creatingData);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['lead_file' => 'The lead file field must be a file of type: pdf, doc, docx.']);

        $this->assertDatabaseMissing('leads', [
            'company' => "АО 'ЛОТОС'",
            'fullname' => 'Олег Грива',
            'email' => 'test777mail@mail.com',
            'phone' => '+380955561111',
            'comment' => 'Новий Тестовий коментар 33',
            'status' => 'новый',
        ]);
    }

    public function test_create_lead_with_valid_file(): void
    {

        $this->actingAs($this->user);

        $response = $this->post(route('erp.executive.leads.store'), $this->creatingData);
        $response->assertStatus(302);

        $testLead = Lead::where('company',"АО 'ЛОТОС'")->firstOrFail();

        Storage::disk('public')->assertExists("uploads/leads/$testLead->id/test.pdf");
        $this->assertDatabaseHas('leads',[
            'company' => "АО 'ЛОТОС'",
            'fullname' => 'Олег Грива',
            'email' => 'test777mail@mail.com',
            'phone' => '+380955561111',
            'comment' => 'Новий Тестовий коментар 33',
            'status' => 'новый',
        ]);
        $this->assertDatabaseHas('documents_paths', [
            'lead_id' => $testLead->id,
            'path' => "uploads/leads/$testLead->id/test.pdf",
            'description' => 'Документ вiд замовника',
            'status' => 'Завантажено',
        ]);
    }

    public function test_update_lead_with_invalid_file(): void
    {

        $this->actingAs($this->user);
        $this->updatedData['lead_file'] = $this->invalidFile;
        $response = $this->put(route('erp.executive.leads.update', ['lead' => $this->test_lead]), $this->updatedData);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['lead_file' => 'The lead file field must not be greater than 15360 kilobytes.']);

        Storage::disk('public')->assertMissing("uploads/leads/{$this->test_lead->id}/test.pdf");

        $this->assertDatabaseMissing('leads',
            [
                'fullname' => 'Тимур Милий',
                'company' => "АО 'TTY'",
            ]);

    }

    public function test_update_lead_with_extension_file(): void
    {
        $this->actingAs($this->user);
        $this->updatedData['lead_file'] = $this->invalidFileExtension;
        $response = $this->put(route('erp.executive.leads.update', ['lead' => $this->test_lead]), $this->updatedData);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['lead_file' => 'The lead file field must be a file of type: pdf, doc, docx.']);

        Storage::disk('public')->assertMissing("uploads/leads/{$this->test_lead->id}/test.odf");

        $this->assertDatabaseMissing('leads',
            [
                'fullname' => 'Тимур Милий',
                'company' => "АО 'TTY'",
            ]);
    }


    public function test_update_lead_with_valid_file(): void
    {
        $this->actingAs($this->user);

        $response = $this->put(route('erp.executive.leads.update', ['lead' => $this->test_lead]), $this->updatedData);
        $response->assertStatus(302);

        Storage::disk('public')->assertExists("uploads/leads/{$this->test_lead->id}/test.pdf");
        $this->assertDatabaseHas('leads',
            [
                'id' => $this->test_lead->id,
                'fullname' => 'Тимур Милий',
                'company' => "АО 'TTY'",
            ]);

        $this->assertDatabaseHas('documents_paths', [
            'lead_id' => $this->test_lead->id,
            'path' => "uploads/leads/{$this->test_lead->id}/test.pdf",
            'description' => 'Документ вiд замовника',
            'status' => 'Завантажено',
        ]);
    }



}
