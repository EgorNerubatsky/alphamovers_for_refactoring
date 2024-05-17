<?php

namespace App\Models;

use App\Http\Requests\ClientCreateFormRequest;
use App\Http\Requests\ClientUpdateFormRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $array)
 * @method static find($client_id)
 * @method static first()
 * @method static findOrFail($client_id)
 * @method static pluck(string $string)
 * @method static distinct()
 * @method static select(string $string, string $string1, string $string2, string $string3, string $string4, string $string5, string $string6, string $string7, string $string8, string $string9)
 * @property mixed $company
 * @property mixed $clientContactPersonDetails
 * @property mixed $id
 */
class ClientBase extends Model
{
    use HasFactory, HasApiTokens, Notifiable, FormAccessible, SoftDeletes;


    protected $fillable = [
        'company',
        'type',
        'debt_ceiling',
        'identification_number',
        'code_of_the_reason_for_registration',
        'main_state_registration_number',
        'director_name',
        'contact_person_position',
        'acting_on_the_basis_of',
        'registered_address',
        'zip_code',
        'postal_address',
        'payment_account',
        'bank_name',
        'bank_identification_code',
    ];

    public function clientContactPersonDetails(): HasMany
    {
        return $this->hasMany(ClientContactPersonDetail::class);
    }

    public function documentsPaths(): HasMany
    {
        return $this->hasMany(DocumentsPath::class, 'client_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'client_id');
    }

    public function arrears(): HasMany
    {
        return $this->hasMany(Arrear::class, 'client_id');
    }

    public function createClientFromLead($lead): ClientBase
    {
        $newClient = new ClientBase();
        $newClient->company = $lead->company;
        $newClient->save();
        return $newClient;
    }

    public function createClient(ClientCreateFormRequest $request): ClientBase
    {
        return ClientBase::create($request->all());
    }

    public function applyClientStartDateFilters($clientQuery, $startDate): void
    {
        if ($startDate) {
            $clientQuery->where('date_of_contract', '>=', $startDate);
        }
    }

    public function applyClientEndDateFilters($clientQuery, $endDate): void
    {
        if ($endDate) {
            $clientQuery->where('date_of_contract', '<=', $endDate);
        }
    }

    public function applyClientCompanyFilters($clientQuery, $company): void
    {
        if ($company) {

            $clientQuery->where('company', $company);
        }
    }

    public function applyClientDirectorPositionFilters($clientQuery, $directorPosition): void
    {
        if ($directorPosition) {
            $clientQuery->where('contact_person_position', $directorPosition);
        }
    }

    public function applyClientTypeFilters($clientQuery, $clientType): void
    {
        if ($clientType) {
            $clientQuery->where('type', $clientType);
        }
    }

    public function applyClientContactPersonFilters($clientQuery, $contactPerson): void
    {
        if ($contactPerson) {
            $clientQuery->where('director_name', $contactPerson);
        }
    }

    public function search($request)
    {
        $search = $request->search;

        return self::where('company', 'like', "%$search%")
            ->orWhere('type', 'like', "%$search%")
            ->orWhere('postal_address', 'like', "%$search%")
            ->orWhere('debt_ceiling', 'like', "%$search%")
            ->orWhere('identification_number', 'like', "%$search%")
            ->orWhere('code_of_the_reason_for_registration', 'like', "%$search%")
            ->orWhere('main_state_registration_number', 'like', "%$search%")
            ->orWhere('director_name', 'like', "%$search%")
            ->orWhere('contact_person_position', 'like', "%$search%")
            ->orWhere('acting_on_the_basis_of', 'like', "%$search%")
            ->orWhere('registered_address', 'like', "%$search%")
            ->orWhere('zip_code', 'like', "%$search%")
            ->orWhere('payment_account', 'like', "%$search%")
            ->orWhere('bank_name', 'like', "%$search%")
            ->orWhere('bank_identification_code', 'like', "%$search%")
            ->orWhere(function ($query) use ($search) {
                $query->whereHas('clientContactPersonDetails', function ($subquery) use ($search) {
                    $subquery->where('client_phone', 'like', "%$search%")
                        ->orWhere('complete_name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%");
                });
            });
    }

    public function companys($clientsQuery): array
    {
        $companys = self::pluck('company')->unique();
        foreach ($clientsQuery as $client) {
            if (!in_array($client->company, $companys)) {
                $companys[] = $client->company;
            }
        }
        return $companys->toArray();
    }

    public function contactPersons(): array
    {
        $clientContacts = ClientContactPersonDetail::query()->get();

        $contactPersons = [];
        $clientNames = $clientContacts->pluck('complete_name');

        foreach ($clientNames as $name) {
            if (!in_array($name, $contactPersons)) {
                $contactPersons[] = $name;
            }
        }
        return $contactPersons;
    }

    public function contactPersonPositions($clientsQuery): array
    {
        $contactPersonPositions = [];
        foreach ($clientsQuery as $client) {
            if (!in_array($client->contact_person_position, $contactPersonPositions)) {
                $contactPersonPositions[] = $client->contact_person_position;
            }
        }
        return $contactPersonPositions;
    }

    public function clientBaseUpdate(ClientUpdateFormRequest $request, $clientBase)
    {
        $clientBase->update($request->all());
        $clientBase->save();
        return $clientBase;
    }
}
