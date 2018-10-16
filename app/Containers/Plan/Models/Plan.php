<?php

namespace App\Containers\Plan\Models;

use App\Containers\Order\Models\Order;
use App\Containers\PlanDepart\Models\PlanDepart;
use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class Plan extends Model
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
        'editer',
        'is_parent',
    );

    protected $fillable = [
        'name',
        'editer',
        'is_parent',
        'deleted_at',
    ];

    protected $attributes = [

    ];

    protected $hidden = [

    ];

    protected $casts = [
        'is_parent' => 'boolean',
        'answers'   => 'array'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * A resource key to be used by the the JSON API Serializer responses.
     */
    protected $resourceKey = 'plans';

    public function plan_departs()
    {
        return $this->hasMany(PlanDepart::class);
    }

    public function order()
    {
        return $this->hasOne(Order::class);
    }

}
