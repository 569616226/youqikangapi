<?php

namespace App\Containers\Company\Tasks;

use App\Containers\Company\Data\Repositories\CompanyRepository;
use App\Containers\Company\Models\Company;
use App\Ship\Criterias\Eloquent\OrderByCreationDateDescendingCriteria;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Exceptions\Exception;
use App\Ship\Parents\Tasks\Task;

class GetAllMobileCompaniesTask extends Task
{

    private $repository;

    public function __construct(CompanyRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run()
    {

        try {

            // return Company::whereHas('orders',function ($query){
            //   $query->whereIn('status', [
            //     '进行中',
            //     '已完成'
            //   ]);
            // })->latest()->get();

            return $this->repository->whereHas('orders', function ($query) {
                $query->whereIn('status', [
                    '进行中',
                    '已完成'
                ]);
            })->get();


        } catch (Exception $exception) {

            report($exception);
            throw new NotFoundException();

        }

    }


    public function ordered()
    {
        $this->repository->pushCriteria(new OrderByCreationDateDescendingCriteria());
    }

}
