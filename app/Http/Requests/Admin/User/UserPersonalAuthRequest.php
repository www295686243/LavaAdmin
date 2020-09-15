<?php

namespace App\Http\Requests\Admin\User;

use App\Http\Requests\BaseRequest;

class UserPersonalAuthRequest extends BaseRequest
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
          'name' => 'string|max:20',
          'company' => 'string|max:60',
          'position' => 'string|max:60',
          'city' => 'numeric',
          'address' => 'string|max:60',
          'intro' => 'string|max:255',
          'certificates' => 'array',
          'refuse_reason' => 'sometime|nullable|string|max:255'
        ];
      default:
        return [];
    }
  }
}
