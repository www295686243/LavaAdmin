<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class EmployeeRequest extends BaseRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    $verify = [
      'username' => [
        'required',
        'string',
        'between:6,30',
        Rule::unique('users')->ignore($this->route('employee'))
      ],
      'nickname' => 'sometimes|between:2,30|nullable|string',
      'phone' => [
        'sometimes',
        'nullable',
        'numeric',
        'digits:11',
        Rule::unique('users')->ignore($this->route('employee'))
      ]
    ];
    switch (request()->route()->getActionMethod()) {
      case 'store':
        $verify['password'] = 'required|between:6,30|string';
        return $verify;
      case 'update':
        $verify['password'] = 'sometimes|nullable|between:6,30|string';
        return $verify;
      default:
        return [];
    }
  }
}
