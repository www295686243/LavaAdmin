<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;

class ImageRequest extends BaseRequest
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
          'type' => 'required|string',
          'info_id' => 'sometimes|numeric',
          'limit' => 'sometimes|numeric'
        ];
      case 'store':
        return [
          'type' => 'required|string',
          'info_id' => 'sometimes|numeric',
          'marking' => 'sometimes|nullable|numeric',
          'file' => 'image'
        ];
      case 'destroyMore':
        return [
          'ids' => 'required|array'
        ];
      default:
        return [];
    }
  }
}
