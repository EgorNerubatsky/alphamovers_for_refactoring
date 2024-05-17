<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

/**
 * @method static findOrFail($id)
 * @method static random()
 * @method static inRandomOrder()
 * @property mixed|string $attachment_path
 */
class Article extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'attachment_path',
        'content',
        'creator_id',

    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function articleFavorites(): HasMany
    {
        return $this->hasMany(ArticleFavorite::class, 'article_id');
    }

    public function newArticle($title, $content, $userId, $path): void
    {
        $article = new Article([
            'title' => $title,
            'content' => $content,
            'creator_id' => $userId,
            'attachment_path' => $path,
        ]);
        $article->save();

    }

    public function updateArticle($updatedArticle, $title, $content, $path): void
    {
        $updatedArticle->update([
            'title' => $title,
            'content' => $content,
//            'creator_id' => $userId,
            'attachment_path' => $path,
        ]);
    }

    public function searchArticle($search)
    {
        return Article::where('title', 'like', "%$search%")
            ->orWhere('content', 'like', "%$search%")->paginate(10);
    }




    public function deleteArticle($id): void
    {
        $deletedArticle = Article::findOrFail($id);
        $deletedArticle->delete();
    }

    public function deleteFile($id): void
    {
        $deletedArticle = Article::findOrFail($id);
        $documentPath = public_path($deletedArticle->attachment_path);
        if (is_file($documentPath)) {
            unlink($documentPath);
        }
        $deletedArticle->attachment_path  = null;
        $deletedArticle->save();
    }


}
