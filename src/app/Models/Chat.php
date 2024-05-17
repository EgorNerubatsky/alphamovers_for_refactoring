<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * @method static create(array $all)
 * @method static findOrFail($id)
 */
class Chat extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'chat_name',
        'chat_cover',
    ];

    public function chatsActivities(): HasMany
    {
        return $this->hasMany(ChatsActivity::class, 'chat_id');
    }

    public function usersChats(): HasMany
    {
        return $this->hasMany(UsersChat::class, 'chat_id');
    }

    public function chatStore($request)
    {
        return Chat::create($request->all());
    }

    public function chatUpdate($request, $id, $path): void
    {
        $chat = Chat::findOrFail($id);
        $chat->update([
            'chat_name' => $request->chat_name,
            'chat_cover' => $path,
        ]);
    }

    public function chatDelete($id): void
    {
        $deleteChat = Chat::findOrFail($id);

        foreach ($deleteChat->usersChats as $chat) {
            $chat->delete();
        }
        $deleteChat->delete();
    }
}
