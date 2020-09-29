<?php

namespace App\Http\Requests\Api;

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
      case 'store':
        return [
          '_model' => 'required|string',
          'info_id' => 'sometimes|numeric',
          'marking' => 'sometimes|nullable|numeric',
          'file' => 'image'
        ];
      default:
        return [];
    }
  }
}
