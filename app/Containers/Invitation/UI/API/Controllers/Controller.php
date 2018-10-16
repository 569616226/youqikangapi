<?php

namespace App\Containers\Invitation\UI\API\Controllers;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Invitation\UI\API\Requests\CreateInvitationRequest;
use App\Containers\Invitation\UI\API\Requests\DeleteInvitationRequest;
use App\Containers\Invitation\UI\API\Requests\FindInvitationByIdRequest;
use App\Containers\Invitation\UI\API\Requests\GetAllInvitationsRequest;
use App\Containers\Invitation\UI\API\Transformers\InvitationTransformer;
use App\Ship\Parents\Controllers\ApiController;

/**
 * Class Controller
 *
 * @package App\Containers\Invitation\UI\API\Controllers
 */
class Controller extends ApiController
{
    /**
     * @param CreateInvitationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createInvitation(CreateInvitationRequest $request)
    {
        $invitation = Apiato::call('Invitation@CreateInvitationAction', [$request]);

        return $this->created($this->transform($invitation, InvitationTransformer::class), 200);
    }

    /**
     * @param FindInvitationByIdRequest $request
     * @return array
     */
    public function findInvitationById(FindInvitationByIdRequest $request)
    {
        $invitation = Apiato::call('Invitation@FindInvitationByIdAction', [$request]);

        return $this->transform($invitation, InvitationTransformer::class);
    }

    /**
     * @param GetAllInvitationsRequest $request
     * @return array
     */
    public function getAllInvitations(GetAllInvitationsRequest $request)
    {
        $invitations = Apiato::call('Invitation@GetAllInvitationsAction', [$request]);

        return $this->transform($invitations, InvitationTransformer::class);
    }

    /**
     * @param DeleteInvitationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteInvitation(DeleteInvitationRequest $request)
    {
        Apiato::call('Invitation@DeleteInvitationAction', [$request]);

        return $this->noContent();
    }
}
