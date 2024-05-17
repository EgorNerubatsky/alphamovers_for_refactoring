<?php

namespace Feature;


use App\Models\Interviewee;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class IntervieweesFileUploadingTest extends TestCase
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

        $this->test_interviewee = Interviewee::factory()->create([
            'call_date' => '2023-06-26 00:00:00',
            'interview_date' => '2023-07-26 00:00:00',
            'fullname' => 'Авдєєв Леонід Олександрович',
            'birth_date' => '2001-06-26 00:00:00',
            'gender' => 'чол',
            'address' => 'Харків, Вулиця 1',
            'phone' => '+380951234567',
            'email' => 'email123@test.com',
            'position' => 'Грузчик',
            'comment' => 'Дуже чудова людина',
        ]);

        $this->updatedData = [
            'call_date' => '2023-08-15 00:00:00',
            'interview_date' => '2023-08-26 00:00:00',
            'fullname_surname' => 'Заквирка',
            'fullname_name' => 'Антон',
            'fullname_patronymic' => 'Олександрович',
            'birth_date' => '2000-01-24 00:00:00',
            'gender' => 'чол',
            'address' => 'Харків, Вулиця 4',
            'phone' => '+380951238888',
            'email' => 'email888@test.com',
            'position' => 'HR',
            'comment' => 'Дуже яскрава людина',
            'interviewee_photo'=>  $this->validFile,
        ];
    }

    public function test_uploading_valid_interviewee_photo(): void
    {
        $this->actingAs($this->user);

        $response = $this->put(route('erp.executive.interviewees.update', ['interviewee' => $this->test_interviewee]), $this->updatedData);
        $response->assertStatus(302);

        Storage::disk('public')->assertExists("uploads/photos/interviewees/{$this->test_interviewee->id}/test.jpg");
        $this->assertDatabaseHas('interviewees',
            [
                'id' => $this->test_interviewee->id,
                'fullname' => 'Заквирка Антон Олександрович',
            ]);

        $this->assertDatabaseHas('candidates_files',
            [
                'interviewee_id' => $this->test_interviewee->id,
                'path' => "uploads/photos/interviewees/{$this->test_interviewee->id}/test.jpg",
            ]);
    }


    public function test_uploading_invalid_interviewee_photo(): void
    {

        $this->actingAs($this->user);
        $this->updatedData['interviewee_photo'] = $this->invalidFile;
        $response = $this->put(route('erp.executive.interviewees.update', ['interviewee' => $this->test_interviewee]), $this->updatedData);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['interviewee_photo' => 'The interviewee photo field must not be greater than 15360 kilobytes.']);

        Storage::disk('public')->assertMissing("uploads/photos/interviewees/{$this->test_interviewee->id}/test.jpg");

        $this->assertDatabaseMissing('interviewees',
            [
                'id' => $this->test_interviewee->id,
                'fullname' => 'Заквирка Антон Олександрович',
            ]);
    }

    public function test_uploading_invalid_interviewee_photo_extension(): void
    {
        $this->actingAs($this->user);
        $this->updatedData['interviewee_photo'] = $this->invalidFileExtension;
        $response = $this->put(route('erp.executive.interviewees.update', ['interviewee' => $this->test_interviewee]), $this->updatedData);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['interviewee_photo' => 'The interviewee photo field must be a file of type: jpeg, jpg, png.']);

        Storage::disk('public')->assertMissing("uploads/photos/interviewees/{$this->test_interviewee->id}/test.jprg");

        $this->assertDatabaseMissing('interviewees',
            [
                'id' => $this->test_interviewee->id,
                'fullname' => 'Заквирка Антон Олександрович',
            ]);
    }

    public function test_interviewee_to_employees_remove_with_photo(): void
    {
        $this->actingAs($this->user);

        $response = $this->put(route('erp.executive.interviewees.update', ['interviewee' => $this->test_interviewee]), $this->updatedData);

        $this->get(route('erp.executive.interviewees.removeToEmployees', ['id' => $this->test_interviewee->id]));
        $response->assertStatus(302);

        $newUser = User::where('phone',$this->updatedData['phone'])->firstOrFail();
        Storage::disk('public')->assertExists("uploads/photos/users/$newUser->id/test.jpg");
        Storage::disk('public')->assertMissing("uploads/photos/interviewees/{$this->test_interviewee->id}/test.jpg");

        $this->assertDatabaseHas('users', [
            'phone' => $this->updatedData['phone'],
            'lastname' => 'Заквирка',
            'name' => 'Антон',
            'middle_name' => 'Олександрович',

        ]);

        $this->assertSoftDeleted('interviewees', [
            'id' => $this->test_interviewee->id,
            'phone' => $this->updatedData['phone'],
            'comment' => $this->updatedData['comment'],
        ]);
    }

}
