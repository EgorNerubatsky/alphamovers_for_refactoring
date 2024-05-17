<?php

namespace App\Models;

use App\Http\Requests\ApplicantFormRequest;
use App\Http\Requests\SearchRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Collective\Html\Eloquent\FormAccessible;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;


/**
 * @method static create(array $array)
 * @method static findOrFail($id)
 */
class Applicant extends Model
{
    use HasFactory, SoftDeletes, FormAccessible, HasApiTokens, Notifiable;

    protected $fillable = [
        'fullname',
        'phone',
        'birth_date',

        'desired_position',
        'comment',
    ];

    public function candidatesFiles(): HasMany
    {
        return $this->hasMany(CandidatesFile::class, 'applicant_id');
    }

    public function search(SearchRequest $request)
    {
        $search = $request->search;
        return Applicant::where('fullname', 'like', "%$search%")
            ->orWhere('phone', 'like', "%$search%")
            ->orWhere('desired_position', 'like', "%$search%")
            ->orWhere('comment', 'like', "%$search%");
    }

    public function applyApplicantStartDateFilters(Builder $applicantQuery, $date): void
    {
        $applicantQuery->when($date, function ($query, $startDate) {
            return $query->where('created_at', '>=', $startDate);
        });
    }

    public function applyApplicantEndDateFilters(Builder $applicantQuery, $date): void
    {
        $applicantQuery->when($date, function ($query, $endDate) {
            return $query->where('created_at', '<=', $endDate);
        });
    }

    public function applyApplicantPhoneFilters(Builder $applicantQuery, $date): void
    {
        $applicantQuery->when($date, function ($query, $applicantPhone) {
            return $query->where('phone', $applicantPhone);
        });
    }

    public function applyApplicantFullnameFilters(Builder $applicantQuery, $date): void
    {
        if ($date) {
            $applicantQuery->where('fullname', $date);
        }
    }

    public function applyApplicantDesiredPositionFilters(Builder $applicantQuery, $date): void
    {
        $applicantQuery->when($date, function ($query, $applicantDesiredPosition) {
            return $query->where('desired_position', $applicantDesiredPosition);
        });
    }


    public function updateApplicant(ApplicantFormRequest $request, $applicant)
    {
        $applicantFullname = $request->fullname_surname . ' ' . $request->fullname_name . ' ' . $request->fullname_patronymic;
        $applicant->update([
            'fullname' => $applicantFullname,
            'phone' => $request->input('phone'),
            'desired_position' => $request->input('desired_position'),
            'comment' => $request->input('comment'),
        ]);
        $applicant->save();

        return $applicant;
    }

    public function createApplicant(ApplicantFormRequest $request)
    {
        $applicantFullname = $request->fullname_surname . ' ' . $request->fullname_name . ' ' . $request->fullname_patronymic;

        return Applicant::create([
            'fullname' => $applicantFullname,
            'phone' => $request->phone,
            'desired_position' => $request->desired_position,
            'comment' => $request->comment,
        ]);
    }


}
