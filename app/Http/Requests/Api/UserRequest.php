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
      case 'login':
        return [
          'username' => 'required|max:20|string',
          'password' => 'required|between:6,20|string'
        ];
      case 'sendSmsCaptcha':
        return [
          'type_name' => 'required|string',
          'phone' => 'required|numeric|digits:11'
        ];
      case 'bindPhone':
        return [
          'code' => 'required|digits:4',
          'phone' => 'required|numeric|digits:11'
        ];
      case 'updatePhone':
        return [
          'code' => 'required|digits:4',
          'phone' => 'required|numeric|digits:11'
        ];
      case 'verifyPhone':
        return [
          'code' => 'required|digits:4',
          'phone' => 'required|numeric|digits:11'
        ];
      default:
        return [];
    }
  }
}
