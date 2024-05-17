<?php

namespace App\Models;

use App\Http\Requests\IntervieweeFormRequest;
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
 * @method static findOrFail($id)
 * @property mixed $birth_date
 * @property int|mixed $age
 */
class Interviewee extends Model
{
    use HasFactory, SoftDeletes, FormAccessible, HasApiTokens, Notifiable;

    protected $fillable = [
        'call_date',
        'interview_date',
        'fullname',
        'birth_date',
        'gender',
        'address',
        'phone',
        'email',
        'position',
        'comment',
    ];


    public function candidatesFiles(): HasMany
    {
        return $this->hasMany(CandidatesFile::class, 'interviewee_id');
    }

    public function intervieweeCreate($applicant): Interviewee
    {
        $interviewee = new Interviewee([
            'fullname' => $applicant->fullname,
            'birth_date'=> $applicant->birth_date,
            'phone' => $applicant->phone,
            'position' => $applicant->desired_position,
            'comment' => $applicant->comment,
        ]);
        $interviewee->save();
        return $interviewee;
    }

    public function intervieweesUpdate(IntervieweeFormRequest $request, $interviewee)
    {
        $intervieweeFullname = $request->input('fullname_surname') . ' ' . $request->input('fullname_name') . ' ' . $request->input('fullname_patronymic');

        $interviewee->update([
            'call_date' => $request->input('call_date'),
            'interview_date' => $request->input('interview_date'),
            'fullname' => $intervieweeFullname,
            'birth_date' => $request->input('birth_date'),
            'gender' => $request->input('gender'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'position' => $request->input('position'),
            'comment' => $request->input('comment'),
        ]);

        $interviewee->save();

        return $interviewee;
    }

    public function search(SearchRequest $request)
    {
        $search = $request->search;
        return Interviewee::where('fullname', 'like', "%$search%")
            ->orWhere('phone', 'like', "%$search%")
            ->orWhere('email', 'like', "%$search%")
            ->orWhere('address', 'like', "%$search%")
            ->orWhere('position', 'like', "%$search%")
            ->orWhere('gender', 'like', "%$search%")
            ->orWhere('comment', 'like', "%$search%");
    }

    public function applyIntervieweeStartCallDateFilters(Builder $intervieweesQuery, $startDate): void
    {
        $intervieweesQuery->when($startDate, function ($query, $startCallDate) {
            return $query->where('call_date', '>=', $startCallDate);
        });
    }

    public function applyIntervieweeEndCallDateFilters(Builder $intervieweesQuery, $endDate): void
    {
        $intervieweesQuery->when($endDate, function ($query, $endCallDate) {
            return $query->where('call_date', '<=', $endCallDate);
        });
    }

    public function applyIntervieweeStartInterviewDateFilters(Builder $intervieweesQuery, $startDate): void
    {
        $intervieweesQuery->when($startDate, function ($query, $startInterviewDate) {
            return $query->where('interview_date', '>=', $startInterviewDate);
        });
    }

    public function applyIntervieweeEndInterviewDateFilters(Builder $intervieweesQuery, $endDate): void
    {
        $intervieweesQuery->when($endDate, function ($query, $endInterviewDate) {
            return $query->where('interview_date', '<=', $endInterviewDate);
        });
    }

    public function applyIntervieweeFullnameFilters(Builder $intervieweesQuery, $fullname): void
    {
        $intervieweesQuery->when($fullname, function ($query, $intervieweeFullname) {
            return $query->where('fullname', $intervieweeFullname);
        });
    }

    public function applyIntervieweePositionFilters(Builder $intervieweesQuery, $position): void
    {
        $intervieweesQuery->when($position, function ($query, $intervieweePosition) {
            return $query->where('position', $intervieweePosition);
        });
    }

    public function applyIntervieweeStartAgeFilters(Builder $intervieweesQuery, $startAge): void
    {
        $intervieweesQuery->when($startAge, function ($query, $intervieweeStartAge) {
            return $query->where('age', '>=', $intervieweeStartAge);
        });
    }

    public function applyIntervieweeEndAgeFilters(Builder $intervieweesQuery, $endAge): void
    {
        $intervieweesQuery->when($endAge, function ($query, $intervieweeEndAge) {
            return $query->where('age', '<=', $intervieweeEndAge);
        });
    }

    public function deleteInterviewee($interviewee): void
    {
        $interviewee->delete();
        $interviewee->save();
    }


}
