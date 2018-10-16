<?php

namespace App\Containers\Company\UI\API\Transformers\Mobile;

use App\Containers\Company\Models\Company;
use App\Containers\Invitation\Models\Invitation;
use App\Containers\Order\UI\API\Transformers\Mobile\ClientOrderTransformer;
use App\Ship\Parents\Transformers\Transformer;

class ClientCompanyTransformer extends Transformer
{
    /**
     * @var  array
     */
    protected $defaultIncludes = [
        'orders'
    ];

    /**
     * @var  array
     */
    protected $availableIncludes = [

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
            'logo'       => $entity->logo,
            'created_at' => $entity->created_at->toDateTimeString(),
        ];

        return $response;
    }

    public function includeOrders(Company $entity)
    {

        $orders = $entity->orders()->whereStatus('已完成')->latest()->get();
        $user = \Auth::user();
        $invitations = $user->invitations;

        if ($user->is_client && !$user->is_client_admin && !$invitations->isEmpty()) {

            $report_ids = $invitations->pluck('report_id')->toArray();

            $orders = $entity->orders()->whereHas('reports', function ($query) use ($report_ids) {
                $query->whereIn('id', $report_ids);
            })->whereStatus('已完成')->latest()->get();

        }

        return $this->collection($orders, new ClientOrderTransformer());

    }


}
