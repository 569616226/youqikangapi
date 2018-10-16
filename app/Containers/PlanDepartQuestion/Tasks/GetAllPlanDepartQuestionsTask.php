<?php

namespace App\Containers\PlanDepartQuestion\Tasks;

use App\Containers\PlanDepartQuestion\Data\Criterias\DepartsCriteria;
use App\Containers\PlanDepartQuestion\Data\Repositories\PlanDepartQuestionRepository;
use App\Ship\Criterias\Eloquent\OrderByCreationDateDescendingCriteria;
use App\Ship\Parents\Tasks\Task;

class GetAllPlanDepartQuestionsTask extends Task
{

    private $repository;

    public function __construct(PlanDepartQuestionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($skipPagination = false, $plan_depart_id)
    {
        $this->repository->pushCriteria(new DepartsCriteria($plan_depart_id));

        return $skipPagination ? $this->repository->all() : $this->repository->paginate();
    }


    public function ordered()
    {
        $this->repository->pushCriteria(new OrderByCreationDateDescendingCriteria());

    }
}
