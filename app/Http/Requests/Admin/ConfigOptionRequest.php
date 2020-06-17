<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;

class ConfigOptionRequest extends BaseRequest
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
          'config_id' => 'sometimes|numeric'
        ];
      case 'store':
        return [
          'config_id' => 'required|numeric',
          'display_name' => 'required|string|max:60'
        ];
      case 'update':
        return [
          'display_name' => 'required|string|max:60'
        ];
      default:
        return [];
    }
  }
}
