<?php

namespace Feature;


use App\Models\Applicant;
use App\Models\Interviewee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class IntervieweesUpdatingActivityTest extends TestCase
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
        ];

        $this->invalidData = [
            'call_date' => '2023--06-26 00:00:00',
            'interview_date' => '2023--07-26 00:00:00',
            'fullname_surname' => 'Зак@#$%^вирка',
            'fullname_name' => 'Ан@#$%^тон',
            'fullname_patronymic' => 'Олек@#$%^сандрович',
            'birth_date' => '2001--06-26 00:00:00',
            'gender' => '@#$%^',
            'address' => 'Ха@#$%^в, Вулиця 1',
            'phone' => '+380@#$%^234567',
            'email' => 'ema@#$%^@test.com',
            'position' => 'Гру@#$%^зчик',
            'comment' => 'Дуж@#$%^дова людина',
        ];
    }

    public function test_try_update_interviewee_with_invalid_data(): void
    {
        $this->actingAs($this->user);

        $response = $this->put(route('erp.executive.interviewees.update', ['interviewee' => $this->test_interviewee]), $this->invalidData);
        $response->assertSessionHasErrors([

            'call_date' => 'The call date field must be a valid date.',
            'interview_date' => 'The interview date field must be a valid date.',
            'fullname_surname' => 'The fullname surname field format is invalid.',
            'fullname_name' => 'The fullname name field format is invalid.',
            'fullname_patronymic' => 'The fullname patronymic field format is invalid.',
            'birth_date' => 'The birth date field must be a valid date.',
            'gender' => 'The gender field format is invalid.',
            'address' => 'The address field format is invalid.',
            'phone' => 'The phone field format is invalid.',
            'email' => 'The email field must be a valid email address.',
            'position' => 'The position field format is invalid.',
            'comment' => 'The comment field format is invalid.',
        ]);

        $this->assertDatabaseMissing('interviewees', [
            'phone' => '+3809#$#%4888',
            'position' => 'Бриг#$#%р',
            'comment' => 'Д#$#%ова людина',
        ]);
    }

    public function test_try_update_interviewee_without_required_email_fullname_phone(): void
    {
        $this->actingAs($this->user);

        unset($this->updatedData['fullname_surname']);
        unset($this->updatedData['fullname_name']);
        unset($this->updatedData['fullname_patronymic']);
        unset($this->updatedData['phone']);

        $response = $this->put(route('erp.executive.interviewees.update', ['interviewee' => $this->test_interviewee]), $this->updatedData);
        $response->assertSessionHasErrors([
            'fullname_surname' => 'The fullname surname field is required.',
            'fullname_name' => 'The fullname name field is required.',
            'fullname_patronymic' => 'The fullname patronymic field is required.',
            'phone' => 'The phone field is required.',
        ]);
        $this->assertDatabaseMissing('interviewees', [
            'comment' => 'Дуже-Дуже чудова людина',
        ]);
    }

    public function test_update_interviewee_with_multi_character_data(): void
    {
        $this->actingAs($this->user);

        $this->updatedData['fullname_surname'] = str_repeat('Aa', 260);
        $this->updatedData['fullname_name'] = str_repeat('Aa', 260);
        $this->updatedData['fullname_patronymic'] = str_repeat('Aa', 260);
        $this->updatedData['phone'] = '+380951234567895656';
        $this->updatedData['position'] = str_repeat('Aa', 400);
        $this->updatedData['comment'] = str_repeat('Aa', 400);

        $response = $this->put(route('erp.executive.interviewees.update', ['interviewee' => $this->test_interviewee]), $this->updatedData);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'fullname_surname' => 'The fullname surname field must not be greater than 50 characters.',
            'fullname_name' => 'The fullname name field must not be greater than 50 characters.',
            'fullname_patronymic' => 'The fullname patronymic field must not be greater than 50 characters.',
            'position' => 'The position field must not be greater than 30 characters.',
            'comment' => 'The comment field must not be greater than 300 characters.',
            'phone' => 'The phone field format is invalid.',
        ]);
        $this->assertDatabaseMissing('interviewees', [
            'phone' => '+38095123456789',
        ]);
    }


    public function test_update_interviewee_with_valid_data(): void
    {
        $this->actingAs($this->user);
        $response = $this->put(route('erp.executive.interviewees.update', ['interviewee' => $this->test_interviewee]), $this->updatedData);
        $response->assertStatus(302);
        $this->assertDatabaseHas('interviewees', [
            'fullname' => 'Заквирка Антон Олександрович',
            'phone' => '+380951238888',
            'position' => 'HR',
            'comment' => 'Дуже яскрава людина',
        ]);
    }


    public function test_interviewee_to_employees_remove(): void
    {

        $response = $this->actingAs($this->user)->get(route('erp.executive.interviewees.removeToEmployees', ['id' => $this->test_interviewee->id]));
        $response->assertStatus(302);

        $this->assertDatabaseHas('users', [
            'phone' => $this->test_interviewee->phone,
            'lastname' => 'Авдєєв',
            'name' => 'Леонід',
            'middle_name' => 'Олександрович',
        ]);

        $this->assertSoftDeleted('interviewees', [
            'id' => $this->test_interviewee->id,
            'phone' => $this->test_interviewee->phone,
            'comment' => $this->test_interviewee->comment,
        ]);
    }

    public function test_employee_soft_delete(): void
    {
        $this->actingAs($this->user);
        $response = $this->get(route('erp.executive.interviewees.delete', ['id' => $this->test_interviewee->id]));
        $response->assertStatus(302);
        $this->assertSoftDeleted('interviewees', ['id' => $this->test_interviewee->id]);
    }

}
