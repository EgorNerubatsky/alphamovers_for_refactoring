<?php

namespace App\Services;

use App\Http\Requests\ChatMessageRequest;
use App\Http\Requests\ChatStoreRequest;

use App\Http\Requests\MessageReplyRequest;
use App\Http\Requests\MessageStoreRequest;
use App\Http\Requests\SearchRequest;
use App\Models\Chat;
use App\Models\ChatsActivity;
use App\Models\Email;
use App\Models\Message;
use App\Models\User;
use App\Models\UsersChat;
use App\Models\UserTask;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class ChatsActivityControllerService extends Controller
{
    protected RolesRoutingService $rolesRoutingService;
    private User $userModel;

    private Message $messageModel;

    private UsersChat $usersChatModel;

    private Chat $chatModel;

    private ChatsActivity $chatsActivityModel;
    private FilesActivityService $filesActivityModel;
    private Email $emailModel;
    private UserTask $userTaskModel;

    public function __construct(
        RolesRoutingService  $rolesRoutingService,
        User                 $userModel,
        UsersChat            $usersChatModel,
        Chat                 $chatModel,
        ChatsActivity        $chatsActivityModel,
        Message              $messageModel,
        FilesActivityService $filesActivityModel,
        Email                $emailModel,
        UserTask             $userTaskModel,

    )
    {
        $this->rolesRoutingService = $rolesRoutingService;
        $this->userModel = $userModel;
        $this->usersChatModel = $usersChatModel;
        $this->chatModel = $chatModel;
        $this->messageModel = $messageModel;
        $this->chatsActivityModel = $chatsActivityModel;
        $this->filesActivityModel = $filesActivityModel;
        $this->emailModel = $emailModel;
        $this->userTaskModel = $userTaskModel;

    }

    public function getMessagesQuery()
    {
        $user = Auth::user();
        return $this->messageModel->getRecipientMessages($user);
    }

    public function messagesSearch(SearchRequest $request)
    {
        $user = Auth::user();
        return $this->messageModel->search($request, $user);
    }

    public function chatStore(ChatStoreRequest $request): void
    {
        $user = Auth::user();
        $newChat = $this->chatModel->chatStore($request);
        $this->usersChatModel->userChatStore($newChat->id, $user->id);
    }

    public function chatUpdate(ChatStoreRequest $request, $id): void
    {
        $path = $this->filesActivityModel->addFile($request, 'chat_cover', "uploads/chats/$id/cover/");
        $this->chatModel->chatUpdate($request, $id, $path);
    }

    public function replyChat(MessageReplyRequest $request, $id): void
    {
        $messageReply = ChatsActivity::findOrFail($id);
        $user = Auth::user();
        $splitMessage = $request->input('message');
        $path = $this->filesActivityModel->addFile($request, 'message_file', "uploads/chats/$id/");
        $this->chatsActivityModel->newChatActivity($messageReply->chat_id, $user, $splitMessage, $path, $id);
    }


    public function storeMessageChat(ChatMessageRequest $request, $id): void
    {
        $user = Auth::user();
        $path = $this->filesActivityModel->addFile($request, 'message_file', "uploads/chats/$id/");
        $this->chatsActivityModel->newChatActivity($id, $user, $request->input('message'), $path, null);
    }

    public function updateMessageChat(ChatMessageRequest $request, $id): void
    {
        $chatActivity = ChatsActivity::findOrFail($id);
        $path = $chatActivity->attachment_path;
        if ($request->hasFile('message_file')) {
            $path = $this->filesActivityModel->addFile($request, 'message_file', "uploads/chats/$chatActivity->chat_id/");
        }
        $this->chatsActivityModel->updateChatActivity($chatActivity, $request->input('message'), $path);
    }


    public function chatAddUser(Request $request, $id): void
    {
        $checkUser = UsersChat::where('chat_id', $id)->pluck('user_id')->toArray();
        $newUser = User::findOrFail($request->input('recipient_user_id'));

        if (!in_array($newUser->id, $checkUser)) {
            $this->usersChatModel->userChatStore($id, $newUser->id);
        }
    }

    public function chatActivityDelete($id): void
    {
        $activity = ChatsActivity::findOrFail($id);
        if (isset($activity->attachment_path)) {
            $this->filesActivityModel->deleteFile($activity->attachment_path);
        }
        $this->chatsActivityModel->deleteChatActivity($id);
    }

    public function chatDelete($id): RedirectResponse
    {
        $chat = Chat::findOrFail($id);
        foreach ($chat->chatsActivities as $activity) {
            if (isset($activity->attachment_path)) {
                $this->filesActivityModel->deleteFile($activity->attachment_path);
                $this->chatsActivityModel->deleteChatActivity($activity->id);
            }
        }
        $this->chatModel->chatDelete($id);
        $user = Auth::user();
        $roleData = $this->rolesRoutingService->getRoleData($user);

        return redirect()->route($roleData['roleData']['messages_index']);

    }

    public function createMessage(MessageStoreRequest $request): void
    {
        $user = Auth::user();
        $path = $this->filesActivityModel->addFile($request, 'message_file', "uploads/messages/$user->id/");
        $this->messageModel->newMessage($user->id, $request->recipient_user_id, $request->message, $path, null);
    }

    public function replyMessage(MessageReplyRequest $request, $id): void
    {
        $messageReply = Message::findOrFail($id);
        $user = Auth::user();
        $splitMessage = $request->input('message');
        $path = $this->filesActivityModel->addFile($request, 'message_file', "uploads/messages/$user->id/");

        $this->messageModel->newMessage($user->id, $messageReply->sender_user_id, $splitMessage, $path, $id);
    }

    public function updateMessage(MessageReplyRequest $request, $id): void
    {
        $user = Auth::user();
        $updatedMessage = Message::findOrFail($id);

        $path = $updatedMessage->attachment_path;
        if ($request->hasFile('message_file')) {
            $path = $this->filesActivityModel->addFile($request, 'message_file', "uploads/messages/$user->id/");
        }
        $this->messageModel->updateMessage($updatedMessage, $request->message, $path);

    }

    public function deleteMessage($id): void
    {
        $message = Message::findOrFail($id);
        if (isset($message->attachment_path)) {
            $this->filesActivityModel->deleteFile($message->attachment_path);
        }
        $this->messageModel->deleteMessage($id);

    }

    public function searchUserResults(Request $request): JsonResponse
    {
        $search = $request->input('q');
        $users = $this->userModel->usersForMessage($search);
        $formattedUsers = $this->userModel->formattedUsers($users);

        return response()->json(['results' => $formattedUsers]);
    }

    public function markReadMessage($id): RedirectResponse
    {
        $this->messageModel->markAsRead($id);
        return redirect()->back()->with('reload', true);

    }

    public function updatingMessagesData($id): JsonResponse
    {
        $renderMessagesView = '';
        $renderChatMessagesView = '';
        $user = Auth::user();
        $roleData = $this->rolesRoutingService->getRoleData($user);

        if ($id !== null) {
            $renderMessagesView = $this->getPrivateChatMessages($id, $user, $roleData);
            $renderChatMessagesView = $this->getChatMessages($id, $user, $roleData);
        }

        $newEmails = $this->emailModel->newEmails();
        $newMessages = $this->messageModel->getNewMessages($user);
        $newTasks = $this->userTaskModel->getNewTasks($user);


        $newEmailsView = $this->getNewEmailsView($roleData, $newEmails);
        $newMessagesView = $this->getNewMessagesView($roleData, $newMessages);
        $newTasksView = $this->getNewTasksView($roleData, $newTasks);

        $renderAllMessagesView = $this->getAllMessagesView($roleData, $user);
        $renderCountsView = $this->getChatsAndPrivatesView($roleData, $user);


        return response()->json([
            'emailsCount' => $newEmails->count(),
            'newMessagesCount' => $newMessages->count(),
            'tasksCount' => $newTasks->count(),
            'newEmailsView' => $newEmailsView,
            'newMessagesView' => $newMessagesView,
            'newTasksView' => $newTasksView,
            'renderMessagesView' => $renderMessagesView,
            'renderAllMessagesView' => $renderAllMessagesView,
            'renderCountsView' => $renderCountsView,
            'renderChatMessagesView' => $renderChatMessagesView,
        ]);

// ---------------------------------
//                $renderMessagesView = '';
//        $renderChatMessagesView = '';
//        $user = Auth::user();
//        $roleData = $this->rolesRoutingService->getRoleData($user);
//        if ($id !== null) {
//            $roleData = $this->rolesRoutingService->getRoleData($user);
//            $privatChatMessages = $this->messageModel->findMessages($id, $user->id)->latest()->paginate(10);
//            $sender = $user;
//            $renderMessagesView = view('erp.parts.messages.modules.private_chat_messages', compact('privatChatMessages', 'roleData', 'sender'))->render();
//
//            $chat = Chat::findOrFail($id);
//            $chatMessages = $chat->chatsActivities()->latest()->paginate(10);
//            $renderChatMessagesView = view('erp.parts.messages.modules.chat_messages', compact('chatMessages', 'roleData', 'sender'))->render();
//        }
//
//        $newEmails = Email::where('read', false)->latest()->get();
//        $newMessages = Message::where('recipient_user_id', $user->id)->where('read', false)->latest()->get();
//        $newTasks = UserTask::where('task_to_user_id', $user->id)->where('status', 'Нове')->orWhere('status', 'У роботі')->get();
//
//        $newMessagesView = view('erp.parts.messages.dropdown_messages', compact('newMessages', 'roleData'))->render();
//        $newEmailsView = view('erp.parts.emails.dropdown_emails', compact('newEmails', 'roleData'))->render();
//        $newTasksView = view('erp.parts.tasks.dropdown_tasks', compact('newTasks', 'roleData'))->render();
//
//        $messagesQuery = $this->messageModel->getRecipientMessages($user);
//        $scopeMessages = $messagesQuery->latest()->paginate(10)->appends(request()->query());
//        $renderAllMessagesView = view('erp.parts.messages.modules.all_messages', compact('$scopeMessages', 'roleData'))->render();
//
//        $chats = $user->usersChats()->latest()->paginate(5) ?? [];
//        $userMessages = $user->messages ?? [];
//        $allUserMessages = $this->messageModel->getRecipientMessages($user)->get()->merge($userMessages);
//        $combinateIds = $allUserMessages->pluck('recipient_user_id')->merge($allUserMessages->pluck('sender_user_id'))->unique()->values();
//        $renderCountsView = view('erp.parts.messages.modules.chats_and_privats', compact('combinateIds', 'roleData', 'chats'))->render();
//
//
//        return response()->json([
//            'emailsCount' => $newEmails->count(),
//            'newMessagesCount' => $newMessages->count(),
//            'tasksCount' => $newTasks->count(),
//            'newEmailsView' => $newEmailsView,
//            'newMessagesView' => $newMessagesView,
//            'newTasksView' => $newTasksView,
//            'renderMessagesView' => $renderMessagesView,
//            'renderAllMessagesView' => $renderAllMessagesView,
//            'renderCountsView' => $renderCountsView,
//            'renderChatMessagesView' => $renderChatMessagesView,
//        ]);
//


    }

    private function getPrivateChatMessages($id, $user, $roleData): string
    {
        $privatChatMessages = $this->messageModel->findMessages($id, $user->id)->latest()->paginate(10);
        $sender = $user;
        return view('erp.parts.messages.modules.private_chat_messages', compact('privatChatMessages', 'roleData', 'sender'))->render();
    }

    private function getChatMessages($id, $user, $roleData): string
    {
        $chat = Chat::findOrFail($id);
        $chatMessages = $chat->chatsActivities()->latest()->paginate(10);
        $sender = $user;

        return view('erp.parts.messages.modules.chat_messages', compact('chatMessages', 'roleData', 'sender'))->render();
    }

    private function getNewEmailsView($roleData, $newEmails): string
    {
        return view('erp.parts.emails.dropdown_emails', compact('newEmails', 'roleData'))->render();
    }

    private function getNewMessagesView($roleData, $newMessages): string
    {
        return view('erp.parts.messages.dropdown_messages', compact('newMessages', 'roleData'))->render();
    }

    private function getNewTasksView($roleData, $newTasks): string
    {
        return view('erp.parts.tasks.dropdown_tasks', compact('newTasks', 'roleData'))->render();
    }

    private function getAllMessagesView($roleData, $user): string
    {
        $messagesQuery = $this->messageModel->getRecipientMessages($user);
        $scopeMessages = $messagesQuery->latest()->paginate(10)->appends(request()->query());
        return view('erp.parts.messages.modules.all_messages', compact('scopeMessages', 'roleData'))->render();
    }

    private function getChatsAndPrivatesView($roleData, $user): string
    {
        $chats = UsersChat::where('user_id', $user->id)->latest()->paginate(5) ?? [];
        $userMessages = $user->messages ?? [];
        $allUserMessages = $this->messageModel->getRecipientMessages($user)->get()->merge($userMessages);
        $combinateIds = $allUserMessages->pluck('recipient_user_id')->merge($allUserMessages->pluck('sender_user_id'))->unique()->values();
        return view('erp.parts.messages.modules.chats_and_privats', compact('combinateIds', 'roleData', 'chats'))->render();
    }


    public function chatsIndexView($messagesQuery): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $user = Auth::user();
        $roleData = $this->rolesRoutingService->getRoleData($user);
        $userMessages = $user->messages ?? [];
        $chats = UsersChat::where('user_id', $user->id)->latest()->paginate(5);
        $users = User::query()->get();
        $allUserMessages = $this->messageModel->getRecipientMessages($user)->get()->merge($userMessages);
        $combinateIds = $allUserMessages->pluck('recipient_user_id')->merge($allUserMessages->pluck('sender_user_id'))->unique()->values();
        $scopeMessages = $messagesQuery->latest()->paginate(10)->appends(request()->query());
        return view('erp.parts.messages.index', compact('chats', 'scopeMessages', 'users', 'combinateIds', 'roleData'));
    }

    public function chatView(int $id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $chat = Chat::findOrFail($id);
        $user = Auth::user();
        $roleData = $this->rolesRoutingService->getRoleData($user);
        $users = User::all();
        $chatUsers = $chat->usersChats()->with('user')->get()->pluck('user');
        $chatMessages = $chat->chatsActivities()->latest()->paginate(10);
        $sender = $user;
        return view('erp.parts.messages.chat_view', compact('chatUsers', 'chat', 'chatMessages', 'users', 'roleData', 'sender'));
    }

    public function privateChatView($id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $user = Auth::user();
        $roleData = $this->rolesRoutingService->getRoleData($user);
        $userId = $user->id;
        $privatChatMessages = $this->messageModel->findMessages($id, $userId)->latest()->paginate(10);
        $privateUser = User::findOrFail($id);
        $chats = UsersChat::where('user_id', $user->id)->latest()->paginate(5) ?? [];
        $userMessages = $user->messages ?? [];
        $allUserMessages = $this->messageModel->getRecipientMessages($user)->get()->merge($userMessages);
        $combinateIds = $allUserMessages->pluck('recipient_user_id')->merge($allUserMessages->pluck('sender_user_id'))->unique()->values();
        $sender = $user;
        return view('erp.parts.messages.chat_view_private', compact('privatChatMessages', 'chats', 'combinateIds', 'privateUser', 'roleData', 'sender'));

    }

    public function showChatRedirect($id): RedirectResponse
    {
        $user = Auth::user();
        $roleData = $this->rolesRoutingService->getRoleData($user);

        return redirect()->route($roleData['roleData']['messages_show_chat'], ['id' => $id]);
    }
}


