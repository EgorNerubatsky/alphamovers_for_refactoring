<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;


/**
 * @method static findOrFail($id)
 * @method static create(array $array)
 * @method static pluck(string $string)
 * @method static where(string $string, $message)
 */
class ChatsActivity extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [

        'chat_id',
        'user_id',
        'message',
        'reply_id',
        'attachment_path',

    ];

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class, 'chat_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function newChatActivity($ChatId, $user, $message, $path, $id): void
    {
        $chat = new ChatsActivity([
            'chat_id' => $ChatId,
            'user_id' => $user->id,
            'reply_id' => $id,
            'message' => $message,
            'attachment_path' => $path
        ]);
        $chat->save();
    }

    public function updateChatActivity($chatActivity, $message, $path): void
    {
        $chatActivity->update([
            'message' => $message,
            'attachment_path' => $path
        ]);
    }


    public function deleteChatActivity($id): void
    {
        $deleteMessage = self::findOrFail($id);
        $deleteMessage->delete();
        $deleteMessage->save();
    }
}
