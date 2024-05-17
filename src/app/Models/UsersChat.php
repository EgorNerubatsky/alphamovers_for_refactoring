<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;


/**
 * @method static where(string $string, $id)
 * @method static pluck(string $string)
 * @method static findOrFail($id)
 */
class UsersChat extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'chat_id',
        'user_id',
    ];

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class, 'chat_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getUserChats($user){
        return UsersChat::where('user_id',$user->id)->get();
    }

    public function userChatStore($chatId,$userId): void
    {
        $newChat = new UsersChat([
            'chat_id' => $chatId,
            'user_id' => $userId,
        ]);
        $newChat->save();
    }
}
