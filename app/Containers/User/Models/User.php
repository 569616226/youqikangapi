<?php

namespace App\Containers\User\Models;

use App\Containers\Authorization\Traits\AuthorizationTrait;
use App\Containers\Company\Models\Company;
use App\Containers\Invitation\Models\Invitation;
use App\Ship\Parents\Models\UserModel;
use Venturecraft\Revisionable\RevisionableTrait;

/**
 * Class User.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class User extends UserModel
{

    use AuthorizationTrait;
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
        'open_id',
        'confirmed',
        'is_client',
    );

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'phone',
        'email',
        'password',
        'confirmed',
        'is_client',
        'is_frozen',
        'is_audit',
        'is_client_admin',
        'wechat_name',
        'wechat_avatar',
        'open_id',
        'wechat_verfiy_time',
        'is_wechat_verfiy',
        'deleted_at'
    ];

    protected $casts = [
        'is_frozen'        => 'boolean',
        'is_client'        => 'boolean',
        'is_audit'         => 'boolean',
        'is_client_admin'  => 'boolean',
        'is_wechat_verfiy' => 'boolean',
        'confirmed'        => 'boolean',
    ];

    /**
     * The dates attributes.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'wechat_verfiy_time',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * 修改认证时的默认email字段为name
     */
    public function findForPassport($username)
    {
        return $this->orWhere('name', $username)->first();
    }

    /*
     * 客户
     * */
    public function companies()
    {
        return $this->belongsToMany(Company::class);
    }

    /*授权*/
    public function invitations()
    {
        return $this->belongsToMany(Invitation::class)->withPivot('is_client');
    }


}
