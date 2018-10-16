<?php

namespace App\Containers\Company\Tasks;

use App\Containers\Company\Data\Repositories\CompanyRepository;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class CreateCompanyTask extends Task
{

    private $repository;

    public function __construct(CompanyRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(array $data, $user_ids)
    {
        try {

            \DB::beginTransaction();

            $company = $this->repository->create($data);

            if ($company) {
                $company->users()->attach($user_ids);
            }

            \DB::commit();

            return $company;

        } catch (Exception $exception) {

            \DB::rollback();
            throw new CreateResourceFailedException();

        }
    }
}
