<?php

namespace App\Containers\Plan\UI\API\Requests;

use App\Ship\Parents\Requests\Request;

/**
 * Class UpdatePlanRequest.
 */
class UpdatePlanRequest extends Request
{
    /**
     * Define which Roles and/or Permissions has access to this request.
     *
     * @var  array
     */
    protected $access = [
        'permissions' => 'manage-plans',
        'roles'       => '',
    ];

    /**
     * Id's that needs decoding before applying the validation rules.
     *
     * @var  array
     */
    protected $decode = [
        'id',
        'plan_data.plan_departs.*.id',
        'plan_data.plan_departs.*.plan_depart_questions.*.id',
    ];

    /**
     * Defining the URL parameters (e.g, `/user/{id}`) allows applying
     * validation rules on them and allows accessing them like request data.
     *
     * @var  array
     */
    protected $urlParameters = [
        'id',
    ];

    /**
     * @return  array
     */
    public function rules()
    {
        return [
            'id'                                                  => 'required|exists:plans,id',
            'plan_data'                                           => 'array',
            'plan_data.plan_departs.*.id'                         => 'exists:plan_departs,id',
            'plan_data.plan_departs.*.plan_depart_questions.*.id' => 'exists:plan_depart_questions,id',
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
