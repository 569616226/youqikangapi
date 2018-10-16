<?php

namespace App\Containers\Authorization\Models;

use Apiato\Core\Traits\HashIdTrait;
use Apiato\Core\Traits\HasResourceKeyTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Permission as SpatiePermission;
use Venturecraft\Revisionable\RevisionableTrait;

/**
 * Class Permission
 *
 * @author  Mahmoud Zalt  <mahmoud@zalt.me>
 */
class Permission extends SpatiePermission
{

    use HashIdTrait;
    use HasResourceKeyTrait;
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
        'display_name',
        'description',
        'deleted_at',
    );


    protected $guard_name = 'web';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'guard_name',
        'display_name',
        'description',
        'deleted_at',
    ];
}
