<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;

class NotifyTemplateRequest extends BaseRequest
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
          'template_id' => 'required|string|max:80',
          'title' => 'required|string|max:60',
          'content' => 'required|string|max:120',
          'remark' => 'required|string|max:120',
          'url' => 'required|string|max:120',
          'url_params' => 'required|string|max:120',
          'keyword_names' => 'required|string|max:120'
        ];
      case 'update':
        return [
          'template_id' => 'required|string|max:80',
          'title' => 'required|string|max:60',
          'content' => 'required|string|max:120',
          'remark' => 'required|string|max:120',
          'url' => 'required|string|max:120',
          'url_params' => 'required|string|max:120',
          'keyword_names' => 'required|string|max:120'
        ];
      case 'destroy':
        return [
          'id' => 'required'
        ];
      default:
        return [];
    }
  }
}
