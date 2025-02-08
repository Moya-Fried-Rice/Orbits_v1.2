<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FacultyCourse extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'faculty_courses';
    protected $primaryKey = 'faculty_course_id';
    public $timestamps = false;

    protected $fillable = [
        'faculty_id',
        'course_section_id',
    ];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id');
    }

    public function courseSection()
    {
        return $this->belongsTo(CourseSection::class, 'course_section_id');
    }

    protected static function booted()
    {
        // Automatically handle evaluations on create, update, and restore
        static::created(fn ($facultyCourse) => self::handleFacultyCourseChanges($facultyCourse));
        static::updated(fn ($facultyCourse) => self::handleFacultyCourseChanges($facultyCourse));
        static::restored(fn ($facultyCourse) => self::handleFacultyCourseChanges($facultyCourse));

        // Delete related evaluations when a FacultyCourse is deleted
        static::deleted(fn ($facultyCourse) => Evaluation::where('course_section_id', $facultyCourse->course_section_id)->delete());
    }

    /**
     * Handles evaluations when a FacultyCourse is created, updated, or restored.
     */
    private static function handleFacultyCourseChanges($facultyCourse)
    {
        // Ensure evaluations exist for this faculty course
        $surveys = Survey::all();
        foreach ($surveys as $survey) {
            Evaluation::firstOrCreate([
                'course_section_id' => $facultyCourse->course_section_id,
                'survey_id' => $survey->survey_id,
            ]);
        }

        self::assignEvaluationsToUsers($facultyCourse);
    }

    /**
     * Assigns evaluations to the appropriate users (Self and Program Chair).
     */
    private static function assignEvaluationsToUsers($facultyCourse)
    {
        $evaluations = Evaluation::whereHas('survey.surveyRoles', fn ($query) => 
            $query->whereIn('role_id', [2, 3])
        )->where('course_section_id', $facultyCourse->course_section_id)
        ->get();

        foreach ($evaluations as $evaluation) {
            $roleIds = $evaluation->survey->surveyRoles->pluck('role_id')->toArray();

            // Assign self-evaluation
            if (in_array(2, $roleIds)) {
                self::createUserEvaluation($evaluation->evaluation_id, $facultyCourse->faculty->user_id ?? null);
            }

            // Assign program chair evaluation
            if (in_array(3, $roleIds)) {
                $programChair = User::whereHas('programChair', fn ($query) => 
                    $query->where('department_id', $facultyCourse->faculty->department_id)
                )->whereHas('role', fn ($query) => 
                    $query->where('role_id', 3)
                )->first();

                self::createUserEvaluation($evaluation->evaluation_id, $programChair->user_id ?? null);
            }
        }
    }

    /**
     * Creates or updates a UserEvaluation.
     */
    private static function createUserEvaluation($evaluationId, $userId)
    {
        if ($userId) {
            UserEvaluation::updateOrCreate(
                ['evaluation_id' => $evaluationId, 'user_id' => $userId],
                ['is_completed' => false, 'evaluated_at' => null]
            );
        }
    }
}
