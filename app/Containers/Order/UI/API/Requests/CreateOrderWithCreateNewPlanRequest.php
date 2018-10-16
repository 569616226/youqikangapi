<?php

namespace App\Containers\Order\UI\API\Requests;

use App\Ship\Parents\Requests\Request;

/**
 * Class CreateOrderRequest.
 */
class CreateOrderWithCreateNewPlanRequest extends Request
{
    /**
     * Define which Roles and/or Permissions has access to this request.
     *
     * @var  array
     */
    protected $access = [
        'permissions' => 'manage-orders',
        'roles'       => '',
    ];

    /**
     * Id's that needs decoding before applying the validation rules.
     *
     * @var  array
     */
    protected $decode = [

        'company_id'
    ];

    /**
     * Defining the URL parameters (e.g, `/user/{id}`) allows applying
     * validation rules on them and allows accessing them like request data.
     *
     * @var  array
     */
    protected $urlParameters = [
        // 'id',
    ];

    /**
     * @return  array
     */
    public function rules()
    {
        return [
            'name'       => 'required|max:255',
            'status'     => 'required|max:255',
            'plan_data'  => 'required|array',
            'company_id' => 'required|exists:companies,id',
        ];
    }

    /**
     * @return  bool
     */
    public function authorize()
    {
        return $this->check([
            'hasAccess',
        ]);
    }
}
