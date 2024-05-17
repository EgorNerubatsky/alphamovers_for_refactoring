<?php

namespace Feature;


use App\Models\Applicant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class ApplicantsUpdatingActivityTest extends TestCase
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
        ];

        $this->invalidData = [
            'fullname_surname' => 'Ев#$#%сюков',
            'fullname_name' => 'Анд#$#%рій',
            'fullname_patronymic' => 'Оле#$#%ксійович',
            'phone' => '+3809#$#%4888',
            'desired_position' => 'Бриг#$#%р',
            'comment' => 'Д#$#%ова людина',
        ];
    }

    public function test_try_update_applicant_with_invalid_data(): void
    {
        $this->actingAs($this->user);

        $response = $this->put(route('erp.executive.applicants.update', ['applicant' => $this->test_applicant]), $this->invalidData);
        $response->assertSessionHasErrors([
            'fullname_surname' => 'The fullname surname field format is invalid.',
            'fullname_name' => 'The fullname name field format is invalid.',
            'fullname_patronymic' => 'The fullname patronymic field format is invalid.',
            'phone' => 'The phone field format is invalid.',
            'desired_position' => 'The desired position field format is invalid.',
            'comment' => 'The comment field format is invalid.',
        ]);

        $this->assertDatabaseMissing('applicants', [
            'phone' => '+3809#$#%4888',
            'desired_position' => 'Бриг#$#%р',
            'comment' => 'Д#$#%ова людина',
        ]);
    }

    public function test_try_update_applicant_without_required_email_fullname_phone(): void
    {
        $this->actingAs($this->user);

        unset($this->updatedData['fullname_surname']);
        unset($this->updatedData['fullname_name']);
        unset($this->updatedData['fullname_patronymic']);
        unset($this->updatedData['phone']);

        $response = $this->put(route('erp.executive.applicants.update', ['applicant' => $this->test_applicant]), $this->updatedData);
        $response->assertSessionHasErrors([
            'fullname_surname' => 'The fullname surname field is required.',
            'fullname_name' => 'The fullname name field is required.',
            'fullname_patronymic' => 'The fullname patronymic field is required.',
            'phone' => 'The phone field is required.',
        ]);
        $this->assertDatabaseMissing('applicants', [
            'comment' => 'Дуже-Дуже чудова людина',
        ]);
    }

    public function test_update_applicant_with_multi_character_data(): void
    {
        $this->actingAs($this->user);

        $this->updatedData['fullname_surname'] = str_repeat('Aa', 260);
        $this->updatedData['fullname_name'] = str_repeat('Aa', 260);
        $this->updatedData['fullname_patronymic'] = str_repeat('Aa', 260);
        $this->updatedData['phone'] = '+380951234567895656';
        $this->updatedData['desired_position'] = str_repeat('Aa', 400);
        $this->updatedData['comment'] = str_repeat('Aa', 400);

        $response = $this->put(route('erp.executive.applicants.update', ['applicant' => $this->test_applicant]), $this->updatedData);
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


    public function test_update_applicant_with_valid_data(): void
    {
        $this->actingAs($this->user);
        $response = $this->put(route('erp.executive.applicants.update', ['applicant' => $this->test_applicant]), $this->updatedData);
        $response->assertStatus(302);
        $this->assertDatabaseHas('applicants', [
            'fullname' => 'Евсюков Андрій Олексійович',
            'phone' => '+380951234888',
            'desired_position' => 'Бригадир',
            'comment' => 'Дуже-Дуже чудова людина',
        ]);
    }


    public function test_applicant_to_interviewee_remove(): void
    {

        $response = $this->actingAs($this->user)->get(route('erp.executive.applicants.removeToInterviewee', ['id' => $this->test_applicant->id]));
        $response->assertStatus(302);

        $this->assertDatabaseHas('interviewees', [
            'phone' => $this->test_applicant->phone,
            'comment' => $this->test_applicant->comment,
        ]);
//        $this->assertDatabaseMissing('applicants', [
//            'id'=> $this->test_applicant->id,
//            'phone' => $this->test_applicant->phone,
//            'comment' => $this->test_applicant->comment,
//        ]);
        $this->assertSoftDeleted('applicants', [
            'id' => $this->test_applicant->id,
            'phone' => $this->test_applicant->phone,
            'comment' => $this->test_applicant->comment,
        ]);
    }

    public function test_employee_soft_delete(): void
    {
        $this->actingAs($this->user);
        $response = $this->get(route('erp.executive.applicants.delete', ['applicant' => $this->test_applicant]));
        $response->assertStatus(302);
        $this->assertSoftDeleted('applicants', ['id' => $this->test_applicant->id]);
    }

}
