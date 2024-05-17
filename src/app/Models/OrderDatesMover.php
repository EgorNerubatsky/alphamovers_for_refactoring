<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * @method static where(string $string, true $true)
 * @method static whereHas(string $string, \Closure $param)
 * @method static findOrFail($id)
 * @method static whereIn(string $string, array $array)
 */
class OrderDatesMover extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_id',
        'user_mover_id',
        'bonus',
        'paid',
        'is_brigadier',
        'is_empty',
    ];

    public function order(){
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function mover(){
        return $this->belongsTo(Mover::class, 'user_mover_id');
    }

    public function getExistingMoversForOrder($orderId, $userMoverId)
    {
        return OrderDatesMover::where('order_id', $orderId)
            ->where('user_mover_id', $userMoverId)
            ->first();

    }

    public function createOrderDatesMover($id, $userMoverId, $isBrigadier, $isBusy): void
    {
        $ordersDatesMovers = new OrderDatesMover([
            'order_id' => $id,
            'user_mover_id' => $userMoverId,
            'is_brigadier' => $isBrigadier,
            'is_empty' => $isBusy,
        ]);
        $ordersDatesMovers->save();
    }

}
