<?php

namespace Feature;


use App\Models\Email;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;


class MailSearchActivityTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();


        $this->test_user = User::factory()->create([
            'is_executive' => true,
        ]);


        $this->test_mail = Email::create([
            'subject' => 'Тестова тема',
            'sender' => 'bnfed@ukr.net',
            'date' => '2024-03-20 15:47:01',
            'body' => 'Привіт, Егор Богуслаев! ЭТО ТЕСТОВОЕ ПИСЬМО',
//            'message' => 'Тестове повидомлення',
//            'sender_name' => 'Роман Микуря',
        ]);

        $this->invalidData = [
            'recipient_name' => 'Артем @#$%^&',
            'message' => '@#$%^& повидомлення',
            'sender_name' => 'Роман @#$%^&',
            'recipient_email' => 'bn@fed@uk@r.net',
            'subject' => 'Тестове @#$%^&',
            'long_text' => str_repeat('Aa', 500),
        ];

        $this->validSearch = [
            "Тестова",
            'ПИСЬМО',
            'bnfed',
            'Егор',
            'Богуслаев',
        ];

        $this->invalidSearch = [
            "C@#$%^o",
            '6@#$%^872561',
            "<script>alert('Executing JS')</script>",
            '@#$%^',
            '://www.mysite.com',
        ];

        $this->longTextSearch = [
            str_repeat('A', 70),
            str_repeat('A', 301),
            str_repeat('A', 5000),
        ];

        $this->absenteesSearch = [
            "RTY",
            '603241888555',
            'Днепр',
            'вул.345',
            '0305743555',
        ];
    }

    public function test_mail_inbox_search_json_results_with_valid_data(): void
    {
        foreach ($this->validSearch as $search) {
            $response = $this->actingAs($this->test_user)->getJson(route('erp.executive.emails.search',
                [
                    'search' => $search,
                    'search_type'=>'inbox_emails',
                ]));
            $response->assertStatus(200)
                ->assertJson(fn(AssertableJson $json) => $json
                    ->where("mails.data.0.id", $this->test_mail->id)
                    ->where("mails.data.0.subject", $this->test_mail->subject)
                    ->where("mails.data.0.sender", $this->test_mail->sender)
                    ->etc()
                );
        }


    }
public function test_mail_inbox_search_json_results_with_absentees_data(): void
    {
        foreach ($this->absenteesSearch as $search) {
            $response = $this->actingAs($this->test_user)->getJson(route('erp.executive.emails.search',
                [
                    'search' => $search,
                    'search_type'=>'inbox_emails',
                ]));
            $response->assertStatus(200)
                ->assertJsonMissingPath("mails.data.0.id")
                ->assertJsonMissingPath("mails.data.0.subject");
        }


    }

    public function test_mail_inbox_search_json_results_with_invalid_data(): void
    {
        foreach ($this->invalidSearch as $search) {
            $response = $this->actingAs($this->test_user)->getJson(route('erp.executive.emails.search',
                [
                    'search' => $search,
                    'search_type' => 'inbox_emails',
                ]));
            $response->assertStatus(422)->assertJson(['message' => 'The search field format is invalid.']);
        }


    }


//
//    public function test_create_email_with_invalid_data(): void
//    {
//        $this->creatingData['recipient_name'] = $this->invalidData['recipient_name'];
//        $this->creatingData['message'] = $this->invalidData['message'];
//        $this->creatingData['sender_name'] = $this->invalidData['sender_name'];
//        $this->creatingData['recipient_email'] = $this->invalidData['recipient_email'];
//        $this->creatingData['subject'] = $this->invalidData['subject'];
//
//        $response = $this->actingAs($this->test_user)->post(route('erp.executive.emails.sendMail', $this->creatingData))->assertStatus(302);
//        $response->assertSessionHasErrors([
//            'recipient_name' => 'The recipient name field format is invalid.',
//            'message' => 'The message field format is invalid.',
//            'sender_name' => 'The sender name field format is invalid.',
//            'recipient_email' => 'The recipient email field must be a valid email address.',
//            'subject' => 'The subject field format is invalid.',
//        ]);
//
//        $this->assertDatabaseMissing('send_emails', $this->creatingData);
//    }
//
//    public function test_create_email_without_required_data(): void
//    {
//
//        unset($this->creatingData['recipient_name']);
//        unset($this->creatingData['message']);
//        unset($this->creatingData['sender_name']);
//        unset($this->creatingData['recipient_email']);
//        unset($this->creatingData['subject']);
//
//        $response = $this->actingAs($this->test_user)->post(route('erp.executive.emails.sendMail', $this->creatingData))->assertStatus(302);
//        $response->assertSessionHasErrors([
//            'recipient_name' => 'The recipient name field is required.',
//            'message' => 'The message field is required.',
//            'sender_name' => 'The sender name field is required.',
//            'recipient_email' => 'The recipient email field is required.',
//            'subject' => 'The subject field is required.',
//        ]);
//        $this->assertDatabaseMissing('send_emails', $this->creatingData);
//    }
//
//
//    public function test_create_client_with_existing_company(): void
//    {
//        $this->creatingData['recipient_name'] = $this->invalidData['long_text'];
//        $this->creatingData['message'] = $this->invalidData['long_text'];
//        $this->creatingData['sender_name'] = $this->invalidData['long_text'];
//        $this->creatingData['recipient_email'] = $this->invalidData['long_text'];
//        $this->creatingData['subject'] = $this->invalidData['long_text'];
//
//
//        $response = $this->actingAs($this->test_user)->post(route('erp.executive.emails.sendMail', $this->creatingData))->assertStatus(302);
//
//        $response->assertSessionHasErrors([
//            'recipient_name' => 'The recipient name field must not be greater than 50 characters.',
//            'message' => 'The message field must not be greater than 500 characters.',
//            'sender_name' => 'The sender name field must not be greater than 50 characters.',
//            'recipient_email' => 'The recipient email field must be a valid email address.',
//            'subject' => 'The subject field must not be greater than 50 characters.',
//            ]);
//    }


}
