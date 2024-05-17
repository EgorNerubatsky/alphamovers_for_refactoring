<?php

namespace App\Services;

use App\Http\Requests\MoverFormRequest;
use App\Http\Requests\SearchRequest;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Mover;
use Illuminate\Support\Facades\Auth;


class MoversControllerService extends Controller
{
    protected RolesRoutingService $rolesRoutingService;
    private Mover $moverModel;
    private User $userModel;
    private FilesActivityService $filesActivityModel;





    public function __construct(
        Mover $moverModel,
        User $userModel,
        RolesRoutingService $rolesRoutingService,
        FilesActivityService $filesActivityModel,

    )
    {

        $this->rolesRoutingService = $rolesRoutingService;
        $this->moverModel = $moverModel;
        $this->userModel = $userModel;
        $this->filesActivityModel = $filesActivityModel;
    }

    public function moverDateFilters(Request $request): Builder
    {
        $moversQuery = Mover::query();

        $this->moverModel->applyMoverFilters($moversQuery, $request->input('mover'));
        $this->moverModel->applyMoverPhoneFilters($moversQuery, $request->input('phone'));
        $this->moverModel->applyMoverNoteFilters($moversQuery, $request->input('note'));
        $this->moverModel->applyMoverAdvantagesFilters($moversQuery, $request->input('advantages'));

        $this->userModel->applyAgeFilters($moversQuery, $request->input('age_from'), $request->input('age_to'));
        $this->applySortAndOrder($moversQuery, $request->input('sort'), $request->input('order'));
        return $moversQuery;
    }

    public function applySortAndOrder(Builder $query, $sort, $order): void
    {
        if ($sort && $order) {
            $query->orderBy($sort, $order);
        }
    }


    public function moversSearch(SearchRequest $request)
    {
        return $this->moverModel->searchMover($request);
    }

    public function moverStore(MoverFormRequest $request): void
    {
        $mover = $this->moverModel->createMover($request);
        if ($request->hasFile('mover_photo')) {
            $this->moverStorePhoto($request, $mover);
        }
    }

    public function moverUpdate(MoverFormRequest $request, $mover): void
    {
        $this->moverModel->updateMover($request, $mover);
        if ($request->hasFile('mover_photo')) {
            $this->moverStorePhoto($request, $mover);
        }
    }
    public function moverStorePhoto($request, $mover): void
    {
            $path = $this->filesActivityModel->addFile($request, "mover_photo", "uploads/photos/movers/$mover->id/");
            $this->moverModel->moverUpdatePhotoPath($path, $mover);
    }

    public function moverIndexRedirect($user, $route): RedirectResponse
    {
        $roleData = $this->rolesRoutingService->getRoleData($user);
        return redirect()->route($roleData['roleData'][$route]);
    }



    public function moversIndexView($moversQuery): View|Application|Factory|JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        $user = Auth::user();
        $moversCategorys = $moversQuery->pluck('note')->unique();
        $moversAdvantages = $moversQuery->pluck('advantages')->unique();
        $moversDatas = $moversQuery->get();
        $movers = $moversQuery->paginate(10)->appends(request()->query());
        $roleData = $this->rolesRoutingService->getRoleData($user);

        if(request()->expectsJson()){
            return response()->json(compact('movers'));
        }

        return view('erp.parts.movers.index', compact('movers', 'moversDatas', 'moversCategorys', 'moversAdvantages', 'roleData'));

    }

    public function moversPlanningView($orderQuery, $user): View|Application|Factory|JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        if ($user->is_logist) {
            $orderQuery->where('user_logist_id', '=', $user->id);
        }
        $roleData = $this->rolesRoutingService->getRoleData($user);

        $orders = $orderQuery->paginate(10)->appends(request()->query());
        return view('erp.parts.movers.planning', compact('orders', 'roleData'));
    }

    public function moversPlanningSearch(SearchRequest $request)
    {
        $search = $request->input('search');
        $ordersSearch = Order::where('status', 'Виконано')->get();

        return $ordersSearch->where('city', 'like', "%$search%")
            ->orWhere('street', 'like', "%$search%")
            ->orWhere('house', 'like', "%$search%")
            ->orwhereHas('client', function ($query) use ($search) {
                $query->where('company', 'like', "%$search%");
            })
            ->orWhereHas('orderDatesMovers.mover', function ($query) use ($search) {
                $query->where('name', 'like', "%$search%");
            })
            ->orWhereHas('orderDatesMovers.mover', function ($query) use ($search) {
                $query->where('lastname', 'like', "%$search%");
            });
    }
}


