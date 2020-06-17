<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;

class RoleRequest extends BaseRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    switch (request()->route()->getActionMethod()) {
      case 'store':
        return [
          'display_name' => 'required|string|between:1,30'
        ];
      case 'update':
        return [
          'display_name' => 'required|string|between:1,30'
        ];
      case 'updatePermissions':
        return [
          'permissions' => 'sometimes|array'
        ];
      default:
        return [];
    }
  }
}
