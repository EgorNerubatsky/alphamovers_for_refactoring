<?php

namespace App\Http\Controllers;

use App\Http\Requests\KanbanTaskRequest;
use App\Http\Requests\KanbanStoreRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\UserTaskRequest;
use App\Models\KanbanTask;
use App\Services\TaskControllerService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use App\Http\Requests\TaskFormRequest;


class   UserTaskController extends Controller
{

    private TaskControllerService $taskControllerService;

    public function __construct(TaskControllerService $taskControllerService)
    {
        $this->taskControllerService = $taskControllerService;
    }

    public function index(Request $request): View|Factory|\Illuminate\Foundation\Application|JsonResponse|Application
    {
        $tasksQuery = $this->taskControllerService->taskDateFilters($request);
        return $this->taskControllerService->taskIndexView($tasksQuery);
    }

    public function search(SearchRequest $request): View|Factory|\Illuminate\Foundation\Application|JsonResponse|Application
    {
        $tasksQuery = $this->taskControllerService->taskSearch($request);
            return $this->taskControllerService->taskIndexView($tasksQuery);
    }


    public function remove(Request $request): RedirectResponse
    {
        try{
            $this->taskControllerService->taskRemove($request);
            return $this->taskControllerService->taskIndexRedirect();
        }catch (Exception $e){
            return back()->withErrors(['error' => "Произошла ошибка: " . $e->getMessage()]);
        }
    }


    public function store(TaskFormRequest $request): RedirectResponse
    {
        return $this->taskControllerService->taskStore($request);
    }

    public function update(UserTaskRequest $request): RedirectResponse
    {
        return $this->taskControllerService->taskUpdate($request);
    }

    public function storeKanban(KanbanStoreRequest $request): RedirectResponse
    {
        return $this->taskControllerService->taskKanbanStore($request);

    }

    public function updateKanban(KanbanStoreRequest $request): RedirectResponse
    {
        return $this->taskControllerService->taskKanbanUpdate($request);
    }

    public function deleteKanban($id): RedirectResponse
    {
        return $this->taskControllerService->taskKanbanDelete($id);
    }

    public function storeKanbanTask(KanbanTaskRequest $request): RedirectResponse
    {
        return $this->taskControllerService->taskStoreKanbanTask($request);
    }

    public function updateTaskColumn(Request $request): JsonResponse
    {
        return $this->taskControllerService->updateKanbanId($request);
    }

    public function updateKanbanTask(KanbanTaskRequest $request): RedirectResponse
    {
        return $this->taskControllerService->taskUpdateTask($request);

    }

    public function deleteKanbanTask($id): RedirectResponse
    {
        try{
            KanbanTask::findOrFail($id)->delete();
            return redirect()->back()->with('reload', true);
        }catch (Exception $e){
            return back()->withErrors(['error' => "Произошла ошибка: " . $e->getMessage()]);
        }
    }
}
