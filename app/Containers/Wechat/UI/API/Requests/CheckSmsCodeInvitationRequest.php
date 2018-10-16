<?php

namespace App\Containers\Wechat\UI\API\Requests;

use App\Ship\Parents\Requests\Request;

/**
 * Class FindGuestByIdRequest.
 */
class CheckSmsCodeInvitationRequest extends Request
{

    /**
     * Define which Roles and/or Permissions has access to this request.
     *
     * @var  array
     */
    protected $access = [
        'permissions' => '',
        'roles'       => '',
    ];

    /**
     * Id's that needs decoding before applying the validation rules.
     *
     * @var  array
     */
    protected $decode = [
//        'id',
    ];

    /**
     * Defining the URL parameters (e.g, `/user/{id}`) allows applying
     * validation rules on them and allows accessing them like request data.
     *
     * @var  array
     */
    protected $urlParameters = [
//        'id',
    ];

    /**
     * @return  array
     */
    public function rules()
    {
        return [

            'phone'         => 'required|numeric',
            'sms_code'      => 'required|numeric',
            'open_id'       => 'required|max:255',
            'wechat_name'   => 'max:255',
            'wechat_avatar' => 'max:255',
            'username'      => 'max:255',
        ];
    }

    /**
     * @return  bool
     */
    public function authorize()
    {
        return $this->check(['hasAccess']);
    }
}
