<?php

namespace App\Models;

use App\Http\Requests\MessageStoreRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;


/**
 * @method static findOrFail($id)
 * @method static where(string $string, $id)
 * @method static create(array $array)
 * @property mixed|string $attachment_path
 */
class Message extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sender_user_id',
        'recipient_user_id',
        'reply_id',
        'message',
        'attachment_path',
        'read',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_user_id');
    }

    public function getRecipientMessages($user)
    {
        return Message::where('recipient_user_id', $user->id);
    }

    public function search($request, $user)
    {
        $search = $request->search;

        return self::where('recipient_user_id', $user->id)
            ->where(function ($query) use ($search) {
                $query->where('message', 'like', "%$search%")
                    ->orWhereHas('user', function ($subquery) use ($search) {
                        $subquery->where('name', 'like', "%$search%")
                            ->orWhere('lastname', 'like', "%$search%");
                    });
            });

    }

    public function getRecipientLatestMessages($user)
    {
        return Message::where('recipient_user_id', $user->id)->latest();
    }

    public function newMessage($userId, $recipientId, $message, $path, $replyId): void
    {

        $message = new Message([
            'sender_user_id' => $userId,
            'recipient_user_id' => $recipientId,
            'message' => $message,
            'read' => false,
            'attachment_path' => $path,
            'reply_id' => $replyId,
        ]);
        $message->save();

    }

    public function getNewMessages($user)
    {

        return Message::where('recipient_user_id', $user->id)->where('read', false)->latest()->get();


    }


    public function updateMessage($updatedMessage, $message, $path): void
    {

        $updatedMessage->update([
            'message' => $message,
            'attachment_path' => $path,
        ]);

    }

    public function findMessages($id, $userId)
    {
        return Message::where('sender_user_id', $id)
            ->where('recipient_user_id', $userId)
            ->orWhere(function ($query) use ($id, $userId) {
                $query->where('recipient_user_id', $id)
                    ->where('sender_user_id', $userId);
            });

    }

    public function markAsRead($id): void
    {
        $readMessage = Message::findOrFail($id);
        $readMessage->read = true;
        $readMessage->save();
    }

    public function deleteMessage($id): void
    {
        $deleteMessage = Message::findOrFail($id);
        $deleteMessage->delete();
        $deleteMessage->save();
    }


}
