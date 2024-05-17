<?php

namespace Feature;


use App\Models\Mover;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class MoversFileUploadingTest extends TestCase
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

        $this->test_mover = Mover::factory()->create([
            'name' => 'Тимур',
            'lastname' => 'Квиря',
            'birth_date' => '2002-08-04 00:00:00',
            'gender' => 'чол',
            'address' => 'Харків, Вулиця 3',
            'phone' => '+380951234222',
            'email' => 'em22ail@test.com',
            'note' => 'кат. 4',
            'advantages' => 'Автонавантажувач',
            'bank_card' => '4567678975343423',
            'passport_number' => '117479',
            'passport_series' => 'ТЕ',
        ]);

        $this->updatedData = [
            'name' => 'Тимур',
            'lastname' => 'Богданович',
            'birth_date' => '2002-08-04 00:00:00',
            'gender' => 'чол',
            'address' => 'Богдановичи, Вулиця 3',
            'phone' => '+380951234555',
            'email' => 'em55ail@test.com',
            'note' => 'кат. 3',
            'advantages' => 'Альпініст',
            'bank_card' => '4444678975343423',
            'passport_number' => '447479',
            'passport_series' => 'ВА',
            'mover_photo' => $this->validFile,
        ];
        $this->creatingData = [
        'name' => 'Олег',
            'lastname' => 'Дрогобич',
            'birth_date' => '2001-07-04 00:00:00',
            'gender' => 'чол',
            'address' => 'Слюсари, Вулиця 3',
            'phone' => '+380951238888',
            'email' => 'em88ail@test.com',
            'note' => 'кат. 3',
            'advantages' => 'Альпініст',
            'bank_card' => '8888678975343423',
            'passport_number' => '887479',
            'passport_series' => 'ДА',
            'mover_photo' => $this->validFile,
        ];
    }

    public function test_uploading_valid_mover_photo(): void
    {
        $this->actingAs($this->user);

        $response = $this->put(route('erp.executive.movers.update', ['id' => $this->test_mover->id]), $this->updatedData);
        $response->assertStatus(302);

        Storage::disk('public')->assertExists("uploads/photos/movers/{$this->test_mover->id}/test.jpg");
        $this->assertDatabaseHas('movers',
            [
                'id' => $this->test_mover->id,
                'name' => 'Тимур',
                'lastname' => 'Богданович',
                'photo_path' => "uploads/photos/movers/{$this->test_mover->id}/test.jpg",
            ]);
    }


    public function test_uploading_invalid_mover_photo(): void
    {

        $this->actingAs($this->user);
        $this->updatedData['mover_photo'] = $this->invalidFile;
        $response = $this->put(route('erp.executive.movers.update', ['id' => $this->test_mover->id]), $this->updatedData);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['mover_photo' => 'The mover photo field must not be greater than 15360 kilobytes.']);

        Storage::disk('public')->assertMissing("uploads/photos/movers/{$this->test_mover->id}/test.jpg");

        $this->assertDatabaseMissing('movers',
            [
                'id' => $this->test_mover->id,
                'name' => 'Тимур',
                'lastname' => 'Богданович',
                'photo_path' => "uploads/photos/movers/{$this->test_mover->id}/test.jpg",
            ]);
    }

    public function test_uploading_invalid_mover_photo_extension(): void
    {
        $this->actingAs($this->user);
        $this->updatedData['mover_photo'] = $this->invalidFileExtension;
        $response = $this->put(route('erp.executive.movers.update', ['id' => $this->test_mover->id]), $this->updatedData);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['mover_photo' => 'The mover photo field must be a file of type: jpeg, jpg, png.']);

        Storage::disk('public')->assertMissing("uploads/photos/movers/{$this->test_mover->id}/test.jprg");

        $this->assertDatabaseMissing('movers',
            [
                'id' => $this->test_mover->id,
                'name' => 'Тимур',
                'lastname' => 'Богданович',
                'photo_path' => "uploads/photos/movers/{$this->test_mover->id}/test.jpg",
            ]);
    }

    public function test_create_mover_with_valid_photo(): void
    {
        $this->actingAs($this->user);

        $response = $this->post(route('erp.executive.movers.store'), $this->creatingData);
        $response->assertStatus(302);

        $newTestMover = Mover::where('phone', $this->creatingData['phone'])->firstOrFail();
        Storage::disk('public')->assertExists("uploads/photos/movers/$newTestMover->id/test.jpg");

        $this->assertDatabaseHas('movers',
            [
                'id' => $newTestMover->id,
                'name' => $newTestMover->name,
                'lastname' => $newTestMover->lastname,
                'photo_path' => "uploads/photos/movers/$newTestMover->id/test.jpg",
            ]);
    }

    public function test_create_mover_with_invalid_photo(): void
    {
        $this->creatingData['mover_photo'] = $this->invalidFile;
        $this->creatingData['email'] = 'emai678st@test.com';
        $this->creatingData['phone'] = '+380951234333';

        $this->actingAs($this->user);

        $response = $this->post(route('erp.executive.movers.store'), $this->creatingData);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['mover_photo' => 'The mover photo field must not be greater than 15360 kilobytes.']);
        $this->assertDatabaseMissing('movers',
            [
                'phone' => '+380951234333',
                'email' => 'emai678st@test.com',
            ]);
    }


}
