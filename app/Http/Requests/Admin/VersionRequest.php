<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;

class VersionRequest extends BaseRequest
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
          'value' => 'required|numeric'
        ];
      default:
        return [];
    }
  }
}
