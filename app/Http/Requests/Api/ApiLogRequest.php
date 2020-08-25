<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseRequest;

class ApiLogRequest extends BaseRequest
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
          'stack' => 'sometimes|nullable|array'
        ];
      default:
        return [];
    }
  }
}
