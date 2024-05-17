<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * @method static create(int[] $array)
 * @property mixed $client_base_id
 */
class ClientContact extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_base_id',
    ];
    public function clientBase(): BelongsTo
    {
        return $this->belongsTo(ClientBase::class);
    }

    public function clientContactPersonDetails(): HasMany
    {
        return $this->hasMany(ClientContactPersonDetail::class);
    }

//    public function createClientContactFromLead($newClient): ClientContact
//    {
//        $clientOrder = new ClientContact();
//        $clientOrder->client_base_id = $newClient->id;
//        $clientOrder->save();
//        return $clientOrder;
//    }
}
