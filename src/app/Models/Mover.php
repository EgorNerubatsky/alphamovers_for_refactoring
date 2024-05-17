<?php

namespace App\Models;

use App\Http\Requests\MoverFormRequest;
use App\Http\Requests\SearchRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;


/**
 * @method static findOrFail($id)
 * @method static create(array $all)
 */
class Mover extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    use FormAccessible, SoftDeletes;

    protected $fillable = [
        'name',
        'lastname',
        'email',
        'phone',
        'address',
        'birth_date',
        'gender',
        'photo_path',
        'bank_card',
        'passport_number',
        'passport_series',
        'advantages',
        'note',
    ];

    public function orderDatesMovers(): HasMany
    {
        return $this->hasMany(OrderDatesMover::class, 'user_mover_id');
    }

    public function applyMoverFilters(Builder $query, $mover): void
    {
        if ($mover) {
            $query->where('id', $mover);
        }
    }

    public function applyMoverPhoneFilters(Builder $query, $phone): void
    {
        if ($phone) {
            $query->where('phone', $phone);
        }
    }

    public function applyMoverNoteFilters(Builder $query, $note): void
    {
        if ($note) {
            $query->where('note', $note);
        }
    }

    public function applyMoverAdvantagesFilters(Builder $query, $advantages): void
    {
        $advantages = urldecode($advantages);
        $query->where('advantages', 'like', '%' . $advantages . '%');
    }

    public function searchMover(SearchRequest $request)
    {
        $search = $request->search;

        return Mover::where('phone', 'like', "%$search%")->orWhere('note', 'like', "%$search%")
            ->orWhere('birth_date', 'like', "%$search%")
            ->orWhere('name', 'like', "%$search%")
            ->orWhere('lastname', 'like', "%$search%")
            ->orWhere('phone', 'like', "%$search%")
            ->orWhere('email', 'like', "%$search%")
            ->orWhere('address', 'like', "%$search%")
            ->orWhere('note', 'like', "%$search%")
            ->orWhere('advantages', 'like', "%$search%");

    }


    public function updateMover(MoverFormRequest $request, $mover): void
    {
        $mover->update($request->all());
    }

    public function createMover(MoverFormRequest $request)
    {
        $mover = Mover::create($request->all());
        $mover->save();
        return $mover;
    }

    public function deleteMover($id): void
    {
        $mover = Mover::findOrFail($id);
        $mover->delete();
    }

    public function addMoverBonus($request, $id): void
    {
        $mover = OrderDatesMover::findOrFail($id);
        $mover->bonus = $request->input('bonus');
        $mover->save();
    }

    public function addMoverPaid($id): void
    {
        $mover = OrderDatesMover::findOrFail($id);
        $mover->paid = true;
        $mover->save();
    }

    public function moverUpdatePhotoPath($path, $mover): void
    {
        $mover->update([
            'photo_path' => $path,
        ]);
    }


}
