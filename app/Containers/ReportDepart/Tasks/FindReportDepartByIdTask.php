<?php

namespace App\Containers\ReportDepart\Tasks;

use App\Containers\ReportDepart\Data\Repositories\ReportDepartRepository;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class FindReportDepartByIdTask extends Task
{

    private $repository;

    public function __construct(ReportDepartRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($id)
    {
        try {
            return $this->repository->find($id);
        } catch (Exception $exception) {
            throw new NotFoundException();
        }
    }
}
