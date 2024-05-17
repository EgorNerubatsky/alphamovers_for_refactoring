<?php

namespace Feature;


use App\Models\ClientBase;
use App\Models\ClientContactPersonDetail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class ClientBaseUpdatingActivityTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->test_user = User::factory()->create([
            'is_executive' => true
        ]);

        $this->test_client = ClientBase::create([
            'company' => "АТ 'Credo'",
            'type' => 'Юридична особа',
            'debt_ceiling' => 228.59,
            'identification_number' => 'UA603241872561',
            'code_of_the_reason_for_registration' => 'UA0323394',
            'main_state_registration_number' => 'UA719881734699',
            'director_name' => 'Костяний Петро Олександрович',
            'contact_person_position' => 'Голова правлiння',
            'acting_on_the_basis_of' => 'Договiр № 69871',
            'registered_address' => 'Харкiв, вул.4',
            'zip_code' => '27831',
            'postal_address' => '4567 Харкiв',
            'payment_account' => 'UA285232153653',
            'bank_name' => 'АТ ПРИ Банк',
            'bank_identification_code' => 'UA526692',
        ]);

        $this->test_client_contact_first = ClientContactPersonDetail::create([
            'client_base_id' => $this->test_client->id,
            'complete_name' => 'Дмитро Олександрович Шипуль',
            'client_phone' => '+380305743523',
            'position' => 'Менеджер',
            'email' => 'test111@test.com',
        ]);
        $this->test_client_contact_second = ClientContactPersonDetail::create([
            'client_base_id' => $this->test_client->id,
            'complete_name' => 'Олександр Олександрович Тамогавк',
            'client_phone' => '+380305748888',
            'position' => 'Зам. директора',
            'email' => 'test222@test.com',
        ]);

        $this->invalidData = [
            'company' => "АТ 'Cr@#$%^edo'",
            'type' => 'Юридич@#$%^на особа',
            'debt_ceiling' => 45454228.59,
            'identification_number' => 'UA60@#$%^1872561',
            'code_of_the_reason_for_registration' => 'UA0@#$%^4',
            'main_state_registration_number' => 'U@#$%^734699',
            'director_name' => 'Кос@#$%^ий Петро Олександрович',
            'contact_person_position' => 'Голова @#$%^ння',
            'acting_on_the_basis_of' => 'Договiр № @#$%^',
            'registered_address' => 'Харкiв, @#$%^',
            'zip_code' => '2@#$%^',
            'postal_address' => '45@#$%^кiв',
            'payment_account' => 'UA28@#$%^3653',
            'bank_name' => 'АТ ПРИ @#$%^',
            'bank_identification_code' => 'UA@#$%^92',
        ];

        $this->updatedData = [
            'company' => "АТ 'Credo PLUS'",
            'type' => 'Фізична особа',
            'debt_ceiling' => 229.59,
            'identification_number' => 'UA603241872888',
            'code_of_the_reason_for_registration' => 'UA0323888',
            'main_state_registration_number' => 'UA719881734888',
            'director_name' => 'Костяний Олександр Олександрович',
            'contact_person_position' => 'Директор',
            'acting_on_the_basis_of' => 'Договiр № 69888',
            'registered_address' => 'Днепр, вул.3',
            'zip_code' => '27888',
            'postal_address' => '2121 Днепр',
            'payment_account' => 'UA285232158888',
            'bank_name' => 'АТ ОТБ Банк',
            'bank_identification_code' => 'UA528888',
        ];

        $this->testClientData = [
            'complete_name' => 'Владимир Владимирович Дерипаска',
            'client_phone' => '+380305741111',
            'position' => 'Зам. директора',
            'email' => 'test333@test.com',
        ];

        $this->testClientInvalidData = [
            'complete_name' => 'Владимир Вл@#$%^&рович Дерипаска',
            'client_phone' => '+380@#$%^&1111',
            'position' => 'З@#$%^&ктора',
            'email' => 'te@st333@test.co@m',
        ];

        $this->testNewClientData = [
            'full_name' => 'Дерун',
            'name' => 'Степан',
            'last_name' => 'Немирявич',
            'client_phone' => '+380888741188',
            'position' => 'Менеджер',
            'email' => 'test444@test.com',
        ];
    }

    public function test_update_client_with_valid_data(): void
    {
        $this->actingAs($this->test_user);

        $response = $this->put(route('erp.executive.clients.update', ['clientBase' => $this->test_client]), $this->updatedData);
        $response->assertStatus(302);

        $this->assertDatabaseHas('client_bases', $this->updatedData);
    }

    public function test_update_client_contact_with_valid_data(): void
    {
        $this->actingAs($this->test_user);
        $this->updatedData['client_contacts'][0]['client_base_id'] = $this->test_client_contact_first->id;
        $this->updatedData['client_contacts'][0]['client_phone'] = $this->testClientData['client_phone'];
        $this->updatedData['client_contacts'][0]['complete_name'] = $this->testClientData['complete_name'];
        $this->updatedData['client_contacts'][0]['position'] = $this->testClientData['position'];
        $this->updatedData['client_contacts'][0]['email'] = $this->testClientData['email'];

        $response = $this->put(route('erp.executive.clients.update', ['clientBase' => $this->test_client]), $this->updatedData);
        $response->assertStatus(302);

        $this->assertDatabaseHas('client_bases', [
            'company' => $this->updatedData['company'],
            'type' => $this->updatedData['type'],
            'debt_ceiling' => $this->updatedData['debt_ceiling'],
            'identification_number' => $this->updatedData['identification_number'],
            'code_of_the_reason_for_registration' => $this->updatedData['code_of_the_reason_for_registration'],
            'main_state_registration_number' => $this->updatedData['main_state_registration_number'],
            'director_name' => $this->updatedData['director_name'],
            'contact_person_position' => $this->updatedData['contact_person_position'],
            'acting_on_the_basis_of' => $this->updatedData['acting_on_the_basis_of'],
            'registered_address' => $this->updatedData['registered_address'],
            'zip_code' => $this->updatedData['zip_code'],
            'postal_address' => $this->updatedData['postal_address'],
            'payment_account' => $this->updatedData['payment_account'],
            'bank_name' => $this->updatedData['bank_name'],
            'bank_identification_code' => $this->updatedData['bank_identification_code'],
        ]);

        $this->assertDatabaseHas('client_contact_person_details', [
            'id' => $this->test_client_contact_first->id,
            'complete_name' => $this->testClientData['complete_name'],
            'client_phone' => $this->testClientData['client_phone'],
            'position' => $this->testClientData['position'],
            'email' => $this->testClientData['email'],
        ]);
    }

    public function test_update_client_with_add_new_contact_with_valid_data(): void
    {
        $this->actingAs($this->test_user);

        $this->updatedData['add_client_contacts'][0]['full_name'] = $this->testNewClientData['full_name'];
        $this->updatedData['add_client_contacts'][0]['name'] = $this->testNewClientData['name'];
        $this->updatedData['add_client_contacts'][0]['last_name'] = $this->testNewClientData['last_name'];
        $this->updatedData['add_client_contacts'][0]['position'] = $this->testNewClientData['position'];
        $this->updatedData['add_client_contacts'][0]['client_phone'] = $this->testNewClientData['client_phone'];
        $this->updatedData['add_client_contacts'][0]['email'] = $this->testNewClientData['email'];

        $response = $this->put(route('erp.executive.clients.update', ['clientBase' => $this->test_client]), $this->updatedData);
        $response->assertStatus(302);

        $this->assertDatabaseHas('client_bases', [
            'company' => $this->updatedData['company'],
            'type' => $this->updatedData['type'],
            'debt_ceiling' => $this->updatedData['debt_ceiling'],
            'identification_number' => $this->updatedData['identification_number'],
            'code_of_the_reason_for_registration' => $this->updatedData['code_of_the_reason_for_registration'],
            'main_state_registration_number' => $this->updatedData['main_state_registration_number'],
            'director_name' => $this->updatedData['director_name'],
            'contact_person_position' => $this->updatedData['contact_person_position'],
            'acting_on_the_basis_of' => $this->updatedData['acting_on_the_basis_of'],
            'registered_address' => $this->updatedData['registered_address'],
            'zip_code' => $this->updatedData['zip_code'],
            'postal_address' => $this->updatedData['postal_address'],
            'payment_account' => $this->updatedData['payment_account'],
            'bank_name' => $this->updatedData['bank_name'],
            'bank_identification_code' => $this->updatedData['bank_identification_code'],
        ]);
        $this->assertDatabaseHas('client_contact_person_details', [
            'client_base_id' => $this->test_client->id,
            'complete_name' => $this->testNewClientData['name'] . ' ' . $this->testNewClientData['last_name'] . ' ' . $this->testNewClientData['full_name'],
            'client_phone' => $this->testNewClientData['client_phone'],
            'position' => $this->testNewClientData['position'],
            'email' => $this->testNewClientData['email'],
        ]);
    }

    public function test_update_history_client_data_changes_with_valid_data(): void
    {
        $clientOldValue = $this->test_client->company;
        $clientContactOldValue = $this->test_client_contact_first->client_phone;
        $this->actingAs($this->test_user);
        $this->updatedData['client_contacts'][0]['client_base_id'] = $this->test_client_contact_first->id;
        $this->updatedData['client_contacts'][0]['client_phone'] = $this->testClientData['client_phone'];
        $this->updatedData['client_contacts'][0]['complete_name'] = $this->testClientData['complete_name'];
        $this->updatedData['client_contacts'][0]['position'] = $this->testClientData['position'];
        $this->updatedData['client_contacts'][0]['email'] = $this->testClientData['email'];

        $response = $this->put(route('erp.executive.clients.update', ['clientBase' => $this->test_client]), $this->updatedData);
        $response->assertStatus(302);
        $clientNewValue = $this->updatedData['company'];
        $clientContactNewValue = $this->testClientData['client_phone'];

        $this->assertDatabaseHas('changes_histories', [
            'client_id' => $this->test_client->id,
            'old_value' => $clientOldValue,
            'new_value' => $clientNewValue,
            'user_id' => $this->test_user->id,
            'reason' => 'company',
        ]);
        $this->assertDatabaseHas('changes_histories', [
            'client_id' => $this->test_client->id,
            'old_value' => $clientContactOldValue,
            'new_value' => $clientContactNewValue,
            'user_id' => $this->test_user->id,
            'reason' => 'client_phone',
        ]);
    }

    public function test_try_update_client_without_required_fields(): void
    {
        $this->actingAs($this->test_user);

        unset($this->updatedData['company']);
        unset($this->updatedData['type']);
        unset($this->updatedData['postal_address']);
        unset($this->updatedData['payment_account']);
        unset($this->updatedData['name']);
        unset($this->updatedData['last_name']);
        unset($this->updatedData['full_name']);
        unset($this->updatedData['client_phone']);
        unset($this->updatedData['position']);

        $response = $this->put(route('erp.executive.clients.update', ['clientBase' => $this->test_client]), $this->updatedData);
        $response->assertSessionHasErrors([
            'company' => 'The company field is required.',
            'type' => 'The type field is required.',
            'postal_address' => 'The postal address field is required.',
            'payment_account' => 'The payment account field is required.',
        ]);
        $this->assertDatabaseMissing('client_bases', [
            'director_name' => $this->updatedData['director_name'],
            'acting_on_the_basis_of' => $this->updatedData['acting_on_the_basis_of'],
            'debt_ceiling' => $this->updatedData['debt_ceiling'],
            'identification_number' => $this->updatedData['identification_number'],
        ]);
    }

    public function test_try_update_client_contact_without_required_fields(): void
    {
        $this->actingAs($this->test_user);

        $this->updatedData['client_contacts'][0]['client_base_id'] = $this->test_client_contact_first->id;
        $this->updatedData['client_contacts'][0]['client_phone'] = '';
        $this->updatedData['client_contacts'][0]['complete_name'] = '';


        $response = $this->put(route('erp.executive.clients.update', ['clientBase' => $this->test_client]), $this->updatedData);
        $response->assertSessionHasErrors([
            'client_contacts.0.complete_name' => 'The client_contacts.0.complete_name field is required.',
            'client_contacts.0.client_phone' => 'The client_contacts.0.client_phone field is required.',


        ]);
        $this->assertDatabaseMissing('client_contact_person_details', [
            'id' => $this->test_client_contact_first->id,
            'complete_name' => '',
            'client_phone' => '',
        ]);
    }

    public function test_try_update_order_with_invalid_data(): void
    {
        $this->actingAs($this->test_user);

        $response = $this->put(route('erp.executive.clients.update', ['clientBase' => $this->test_client]), $this->invalidData);
        $response->assertSessionHasErrors([
            'company' => 'The company field format is invalid.',
            'type' => 'The type field format is invalid.',
            'debt_ceiling' => 'The debt ceiling field must be between 0 and 999999.99.',
            'identification_number' => 'The identification number field format is invalid.',
            'code_of_the_reason_for_registration' => 'The code of the reason for registration field format is invalid.',
            'main_state_registration_number' => 'The main state registration number field format is invalid.',
            'director_name' => 'The director name field format is invalid.',
            'contact_person_position' => 'The contact person position field format is invalid.',
            'acting_on_the_basis_of' => 'The acting on the basis of field format is invalid.',
            'registered_address' => 'The registered address field format is invalid.',
            'zip_code' => 'The zip code field format is invalid.',
            'postal_address' => 'The postal address field format is invalid.',
            'payment_account' => 'The payment account field format is invalid.',
            'bank_name' => 'The bank name field format is invalid.',
            'bank_identification_code' => 'The bank identification code field format is invalid.',
        ]);
        $this->assertDatabaseMissing('client_bases', $this->invalidData);
    }

    public function test_update_client_contact_with_invalid_data(): void
    {
        $this->actingAs($this->test_user);
        $this->updatedData['client_contacts'][0]['client_base_id'] = $this->test_client_contact_first->id;
        $this->updatedData['client_contacts'][0]['client_phone'] = $this->testClientInvalidData['client_phone'];
        $this->updatedData['client_contacts'][0]['complete_name'] = $this->testClientInvalidData['complete_name'];
        $this->updatedData['client_contacts'][0]['position'] = $this->testClientInvalidData['position'];
        $this->updatedData['client_contacts'][0]['email'] = $this->testClientInvalidData['email'];

        $response = $this->put(route('erp.executive.clients.update', ['clientBase' => $this->test_client]), $this->updatedData);
        $response->assertStatus(302);

        $this->assertDatabaseMissing('client_bases', [
            'company' => $this->updatedData['company'],
            'type' => $this->updatedData['type'],
            'debt_ceiling' => $this->updatedData['debt_ceiling'],
            'identification_number' => $this->updatedData['identification_number'],
            'code_of_the_reason_for_registration' => $this->updatedData['code_of_the_reason_for_registration'],
            'main_state_registration_number' => $this->updatedData['main_state_registration_number'],
            'director_name' => $this->updatedData['director_name'],
            'contact_person_position' => $this->updatedData['contact_person_position'],
            'acting_on_the_basis_of' => $this->updatedData['acting_on_the_basis_of'],
            'registered_address' => $this->updatedData['registered_address'],
            'zip_code' => $this->updatedData['zip_code'],
            'postal_address' => $this->updatedData['postal_address'],
            'payment_account' => $this->updatedData['payment_account'],
            'bank_name' => $this->updatedData['bank_name'],
            'bank_identification_code' => $this->updatedData['bank_identification_code'],
        ]);

        $this->assertDatabaseMissing('client_contact_person_details', [
            'complete_name' => $this->testClientInvalidData['complete_name'],
            'client_phone' => $this->testClientInvalidData['client_phone'],
            'position' => $this->testClientInvalidData['position'],
            'email' => $this->testClientInvalidData['email'],
        ]);
    }

    public function test_update_history_client_data_changes_with_invalid_data(): void
    {
        $clientOldValue = $this->test_client->company;
        $clientContactOldValue = $this->test_client_contact_first->client_phone;
        $this->actingAs($this->test_user);
        $this->updatedData['company'] = $this->invalidData['company'];
        $this->updatedData['client_contacts'][0]['client_base_id'] = $this->test_client_contact_first->id;
        $this->updatedData['client_contacts'][0]['client_phone'] = $this->testClientInvalidData['client_phone'];
        $this->updatedData['client_contacts'][0]['complete_name'] = $this->testClientData['complete_name'];
        $this->updatedData['client_contacts'][0]['position'] = $this->testClientData['position'];
        $this->updatedData['client_contacts'][0]['email'] = $this->testClientData['email'];

        $response = $this->put(route('erp.executive.clients.update', ['clientBase' => $this->test_client]), $this->updatedData);
        $response->assertStatus(302);
        $clientNewValue = $this->updatedData['company'];
        $clientContactNewValue = $this->testClientData['client_phone'];

        $this->assertDatabaseMissing('changes_histories', [
            'client_id' => $this->test_client->id,
            'old_value' => $clientOldValue,
            'new_value' => $clientNewValue,
            'user_id' => $this->test_user->id,
            'reason' => 'company',
        ]);

        $this->assertDatabaseMissing('changes_histories', [
            'client_contact_id' => $this->test_client_contact_first->id,
            'old_value' => $clientContactOldValue,
            'new_value' => $clientContactNewValue,
            'user_id' => $this->test_user->id,
            'reason' => 'client_phone',
        ]);
    }

    public function test_client_contact_soft_delete(): void
    {
        $response = $this->actingAs($this->test_user)->get(route('erp.executive.clients.client_delete', ['id' => $this->test_client_contact_first->id]));
        $response->assertStatus(302);

        $this->assertSoftDeleted('client_contact_person_details', [
            'client_base_id' => $this->test_client->id,
            'complete_name' => $this->test_client_contact_first->complete_name,
            'client_phone' => $this->test_client_contact_first->client_phone,
            'position' => $this->test_client_contact_first->position,
            'email' => $this->test_client_contact_first->email,
        ]);
    }

    public function test_client_soft_delete(): void
    {
        $response = $this->actingAs($this->test_user)->get(route('erp.executive.clients.delete', ['clientBase' => $this->test_client]));
        $response->assertStatus(302);
        $this->assertSoftDeleted('client_bases', [
            'company' => $this->test_client->company,
            'type' => $this->test_client->type,
            'debt_ceiling' => $this->test_client->debt_ceiling,
            'identification_number' => $this->test_client->identification_number,
            'code_of_the_reason_for_registration' => $this->test_client->code_of_the_reason_for_registration,
        ]);
    }

}
