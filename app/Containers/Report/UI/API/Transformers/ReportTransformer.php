<?php

namespace App\Containers\Report\UI\API\Transformers;

use App\Containers\Report\Models\Report;
use App\Containers\ReportDepart\UI\API\Transformers\ReportDepartTransformer;
use App\Ship\Parents\Transformers\Transformer;

class ReportTransformer extends Transformer
{
    /**
     * @var  array
     */
    protected $defaultIncludes = [
        'report_departs',
    ];

    /**
     * @var  array
     */
    protected $availableIncludes = [

    ];

    /**
     * @param Report $entity
     *
     * @return array
     */
    public function transform(Report $entity)
    {
        $response = [

            'object'       => 'Report',
            'id'           => $entity->getHashedKey(),
            'name'         => $entity->name,
            'company_logo' => $entity->order->company->logo,
            'created_at'   => $entity->created_at->toDateTimeString(),
            'updated_at'   => $entity->updated_at->toDateTimeString(),

        ];

        return $response;
    }

    public function includeReportDeparts(Report $entity)
    {

        $user = \Auth::user();
        $invitations = $user->invitations()->where('report_id',$entity->id)->get();

        if ($user->is_client && !$user->is_client_admin && !$invitations->isEmpty()) {

            $depart_ids = $invitations->first()->depart_ids;

            $report_departs = $entity->report_departs()->whereIn('id', $depart_ids)->get();

        } else {

            $report_departs = $entity->report_departs;

        }

        return $this->collection($report_departs, new ReportDepartTransformer());
    }

}
