<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


/**
 * @method static create(array $array)
 * @method static where(string $string, $id)
 * @method static whereIn(string $string, array $array)
 * @method static find(mixed $client_base_id)
 * @method static findOrFail($id)
 * @property mixed $complete_name
 * @property mixed $client_phone
 * @property mixed $email
 * @property mixed $client_contact_id
 * @property mixed $client_base_id
 */
class ClientContactPersonDetail extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    use FormAccessible, SoftDeletes;

    protected $fillable = [
        'client_base_id',
        'complete_name',
        'position',
        'client_phone',
        'complete_name',
        'email',
    ];


    public function clientBase(): BelongsTo
    {
        return $this->belongsTo(ClientBase::class);
    }

    public function createClientContactPersonDetail($fullname, $phone, $position, $email, $client): void
    {
        $clientContactPersonDetail = new ClientContactPersonDetail([
            'client_base_id' => $client->id,
            'position' => $position ?? null,

            'complete_name' => $fullname,
            'client_phone' => $phone,
            'email' => $email,
        ]);

        $clientContactPersonDetail->save();
    }


    public function updateClientContactPersonDetail($client, $completeName, $position, $clientPhone, $email)
    {
        $client->update([
            'complete_name' => $completeName,
            'position' => $position,
            'client_phone' => $clientPhone,
            'email' => $email,
        ]);
        $client->save();
        return $client;
    }


//    public function clientContactId($search): array
//    {
//        $clientNames = ClientContactPersonDetail::where('complete_name', 'like', "%$search%")->get();
//        $clientContactId = [];
//        foreach ($clientNames as $clientName) {
//            $clientContactId[] = $clientName->client_contact_id;
//        }
//        return $clientContactId;
//    }
//
//    public function clientPhoneId($search): array
//    {
//        $clientPhones = ClientContactPersonDetail::where('client_phone', 'like', "%$search%")->get();
//        $clientPhoneId = [];
//        foreach ($clientPhones as $clientPhone) {
//            $clientPhoneId[] = $clientPhone->client_contact_id;
//        }
//        return $clientPhoneId;
//    }


}
