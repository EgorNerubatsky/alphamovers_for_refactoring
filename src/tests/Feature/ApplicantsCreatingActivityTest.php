<?php

namespace Tests\Feature;


use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use JetBrains\PhpStorm\NoReturn;
use Tests\TestCase;


class ApplicantsCreatingActivityTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'is_executive' => true,
        ]);
        $this->creatingData = [
            'fullname_surname' => 'Авдєєв',
            'fullname_name' => 'Леонід',
            'fullname_patronymic' => 'Олександрович',
            'phone' => '+380951234569',
            'desired_position' => 'Грузчик',
            'comment' => 'Дуже чудова людина',
        ];

        $this->invalidData = [
            'fullname_surname' => 'Авд@#$%^!єєв',
            'fullname_name' => 'Ле@#$%^!онід',
            'fullname_patronymic' => 'Олек@#$%^!сандрович',
            'phone' => '+380@#$%^!569',
            'desired_position' => 'Гр@#$%^!ик',
            'comment' => 'Дуже @#$%^! людина',
        ];
    }

    public function test_create_applicant_with_valid_data(): void
    {
//
//        $url = URL::full();
//        dd($url);

        $this->actingAs($this->user);

        $response = $this->post(route('erp.executive.applicants.store', $this->creatingData));
        $response->assertStatus(302);

        $this->assertDatabaseHas('applicants', [
            'fullname' => 'Авдєєв Леонід Олександрович',
            'phone' => '+380951234569',
            'desired_position' => 'Грузчик',
            'comment' => 'Дуже чудова людина',
        ]);
    }

    public function test_create_applicant_with_invalid_data(): void
    {
        $this->actingAs($this->user);

        $response = $this->post(route('erp.executive.applicants.store', $this->invalidData));

        $response->assertSessionHasErrors([
            'fullname_surname' => 'The fullname surname field format is invalid.',
            'fullname_name' => 'The fullname name field format is invalid.',
            'fullname_patronymic' => 'The fullname patronymic field format is invalid.',
            'phone' => 'The phone field format is invalid.',
            'desired_position' => 'The desired position field format is invalid.',
            'comment' => 'The comment field format is invalid.',
        ]);

        $this->assertDatabaseMissing('applicants', [
            'phone' => '+380@#$%^!569',
            'desired_position' => 'Гр@#$%^!ик',
            'comment' => 'Дуже @#$%^! людина',
        ]);
    }

    public function test_create_applicant_without_required_data(): void
    {
        $this->actingAs($this->user);

        unset($this->creatingData['fullname_surname']);
        unset($this->creatingData['fullname_name']);
        unset($this->creatingData['fullname_patronymic']);
        unset($this->creatingData['phone']);

        $response = $this->post(route('erp.executive.applicants.store', $this->creatingData));
        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'fullname_surname' => 'The fullname surname field is required.',
            'fullname_name' => 'The fullname name field is required.',
            'fullname_patronymic' => 'The fullname patronymic field is required.',
            'phone' => 'The phone field is required.',
        ]);
        $this->assertDatabaseMissing('applicants', [
            'fullname' => 'Авдєєв Леонід Олександрович',
            'phone' => '+380951234569',
            'desired_position' => 'Грузчик',
            'comment' => 'Дуже чудова людина',
        ]);
    }

    public function test_create_applicant_with_multi_character_data(): void
    {
        $this->actingAs($this->user);

        $this->creatingData['fullname_surname'] = str_repeat('Aa', 260);
        $this->creatingData['fullname_name'] = str_repeat('Aa', 260);
        $this->creatingData['fullname_patronymic'] = str_repeat('Aa', 260);
        $this->creatingData['phone'] = '+380951234567895656';
        $this->creatingData['desired_position'] = str_repeat('Aa', 400);
        $this->creatingData['comment'] = str_repeat('Aa', 400);

        $response = $this->post(route('erp.executive.applicants.store', $this->creatingData));
        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'fullname_surname' => 'The fullname surname field must not be greater than 50 characters.',
            'fullname_name' => 'The fullname name field must not be greater than 50 characters.',
            'fullname_patronymic' => 'The fullname patronymic field must not be greater than 50 characters.',
            'desired_position' => 'The desired position field must not be greater than 30 characters.',
            'comment' => 'The comment field must not be greater than 300 characters.',
            'phone' => 'The phone field format is invalid.',
        ]);
        $this->assertDatabaseMissing('applicants', [
            'phone' => '+38095123456789',
        ]);
    }
}
