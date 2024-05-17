<?php

namespace Feature;


use App\Models\Applicant;
use App\Models\Interviewee;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class ApplicantsFileUploadingTest extends TestCase
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

        $this->validFile = UploadedFile::fake()->create('test.jpg', 400);
        $this->invalidFile = UploadedFile::fake()->create('test.jpg', 15400);
        $this->invalidFileExtension = UploadedFile::fake()->create('test.jprg', 400);

        $this->test_applicant = Applicant::factory()->create([
            'fullname' => 'Авдєєв Леонід Олександрович',
            'phone' => '+380951234569',
            'desired_position' => 'Грузчик',
            'comment' => 'Дуже чудова людина',
        ]);

        $this->updatedData = [
            'fullname_surname' => 'Евсюков',
            'fullname_name' => 'Андрій',
            'fullname_patronymic' => 'Олексійович',
            'phone' => '+380951234888',
            'desired_position' => 'Бригадир',
            'comment' => 'Дуже-Дуже чудова людина',
            'applicant_photo' => $this->validFile,

        ];

        $this->creatingData = [
            'fullname_surname' => 'Авдєєв',
            'fullname_name' => 'Миколо',
            'fullname_patronymic' => 'Олександрович',
            'phone' => '+380951234777',
            'desired_position' => 'Грузчик',
            'comment' => 'Дуже-придуже чудова людина',
            'applicant_photo' => $this->validFile,

        ];
    }

    public function test_uploading_valid_applicant_photo(): void
    {
        $this->actingAs($this->user);

        $response = $this->put(route('erp.executive.applicants.update', ['applicant' => $this->test_applicant]), $this->updatedData);
        $response->assertStatus(302);

        Storage::disk('public')->assertExists("uploads/photos/applicants/{$this->test_applicant->id}/test.jpg");
        $this->assertDatabaseHas('applicants',
            [
                'id' => $this->test_applicant->id,
                'fullname' => 'Евсюков Андрій Олексійович',
            ]);
        $this->assertDatabaseHas('candidates_files',
            [
                'applicant_id' => $this->test_applicant->id,
                'path' => "uploads/photos/applicants/{$this->test_applicant->id}/test.jpg",
            ]);

    }


    public function test_uploading_invalid_applicant_photo(): void
    {

        $this->actingAs($this->user);
        $this->updatedData['applicant_photo'] = $this->invalidFile;
        $response = $this->put(route('erp.executive.applicants.update', ['applicant' => $this->test_applicant]), $this->updatedData);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['applicant_photo' => 'The applicant photo field must not be greater than 15360 kilobytes.']);

        Storage::disk('public')->assertMissing("uploads/photos/applicants/{$this->test_applicant->id}/test.jpg");

        $this->assertDatabaseMissing('applicants',
            [
                'id' => $this->test_applicant->id,
                'fullname' => 'Евсюков Андрій Олексійович',

            ]);
    }

    public function test_uploading_invalid_applicant_photo_extension(): void
    {
        $this->actingAs($this->user);
        $this->updatedData['applicant_photo'] = $this->invalidFileExtension;
        $response = $this->put(route('erp.executive.applicants.update', ['applicant' => $this->test_applicant]), $this->updatedData);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['applicant_photo' => 'The applicant photo field must be a file of type: jpeg, jpg, png.']);

        Storage::disk('public')->assertMissing("uploads/photos/applicants/{$this->test_applicant->id}/test.jprg");

        $this->assertDatabaseMissing('applicants',
            [
                'id' => $this->test_applicant->id,
                'fullname' => 'Евсюков Андрій Олексійович',

            ]);
    }

    public function test_create_applicant_with_valid_photo(): void
    {
        $this->actingAs($this->user);

        $response = $this->post(route('erp.executive.applicants.store'), $this->creatingData);
        $response->assertStatus(302);

        $newTestApplicant = Applicant::where('phone', $this->creatingData['phone'])->firstOrFail();
        Storage::disk('public')->assertExists("uploads/photos/applicants/$newTestApplicant->id/test.jpg");

        $this->assertDatabaseHas('applicants',
            [
                'id' => $newTestApplicant->id,
                'fullname' => 'Авдєєв Миколо Олександрович',

            ]);
        $this->assertDatabaseHas('candidates_files',
            [
                'applicant_id' => $newTestApplicant->id,
                'path' => "uploads/photos/applicants/$newTestApplicant->id/test.jpg",

            ]);


    }

    public function test_create_applicant_with_invalid_photo(): void
    {
        $this->creatingData['applicant_photo'] = $this->invalidFile;
        $this->creatingData['phone'] = '+380951234333';

        $this->actingAs($this->user);

        $response = $this->post(route('erp.executive.applicants.store'), $this->creatingData);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['applicant_photo' => 'The applicant photo field must not be greater than 15360 kilobytes.']);
        $this->assertDatabaseMissing('applicants',
            [
                'phone' => '+380951234333',
            ]);
    }

    public function test_applicant_to_interviewee_remove(): void
    {

        $this->actingAs($this->user);

        $response = $this->put(route('erp.executive.applicants.update', ['applicant' => $this->test_applicant]), $this->updatedData);

        $this->get(route('erp.executive.applicants.removeToInterviewee', ['id' => $this->test_applicant->id]));
        $response->assertStatus(302);

        $newInterviewee = Interviewee::where('phone',$this->updatedData['phone'])->firstOrFail();
        Storage::disk('public')->assertExists("uploads/photos/interviewees/$newInterviewee->id/test.jpg");
        Storage::disk('public')->assertMissing("uploads/photos/applicants/{$this->test_applicant->id}/test.jpg");

        $this->assertDatabaseHas('interviewees', [
            'phone' => $this->updatedData['phone'],
            'fullname' => 'Евсюков Андрій Олексійович',
        ]);

        $this->assertSoftDeleted('applicants', [
            'id' => $this->test_applicant->id,
            'phone' => $this->updatedData['phone'],
            'comment' => $this->updatedData['comment'],
        ]);
    }


}
