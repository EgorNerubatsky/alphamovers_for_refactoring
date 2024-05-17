<?php

namespace Tests\Feature;


use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class LeadsCreatingActivityTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'is_executive'=>true,
        ]);
        $this->creatingData = [
            'company' => "АО 'Test Company'",
            'fullname' => 'Антон Кмийка',
            'email' => 'test456mail@mail.com',
            'phone' => '+380955567121',
            'comment' => 'Новий Тестовий коментар Тест',
            'status' => 'новый',
        ];

        $this->invalidData = [
            'company' => "АО 'Te@#$%^!st Company'",
            'fullname' => 'Ант@#$%^!он Кмийка',
            'email' => 'test456@#$%^!mail@mail.com',
            'phone' => '+38095@#$%^!5567121',
            'comment' => 'Новий Тесто@#$%^!вий коментар Тест',
            'status' => 'нов@#$%^!ый',
        ];
    }


    public function test_create_lead_with_valid_data(): void
    {
        $response = $this->actingAs($this->user)->assertAuthenticated();

        $response->post(route('erp.executive.leads.store', $this->creatingData))
            ->assertStatus(302);
        $this->assertDatabaseHas('leads', $this->creatingData);
    }

    public function test_create_lead_with_invalid_data(): void
    {
        $response = $this->actingAs($this->user)->assertAuthenticated();

        $response->post(route('erp.executive.leads.store', $this->invalidData))
            ->assertSessionHasErrors([

                'company' => 'The company field format is invalid.',
                'fullname' => 'The fullname field format is invalid.',
                'email' => 'The email field must be a valid email address.',
                'phone' => 'The phone field format is invalid.',
                'comment' => 'The comment field format is invalid.',
                'status' => 'The status field format is invalid.',
            ]);
        $this->assertDatabaseMissing('leads', $this->invalidData);
    }

    public function test_create_lead_without_required_data(): void
    {
        $response = $this->actingAs($this->user)->assertAuthenticated();

        unset($this->creatingData['fullname']);
        unset($this->creatingData['phone']);
        unset($this->creatingData['email']);

        $response->post(route('erp.executive.leads.store', $this->creatingData))->assertStatus(302)
            ->assertSessionHasErrors([
                'fullname' => 'The fullname field is required.',
                'phone' => 'The phone field is required.',
                'email' => 'The email field is required.',
            ]);
        $this->assertDatabaseMissing('leads', $this->creatingData);
    }

}
