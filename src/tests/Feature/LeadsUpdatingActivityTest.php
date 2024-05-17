<?php

namespace Feature;


use App\Models\ClientBase;
use App\Models\ClientContactPersonDetail;
use App\Models\Lead;
use App\Models\User;
use Database\Seeders\LeadTableSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class LeadsUpdatingActivityTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(LeadTableSeeder::class);
        $this->user = User::factory()->create([
            'is_executive'=>true,
        ]);
        $this->test_client = ClientBase::factory()
            ->has(ClientContactPersonDetail::factory()->count(2))
            ->create();

        $this->new_test_client = ClientBase::factory()
            ->has(ClientContactPersonDetail::factory()->count(2))
            ->create();

        $this->new_test_lead = Lead::factory()->create([
//            'id' => 122,
            'company' => $this->new_test_client->company,
            'fullname' => 'Андрей Береза',
            'phone' => '+380988867898',
            'email' => 'test888mail@mail.com',
            'comment' => 'Тестовий коментар 888',
            'status' => 'новый',
        ]);

        $this->test_lead = Lead::factory()->create([
//            'id' => 121,
            'company' => "АТ 'Берега'",
            'fullname' => 'Максим Береза',
            'phone' => '+380954567898',
            'email' => 'testmail@mail.com',
            'comment' => 'Тестовий коментар',
            'status' => 'новый',
        ]);

        $contact = $this->test_client->clientContactPersonDetails->first();

        $this->new_existing_test_lead = Lead::factory()->create([
//            'id' => 123,
            'company' => $this->test_client->company,
            'fullname' => $contact->complete_name,
            'phone' => $contact->client_phone,
            'email' => $contact->email,
            'comment' => 'Тестовий коментар 888',
            'status' => 'новый',
        ]);

        $this->updatedData = [
            'company' => "АО 'Тест'",
            'fullname' => 'Антон Змийка',
            'email' => 'testmail@mail.com',
            'phone' => '+380954567121',
            'comment' => 'Новий Тестовий коментар',
        ];

        $this->invalidData = [
            'company' => "АО 'Те@#$%^ст'",
            'fullname' => 'Антон Зми@#$%^йка',
            'email' => 'testma@#$%^il@mail.com',
            'phone' => '+380@#$%^954567121',
            'comment' => str_repeat('Aa', 260),
        ];
    }

    public function test_update_lead_with_valid_data(): void
    {
        $response = $this->actingAs($this->user)->assertAuthenticated();
        $response->put(route('erp.executive.leads.update', ['lead' => $this->test_lead->id]), $this->updatedData)->assertStatus(302);
        $this->assertDatabaseHas('leads', $this->updatedData);
    }


    public function test_try_update_lead_without_required_email_fullname_phone(): void
    {
        $response = $this->actingAs($this->user)->assertAuthenticated();

        unset($this->updatedData['email']);
        unset($this->updatedData['fullname']);
        unset($this->updatedData['phone']);

        $response->put(route('erp.executive.leads.update', ['lead' => $this->test_lead->id]), $this->updatedData)
            ->assertSessionHasErrors([
                'email' => 'The email field is required.',
                'fullname' => 'The fullname field is required.',
                'phone' => 'The phone field is required.',
            ]);
    }

    public function test_try_update_lead_with_invalid_data(): void
    {
        $response = $this->actingAs($this->user)->assertAuthenticated();

        $response->put(route('erp.executive.leads.update', ['lead' => $this->test_lead->id]), $this->invalidData)
            ->assertSessionHasErrors([
                'company' => 'The company field format is invalid.',
                'fullname' => 'The fullname field format is invalid.',
                'phone' => 'The phone field format is invalid.',
                'email' => 'The email field must be a valid email address.',
                'comment' => 'The comment field must not be greater than 250 characters.',
            ]);
    }

    public function test_lead_soft_delete(): void
    {
        $response = $this->actingAs($this->user)->get(route('erp.executive.leads.delete', ['lead' => $this->test_lead]));
        $response->assertStatus(302);

        $this->assertSoftDeleted('leads', ['id' => $this->test_lead->id]);
    }

    public function test_lead_to_order_remove(): void
    {

        $response = $this->actingAs($this->user)->get(route('erp.executive.leads.toOrder', ['id' => $this->test_lead->id]));
        $response->assertStatus(302);

        $newClientBase = ClientBase::where('company', $this->test_lead->company)->first();

        $this->assertDatabaseHas('client_bases', ['company' => $this->test_lead->company]);
        $this->assertDatabaseHas('orders', [
            'review' => $this->test_lead->comment,
            'client_id' => $newClientBase->id,
        ]);

        $this->assertDatabaseHas('client_contact_person_details', [
            'complete_name' => $this->test_lead->fullname,
            'client_phone' => $this->test_lead->phone,
            'client_base_id' => $newClientBase->id,
        ]);

        $this->assertSoftDeleted('leads', ['id' => $this->test_lead->id]);
    }

    public function test_lead_to_order_remove_with_new_client_contact(): void
    {

        $response = $this->actingAs($this->user)->get(route('erp.executive.leads.toOrder', ['id' => $this->new_test_lead->id]));
        $response->assertStatus(302);

        $this->assertDatabaseHas('client_bases', ['company' => $this->new_test_client->company]);
        $this->assertDatabaseHas('orders', [
            'review' => $this->new_test_lead->comment,
            'client_id' => $this->new_test_client->id,
        ]);
        $this->assertDatabaseHas('client_contact_person_details', [
            'complete_name' => $this->new_test_lead->fullname,
            'client_phone' => $this->new_test_lead->phone,
            'client_base_id' => $this->new_test_client->id,
        ]);
        $this->assertEquals(3, $this->new_test_client->clientContactPersonDetails->count());
        $this->assertSoftDeleted('leads', ['id' => $this->new_test_lead->id]);
    }

    public function test_lead_to_order_remove_with_existing_client_contact(): void
    {

        $response = $this->actingAs($this->user)->get(route('erp.executive.leads.toOrder', ['id' => $this->new_existing_test_lead->id]));
        $response->assertStatus(302);

        $this->assertDatabaseHas('client_bases', ['company' => $this->test_client->company]);
        $this->assertDatabaseHas('orders', [
            'review' => $this->new_existing_test_lead->comment,
            'client_id' => $this->test_client->id,
        ]);
        $this->assertDatabaseHas('client_contact_person_details', [
            'complete_name' => $this->new_existing_test_lead->fullname,
            'client_phone' => $this->new_existing_test_lead->phone,
            'client_base_id' => $this->test_client->id,
        ]);
        $this->assertEquals(2, $this->test_client->clientContactPersonDetails->count());
        $this->assertSoftDeleted('leads', ['id' => $this->new_existing_test_lead->id]);
    }


}
