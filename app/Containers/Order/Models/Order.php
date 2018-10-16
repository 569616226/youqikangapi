<?php

namespace App\Containers\Order\Models;

use App\Containers\Company\Models\Company;
use App\Containers\Plan\Models\Plan;
use App\Containers\Report\Models\Report;
use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class Order extends Model
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
        'plan_id',
        'company_id',
        'start_at',
    );
    protected $fillable = [
        'name',
        'status',
        'plan_id',
        'company_id',
        'start_at',
        'order_number',
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
        'start_at',
    ];

    /**
     * A resource key to be used by the the JSON API Serializer responses.
     */
    protected $resourceKey = 'orders';

    /*方案*/
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /*客户*/
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /*报告*/
    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}
