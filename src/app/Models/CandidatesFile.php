<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * @method static where(string $string, $id)
 */
class CandidatesFile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'applicant_id',
        'interviewee_id',
        'path',
        'description',
    ];

    public function applicant(): BelongsTo
    {
        return $this->belongsTo(Applicant::class, 'applicant_id');
    }

    public function interviewee(): BelongsTo
    {
        return $this->belongsTo(Interviewee::class, 'interviewee_id');
    }

    public function createCandidatesFile($path, $applicant, $description, $field): void
    {
        $candidatesFile = new CandidatesFile([
            $field => $applicant->id,
            'path' => $path,
            'description' => $description,
        ]);
        $candidatesFile->save();
    }

    public function applicantToInterviewee($applicant,$interviewee): void
    {
        foreach ($applicant->candidatesFiles as $candidateFile) {
            $description = '';
            if ($candidateFile->description == 'Фото кандидата') {
                $description = 'Фото претендента';
            } elseif ($candidateFile->description == 'Документ кандидата') {
                $description = 'Документ претендента';
            }

            $newCandidateFile = new CandidatesFile([
                'interviewee_id' => $interviewee->id,
                'path' => $candidateFile->path,
                'description' => $description,
            ]);

            $newCandidateFile->save();

            $candidateFile->delete();
        }

    }


}
