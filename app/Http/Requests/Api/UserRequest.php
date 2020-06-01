<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseRequest;

class UserRequest extends BaseRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    switch (request()->route()->getActionMethod()) {
      case 'index':
        return [
          'username' => 'min:6|numeric',
          'password' => 'required'
        ];
      default:
        return [];
    }
  }
}
