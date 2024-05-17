<?php

namespace Feature;


use App\Models\Mover;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class MoversUpdatingActivityTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'is_executive' => true,
        ]);

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
            'name' => 'Антон',
            'lastname' => 'Кмийка',
            'birth_date' => '2001-06-26 00:00:00',
            'gender' => 'чол',
            'address' => 'Харків, Вулиця 1',
            'phone' => '+380951234567',
            'email' => 'email@test.com',
            'note' => 'кат. 2',
            'advantages' => 'Висотні роботи',
            'bank_card' => '4567678975346742',
            'passport_number' => '667479',
            'passport_series' => 'CB',
        ];

        $this->invalidData = [
            'name' => 'Ант@#$%^!он',
            'lastname' => 'Кми@#$%^!йка',
            'birth_date' => '2045401-06-26',
            'gender' => '@#',
            'address' => '@#$%^!, Вулиця 1',
            'phone' => '+380@#$%^!567',
            'email' => 'emailtest.com',
            'note' => 'ка@#$%^т. 2',
            'advantages' => 'Вис@#$%^оботи',
            'bank_card' => '456743@#$%467425',
            'passport_number' => '65#$79',
            'passport_series' => '#$',
        ];
    }

    public function test_update_mover_with_valid_data(): void
    {
        $this->actingAs($this->user);
        $response = $this->put(route('erp.executive.movers.update', ['id' => $this->test_mover->id]), $this->updatedData);
        $response->assertStatus(302);
        $this->assertDatabaseHas('movers', $this->updatedData);
    }

    public function test_try_update_mover_with_invalid_data(): void
    {
        $this->actingAs($this->user);

        $response = $this->put(route('erp.executive.movers.update', ['id' => $this->test_mover->id]), $this->invalidData);
        $response->assertSessionHasErrors([
            'name' => 'The name field format is invalid.',
            'lastname' => 'The lastname field format is invalid.',
            'gender' => 'The gender field format is invalid.',
            'address' => 'The address field format is invalid.',
            'phone' => 'The phone field format is invalid.',
            'email' => 'The email field must be a valid email address.',
            'note' => 'The note field format is invalid.',
            'advantages' => 'The advantages field format is invalid.',
            'bank_card' => 'The bank card field must be 16 digits.',
            'passport_number' => 'The passport number field must be 6 digits.',
        ]);

        $this->assertDatabaseMissing('movers', $this->invalidData);
    }

    public function test_try_update_mover_without_required_email_fullName_phone(): void
    {
        $this->actingAs($this->user);

        unset($this->updatedData['name']);
        unset($this->updatedData['lastname']);
        unset($this->updatedData['phone']);

        $response = $this->put(route('erp.executive.movers.update', ['id' => $this->test_mover->id]), $this->updatedData);
        $response->assertSessionHasErrors([
            'name' => 'The name field is required.',
            'lastname' => 'The lastname field is required.',
            'phone' => 'The phone field is required.',
        ]);

        $this->assertDatabaseMissing('movers', $this->updatedData);
    }

    public function test_mover_soft_delete(): void
    {
        $this->actingAs($this->user);
        $response = $this->get(route('erp.executive.movers.delete', ['id' => $this->test_mover->id]));
        $response->assertStatus(302);

        $this->assertSoftDeleted('movers', ['id' => $this->test_mover->id]);
    }

}
