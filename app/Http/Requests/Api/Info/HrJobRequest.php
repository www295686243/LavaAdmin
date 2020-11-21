<?php

namespace App\Http\Requests\Api\Info;

use App\Http\Requests\BaseRequest;

class HrJobRequest extends BaseRequest
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
          'industry' => 'sometimes|nullable|array',
          'city' => 'sometimes|nullable|numeric',
          'end_time' => 'sometimes|nullable|date',
          'order' => 'sometimes|numeric',
          'keyword' => 'sometimes|nullable|string'
        ];
      default:
        return [];
    }
  }
}
