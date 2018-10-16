<?php

namespace App\Containers\Invitation\Tasks;

use App\Containers\Invitation\Data\Repositories\InvitationRepository;
use App\Containers\Invitation\Models\Invitation;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;
use Illuminate\Support\Facades\App;

class FindInvitationByCodeTask extends Task
{

    public function run($code)
    {
        try {
            return App(Invitation::class)->whereCode($code)->first();
        } catch (Exception $exception) {
            throw new NotFoundException();
        }
    }
}
