<?php

namespace App\Containers\Company\Tasks;

use App\Containers\Company\Data\Repositories\CompanyRepository;
use App\Containers\Invitation\Models\Invitation;
use App\Ship\Criterias\Eloquent\OrderByCreationDateDescendingCriteria;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Exceptions\Exception;
use App\Ship\Parents\Tasks\Task;

class GetAllClientCompaniesTask extends Task
{

    private $repository;

    public function __construct(CompanyRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run()
    {
        try {

            $user = \Auth::user();

            $companies = $user->companies()->whereHas('orders', function ($query) {

                $query->whereStatus('已完成');

            })->latest()->get();

            /*
             * 授权客户联系人返回的数据
            */
            $invitations = $user->invitations;
            if (!$user->is_client_admin && !$invitations->isEmpty()) {

                /**/
                $company_ids = [];
                foreach ($invitations as $key => $invitation) {
                    $company_ids[$key] = $invitation->report->order->company->id;
                }

                $companies = collect($companies->filter(function ($item) use ($company_ids) {

                    return in_array($item->id, $company_ids);

                })->all());

            }

            return $companies;

        } catch (Exception $exception) {

            report($exception);
            throw new NotFoundException();

        }

    }


}
