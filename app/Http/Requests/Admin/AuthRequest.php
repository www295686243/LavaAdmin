<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    switch (request()->route()->getActionMethod()) {
      case 'login':
        return [
          'username' => 'required|max:20|string',
          'password' => 'required|between:6,20|string'
        ];
      default:
        return [];
    }
  }
}
