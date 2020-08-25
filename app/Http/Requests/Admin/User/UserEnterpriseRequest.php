<?php

namespace App\Http\Requests\Admin\User;

use App\Http\Requests\BaseRequest;

class UserEnterpriseRequest extends BaseRequest
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
          'company' => 'sometimes|nullable|string|max:60',
          'business_license' => 'sometimes|nullable|string|max:18',
          'city' => 'sometimes|nullable|numeric',
          'address' => 'sometimes|nullable|string|max:60',
          'intro' => 'sometimes|nullable|string|max:255',
          'tags' => 'sometimes|nullable|array',
          'company_images' => 'sometimes|nullable|array',
          'company_scale' => 'sometimes|nullable|numeric',
          'name' => 'sometimes|nullable|string|max:20',
          'id_card' => 'sometimes|nullable|string|max:18',
          'position' => 'sometimes|nullable|string|max:60'
        ];
      default:
        return [];
    }
  }
}
