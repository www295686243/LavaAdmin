<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseRequest;

class AppRequest extends BaseRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    switch (request()->route()->getActionMethod()) {
      case 'getAppConfig':
        return [
          'guard_name' => 'sometimes|nullable|string'
        ];
      default:
        return [];
    }
  }
}
