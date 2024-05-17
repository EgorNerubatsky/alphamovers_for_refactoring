<?php

namespace Tests\Feature;


use App\Models\Chat;
use App\Models\ChatsActivity;
use App\Models\Message;
use App\Models\User;
use App\Models\UsersChat;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class MessagingUpdatingActivityTest extends TestCase
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

        $this->test_user_chat = UsersChat::create([
            'chat_id' => $this->test_chat->id,
            'user_id' => $this->test_user->id,
        ]);


        $this->invalidData = [
            'str_invalid' => "@#$%^& повiдомлення",
            'str_repeat' => str_repeat('Aa', 800),
            'str_empty' => '',
            'str_spaces' => '   ',
        ];

        $this->updatingMessageData = [
            'message' => "Тестове повiдомлення",
        ];

        $this->updatingChatData = [
            'chat_name' => 'New chat 123',
        ];

        $this->addingUsrData = [
            'recipient_user_id' => $this->test_second_user->id,
        ];

    }

    public function test_update_chat_message_with_valid_data(): void
    {
        $response = $this->actingAs($this->test_user)->put(route('erp.executive.messages.updateChatMessage', ['id' => $this->test_chat_message->id]), $this->updatingMessageData);
        $response->assertStatus(302);

        $this->assertDatabaseHas('chats_activities', [
            'chat_id' => $this->test_chat_message->chat_id,
            'user_id' => $this->test_chat_message->user_id,
            'message' => $this->updatingMessageData['message'],
        ]);
    }

    public function test_update_chat_message_with_spaces(): void
    {
        $this->updatingMessageData['message'] = $this->invalidData['str_spaces'];
        $this->messageUpdatingWithInvalidData(
            'The message field is required.',
            $this->updatingMessageData,
            'updateChatMessage',
            $this->test_chat_message->id,
            'message',
            'chats_activities'
        );
    }

    public function test_update_chat_message_without_required_data(): void
    {
        $this->updatingMessageData['message'] = $this->invalidData['str_empty'];

        $this->messageUpdatingWithInvalidData(
            'The message field is required.',
            $this->updatingMessageData,
            'updateChatMessage',
            $this->test_chat_message->id,
            'message',
            'chats_activities'

        );
    }

    public function test_update_message_with_valid_data(): void
    {
        $response = $this->actingAs($this->test_user)->put(route('erp.executive.messages.updateMessage', ['id' => $this->test_message->id]), $this->updatingMessageData);
        $response->assertStatus(302);

        $this->assertDatabaseHas('messages', [
            'sender_user_id' => $this->test_message->sender_user_id,
            'recipient_user_id' => $this->test_message->recipient_user_id,

            'message' => $this->updatingMessageData['message'],
        ]);
    }

    public function test_update_message_with_spaces(): void
    {
        $this->updatingMessageData['message'] = $this->invalidData['str_spaces'];
        $this->messageUpdatingWithInvalidData(
            'The message field is required.',
            $this->updatingMessageData,
            'updateMessage',
            $this->test_message->id,
            'message',
            'messages'
        );
    }

    public function test_update_message_without_required_data(): void
    {
        $this->updatingMessageData['message'] = $this->invalidData['str_empty'];

        $this->messageUpdatingWithInvalidData(
            'The message field is required.',
            $this->updatingMessageData,
            'updateMessage',
            $this->test_message->id,
            'message',
            'messages'
        );
    }

    public function test_update_chat_title_with_valid_data(): void
    {

        $response = $this->actingAs($this->test_user)->put(route('erp.executive.messages.updateChat', ['id' => $this->test_chat->id]), $this->updatingChatData);
        $response->assertStatus(302);

        $this->assertDatabaseHas('chats', [
            'id' => $this->test_chat->id,
            'chat_name' => $this->updatingChatData['chat_name'],
        ]);
    }

    public function test_update_chat_title_with_invalid_data(): void
    {
        $this->updatingChatData['chat_name'] = $this->invalidData['str_invalid'];

        $this->messageUpdatingWithInvalidData(
            'The chat name field is required.',
            $this->updatingChatData,
            'updateChat',
            $this->test_chat->id,
            'chat_name',
            'chats',
        );
    }

    public function test_update_chat_title_with_spaces(): void
    {
        $this->updatingChatData['chat_name'] = $this->invalidData['str_spaces'];
        $this->messageUpdatingWithInvalidData(
            'The chat name field is required.',
            $this->updatingChatData,
            'updateChat',
            $this->test_chat->id,
            'chat_name',
            'chats',
        );
    }

    public function test_update_chat_title_without_required_data(): void
    {
        $this->updatingChatData['chat_name'] = $this->invalidData['str_empty'];
        $this->messageUpdatingWithInvalidData(
            'The chat name field is required.',
            $this->updatingChatData,
            'updateChat',
            $this->test_chat->id,
            'chat_name',
            'chats',
        );
    }

    public function test_add_user_in_chat(): void
    {
        $response = $this->actingAs($this->test_user)->post(route('erp.executive.messages.addUser', ['id' => $this->test_chat->id]), $this->addingUsrData);
        $response->assertStatus(302);

        $this->assertDatabaseHas('users_chats', [
            'chat_id' => $this->test_chat->id,
            'user_id' => $this->test_second_user->id,
        ]);
    }

    public function test_add_existing_user_in_chat(): void
    {
        $response = $this->actingAs($this->test_user)->post(route('erp.executive.messages.addUser', ['id' => $this->test_chat->id]), $this->addingUsrData);
        $response->assertStatus(302);

        $count = UsersChat::where('chat_id', $this->test_chat->id)->where('user_id', $this->test_second_user->id)->count();
        $this->assertCount(1, [$count]);
    }

    public function test_delete_message(): void
    {
        $response = $this->actingAs($this->test_user)->get(route('erp.executive.messages.deleteMessage', ['id' => $this->test_message->id]));
        $response->assertStatus(302);
        $this->assertSoftDeleted('messages', [
            'sender_user_id' => $this->test_message->sender_user_id,
            'recipient_user_id' => $this->test_message->recipient_user_id,
            'message' => $this->test_message->message,
        ]);
    }

    public function test_delete_chat_message(): void
    {
        $response = $this->actingAs($this->test_user)->get(route('erp.executive.messages.deleteChatMessage', ['id' => $this->test_chat_message->id]));
        $response->assertStatus(302);
        $this->assertSoftDeleted('chats_activities', [
            'chat_id' => $this->test_chat_message->chat_id,
            'user_id' => $this->test_chat_message->user_id,
            'message' => $this->test_chat_message->message,
        ]);
    }

    public function test_delete_chat(): void
    {
        $response = $this->actingAs($this->test_user)->get(route('erp.executive.messages.deleteChat', ['id' => $this->test_chat->id]));
        $response->assertStatus(302);
        $this->assertSoftDeleted('chats', [
            'id' => $this->test_chat->id,
            'chat_name' => $this->test_chat->chat_name,
        ]);
    }

    private function messageUpdatingWithInvalidData($message, $invalidData, $path, $idData, $field, $dbValue): void
    {
        $response = $this->actingAs($this->test_user)->put(route("erp.executive.messages.$path", ['id' => $idData]), $this->updatingMessageData)->assertStatus(302);
        $response->assertSessionHasErrors([
            $field => $message,
        ]);

        $this->assertDatabaseMissing($dbValue, [
            $field => $invalidData[$field],
        ]);

    }


}
