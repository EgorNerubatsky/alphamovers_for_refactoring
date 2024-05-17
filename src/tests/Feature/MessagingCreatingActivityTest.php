<?php

namespace Tests\Feature;


use App\Models\Chat;
use App\Models\ChatsActivity;
use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class MessagingCreatingActivityTest extends TestCase
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
            'sender_user_id' => $this->test_second_user->id,
            'recipient_user_id' => $this->test_user->id,
            'message' => "Повiдомлення Тестове 888",
            'read' => false,
        ]);
        $this->test_chat_message = ChatsActivity::create([
            'chat_id' => $this->test_chat->id,
            'user_id' => $this->test_user->id,
            'message' => "Тестове Повiдомлення у чатi 12345",
        ]);

        $this->invalidData = [
            'invalid_message' => 3456.78787,
            'invalid_title' => "@#$%^&",
            'str_repeat' => str_repeat('Aa', 800),
            'str_empty' => '',
            'str_spaces' => '   ',
        ];

        $this->creatingMessageData = [
            'sender_user_id' => $this->test_user->id,
            'recipient_user_id' => $this->test_second_user->id,
            'message' => "Тестове повiдомлення",
            'read' => false,
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

    public function test_create_message_with_valid_data(): void
    {
        $response = $this->actingAs($this->test_user)->post(route('erp.executive.messages.storeMessage', $this->creatingMessageData));
        $response->assertStatus(302);

        $this->assertDatabaseHas('messages', [
            'sender_user_id' => $this->creatingMessageData['sender_user_id'],
            'recipient_user_id' => $this->creatingMessageData['recipient_user_id'],
            'message' => $this->creatingMessageData['message'],
            'read' => $this->creatingMessageData['read'],
        ]);
    }

    public function test_create_message_with_spaces(): void
    {
        $this->creatingMessageData['message'] = $this->invalidData['str_spaces'];
        $this->messageCreationWithInvalidData(
            'The message field is required.',
            $this->creatingMessageData
        );
    }

    public function test_create_message_without_required_data(): void
    {
        $this->creatingMessageData['message'] = '';

        $this->messageCreationWithInvalidData(
            'The message field is required.',
            $this->creatingMessageData
        );
    }

    public function test_create_chat_with_valid_data()
    {
        $response = $this->actingAs($this->test_user)->post(route('erp.executive.messages.storeChat', $this->creatingChatData));
        $response->assertStatus(302);
        $this->assertDatabaseHas('chats', [
            'chat_name' => $this->creatingChatData['chat_name'],
        ]);
    }

    public function test_create_chat_with_invalid_data()
    {
        $this->creatingChatData['chat_name'] = $this->invalidData['invalid_title'];

        $this->chatCreationWithInvalidData(
            'The chat name field format is invalid.',
            $this->creatingChatData,
        );
    }

    public function test_create_chat_with_spaces()
    {
        $this->creatingChatData['chat_name'] = $this->invalidData['str_spaces'];
        $this->chatCreationWithInvalidData(
            'The chat name field is required.',
            $this->creatingChatData,
        );
    }

    public function test_create_chat_with_long_text()
    {
        $this->creatingChatData['chat_name'] = $this->invalidData['str_repeat'];
        $this->chatCreationWithInvalidData(
            'The chat name field must not be greater than 600 characters.',
            $this->creatingChatData,
        );
    }

    public function test_create_chat_without_required_data()
    {
        unset($this->creatingChatData['chat_name']);
        $this->chatCreationWithInvalidData(
            'The chat name field is required.',
            $this->creatingChatData,
        );
    }

    public function test_create_chat_message_with_valid_data()
    {
        $response = $this->actingAs($this->test_user)->post(route('erp.executive.messages.storeChatMessage',
            ['id' => $this->test_chat->id]), $this->creatingChatMessageData);
        $response->assertStatus(302);
        $this->assertDatabaseHas('chats_activities', [
//            'chat_name' => $this->creatingChatData['chat_name'],

            'chat_id' => $this->creatingChatMessageData['chat_id'],
            'user_id' => $this->creatingChatMessageData['user_id'],
            'message' => $this->creatingChatMessageData['message'],
        ]);
    }
    public function test_create_chat_message_with_spaces()
    {
        $this->creatingChatData['message'] = $this->invalidData['str_spaces'];
        $this->chatMessageCreationWithInvalidData(
            'The message field is required.',
            $this->creatingChatData,
            'storeChatMessage',
            $this->test_chat->id,
        );
    }

    public function test_create_chat_message_without_required_data()
    {
        unset($this->creatingChatData['message']);
        $this->chatMessageCreationWithInvalidData(
            'The message field is required.',
            $this->creatingChatData,
            'storeChatMessage',
            $this->test_chat->id,
        );
    }

    public function test_create_message_reply_with_valid_data()
    {
        $response = $this->actingAs($this->test_user)->post(route('erp.executive.messages.messageReply',
            ['id' => $this->test_message->id]), $this->creatingMessageData);
        $response->assertStatus(302);
        $this->assertDatabaseHas('messages', [
            'sender_user_id' => $this->creatingMessageData['sender_user_id'],
            'recipient_user_id' => $this->creatingMessageData['recipient_user_id'],
            'message'=>$this->creatingMessageData['message'],
        ]);
    }

    public function test_create_message_reply_with_invalid_data()
    {
        $this->creatingMessageData['message'] = $this->invalidData['invalid_message'];
        $this->messageReplyCreationWithInvalidData(
            'The message field must be a string.',
            'messageReply',
            $this->test_message->id,
            $this->creatingMessageData,
        );
    }

    public function test_create_message_reply_with_spaces()
    {
        $this->creatingMessageData['message'] = $this->invalidData['str_spaces'];
        $this->messageReplyCreationWithInvalidData(
            'The message field is required.',
            'messageReply',
            $this->test_message->id,
            $this->creatingMessageData,
        );
    }

    public function test_create_chat_message_reply_with_valid_data()
    {
        unset($this->creatingMessageData['sender_user_id']);
        unset($this->creatingMessageData['recipient_user_id']);
        unset($this->creatingMessageData['read']);

        $response = $this->actingAs($this->test_user)->post(route('erp.executive.messages.chatReply',
            ['id' => $this->test_chat_message->id]), $this->creatingMessageData);
        $response->assertStatus(302);

        $this->assertDatabaseHas('chats_activities', [
            'chat_id' => $this->test_chat_message['chat_id'],
            'user_id' => $this->test_chat_message['user_id'],
            'message' => $this->creatingMessageData['message'],
        ]);
    }

    public function test_create_chat_message_reply_with_invalid_data()
    {
        unset($this->creatingMessageData['sender_user_id']);
        unset($this->creatingMessageData['recipient_user_id']);
        unset($this->creatingMessageData['read']);
        $this->creatingChatData['message'] = $this->invalidData['invalid_message'];

        $this->chatMessageCreationWithInvalidData(
            'The message field must be a string.',
            $this->creatingChatData,
            'chatReply',
            $this->test_chat_message->id,
        );
    }

    public function test_create_chat_message_reply_with_spaces()
    {
        unset($this->creatingMessageData['sender_user_id']);
        unset($this->creatingMessageData['recipient_user_id']);
        unset($this->creatingMessageData['read']);
        $this->creatingChatData['message'] = $this->invalidData['str_spaces'];
        $this->chatMessageCreationWithInvalidData(
            'The message field is required.',
            $this->creatingChatData,
            'chatReply',
            $this->test_chat_message->id,
        );
    }

    public function test_create_chat_message_reply_without_required_data()
    {
        unset($this->creatingMessageData['sender_user_id']);
        unset($this->creatingMessageData['recipient_user_id']);
        unset($this->creatingMessageData['read']);
        unset($this->creatingChatData['message']);
        $this->chatMessageCreationWithInvalidData(
            'The message field is required.',
            $this->creatingChatData,
            'chatReply',
            $this->test_chat_message->id,
        );
    }

    private function messageCreationWithInvalidData($message, $invalidData): void
    {
        $response = $this->actingAs($this->test_user)->post(route('erp.executive.messages.storeMessage', $invalidData))->assertStatus(302);
        $response->assertSessionHasErrors([
            'message' => $message,
        ]);

        $this->assertDatabaseMissing('messages', [
            'sender_user_id' => $invalidData['sender_user_id'],
            'recipient_user_id' => $invalidData['recipient_user_id'],
            'message' => $invalidData['message'],
        ]);
    }

    private function chatCreationWithInvalidData($message, $invalidData): void
    {
        $response = $this->actingAs($this->test_user)->post(route('erp.executive.messages.storeChat', $invalidData))
            ->assertStatus(302);
        $response->assertSessionHasErrors([
            'chat_name' => $message,
        ]);
    }

    private function chatMessageCreationWithInvalidData($message, $invalidData, $path, $id): void
    {
        $response = $this->actingAs($this->test_user)->post(route("erp.executive.messages.$path",
            ['id' => $id]),
            $invalidData,
        )->assertStatus(302);

        $response->assertSessionHasErrors([
            'message' => $message,
        ]);
    }

    private function messageReplyCreationWithInvalidData($message, $path, $id, $creatingData): void
    {
        $response = $this->actingAs($this->test_user)->post(route("erp.executive.messages.$path",
            ['id' => $id]),
            $creatingData,
        )
            ->assertStatus(302);

        $response->assertSessionHasErrors([
            'message' => $message,
        ]);
    }

}
