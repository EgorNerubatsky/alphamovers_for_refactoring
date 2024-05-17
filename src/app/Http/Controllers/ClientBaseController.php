<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Http\Requests\ClientCommentRequest;
use App\Http\Requests\OrderFilesRequest;
use App\Http\Resources\Clients\ClientCommentResource;
use App\Http\Resources\Clients\ClientResource;
use App\Http\Resources\Orders\OrderResource;
use App\Models\ClientBase;
use App\Models\Order;
use App\Services\ClientBaseControllerService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ClientCreateFormRequest;
use App\Http\Requests\ClientUpdateFormRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;


class ClientBaseController extends Controller
{
    private ClientBaseControllerService $clientBaseControllerService;

    public function __construct(ClientBaseControllerService $clientBaseControllerService)
    {
        $this->clientBaseControllerService = $clientBaseControllerService;
    }

    public function index(Request $request): \Illuminate\Foundation\Application|Factory|View|JsonResponse|AnonymousResourceCollection|Application
    {
        $clientQuery = $this->clientBaseControllerService->clientsDateFilters($request);
        $clients = ClientBase::all();
        if (request()->expectsJson()) {
            return ClientResource::collection($clients);
        }

        return $this->clientBaseControllerService->clientIndexView($clientQuery);
    }

    public function search(SearchRequest $request): \Illuminate\Foundation\Application|Factory|View|JsonResponse|Application|RedirectResponse
    {
        try {
            $clientsQuery = $this->clientBaseControllerService->clientsSearch($request);
            return $this->clientBaseControllerService->clientIndexView($clientsQuery);
        } catch (Exception $e) {
            return back()->withErrors(['error' => "Произошла ошибка: " . $e->getMessage()]);
        }
    }

    public function edit(ClientBase $clientBase): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return $this->clientBaseControllerService->clientEdit($clientBase);
    }

    public function update(ClientUpdateFormRequest $request, ClientBase $clientBase): JsonResponse|RedirectResponse
    {
        try {
//            dd($request);
//            return response()->json([
//                "data2" =>$client,
//            ]);

            $this->clientBaseControllerService->clientUpdate($request, $clientBase);
//            $client = $client->fresh();
//            $id = $clientBase->clientContactPersonDetails()->client_base_id;
//            dd($clientBase);

            if (request()->expectsJson()) {
                return $this->clientBaseControllerService->returnClientJson($clientBase);
//                return response()->json([
//                    'data' => ClientResource::make($clientBase),
//                ]);
            }

            return $this->clientBaseControllerService->clientIndexRedirect();
//            return redirect()->back()->with('reload', true);

        } catch (Exception $e) {
            return back()->withErrors(['error' => "Произошла ошибка: " . $e->getMessage()]);
        }
    }

    public function create(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return $this->clientBaseControllerService->clientCreate();
    }


    public function store(ClientCreateFormRequest $request): JsonResponse|RedirectResponse
    {
        try {
            $client = $this->clientBaseControllerService->clientStore($request);

            if (request()->expectsJson()) {
                return $this->clientBaseControllerService->clientJson($client);
            }
            return $this->clientBaseControllerService->clientIndexRedirect();

        } catch (Exception $e) {
            return back()->withErrors(['error' => "Произошла ошибка: " . $e->getMessage()]);
        }
    }

    public function show(ClientBase $clientBase): ClientResource
    {
        return ClientResource::make($clientBase);
    }

    public function destroy(ClientBase $clientBase): JsonResponse|RedirectResponse
    {

        $this->clientBaseControllerService->clientDelete($clientBase);

        if(request()->expectsJson()){
            return response()->json([
                'message'=>'done',
            ]);
        }

        return redirect()->back()->with('reload', true);
    }

    public function clientContactDelete($id): RedirectResponse
    {
        return $this->clientBaseControllerService->contactDelete($id);
    }


    public function addComment(ClientCommentRequest $request, $id): JsonResponse|RedirectResponse
    {
//        $user = Auth::user();

        $changesHistory = $this->clientBaseControllerService->clientAddComment($request, $id);
        if(request()->expectsJson()){
            return response()->json([
                'data'=>ClientCommentResource::make($changesHistory),
            ]);
        }
//        return $this->clientBaseControllerService->clientEditRedirect($user, $id);
        return redirect()->back()->with('reload', true);


    }

    public function getClientContactInfo(Request $request): JsonResponse
    {
        return $this->clientBaseControllerService->clientContactInfo($request);
    }

    public function addFiles(OrderFilesRequest $request, $id): RedirectResponse
    {
        return $this->clientBaseControllerService->clientAddFiles($request, $id);
    }

    public function deleteFile(int $id): RedirectResponse
    {
        return $this->clientBaseControllerService->clientDeleteFile($id);
    }

    public function checkCompanyExists(Request $request): JsonResponse
    {
        return $this->clientBaseControllerService->checkCompany($request);

    }

    public function checkClientExists(Request $request): JsonResponse
    {
        return $this->clientBaseControllerService->checkClient($request);

    }
}
