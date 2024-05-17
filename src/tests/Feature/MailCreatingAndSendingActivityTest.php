<?php

namespace Feature;


use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class MailCreatingAndSendingActivityTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();


        $this->test_user = User::factory()->create([
            'is_executive' => true,
        ]);

        $this->invalidData = [
            'recipient_name' => 'Артем @#$%^&',
            'message' => '@#$%^& повидомлення',
            'sender_name' => 'Роман @#$%^&',
            'recipient_email' => 'bn@fed@uk@r.net',
            'subject' => 'Тестове @#$%^&',
            'long_text' => str_repeat('Aa', 500),
        ];

        $this->creatingData = [
            'recipient_name' => 'Артем Богуслаев',
            'message' => 'Тестове повидомлення',
            'sender_name' => 'Роман Микуря',
            'recipient_email' => 'bnfed@ukr.net',
            'subject' => 'Тестове тема',
        ];

    }

    public function test_create_mail_with_valid_data(): void
    {
        $response = $this->actingAs($this->test_user)->post(route('erp.executive.emails.sendMail', $this->creatingData));
        $response->assertStatus(302);

        $this->assertDatabaseHas('send_emails', $this->creatingData);
    }

    public function test_create_email_with_invalid_data(): void
    {
        $this->creatingData['recipient_name'] = $this->invalidData['recipient_name'];
        $this->creatingData['message'] = $this->invalidData['message'];
        $this->creatingData['sender_name'] = $this->invalidData['sender_name'];
        $this->creatingData['recipient_email'] = $this->invalidData['recipient_email'];
        $this->creatingData['subject'] = $this->invalidData['subject'];

        $response = $this->actingAs($this->test_user)->post(route('erp.executive.emails.sendMail', $this->creatingData))->assertStatus(302);
        $response->assertSessionHasErrors([
            'recipient_name' => 'The recipient name field format is invalid.',
            'message' => 'The message field format is invalid.',
            'sender_name' => 'The sender name field format is invalid.',
            'recipient_email' => 'The recipient email field must be a valid email address.',
            'subject' => 'The subject field format is invalid.',
        ]);

        $this->assertDatabaseMissing('send_emails', $this->creatingData);
    }

    public function test_create_email_without_required_data(): void
    {

        unset($this->creatingData['recipient_name']);
        unset($this->creatingData['message']);
        unset($this->creatingData['sender_name']);
        unset($this->creatingData['recipient_email']);
        unset($this->creatingData['subject']);

        $response = $this->actingAs($this->test_user)->post(route('erp.executive.emails.sendMail', $this->creatingData))->assertStatus(302);
        $response->assertSessionHasErrors([
            'recipient_name' => 'The recipient name field is required.',
            'message' => 'The message field is required.',
            'sender_name' => 'The sender name field is required.',
            'recipient_email' => 'The recipient email field is required.',
            'subject' => 'The subject field is required.',
        ]);
        $this->assertDatabaseMissing('send_emails', $this->creatingData);
    }


    public function test_create_email_with_long_text_data(): void
    {
        $this->creatingData['recipient_name'] = $this->invalidData['long_text'];
        $this->creatingData['message'] = $this->invalidData['long_text'];
        $this->creatingData['sender_name'] = $this->invalidData['long_text'];
        $this->creatingData['recipient_email'] = $this->invalidData['long_text'];
        $this->creatingData['subject'] = $this->invalidData['long_text'];


        $response = $this->actingAs($this->test_user)->post(route('erp.executive.emails.sendMail', $this->creatingData))->assertStatus(302);

        $response->assertSessionHasErrors([
            'recipient_name' => 'The recipient name field must not be greater than 50 characters.',
            'message' => 'The message field must not be greater than 500 characters.',
            'sender_name' => 'The sender name field must not be greater than 50 characters.',
            'recipient_email' => 'The recipient email field must be a valid email address.',
            'subject' => 'The subject field must not be greater than 50 characters.',
        ]);
    }


}
