<?php

namespace App\Containers\Invitation\UI\API\Transformers;

use App\Containers\Invitation\Models\Invitation;
use App\Ship\Parents\Transformers\Transformer;

class InvitationTransformer extends Transformer
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

    ];

    /**
     * @param Invitation $entity
     *
     * @return array
     */
    public function transform(Invitation $entity)
    {
        $response = [
            'object'     => 'Invitation',
            'id'         => $entity->getHashedKey(),
            'code'       => $entity->code,
            'depart_ids' => $entity->depart_ids,
            'created_at' => $entity->created_at,
        ];

        return $response;
    }
}
