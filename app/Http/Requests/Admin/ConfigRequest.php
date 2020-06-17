<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class ConfigRequest extends BaseRequest
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
          'guard_name' => [
            'required',
            Rule::in(['system'])
          ]
        ];
      case 'store':
        return [
          'name' => 'required|string|max:60',
          'display_name' => 'required|string|max:60',
          'value' => 'required|string|max:120',
          'guard_name' => [
            'required',
            Rule::in(['system'])
          ]
        ];
      case 'update':
        return [
          'display_name' => 'required|string|max:60',
          'value' => 'required|string|max:120'
        ];
      default:
        return [];
    }
  }
}
