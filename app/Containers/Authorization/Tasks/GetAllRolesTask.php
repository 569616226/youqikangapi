<?php

namespace App\Containers\Authorization\Tasks;

use App\Containers\Authorization\Data\Criterias\NoAdminGuestCriteria;
use App\Containers\Authorization\Data\Repositories\RoleRepository;
use App\Ship\Criterias\Eloquent\OrderByCreationDateDescendingCriteria;
use App\Ship\Parents\Tasks\Task;

/**
 * Class GetAllPermissionsTask.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class GetAllRolesTask extends Task
{

    /**
     * @var RoleRepository
     */
    private $repository;

    /**
     * GetAllPermissionsTask constructor.
     *
     * @param RoleRepository $repository
     */
    public function __construct(RoleRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param bool $skipPagination
     *
     * @return  mixed
     */
    public function run($skipPagination = false)
    {
        return $skipPagination ? $this->repository->all() : $this->repository->paginate();
    }

    public function ordered()
    {
        $this->repository->pushCriteria(new OrderByCreationDateDescendingCriteria());
    }

    public function no_admin_guest()
    {
        $this->repository->pushCriteria(new NoAdminGuestCriteria());
    }

}
