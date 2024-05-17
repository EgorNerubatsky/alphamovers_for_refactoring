<?php

namespace App\Services;


use App\Http\Requests\KanbanTaskRequest;
use App\Http\Requests\KanbanStoreRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\TaskFormRequest;
use App\Http\Requests\UserTaskRequest;
use App\Models\ClientBase;
use App\Models\Kanban;
use App\Models\KanbanTask;
use App\Models\User;
use App\Models\UserTask;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class TaskControllerService extends Controller
{
    protected RolesRoutingService $rolesRoutingService;
    private UserTask $userTaskModel;
    private Kanban $kanbanModel;
    private KanbanTask $kanbanTaskModel;

    public function __construct(
        RolesRoutingService $rolesRoutingService,
        UserTask            $userTaskModel,
        Kanban              $kanbanModel,
        KanbanTask          $kanbanTaskModel,

    )
    {
        $this->rolesRoutingService = $rolesRoutingService;
        $this->userTaskModel = $userTaskModel;
        $this->kanbanModel = $kanbanModel;
        $this->kanbanTaskModel = $kanbanTaskModel;
    }

    public function taskDateFilters(Request $request): Builder
    {
        $tasksQuery = UserTask::where('task_to_user_id', Auth::id())->where(function ($query) {
            $query->where('status', 'У роботі')->orWhere('status', 'Нове');
        });

        $allUserTaskQuery = UserTask::where('user_id', Auth::id());

        $this->userTaskModel->applyTaskCompanyFilters($tasksQuery, $request->input('selectCompany'));
        $tasksQuery = $this->userTaskModel->applyTaskStatusFilters($tasksQuery, $request->input('selectStatus'));
        $this->userTaskModel->applyTaskToUserFilters($tasksQuery, $allUserTaskQuery, $request->input('selectUser'));

        return $tasksQuery;
    }


    public function taskSearch(SearchRequest $request)
    {
        return $this->userTaskModel->search($request);
    }

    public function taskRemove($request): void
    {


        $formattedStart = Carbon::parse($request->start)->addHours(2)->toDateTimeString();
        $formattedEnd = Carbon::parse($request->end)->addHours(2)->toDateTimeString();

        $this->userTaskModel->updateTask($request, $formattedStart, $formattedEnd);

    }

    public function taskUpdate(UserTaskRequest $request): RedirectResponse
    {

        try {
            $event = UserTask::findOrFail($request->eventId);

            $formattedStart = Carbon::parse($request->eventStart)->toDateTimeString();
            $formattedEnd = Carbon::parse($request->eventEnd)->toDateTimeString();

            $this->userTaskModel->taskFullUpdate(
                $event,
                $request->input('eventTitle'),
                $request->input('company'),
                $request->input('status'),
                $formattedStart,
                $formattedEnd,
            );

            return $this->taskIndexRedirect();
        } catch (Exception $e) {
            return back()->withErrors(['error' => "Произошла ошибка: " . $e->getMessage()]);
        }


    }

    public function taskKanbanStore(KanbanStoreRequest $request): RedirectResponse
    {
        try {
            $user = Auth::user();
            $this->kanbanModel->createKanban($request, $user);
            return redirect()->back()->with('reload', true);
        } catch (Exception $e) {
            return back()->withErrors(['error' => "Произошла ошибка: " . $e->getMessage()]);
        }
    }

    public function taskKanbanUpdate(KanbanStoreRequest $request): RedirectResponse
    {
        try {
            $this->kanbanModel->updateKanban($request);
            return redirect()->back()->with('reload', true);
        } catch (Exception $e) {
            return back()->withErrors(['error' => "Произошла ошибка: " . $e->getMessage()]);
        }
    }

    public function taskKanbanDelete($id): RedirectResponse
    {
        try {
            $this->kanbanModel->deleteKanban($id);
            return redirect()->back()->with('reload', true);
        } catch (Exception $e) {
            return back()->withErrors(['error' => "Произошла ошибка: " . $e->getMessage()]);
        }
    }

    public function taskIndexView($tasksQuery): View|Application|Factory|JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        $user = Auth::user();
        $roleData = $this->rolesRoutingService->getRoleData($user);

        $users = User::all();
        $companys = ClientBase::all();

        $tasks = $tasksQuery->get();
        $today = date('Y-m-d');
        $todayEvents = [];
        $events = [];

        foreach ($tasks as $task) {
            $taskDate = substr($task->start_task, 0, 10);
            $event = [
                'id' => $task->id,
                'title' => $task->task,
                'company' => $task->company,
                'status' => $task->status,
                'start' => $task->start_task,
                'end' => $task->end_task,
                'allDay' => false,
            ];
            $events[] = $event;
            if ($taskDate == $today) {
                $todayEvents[] = $event;
            }
        }

        $kanbans = $user->kanbans ?? [];
        $tasksUsers = [];
        if (!empty($user->userTasks)) {
            $allUserTaskQueryIds = $user->userTasks->pluck('task_to_user_id')->unique();
            $tasksUsers = $users->whereIn('id', $allUserTaskQueryIds);

        }
        $tasksCompanys = $tasksQuery->pluck('company')->unique();
        $tasksStatuses = UserTask::pluck('status')->unique();

        if (request()->expectsJson()) {
            return response()->json([
                'events' => $events,
            ]);
        }


        return view('erp.parts.tasks.index')->with([
            'events' => json_encode($events),
            'todayEvents' => json_encode($todayEvents),
            'users' => $users,
            'companys' => $companys,
            'tasksCompanys' => $tasksCompanys,
            'tasksStatuses' => $tasksStatuses,
            'tasksUsers' => $tasksUsers,
            'kanbans' => $kanbans,
            'roleData' => $roleData,
        ]);
    }

    public function taskStore(TaskFormRequest $request): RedirectResponse
    {
        try {
            $user = Auth::user();
            $formattedStart = Carbon::parse($request->start_task)->addHours(3)->toDateTimeString();
            $formattedEnd = Carbon::parse($request->end_task)->addHours(3)->toDateTimeString();

            if (!empty($user->id)) {
                $this->userTaskModel->storeTask(
                    $user->id,
                    $request->task_to_user_id,
                    str_replace(["'", '"'], '', $request->input('task')),
                    $request->input('company') ? str_replace(["'", '"'], '', $request->input('company')) : null,
                    'Нове',
                    $formattedStart,
                    $formattedEnd,
                );
            }
            return $this->taskIndexRedirect();
        } catch (Exception $e) {
            return back()->withErrors(['error' => "Произошла ошибка: " . $e->getMessage()]);
        }
    }

    public function taskStoreKanbanTask(KanbanTaskRequest $request): RedirectResponse
    {
        try {
            $this->kanbanTaskModel->storeKanbanTask($request);
            return redirect()->back()->with('reload', true);
        } catch (Exception $e) {
            return back()->withErrors(['error' => "Произошла ошибка: " . $e->getMessage()]);
        }
    }

    public function taskUpdateTask(KanbanTaskRequest $request): RedirectResponse
    {
        try {
            $task = KanbanTask::findOrFail($request->input('kanban_task_id'));
            $taskText = $request->input('task');
            $taskColor = $request->input('task_color');

            $this->kanbanTaskModel->updateKanbanTask(
                $task,
                $taskText,
                $taskColor,
            );
            return redirect()->back()->with('reload', true);
        } catch (Exception $e) {
            return back()->withErrors(['error' => "Произошла ошибка: " . $e->getMessage()]);
        }
    }

    public function updateKanbanId($request): JsonResponse|RedirectResponse
    {
        try {
            $task = KanbanTask::findOrFail($request->input('task_id'));
            $task->kanban_id = $request->input('kanban_id');
            $task->save();
            return response()->json(['success' => true]);
        } catch (Exception $e) {
            return back()->withErrors(['error' => "Произошла ошибка: " . $e->getMessage()]);
        }
    }

    public function taskIndexRedirect(): RedirectResponse
    {
//        $user = Auth::user();
//        $roleData = $this->rolesRoutingService->getRoleData($user);
//        return redirect()->route($roleData['roleData']['tasks_index']);

        return redirect()->back()->with('reload', true);
    }
}

