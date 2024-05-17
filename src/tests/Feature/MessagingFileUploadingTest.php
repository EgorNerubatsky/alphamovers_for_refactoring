<?php

namespace Tests\Feature;


use App\Models\Chat;
use App\Models\ChatsActivity;
use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;


class MessagingFileUploadingTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->test_user = User::factory()->create([
            'is_executive' => true,
        ]);

        $this->test_second_user = User::factory()->create([
            'is_logist' => true,
        ]);
        Storage::fake('public');
        $this->validFile = UploadedFile::fake()->create('test.pdf', 1400);
        $this->invalidFile = UploadedFile::fake()->create('test.pdf', 15400);
        $this->invalidExtensionFile = UploadedFile::fake()->create('test.odf', 1400);

        $this->test_chat = Chat::create([
            'chat_name' => 'New chat 888',
        ]);

        $this->test_message = Message::create([
            'sender_user_id' => $this->test_user->id,
            'recipient_user_id' => $this->test_second_user->id,
            'message' => "Повiдомлення Тестове 888",
            'read' => false,
        ]);
        $this->test_chat_message = ChatsActivity::create([
            'chat_id' => $this->test_chat->id,
            'user_id' => $this->test_user->id,
            'message' => "Тестове Повiдомлення у чатi 12345",
        ]);

        $this->invalidData = [
            'invalid_message' => "@#$%^& повiдомлення",
            'str_repeat' => str_repeat('Aa', 800),
            'str_empty' => '',
            'str_spaces' => '   ',
        ];

        $file = $this->validFile;
        $this->creatingMessageData = [
            'sender_user_id' => $this->test_user->id,
            'recipient_user_id' => $this->test_second_user->id,
            'message' => "Тестове повiдомлення",
        ];

        $this->creatingChatData = [
            'chat_name' => 'New chat 123',
        ];

        $this->creatingChatMessageData = [
            'chat_id' => $this->test_chat->id,
            'user_id' => $this->test_user->id,
            'message' => $this->creatingMessageData['message'],
        ];
    }

    public function test_create_message_with_valid_file(): void
    {
        $this->uploadingFileWithCreationTesting(
            'post',
            'storeMessage',
            null,
            $this->creatingMessageData,
            $this->test_user->id,
            'messages',
            'messages',
            $this->creatingMessageData['message'],
        );
    }

    public function test_update_message_with_valid_file(): void
    {
        $this->uploadingFileTesting(
            'put',
            'updateMessage',
            $this->test_message->id,
            $this->test_chat_message->message,
            $this->test_user->id,
            'messages',
            'messages',
            $this->test_chat_message->message
        );
    }

    public function test_reply_message_with_valid_file(): void
    {
        $this->uploadingFileTesting(
            'post',
            'messageReply',
            $this->test_message->id,
            $this->test_chat_message->message,
            $this->test_user->id,
            'messages',
            'messages',
            $this->test_chat_message->message
        );
    }

    public function test_create_chat_message_with_valid_file(): void
    {
        $this->uploadingFileWithCreationTesting(
            'post',
            'storeChatMessage',
            $this->test_chat->id,
            $this->creatingChatMessageData,
            $this->test_chat->id,
            'chats',
            'chats_activities',
            $this->creatingMessageData['message'],
        );

    }

    public function test_update_chat_message_with_valid_file(): void
    {
        $this->uploadingFileTesting(
            'put',
            'updateChatMessage',
            $this->test_chat_message->id,
            $this->test_message->message,
            $this->test_chat->id,
            'chats',
            'chats_activities',
            $this->test_message->message
        );
    }

    public function test_reply_chat_message_with_valid_file(): void
    {
        $this->uploadingFileTesting(
            'post',
            'chatReply',
            $this->test_chat_message->id,
            $this->test_message->message,
            $this->test_chat_message->id,
            'chats',
            'chats_activities',
            $this->test_message->message
        );
    }

    public function test_update_message_with_invalid_file(): void
    {
        $this->uploadingInvalidFileTesting(
            'put',
            'updateMessage',
            $this->test_message->id,
            $this->test_chat_message->message,
            $this->test_user->id,
            'messages',
            'messages',
            $this->test_chat_message->message,
            "The message file field must not be greater than 15000 kilobytes.",
            $this->invalidFile,
        );
    }

    public function test_reply_message_with_invalid_file(): void
    {
        $this->uploadingInvalidFileTesting(
            'post',
            'messageReply',
            $this->test_message->id,
            $this->test_chat_message->message,
            $this->test_user->id,
            'messages',
            'messages',
            $this->test_chat_message->message,
            "The message file field must not be greater than 15000 kilobytes.",
            $this->invalidFile,
        );
    }

    public function test_update_chat_message_with_invalid_file(): void
    {
        $this->uploadingInvalidFileTesting(
            'put',
            'updateChatMessage',
            $this->test_chat_message->id,
            $this->test_message->message,
            $this->test_chat_message->id,
            'chats',
            'chats_activities',
            $this->test_message->message,
            "The message file field must not be greater than 15000 kilobytes.",
            $this->invalidFile,
        );
    }

    public function test_reply_chat_message_with_invalid_file(): void
    {
        $this->uploadingInvalidFileTesting(
            'post',
            'chatReply',
            $this->test_chat_message->id,
            $this->test_message->message,
            $this->test_chat_message->id,
            'chats',
            'chats_activities',
            $this->test_message->message,
            "The message file field must not be greater than 15000 kilobytes.",
            $this->invalidFile,
        );
    }

    public function test_update_message_with_invalid_extension_file(): void
    {
        $this->uploadingInvalidFileTesting(
            'put',
            'updateMessage',
            $this->test_message->id,
            $this->test_chat_message->message,
            $this->test_user->id,
            'messages',
            'messages',
            $this->test_chat_message->message,
            "The message file field must be a file of type: png, jpg, jpeg, doc, docx, pdf.",
            $this->invalidExtensionFile,
        );
    }

    public function test_reply_message_with_invalid_extension_file(): void
    {
        $this->uploadingInvalidFileTesting(
            'post',
            'messageReply',
            $this->test_message->id,
            $this->test_chat_message->message,
            $this->test_user->id,
            'messages',
            'messages',
            $this->test_chat_message->message,
            "The message file field must be a file of type: png, jpg, jpeg, doc, docx, pdf.",
            $this->invalidExtensionFile,
        );
    }

    public function test_update_chat_message_with_invalid_extension_file(): void
    {
        $this->uploadingInvalidFileTesting(
            'put',
            'updateChatMessage',
            $this->test_chat_message->id,
            $this->test_message->message,
            $this->test_chat_message->id,
            'chats',
            'chats_activities',
            $this->test_message->message,
            "The message file field must be a file of type: png, jpg, jpeg, doc, docx, pdf.",
            $this->invalidExtensionFile,
        );
    }

    public function test_reply_chat_message_with_invalid_extension_file(): void
    {
        $this->uploadingInvalidFileTesting(
            'post',
            'chatReply',
            $this->test_chat_message->id,
            $this->test_message->message,
            $this->test_chat_message->id,
            'chats',
            'chats_activities',
            $this->test_message->message,
            "The message file field must be a file of type: png, jpg, jpeg, doc, docx, pdf.",
            $this->invalidExtensionFile,
        );
    }

    public function test_delete_message_with_file(): void
    {
        $this->uploadingFileTesting(
            'put',
            'updateMessage',
            $this->test_message->id,
            $this->test_chat_message->message,
            $this->test_user->id,
            'messages',
            'messages',
            $this->test_chat_message->message
        );
        $message = Message::where('message', $this->test_chat_message->message)->first();
        $this->deleteFileTesting(
            'get',
            'deleteMessage',
            $message->id,
            $this->test_user->id,
            'messages',
        );
    }

    public function test_delete_chat_message_with_file(): void
    {
        $this->uploadingFileTesting(
            'put',
            'updateChatMessage',
            $this->test_chat_message->id,
            $this->test_message->message,
            $this->test_chat->id,
            'chats',
            'chats_activities',
            $this->test_message->message
        );

        $message = ChatsActivity::where('message', $this->test_message->message)->first();
        $this->deleteFileTesting(
            'get',
            'deleteChatMessage',
            $message->id,
            $this->test_chat->id,
            'chats',
        );
    }

    public function test_delete_chat_with_files(): void
    {
        $this->uploadingFileTesting(
            'put',
            'updateChatMessage',
            $this->test_chat_message->id,
            $this->test_message->message,
            $this->test_chat->id,
            'chats',
            'chats_activities',
            $this->test_message->message
        );
        $this->deleteFileTesting(
            'get',
            'deleteChat',
            $this->test_chat->id,
            $this->test_chat->id,
            'chats',
        );

    }

    private function uploadingFileWithCreationTesting(
        $action,
        $routePath,
        $idValue,
        $mergeValue,
        $idPathValue,
        $storePath,
        $dbTable,
        $messageAssert
    ): void
    {
        $response = $this->actingAs($this->test_user)->$action(route("erp.executive.messages.$routePath", ['id' => $idValue]),
            array_merge($mergeValue, ['message_file' => $this->validFile]

            ));
        $response->assertStatus(302);
        $id = $idPathValue;
        Storage::disk('public')->assertExists("uploads/$storePath/$id/test.pdf");
        $this->assertDatabaseHas("$dbTable", [
            'message' => $messageAssert,
            'attachment_path' => "uploads/$storePath/$id/test.pdf",
        ]);
    }

    private function uploadingFileTesting(
        $action,
        $routePath,
        $idValue,
        $messageValue,
        $idPathValue,
        $storePath,
        $dbTable,
        $messageAssert
    ): void
    {
        $response = $this->actingAs($this->test_user)->$action(route("erp.executive.messages.$routePath", ['id' => $idValue]),
            [
                'message' => $messageValue,
                'message_file' => $this->validFile
            ],

        );
        $response->assertStatus(302);
        $id = $idPathValue;
        Storage::disk('public')->assertExists("uploads/$storePath/$id/test.pdf");
        $this->assertDatabaseHas("$dbTable", [
            'message' => $messageAssert,
            'attachment_path' => "uploads/$storePath/$id/test.pdf",
        ]);
    }


    private function uploadingInvalidFileTesting(
        $action,
        $routePath,
        $idValue,
        $messageValue,
        $idPathValue,
        $storePath,
        $dbTable,
        $messageAssert,
        $error,
        $file,
    ): void
    {
        $response = $this->actingAs($this->test_user)->$action(route("erp.executive.messages.$routePath", ['id' => $idValue]),
            [
                'message' => $messageValue,
                'message_file' => $file
            ],
        );
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['message_file' => $error]);
        $id = $idPathValue;
        Storage::disk('public')->assertMissing("uploads/$storePath/$id/test.pdf");
        $this->assertDatabaseMissing("$dbTable", [
            'message' => $messageAssert,
            'attachment_path' => "uploads/$storePath/$id/test.pdf",
        ]);
    }

    private function deleteFileTesting(
        $action,
        $routePath,
        $idValue,
        $idPathValue,
        $storePath,

    ): void
    {
        $response = $this->actingAs($this->test_user)->$action(route("erp.executive.messages.$routePath", ['id' => $idValue]));
        $response->assertStatus(302);
        $id = $idPathValue;
        Storage::disk('public')->assertMissing("uploads/$storePath/$id/test.pdf");
    }

}
