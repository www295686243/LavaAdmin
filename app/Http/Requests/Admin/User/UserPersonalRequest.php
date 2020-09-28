<?php

namespace App\Http\Requests\Admin\User;

use App\Http\Requests\BaseRequest;

class UserPersonalRequest extends BaseRequest
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
          'avatar' => 'sometimes|nullable|string',
          'name' => 'sometimes|nullable|string|max:20',
          'id_card' => 'sometimes|nullable|string|max:18',
          'seniority' => 'sometimes|nullable|numeric',
          'intro' => 'sometimes|nullable|string|max:255',
          'email' => 'sometimes|nullable|email',
          'phone' => 'sometimes|nullable|digits:11|numeric',
          'company' => 'sometimes|nullable|string|max:60',
          'position' => 'sometimes|nullable|string|max:60',
          'position_attr' => 'sometimes|nullable|numeric',
          'city' => 'sometimes|nullable|numeric',
          'address' => 'sometimes|nullable|string|max:60',
          'tags' => 'sometimes|nullable|string',
          'education_experience' => 'sometimes|nullable|array',
          'work_experience' => 'sometimes|nullable|array',
          'honorary_certificate' => 'sometimes|nullable|array'
        ];
      default:
        return [];
    }
  }
}
