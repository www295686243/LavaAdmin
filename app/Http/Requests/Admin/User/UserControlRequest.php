<?php

namespace App\Http\Requests\Admin\User;

use App\Http\Requests\BaseRequest;

class UserControlRequest extends BaseRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    switch (request()->route()->getActionMethod()) {
      case 'update':
        return [
          'is_disable_all_push' => 'sometimes|boolean'
        ];
      default:
        return [];
    }
  }
}
