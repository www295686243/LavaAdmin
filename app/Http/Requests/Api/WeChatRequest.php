<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseRequest;

class WeChatRequest extends BaseRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    switch (request()->route()->getActionMethod()) {
      case 'getConfig':
        return [
          'url' => 'required|string'
        ];
      case 'auth':
        return [
          'redirect_url' => 'required|string'
        ];
      default:
        return [];
    }
  }
}
