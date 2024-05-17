<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UsersFile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'interviewee_id',
        'path',
        'description',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function createUserFile($path, $user, $description): void
    {
        $usersFile = new UsersFile([
            'user_id' => $user->id,
            'path' => $path,
            'description' => $description,
        ]);
        $usersFile->save();
        $user->photo_path =$path;
        $user->save();
    }

}
