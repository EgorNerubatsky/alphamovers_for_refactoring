<?php

namespace App\Models;

use App\Http\Requests\SearchRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;


/**
 * @method static findOrFail(mixed $id)
 * @method static create(array $array)
 * @method static pluck(string $string)
 * @method static where(string $string, $id)
 */
class UserTask extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'task_to_user_id',
        'task',
        'start_task',
        'end_task',
        'company',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function applyTaskCompanyFilters($tasksQuery, $selectedCompany): void
    {
        if ($selectedCompany) {
            $tasksQuery->where('company', $selectedCompany);
        }
    }

    public function applyTaskStatusFilters($tasksQuery, $selectedStatus)
    {


        if($selectedStatus == 'Виконано'){
            $tasksQuery = UserTask::where('task_to_user_id', Auth::id())->where(function ($query) {
                $query->where('status', 'Виконано');
            });
        }else if ($selectedStatus == 'У роботі' || $selectedStatus == 'Нове'){
            $tasksQuery->where('status', $selectedStatus);
        }



        return $tasksQuery;
    }

    public function search(SearchRequest $request)
    {
        $search = $request->search;
        return self::where('task', 'like', "%$search%");
    }

    public function applyTaskToUserFilters($tasksQuery, $allUserTaskQuery, $selectedUser)
    {
        if ($selectedUser) {
            $tasksQuery = $allUserTaskQuery->where('task_to_user_id', $selectedUser);
        }
        return $tasksQuery;
    }
    public function updateTask($request, $formattedStart, $formattedEnd): void
    {
       $task = UserTask::findOrFail($request->id);
        $task->update([
            'start_task' => $formattedStart,
            'end_task' => $formattedEnd,
        ]);
    }

    public function storeTask($userId,$taskToUserId,$task,$company, $status, $startTask,$endTask): void
    {
        $task = new UserTask([
            'user_id' => $userId,
            'task_to_user_id' => $taskToUserId,
            'task' => $task,
            'company' => $company,
            'status' => $status,
            'start_task' => $startTask,
            'end_task' => $endTask,
        ]);
        $task->save();
    }

    public function taskFullUpdate($task,$eventTitle,$company, $status, $startTask,$endTask): void
    {
        $task->update([
            'task' => $eventTitle,
            'company' => $company,
            'status' => $status,
            'start_task' => $startTask,
            'end_task' => $endTask,
        ]);
        $task->save();
    }
 public function getNewTasks($user)
    {
       return UserTask::where('task_to_user_id', $user->id)->where('status', 'Нове')->orWhere('status', 'У роботі')->get();

    }





}
