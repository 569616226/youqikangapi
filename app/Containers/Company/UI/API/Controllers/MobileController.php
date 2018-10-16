<?php

namespace App\Containers\Company\UI\API\Controllers;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Company\UI\API\Requests\Mobile\GetAllMobileCompaniesRequest;
use App\Containers\Company\UI\API\Transformers\Mobile\ClientCompanyTransformer;
use App\Containers\Company\UI\API\Transformers\Mobile\MobileCompanyTransformer;
use App\Ship\Parents\Controllers\ApiController;


/**
 * Class Controller
 *
 * @package App\Containers\Company\UI\API\Controllers
 */
class MobileController extends ApiController
{


    /**
     * @param GetAllMobileCompaniesRequest $request
     * @return array
     */
    public function getAllMobileCompanies(GetAllMobileCompaniesRequest $request)
    {
        $companies = Apiato::call('Company@GetAllMobileCompaniesAction', [$request]);

        return $this->transform($companies, MobileCompanyTransformer::class);
    }

    /**
     * @param GetAllMobileCompaniesRequest $request
     * @return array
     */
    public function getAllClientCompanies(GetAllMobileCompaniesRequest $request)
    {
        $companies = Apiato::call('Company@GetAllClientCompaniesAction', [$request]);

        return $this->transform($companies, ClientCompanyTransformer::class);
    }

}
