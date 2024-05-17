<?php

namespace App\Models;

use App\Http\Requests\SearchRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static where(string $string, string $string1, string $string2)
 * @method static create(array $array)
 */
class Arrear extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    use FormAccessible, SoftDeletes;

    protected $fillable =[
        'client_id',
        'order_id',
        'work_debt',
        'days_from_order',
        'current_year_revenue',
        'total_revenue',
        'contract_date',
        'comment',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(ClientBase::class, 'client_id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function createArrear(Order $order): void
    {
        $orders = Order::query();
        $arrear = new Arrear([
            'client_id' => $order->client->id,
            'order_id' => $order->id,
            'work_debt' => $order->total_price,
            'current_year_revenue' => $orders->where('client_id', $order->client->id)->whereYear('created_at', now()->year)->sum('total_price'),
            'total_revenue' => $orders->where('client_id', $order->client->id)->sum('total_price'),
            'contract_date' => $order->created_at,
            'comment' => 'Замовлення завершано, рахунок не оплачено замовником',
        ]);
        $arrear->save();
    }

    public function search(SearchRequest $request)
    {

        $search = $request->search;

        return Arrear::where('contract_date', 'like', "%$search%")
            ->orWhere('comment', 'like', "%$search%")
            ->orWhereHas('client', function ($query) use ($search) {
                $query->where('company', 'like', "%$search%")
                    ->orWhere('director_name', 'like', "%$search%");
            })
            ->orWhereHas('order', function ($query) use ($search) {
                $query->where('city', 'like', "%$search%")
                    ->orWhere('service_type', 'like', "%$search%");
            });
    }

    public function applyArrearStartDateFilters(Builder $arrearQuery, $startDate, $endDate): void
    {
        if ($startDate && !$endDate) {
            $arrearQuery->where('contract_date', '>=', $startDate);
        }
    }

    public function applyArrearEndDateFilters(Builder $arrearQuery, $startDate, $endDate): void
    {
        if (!$startDate && $endDate) {
            $arrearQuery->where('contract_date', '<=', $endDate);
        }
    }

    public function applyArrearStartAndEndDateFilters(Builder $arrearQuery, $startDate, $endDate): void
    {
        if ($startDate && $endDate) {
            $arrearQuery->whereBetween('contract_date', [$startDate,$endDate]);
        }
    }

    public function applyArrearTypeFilters(Builder $arrearQuery, $type): void
    {
        if ($type) {
            $arrearQuery->whereHas('client', function ($query) use ($type) {
                $query->where('type', $type);
            });
        }
    }

    public function applyArrearCompanyFilters(Builder $arrearQuery, $company): void
    {
        if ($company) {
            $arrearQuery->whereHas('client', function ($query) use ($company) {
                $query->where('company', $company);
            });
        }
    }

    public function applyArrearAmountFromFilters(Builder $arrearQuery, $amountFrom, $amountTo): void
    {
        if ($amountFrom && !$amountTo) {
            $arrearQuery->where('work_debt', '>=', $amountFrom);
        }
    }
    public function applyArrearAmountToFilters(Builder $arrearQuery, $amountFrom, $amountTo): void
    {
        if (!$amountFrom && $amountTo) {
            $arrearQuery->where('work_debt', '<=', $amountTo);
        }
    }

    public function applyArrearAmountToAndFromFilters(Builder $arrearQuery, $amountFrom, $amountTo): void
    {
        if ($amountFrom && $amountTo) {
            $arrearQuery->whereBetween('work_debt', [$amountFrom, $amountTo]);
        }
    }
}
