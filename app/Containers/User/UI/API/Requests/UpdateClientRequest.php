<?php

namespace App\Containers\User\UI\API\Requests;

use App\Ship\Parents\Requests\Request;

/**
 * Class UpdateUserRequest.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class UpdateClientRequest extends Request
{

  /**
   * Define which Roles and/or Permissions has access to this request.
   *
   * @var  array
   */
  protected $access = [
    'permissions' => 'update-users',
    'roles'       => '',
  ];

  /**
   * Id's that needs decoding before applying the validation rules.
   *
   * @var  array
   */
  protected $decode = [
    'id',
    'role_id.*',
    'company_id.*'
  ];

  /**
   * Defining the URL parameters (`/stores/999/items`) allows applying
   * validation rules on them and allows accessing them like request data.
   *
   * @var  array
   */
  protected $urlParameters = [
    'id'
  ];

  /**
   * @return  array
   */
  public function rules()
  {
    return [
      'phone'           => 'required',
      'id'              => 'required|exists:users,id',
      'username'        => 'required|min:2|max:50',
      'role_id.*'       => 'required|exists:roles,id',
      'company_id.*'    => 'required|exists:companies,id',
      'is_client_admin' => 'required',
    ];
  }

  /**
   * @return  bool
   *
   */
  public function authorize()
  {
    // is this an admin who has access to permission `update-users`
    // or the user is updating his own object (is the owner).

    return $this->check([
      'hasAccess',
    ]);
  }
}
