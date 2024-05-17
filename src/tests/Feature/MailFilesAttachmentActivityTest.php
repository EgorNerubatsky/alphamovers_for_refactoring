<?php

namespace Feature;


use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class MailFilesAttachmentActivityTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();


        $this->test_user = User::factory()->create([
            'is_executive' => true,
        ]);

        Storage::fake('public');

        $this->validFile = UploadedFile::fake()->create('test.pdf', 1400);
        $this->validFileTwo = UploadedFile::fake()->create('test_two.pdf', 1400);
        $this->validFileThree = UploadedFile::fake()->create('test_three.pdf', 1400);
        $this->validFileFour = UploadedFile::fake()->create('test_four.pdf', 1400);

        $this->invalidFileSize = UploadedFile::fake()->create('test.pdf', 15400);
        $this->invalidFile = UploadedFile::fake()->create('test.pdo', 1400);


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

        $this->attachmentFile = [
            'attachment' => [0 => $this->validFile],
        ];

        $this->multipleAttachments = [
            'attachment' => [
                0 => $this->validFile,
                1 => $this->validFileTwo,
                2 => $this->validFileThree,
                3 => $this->validFileFour,
            ],
        ];
        $this->paths = [
            'assert_one' => "uploads/send_email_files/bnfed@ukr.net/test.pdf",
            'assert_two' => "uploads/send_email_files/bnfed@ukr.net/test_two.pdf",
            'assert_three' => "uploads/send_email_files/bnfed@ukr.net/test_three.pdf",
            'assert_four' => "uploads/send_email_files/bnfed@ukr.net/test_four.pdf",


            'assert_incoming_one'=>"uploads/incoming_email_files/bnfed@ukr.net/test.pdf",

            'assert_one_db' => "uploads\/send_email_files\/bnfed@ukr.net\/test.pdf",
            'assert_two_db' => "uploads\/send_email_files\/bnfed@ukr.net\/test_two.pdf",
            'assert_three_db' => "uploads\/send_email_files\/bnfed@ukr.net\/test_three.pdf",
            'assert_four_db' => "uploads\/send_email_files\/bnfed@ukr.net\/test_four.pdf",
        ];

    }

    public function test_create_mail_with_valid_data_with_single_attachment(): void
    {
        $response = $this->actingAs($this->test_user)
            ->withHeaders(['Content-Type' => 'multipart/form-data'])
            ->post(route('erp.executive.emails.sendMail', $this->creatingData), $this->attachmentFile);

        $response->assertStatus(302);
        Storage::disk('public')->assertExists($this->paths['assert_one']);
        $path = $this->paths['assert_one_db'];
        $this->assertDatabaseHas('send_emails', [
            'recipient_name' => $this->creatingData['recipient_name'],
            'message' => $this->creatingData['message'],
            'sender_name' => $this->creatingData['sender_name'],
            'recipient_email' => $this->creatingData['recipient_email'],
            'attachment_paths' => '[' . '"' . $path . '"' . ']',
        ]);
    }

    public function test_create_mail_with_valid_data_with_multiple_attachment(): void
    {
        $response = $this->actingAs($this->test_user)
            ->withHeaders(['Content-Type' => 'multipart/form-data'])
            ->post(route('erp.executive.emails.sendMail', $this->creatingData), $this->multipleAttachments);

        $response->assertStatus(302);
        Storage::disk('public')->assertExists($this->paths['assert_one']);
        Storage::disk('public')->assertExists($this->paths['assert_two']);
        Storage::disk('public')->assertExists($this->paths['assert_three']);
        Storage::disk('public')->assertExists($this->paths['assert_four']);
        $pathOne = $this->paths['assert_one_db'];
        $pathTwo = $this->paths['assert_two_db'];
        $pathThree = $this->paths['assert_three_db'];
        $pathFour = $this->paths['assert_four_db'];

        $this->assertDatabaseHas('send_emails', [
            'recipient_name' => $this->creatingData['recipient_name'],
            'message' => $this->creatingData['message'],
            'sender_name' => $this->creatingData['sender_name'],
            'recipient_email' => $this->creatingData['recipient_email'],
            'attachment_paths' => '[' . '"' . $pathOne . '"' . ',' . '"' . $pathTwo . '"' . ',' . '"' . $pathThree . '"' . ',' . '"' . $pathFour . '"' . ']',

        ]);
    }

    public function test_create_mail_with_valid_data_and_invalid_extension_attachment(): void
    {
        $this->attachmentFile['attachment']['0'] = $this->invalidFile;
        $response = $this->actingAs($this->test_user)
            ->withHeaders(['Content-Type' => 'multipart/form-data'])
            ->post(route('erp.executive.emails.sendMail', $this->creatingData), $this->attachmentFile)->assertStatus(302);

        $response->assertSessionHasErrors(['attachment.0' => 'The attachment.0 field must be a file of type: pdf, doc, docx, png, jpeg, jpg, rar, zip.']);
        Storage::disk('public')->assertMissing($this->paths['assert_one']);

        $this->assertDatabaseMissing('send_emails', $this->creatingData);
    }

    public function test_create_mail_with_valid_data_and_invalid_file_size_attachment(): void
    {

        $this->attachmentFile['attachment']['0'] = $this->invalidFileSize;

        $response = $this->actingAs($this->test_user)
            ->withHeaders(['Content-Type' => 'multipart/form-data'])
            ->post(route('erp.executive.emails.sendMail', $this->creatingData), $this->attachmentFile)->assertStatus(302);

        $response->assertSessionHasErrors([
            'attachment.0' => 'The attachment.0 field must not be greater than 10240 kilobytes.',
        ]);
        Storage::disk('public')->assertMissing($this->paths['assert_one']);
        $this->assertDatabaseMissing('send_emails', $this->creatingData);
    }

}
