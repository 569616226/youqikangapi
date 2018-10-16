<?php

namespace App\Containers\Company\Models;

use App\Containers\Order\Models\Order;
use App\Containers\User\Models\User;
use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class Company extends Model
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
        'creator',
    );

    protected $fillable = [
        'name',
        'logo',
        'creator',
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
    protected $resourceKey = 'companies';

    /*客户联系人*/
    public function users()
    {
        return $this->belongsToMany(User::class)->where('is_client', true);
    }

    /*订单*/
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

}
