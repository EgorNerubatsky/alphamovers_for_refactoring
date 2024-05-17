<?php

namespace Feature;


use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class ClientBaseCreatingActivityTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();


        $this->test_user = User::factory()->create([
            'is_executive' => true,
        ]);

        $this->test_logist = User::factory()->create([
            'is_logist' => true,
        ]);

        $this->invalidData = [
            'date_of_contract' => '2024--06-26 18:00',
            'company' => "АТ 'Cr@#$%^edo'",
            'type' => 'Юридич@#$%^на особа',
            'debt_ceiling' => 45454228, 59,
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
            'name' => 'Дми@#$%^о',
            'last_name' => 'Олек@#$%^ович',
            'full_name' => 'Ши@#$%^ль',
            'client_phone' => '+380@#$%^3523',
            'position' => 'Ме@#$%^ер',
            'email' => 'test@456@test.com',
        ];

        $this->creatingData = [
            'date_of_contract' => '2024-06-26 18:00',
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
            'name' => 'Дмитро',
            'last_name' => 'Олександрович',
            'full_name' => 'Шипуль',
            'client_phone' => '+380305743523',
            'position' => 'Менеджер',
            'email' => 'test456@test.com',
        ];

    }

    public function test_create_client_with_valid_data(): void
    {
        $this->actingAs($this->test_user);

        $response = $this->post(route('erp.executive.clients.store', $this->creatingData));
        $response->assertStatus(302);


        $this->assertDatabaseHas('client_bases', [
            'company' => "АТ 'Credo'",
            'type' => 'Юридична особа',
            'identification_number' => 'UA603241872561',
            'code_of_the_reason_for_registration' => 'UA0323394',
            'main_state_registration_number' => 'UA719881734699',
            'director_name' => 'Костяний Петро Олександрович',
        ]);

        $this->assertDatabaseHas('client_contact_person_details', [
            'complete_name' => 'Дмитро Олександрович Шипуль',
            'client_phone' => '+380305743523',
            'position' => 'Менеджер',
            'email' => 'test456@test.com',
        ]);
    }

    public function test_create_client_with_invalid_data(): void
    {
        $this->actingAs($this->test_user);

        $response = $this->post(route('erp.executive.clients.store', $this->invalidData));
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
            'name' => 'The name field format is invalid.',
            'last_name' => 'The last name field format is invalid.',
            'full_name' => 'The full name field format is invalid.',
            'client_phone' => 'The client phone field format is invalid.',
            'position' => 'The position field format is invalid.',
            'email' => 'The email field must be a valid email address.',
        ]);

        $this->assertDatabaseMissing('client_bases', [
            'company' => "АТ 'Cr@#$%^edo'",
            'type' => 'Юридич@#$%^на особа',
        ]);
    }

    public function test_create_client_without_required_data(): void
    {
        $this->actingAs($this->test_user);


        unset($this->creatingData['company']);
        unset($this->creatingData['type']);
        unset($this->creatingData['postal_address']);
        unset($this->creatingData['payment_account']);
        unset($this->creatingData['name']);
        unset($this->creatingData['last_name']);
        unset($this->creatingData['full_name']);
        unset($this->creatingData['client_phone']);
        unset($this->creatingData['position']);


        $response = $this->post(route('erp.executive.clients.store', $this->creatingData))->assertStatus(302);
        $response->assertSessionHasErrors([
            'company' => 'The company field is required.',
            'type' => 'The type field is required.',
            'postal_address' => 'The postal address field is required.',
            'payment_account' => 'The payment account field is required.',
            'name' => 'The name field is required.',
            'last_name' => 'The last name field is required.',
            'full_name' => 'The full name field is required.',
            'client_phone' => 'The client phone field is required.',
            'position' => 'The position field is required.',
        ]);
        $this->assertDatabaseMissing('client_bases', [
            'company' => "АТ 'Credo'",
            'type' => 'Юридична особа',
            'identification_number' => 'UA603241872561',
            'code_of_the_reason_for_registration' => 'UA0323394',
            'main_state_registration_number' => 'UA719881734699',
            'director_name' => 'Костяний Петро Олександрович',
        ]);
    }


    public function test_create_client_with_existing_company(): void
    {
        $this->actingAs($this->test_user);

        $this->post(route('erp.executive.clients.store', $this->creatingData))->assertStatus(302);
        $this->creatingData['identification_number'] = 'UA603241872888';
        $this->creatingData['code_of_the_reason_for_registration'] = 'UA0323888';

        $this->post(route('erp.executive.clients.store', $this->creatingData))->assertStatus(302);

        $this->assertDatabaseMissing('client_bases', [
            'identification_number' => 'UA603241872888',
            'code_of_the_reason_for_registration' => 'UA0323888',
            ]);
    }


}
