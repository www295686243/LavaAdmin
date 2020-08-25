<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;

class ChartRequest extends BaseRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    switch (request()->route()->getActionMethod()) {
      case 'getCurrentMonthData':
        return [
          'date' => 'required|date_format:Y-m',
          'code' => 'required|string'
        ];
      case 'getCurrentYearData':
        return [
          'date' => 'required|date_format:Y',
          'code' => 'required|string'
        ];
      default:
        return [];
    }
  }
}
