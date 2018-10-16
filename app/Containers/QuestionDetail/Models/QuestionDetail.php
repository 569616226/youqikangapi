<?php

namespace App\Containers\QuestionDetail\Models;

use App\Containers\PlanDepartQuestion\Models\PlanDepartQuestion;
use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class QuestionDetail extends Model
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
        'plan_depart_question_id',
    );

    protected $fillable = [
        'question',
        'answer',
        'plan_depart_question_id',
        'deleted_at',
    ];

    protected $attributes = [

    ];

    protected $hidden = [

    ];

    protected $casts = [

    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * A resource key to be used by the the JSON API Serializer responses.
     */
    protected $resourceKey = 'question_details';

    /*方案问题*/
    public function plan_depart_question()
    {
        return $this->belongsTo(PlanDepartQuestion::class);
    }
}
