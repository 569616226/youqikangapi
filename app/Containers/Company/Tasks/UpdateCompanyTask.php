<?php

namespace App\Containers\Company\Tasks;

use App\Containers\Company\Data\Repositories\CompanyRepository;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class UpdateCompanyTask extends Task
{

    private $repository;

    public function __construct(CompanyRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($id, array $data, $user_ids)
    {
        try {

            \DB::beginTransaction();

            $company = $this->repository->update($data, $id);

            if ($company) {
                $company->users()->sync($user_ids);
            }

            \DB::commit();

            return $company;

        } catch (Exception $exception) {

            \DB::rollback();
            throw new UpdateResourceFailedException();
        }
    }
}
