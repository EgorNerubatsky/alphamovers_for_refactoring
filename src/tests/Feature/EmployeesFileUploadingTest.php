<?php

namespace Feature;


use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class EmployeesFileUploadingTest extends TestCase
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

        $this->updatedData = [
            'name' => 'Антон',
            'lastname' => 'Кмийка',
            'middle_name' => 'Володимирович',
            'birth_date' => '2003-07-19 00:00:00',
            'gender' => 'чол',
            'address' => 'Днепро, Вулиця 4',
            'phone' => '+380951234666',
            'email' => 'emailtest@test.com',
            'is_manager' => 0,
            'is_executive' => 1,
            'is_brigadier' => 0,
            'is_hr' => 0,
            'is_accountant' => 0,
            'is_logist' => 0,
            'bank_card' => '4567678975348888',
            'passport_number' => '667488',
            'passport_series' => 'АП',
            'employee_photo' => $this->validFile,
        ];
        $this->creatingData = [
            'name' => 'Петро',
            'lastname' => 'Небензя',
            'middle_name' => 'Степанович',
            'birth_date' => '2003-07-19 00:00:00',
            'gender' => 'чол',
            'address' => 'Мукачево, Вулиця 4',
            'phone' => '+380951234888',
            'email' => 'ema34est@test.com',
            'password' => 'Aa345678',
            'is_manager' => 1,
            'is_executive' => 0,
            'is_brigadier' => 0,
            'is_hr' => 0,
            'is_accountant' => 0,
            'is_logist' => 0,
            'bank_card' => '4567678975341111',
            'passport_number' => '667411',
            'passport_series' => 'АП',
            'employee_photo' => $this->validFile,
        ];
    }

    public function test_uploading_valid_employee_photo(): void
    {
        $this->actingAs($this->user);

        $response = $this->put(route('erp.executive.employees.update', ['id' => $this->user->id]), $this->updatedData);
        $response->assertStatus(302);

        Storage::disk('public')->assertExists("uploads/photos/users/{$this->user->id}/test.jpg");
        $this->assertDatabaseHas('users',
            [
                'id' => $this->user->id,
                'name' => 'Антон',
                'lastname' => 'Кмийка',
                'middle_name' => 'Володимирович',
            ]);

        $this->assertDatabaseHas('users_files',
            [
                'user_id' => $this->user->id,
                'path' => "uploads/photos/users/{$this->user->id}/test.jpg",
            ]);
    }


    public function test_uploading_invalid_employee_photo(): void
    {

        $this->actingAs($this->user);
        $this->updatedData['employee_photo'] = $this->invalidFile;
        $response = $this->put(route('erp.executive.employees.update', ['id' => $this->user->id]), $this->updatedData);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['employee_photo' => 'The employee photo field must not be greater than 15360 kilobytes.']);

        Storage::disk('public')->assertMissing("uploads/photos/users/{$this->user->id}/test.jpg");

        $this->assertDatabaseMissing('users',
            [
                'id' => $this->user->id,
                'name' => 'Антон',
                'lastname' => 'Кмийка',
                'middle_name' => 'Володимирович',
            ]);
    }

    public function test_uploading_invalid_employee_photo_extension(): void
    {
        $this->actingAs($this->user);
        $this->updatedData['employee_photo'] = $this->invalidFileExtension;
        $response = $this->put(route('erp.executive.employees.update', ['id' => $this->user->id]), $this->updatedData);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['employee_photo' => 'The employee photo field must be a file of type: jpeg, jpg, png.']);

        Storage::disk('public')->assertMissing("uploads/photos/users/{$this->user->id}/test.jprg");

        $this->assertDatabaseMissing('users',
            [
                'id' => $this->user->id,
                'name' => 'Антон',
                'lastname' => 'Кмийка',
                'middle_name' => 'Володимирович',
            ]);
    }

    public function test_create_employee_with_valid_photo(): void
    {
        $this->actingAs($this->user);

        $response = $this->post(route('erp.executive.employees.store'), $this->creatingData);
        $response->assertStatus(302);

        $newTestUser = User::where('phone', $this->creatingData['phone'])->firstOrFail();
        Storage::disk('public')->assertExists("uploads/photos/users/$newTestUser->id/test.jpg");

        $this->assertDatabaseHas('users',
            [
                'id' => $newTestUser->id,
                'name' => $newTestUser->name,
                'lastname' => $newTestUser->lastname,
            ]);

        $this->assertDatabaseHas('users_files',
            [
                'user_id' => $newTestUser->id,
                'path' => "uploads/photos/users/$newTestUser->id/test.jpg",
            ]);
    }

    public function test_create_employee_with_invalid_photo(): void
    {
        $this->creatingData['employee_photo'] = $this->invalidFile;
        $this->creatingData['email'] = 'emai678st@test.com';
        $this->creatingData['phone'] = '+380951234333';

        $this->actingAs($this->user);

        $response = $this->post(route('erp.executive.employees.store'), $this->creatingData);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['employee_photo' => 'The employee photo field must not be greater than 15360 kilobytes.']);
        $this->assertDatabaseMissing('users',
            [
                'phone' => '+380951234333',
                'email' => 'emai678st@test.com',
            ]);
    }


}
