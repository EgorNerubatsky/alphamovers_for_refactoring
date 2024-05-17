<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * @method static whereIn(string $string, $id)
 * @method static where(string $string, $id)
 */
class ArticleFavorite extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'article_id',
        'user_id',
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class, 'article_id');
    }

    public function newArticleFavorite($id, $userId): void
    {
        $favorite = new ArticleFavorite([
            'article_id' => $id,
            'user_id' => $userId,
        ]);
        $favorite->save();
    }

    public function deleteArticleFavorite($id): void
    {
        ArticleFavorite::where('article_id', $id)->delete();
    }


}
