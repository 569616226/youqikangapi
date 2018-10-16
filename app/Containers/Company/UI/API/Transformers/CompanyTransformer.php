<?php

namespace App\Containers\Company\UI\API\Transformers;

use App\Containers\Company\Models\Company;
use App\Containers\User\UI\API\Transformers\UserTransformer;
use App\Ship\Parents\Transformers\Transformer;

class CompanyTransformer extends Transformer
{
    /**
     * @var  array
     */
    protected $defaultIncludes = [

    ];

    /**
     * @var  array
     */
    protected $availableIncludes = [
        'users'
    ];

    /**
     * @param Company $entity
     *
     * @return array
     */
    public function transform(Company $entity)
    {
        $response = [
            'object'     => 'Company',
            'id'         => $entity->getHashedKey(),
            'name'       => $entity->name,
            'creator'    => $entity->creator,
            'logo'       => $entity->logo,
            'users'      => implode(',', $entity->users->pluck('username')->toArray()),
            'created_at' => $entity->created_at->toDateTimeString(),
            'updated_at' => $entity->updated_at->toDateTimeString(),
            'deleted_at' => $entity->deleted_at ? $entity->deleted_at->toDateTimeString() : null,

        ];

        $response = $this->ifAdmin([
            'real_id' => $entity->id,
        ], $response);

        return $response;
    }

    public function includeUsers(Company $entity)
    {
        return $this->collection($entity->users, new UserTransformer());
    }
}
