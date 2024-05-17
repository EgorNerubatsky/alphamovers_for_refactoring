<?php

namespace App\Models;

use App\Http\Requests\KanbanTaskRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * @method static findOrFail(mixed $input)
 * @method static whereIn(string $string, $id)
 * @method static create(array $array)
 * @property mixed $task_color
 */
class KanbanTask extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'kanban_id',
        'task',
        'task_color',
        'completed',
        'column_id',
    ];

    public function kanban(): BelongsTo
    {
        return $this->belongsTo(Kanban::class, 'kanban_id');
    }

    public function storeKanbanTask(KanbanTaskRequest $request): void
    {
        $newKanbanTask = new KanbanTask([
            'kanban_id' => $request->kanban_id,
            'task' => $request->task,
        ]);
        if ($request->input('task_color')) $newKanbanTask->task_color = $request->task_color;

        $newKanbanTask->save();
    }

     public function updateKanbanTask(KanbanTask $task, string $taskText, string $taskColor): void
     {
         $task->update([
             'task'=>$taskText,
             'task_color'=>$taskColor,
         ]);
     }

}
