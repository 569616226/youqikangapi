<?php

namespace App\Containers\Invitation\Models;

use App\Containers\Report\Models\Report;
use App\Containers\User\Models\User;
use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class Invitation extends Model
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
        'report_id',
        'is_client',
    );


    protected $fillable = [
        'code',
        'depart_ids',
        'is_client',
        'report_id',
        'deleted_at',
    ];

    protected $attributes = [

    ];

    protected $hidden = [

    ];

    protected $casts = [
        'depart_ids' => 'array',
        'is_client'  => 'boolean',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * A resource key to be used by the the JSON API Serializer responses.
     */
    protected $resourceKey = 'invitations';


    /*授权人*/
    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('is_client')
            ->wherePivot('is_client', false);
    }


    /*授权使用人*/
    public function clients()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('is_client')
            ->wherePivot('is_client', true);
    }

    /*授权报告*/
    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}
