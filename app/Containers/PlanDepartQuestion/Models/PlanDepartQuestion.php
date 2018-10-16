<?php

namespace App\Containers\PlanDepartQuestion\Models;

use App\Containers\PlanDepart\Models\PlanDepart;
use App\Containers\QuestionDetail\Models\QuestionDetail;
use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class PlanDepartQuestion extends Model
{
    use RevisionableTrait;
    use SoftDeletes;

    public static function boot()
    {
        parent::boot();
    }

    protected $revisionEnabled = true;
    protected $revisionCreationsEnabled = true;
    protected $revisionNullString = 'nothing';
    protected $revisionUnknownString = 'unknown';
    protected $dontKeepRevisionOf = array(
        'plan_depart_id',
        'client_answer_editer',
        'confirm_editer',
        'conclusion_editer',
        'auditer',
    );

    protected $fillable = [
        'answers',
        'question',
        'plan_depart_id',
        'status',
        'client_answer',
        'client_answer_editer',
        'more_files',
        'confirm_text',
        'confirm_editer',
        'confirm_at',
        'conclusion',
        'conclusion_status',
        'conclusion_at',
        'conclusion_editer',
        'auditer',
        'audit_text',
        'deleted_at',
        'audit_at',
    ];

    protected $attributes = [

    ];

    protected $hidden = [

    ];

    protected $casts = [
        'answers'    => 'array',
        'more_files' => 'array',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'confirm_at',
        'audit_at',
        'conclusion_at',
    ];

    /**
     * A resource key to be used by the the JSON API Serializer responses.
     */
    protected $resourceKey = 'plan_depart_questions';

    /*问题部门*/
    public function plan_depart()
    {
        return $this->belongsTo(PlanDepart::class);
    }

    /*进一步提问*/
    public function question_details()
    {
        return $this->hasMany(QuestionDetail::class);
    }
}
