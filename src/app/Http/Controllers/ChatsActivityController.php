<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChatMessageRequest;
use App\Http\Requests\ChatStoreRequest;
use App\Http\Requests\MessageReplyRequest;
use App\Http\Requests\MessageStoreRequest;
use App\Http\Requests\SearchRequest;
use App\Services\ChatsActivityControllerService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ChatsActivityController extends Controller
{
    private ChatsActivityControllerService $chatsActivityControllerService;


    public function __construct(
        ChatsActivityControllerService $chatsActivityControllerService,

    )
    {
        $this->chatsActivityControllerService = $chatsActivityControllerService;

    }

    public function index(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $messagesQuery = $this->chatsActivityControllerService->getMessagesQuery();
        return $this->chatsActivityControllerService->chatsIndexView($messagesQuery);
    }

    public function search(SearchRequest $request): View|Factory|\Illuminate\Foundation\Application|Application
    {
        $searchQuery = $this->chatsActivityControllerService->messagesSearch($request);
        return $this->chatsActivityControllerService->chatsIndexView($searchQuery);
    }

    public function storeChat(ChatStoreRequest $request): RedirectResponse
    {
        try {
            $this->chatsActivityControllerService->chatStore($request);
            return redirect()->back()->with('reload', true);
        } catch (Exception $e) {
            return back()->withErrors(['error' => "Произошла ошибка: " . $e->getMessage()]);
        }
    }

    public function updateChat(ChatStoreRequest $request, $id): RedirectResponse
    {
        try {
            $this->chatsActivityControllerService->chatUpdate($request, $id);
            return redirect()->back()->with('reload', true);
        } catch (Exception $e) {
            return back()->withErrors(['error' => "Произошла ошибка: " . $e->getMessage()]);
        }
    }

    public function chatReply(MessageReplyRequest $request, $id): RedirectResponse
    {
        try {
            $this->chatsActivityControllerService->replyChat($request, $id);
            return redirect()->back()->with('reload', true);
        } catch (Exception $e) {
            return back()->withErrors(['error' => "Произошла ошибка: " . $e->getMessage()]);
        }
    }

    public function storeChatMessage(ChatMessageRequest $request, $id): RedirectResponse
    {
        try {
            $this->chatsActivityControllerService->storeMessageChat($request, $id);
            return $this->chatsActivityControllerService->showChatRedirect($id);
        } catch (Exception $e) {
            return back()->withErrors(['error' => "Произошла ошибка: " . $e->getMessage()]);
        }
    }

    public function updateChatMessage(ChatMessageRequest $request, $id): RedirectResponse
    {
        try {
            $this->chatsActivityControllerService->updateMessageChat($request, $id);
            return redirect()->back()->with('reload', true);
        } catch (Exception $e) {
            return back()->withErrors(['error' => "Произошла ошибка: " . $e->getMessage()]);
        }
    }

    public function deleteChatMessage($id): RedirectResponse
    {
        $this->chatsActivityControllerService->chatActivityDelete($id);
        return redirect()->back()->with('reload', true);
    }

    public function deleteChat($id): RedirectResponse
    {
        try {
            return $this->chatsActivityControllerService->chatDelete($id);
        } catch (Exception $e) {
            return back()->withErrors(['error' => "Произошла ошибка: " . $e->getMessage()]);
        }
    }

    public function showChat($id): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return $this->chatsActivityControllerService->chatView($id);
    }

    public function storeMessage(MessageStoreRequest $request): RedirectResponse
    {
        try {
            $this->chatsActivityControllerService->createMessage($request);
            return redirect()->back()->with('reload', true);
        } catch (Exception $e) {
            return back()->withErrors(['error' => "Произошла ошибка: " . $e->getMessage()]);
        }
    }

    public function updateMessage(MessageReplyRequest $request, $id): RedirectResponse
    {
        try {
            $this->chatsActivityControllerService->updateMessage($request, $id);
            return redirect()->back()->with('reload', true);
        } catch (Exception $e) {
            return back()->withErrors(['error' => "Произошла ошибка: " . $e->getMessage()]);
        }
    }


    public function messageReply(MessageReplyRequest $request, $id): RedirectResponse
    {
        try {
            $this->chatsActivityControllerService->replyMessage($request, $id);
            return redirect()->back()->with('reload', true);
        } catch (Exception $e) {
            return back()->withErrors(['error' => "Произошла ошибка: " . $e->getMessage()]);
        }
    }


    public function deleteMessage($id): RedirectResponse
    {
        $this->chatsActivityControllerService->deleteMessage($id);
        return redirect()->back()->with('reload', true);
    }


    /**
     * @param $id
     * @return View|\Illuminate\Foundation\Application|Factory|Application
     */
    public function showPrivatChat($id): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return $this->chatsActivityControllerService->privateChatView($id);
    }

    public function addUser(Request $request, $id): RedirectResponse
    {
        try {
            $this->chatsActivityControllerService->chatAddUser($request, $id);
            return $this->chatsActivityControllerService->showChatRedirect($id);
        } catch (Exception $e) {
            return back()->withErrors(['error' => "Произошла ошибка: " . $e->getMessage()]);
        }
    }

    public function searchUsers(Request $request): JsonResponse
    {
        return $this->chatsActivityControllerService->searchUserResults($request);
    }

    public function readMessage($id): RedirectResponse
    {
        return $this->chatsActivityControllerService->markReadMessage($id);
    }

    public function updateChatsData(Request $request): JsonResponse
    {
        $id = $request->query('id');
        return $this->chatsActivityControllerService->updatingMessagesData($id);
    }

}
