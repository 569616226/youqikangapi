<?php

namespace App\Containers\Message\Models;

use App\Ship\Parents\Models\Model;
use Venturecraft\Revisionable\RevisionableTrait;

class Message extends Model
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
    protected $KeepRevisionOf = [
        'content'
    ];

    protected $fillable = [
        'content'
    ];

    protected $attributes = [
    ];

    protected $hidden = [

    ];

    protected $casts = [
        'content' => 'array',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * A resource key to be used by the the JSON API Serializer responses.
     */
    protected $resourceKey = 'messages';
}
