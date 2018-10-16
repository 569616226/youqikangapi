<?php

namespace App\Containers\PlanDepart\Models;

use App\Containers\Plan\Models\Plan;
use App\Containers\PlanDepartQuestion\Models\PlanDepartQuestion;
use App\Containers\QuestionDetail\Models\QuestionDetail;
use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class PlanDepart extends Model
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
    protected $KeepRevisionOf = array(
        'name',
        'icon',
        'deleted_at',
    );
    protected $fillable = [
        'name',
        'icon',
        'plan_id',
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
    protected $resourceKey = 'plan_departs';

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function plan_depart_questions()
    {
        return $this->hasMany(PlanDepartQuestion::class);
    }

}
