<?php

namespace App\Models;

use App\Http\Requests\LeadFormRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * @method static pluck(string $string, string $string1)
 * @method static truncate()
 * @method static find(mixed $testLeadId)
 * @method static create(int[] $array)
 * @method static paginate(int $int)
 * @method static whereIn(string $string, mixed $selectedLeads)
 * @property mixed|string $status
 * @property mixed $id
 */
class Lead extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    use FormAccessible, SoftDeletes;

    protected $fillable = [
        'company',
        'fullname',
        'phone',
        'email',
        'comment',
        'status'

    ];

    public function documentsPaths(): HasMany
    {
        return $this->hasMany(DocumentsPath::class, 'lead_id');
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

    public function leadSearch($search){
        return Lead::where('fullname', 'like', "%$search%")
            ->orWhere('phone', 'like', "%$search%")
            ->orWhere('email', 'like', "%$search%")
            ->orWhere('comment', 'like', "%$search%")
            ->orWhere('company', 'like', "%$search%");
    }

    public function applyStatusFilter(Builder $query, $status): void
    {
        if ($status) {
            $query->where('status', $status);
        }
    }

    public function leadUpdate(LeadFormRequest $request,Lead $lead): Lead
    {

        $lead->update([
            'company' => $request->input('company'),
            'fullname' => $request->input('fullname'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'comment' => $request->input('comment'),
            'status' => $request->input('status'),
        ]);
        $lead->save();

        return $lead;
    }

    public function deleteLead($lead): void
    {
        $lead->status = 'удален';
        $lead->save();
        $lead->delete();
    }

    public function createLead(LeadFormRequest $request)
    {
        return Lead::create($request->all());
    }

}
