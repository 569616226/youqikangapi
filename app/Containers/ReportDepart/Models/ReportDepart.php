<?php

namespace App\Containers\ReportDepart\Models;

use App\Containers\Report\Models\Report;
use App\Containers\ReportDepartQuestion\Models\ReportDepartQuestion;
use App\Ship\Parents\Models\Model;


class ReportDepart extends Model
{

    protected $fillable = [
        'name',
        'icon',
        'report_id',
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
    protected $resourceKey = 'report_departs';

    /*报告*/
    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    /*报告部门问题*/
    public function report_depart_questions()
    {
        return $this->hasMany(ReportDepartQuestion::class);
    }

}
