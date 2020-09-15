<?php

namespace App\Http\Requests\Admin\User;

use App\Http\Requests\BaseRequest;

class UserEnterpriseAuthRequest extends BaseRequest
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
          'company' => 'string|max:60',
          'business_license' => 'string|max:18',
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
