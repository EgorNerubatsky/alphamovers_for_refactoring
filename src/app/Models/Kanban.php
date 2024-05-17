<?php

namespace App\Models;

use App\Http\Requests\KanbanStoreRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;


/**
 * @method static where(string $string, $id)
 * @method static findOrFail(string $string)
 * @method static find($id)
 * @method static create(array $array)
 * @property mixed $title_color
 */
class Kanban extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable =[
        'kanban_title',
        'title_color',
        'user_id',

    ];

    public function kanbanTasks(): HasMany
    {
        return $this->hasMany(KanbanTask::class, 'kanban_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function createKanban(KanbanStoreRequest $request, $user): void
    {
        $newKanban = new Kanban([
            'kanban_title' => $request->input('kanban_title'),
            'user_id' => $user->id,
        ]);

        if($request->input('title_color')){
            $newKanban->title_color = $request->input('title_color');
        }
        $newKanban->save();
    }

    public function updateKanban(KanbanStoreRequest $request): void
    {
        $editedKanban = Kanban::findOrFail($request->kanban_id);
        $editedKanban->kanban_title = $request->kanban_title;
        if($request->input('title_color')){
            $editedKanban->title_color = $request->title_color;
        }
        $editedKanban->save();
    }

    public function deleteKanban($id): void
    {
        $kanban = Kanban::find($id);
        foreach ($kanban->kanbanTasks as $task){
            $task->delete();
        }
//        $kanban->kanbanTasks->delete();
        $kanban->delete();

    }

}
