<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static whereIn(string $string, array $array)
 */
class ChangesHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'client_id',
        'client_contact_id',
        'old_value',
        'new_value',
        'user_id',
        'reason',

    ];

    public function changeHistory($orderId, $clientId, $oldValue, $newValue,$reason,$user): ChangesHistory
    {
        $changesHistory = new ChangesHistory([
            'order_id'=>$orderId,
            'client_id' => $clientId,
            'old_value' => $oldValue ?? null,
            'new_value' => $newValue ?? null,
            'user_id' => $user->id,
            'reason' => $reason,
        ]);
        $changesHistory->save();

        return $changesHistory;
    }
}
