<?php

namespace App\Containers\ReportDepartQuestion\Models;

use App\Containers\ReportDepart\Models\ReportDepart;
use App\Ship\Parents\Models\Model;

class ReportDepartQuestion extends Model
{

    protected $fillable = [
        'answers',
        'question',
        'report_depart_id',
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
        'audit_at',
        'question_details',
    ];

    protected $attributes = [

    ];

    protected $hidden = [

    ];

    protected $casts = [
        'answers'          => 'array',
        'more_files'       => 'array',
        'question_details' => 'array',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'confirm_at',
        'audit_at',
        'conclusion_at',
    ];

    /**
     * A resource key to be used by the the JSON API Serializer responses.
     */
    protected $resourceKey = 'report_depart_questions';

    /*报告部门*/
    public function report_depart()
    {
        return $this->belongsTo(ReportDepart::class);
    }
}
