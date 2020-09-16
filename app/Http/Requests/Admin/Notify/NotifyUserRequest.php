<?php

namespace App\Http\Requests\Admin\Notify;

use App\Http\Requests\BaseRequest;

class NotifyUserRequest extends BaseRequest
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
          'notify_template_id' => 'required',
          'user_id' => 'required'
        ];
      default:
        return [];
    }
  }
}
