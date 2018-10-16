<?php

namespace App\Containers\Authorization\Models;

use Apiato\Core\Traits\HashIdTrait;
use Apiato\Core\Traits\HasResourceKeyTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role as SpatieRole;
use Venturecraft\Revisionable\RevisionableTrait;

/**
 * Class Role
 *
 * @author  Mahmoud Zalt  <mahmoud@zalt.me>
 */
class Role extends SpatieRole
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
        'level',
        'deleted_at',
    ];

}
