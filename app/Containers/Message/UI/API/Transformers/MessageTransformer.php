<?php

namespace App\Containers\Message\UI\API\Transformers;

use App\Containers\Message\Models\Message;
use App\Ship\Parents\Transformers\Transformer;

class MessageTransformer extends Transformer
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
     * @param Message $entity
     *
     * @return array
     */
    public function transform(Message $entity)
    {
        $response = [
            'object'     => 'Message',
            'id'         => $entity->getHashedKey(),
            'created_at' => $entity->created_at,
            'updated_at' => $entity->updated_at,

        ];

        $response = $this->ifAdmin([
            'real_id' => $entity->id,
            // 'deleted_at' => $entity->deleted_at,
        ], $response);

        return $response;
    }
}
