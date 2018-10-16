<?php

namespace App\Containers\User\UI\API\Transformers;

use App\Containers\Authorization\UI\API\Transformers\RoleTransformer;
use App\Containers\Company\UI\API\Transformers\CompanyTransformer;
use App\Containers\User\Models\User;
use App\Ship\Parents\Transformers\Transformer;

/**
 * Class UserPrivateProfileTransformer.
 *
 * @author Johannes Schobel <johannes.schobel@googlemail.com>
 */
class ClientTransformer extends Transformer
{

    /**
     * @var  array
     */
    protected $availableIncludes = [
        'roles',
        'companies',
    ];

    /**
     * @var  array
     */
    protected $defaultIncludes = [

    ];

    /**
     * @param \App\Containers\User\Models\User $user
     *
     * @return array
     */
    public function transform(User $user)
    {
        $response = [
            'object'             => 'User',
            'id'                 => $user->getHashedKey(),
            'name'               => $user->name,
            'username'           => $user->username,
            'phone'              => $user->phone,
            'is_frozen'          => $user->is_frozen,
            'wechat_name'        => $user->wechat_name,
            'wechat_avatar'      => $user->wechat_avatar,
            'open_id'            => $user->open_id,
            'wechat_verfiy_time' => $user->wechat_verfiy_time ? $user->wechat_verfiy_time->toDateTimeString() : null,
            'is_wechat_verfiy'   => $user->is_wechat_verfiy ? '已绑定' : '未绑定',
            'is_client_admin'    => $user->is_client_admin,
            'created_at'         => $user->created_at->toDateTimeString(),
            'updated_at'         => $user->updated_at->toDateTimeString(),
            'deleted_at'         => $user->deleted_at ? $user->deleted_at->toDateTimeString() : null,
        ];

        $response = $this->ifAdmin([
            'real_id' => $user->id,
        ], $response);

        return $response;
    }

    public function includeRoles(User $user)
    {
        return $this->collection($user->roles, new RoleTransformer());
    }

    public function includeCompanies(User $user)
    {
        return $this->collection($user->companies, new CompanyTransformer());
    }

}
