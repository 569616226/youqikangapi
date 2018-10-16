<?php

namespace App\Containers\Report\Models;

use App\Containers\Invitation\Models\Invitation;
use App\Containers\Order\Models\Order;
use App\Containers\ReportDepart\Models\ReportDepart;
use App\Ship\Parents\Models\Model;
use Venturecraft\Revisionable\RevisionableTrait;

class Report extends Model
{

    use RevisionableTrait;

    public static function boot()
    {
        parent::boot();
    }

    protected $revisionEnabled = true;
    protected $revisionCreationsEnabled = true;
    protected $revisionNullString = 'nothing';
    protected $revisionUnknownString = 'unknown';
    protected $dontKeepRevisionOf = array(
        'order_id',
    );

    protected $fillable = [
        'name',
        'order_id'
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
    ];

    /**
     * A resource key to be used by the the JSON API Serializer responses.
     */
    protected $resourceKey = 'reports';

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /*授权*/
    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    /*报告部门*/
    public function report_departs()
    {
        return $this->hasMany(ReportDepart::class);
    }
}
