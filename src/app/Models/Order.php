<?php

namespace App\Models;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * @method static whereNotNull(string $string)
 * @method static pluck(string $string)
 * @method static create(array $array)
 * @method static first()
 * @method static find(mixed $searchOrderResult)
 * @method static findOrFail($id)
 * @method static whereIn(string $string, string $string1)
 * @property mixed $id
 * @property mixed|string $status
 * @property mixed|null $user_manager_id
 * @property mixed $client_id
 * @property mixed $client
 * @property mixed $total_price
 * @property mixed $created_at
 * @property mixed $documentsPaths
 * @property mixed $review
 * @property mixed|string $order_source
 */
class Order extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    use FormAccessible, SoftDeletes;

    protected $fillable = [

        'client_id',
        'execution_date',
        'review',
        'status',
        'order_source',
        'payment_form',
        'number_of_workers',
        'city',
        'street',
        'house',
        'service_type',
        'task_description',
        'straps',
        'tools',
        'respirators',
        'transport',
        'price_to_customer',
        'price_to_workers',
        'min_order_amount',
        'min_order_hrs',
        'order_hrs',
        'total_price',
        'payment_note',
        'user_manager_id',
        'user_logist_id',
        'user_brigadier_id',

    ];
    // public function orderfiles()
    // {
    //     return $this->belongsTo(ClientContact::class, 'client_id');
    // }

    public function documentsPaths(): HasMany
    {
        return $this->hasMany(DocumentsPath::class, 'order_id');
    }

    public function bankOperations(): HasMany
    {
        return $this->hasMany(BankOperation::class, 'order_id');
    }
    // public function orderDetails()
    // {
    //     return $this->hasOne(OrderDetail::class);
    // }

    public function client(): BelongsTo
    {
        return $this->belongsTo(ClientBase::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_manager_id');
    }

    // public function bankOperations(){
    //     return $this->hasMany(BankOperation::class, 'order_date_id');
    // }

    // public function documentPaths(){
    //     return $this->hasMany(DocumentsPath::class, 'order_date_id');
    // }

    public function orderDatesMovers(): HasMany
    {
        return $this->hasMany(OrderDatesMover::class, 'order_id');
    }

    public function arrear(): HasMany
    {
        return $this->hasMany(Arrear::class, 'order_id');
    }

    public function applyCreatedAtFilters(Builder $query, $startDate, $endDate): void
    {
        if ($startDate && !$endDate) {
            $query->where('created_at', '>=', $startDate);
        } elseif (!$startDate && $endDate) {
            $query->where('created_at', '<=', $endDate);
        } elseif ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }
    }

    public function applyExecutionDateFilters(Builder $query, $startExecDate, $endExecDate): void
    {
        if ($startExecDate && !$endExecDate) {
            $query->where('execution_date', '>=', $startExecDate);
        } elseif (!$startExecDate && $endExecDate) {
            $query->where('execution_date', '<=', $endExecDate);
        } elseif ($startExecDate && $endExecDate) {
            $query->whereBetween('execution_date', [$startExecDate, $endExecDate]);
        }
    }

    public function applyMoverFilter(Builder $query, $relationship, $value): void
    {
        if ($value) {
            $query->whereHas('orderDatesMovers', function ($subQuery) use ($relationship, $value) {
                $subQuery->where('user_mover_id', $value);
            });
        }
    }

    public function applyManagerFilter(Builder $query, $manager): void
    {
        if ($manager) {
            $query->where('user_manager_id', $manager);
        }
    }

    public function applyStatusFilter(Builder $query, $status): void
    {
        if ($status) {
            $query->where('status', $status);
        }
    }

    public function applyAmountFilters(Builder $query, $amountFrom, $amountTo): void
    {
        if ($amountFrom && !$amountTo) {
            $query->where('total_price', '>=', $amountFrom);
        } elseif (!$amountFrom && $amountTo) {
            $query->where('total_price', '<=', $amountTo);
        } elseif ($amountFrom && $amountTo) {
            $query->whereBetween('total_price', [$amountFrom, $amountTo]);
        }
    }

    public function orderCreationFromLead($lead): Order
    {
        $order =  new Order([
            'review' => $lead->comment,
            'status' => 'Попереднє замовлення',
            'order_source' => 'Активні продажі',
        ]);
        $order->save();
        return $order;


    }

    public function updateOrder($order, $data): void
    {
        $order->update([
        'client_id' => $data->id,
        'execution_date' => $data->execution_date ?? null,
        ]);
    }

    public function updateStatus($order, $status): void
    {
        $order->update([
            'status' => $status,
        ]);
    }

        public function searchOrder($search)
    {
        return Order::where(function ($query) use ($search) {
            $query->where('city', 'like', "%$search%")
                ->orWhere('street', 'like', "%$search%")
                ->orWhere('house', 'like', "%$search%")
                ->orWhere('review', 'like', "%$search%")
                ->orWhere('service_type', 'like', "%$search%")
                ->orWhere('user_brigadier_id', 'like', "%$search%")
                ->orWhere('payment_note', 'like', "%$search%");
        })
            ->orWhereHas('client.clientContactPersonDetails', function ($query) use ($search) {
                $query->where('complete_name', 'like', "%$search%")
                    ->orWhere('client_phone', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            })
            ->orWhereHas('client', function ($query) use ($search) {
                $query->where('company', 'like', "%$search%");
            });
//            ->paginate(20);
    }
}
