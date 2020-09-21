<?php

namespace App\Http\Requests;

use App\Services\ResourceService;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }


  /**
   * @param Validator $validator
   * @throws \Illuminate\Validation\ValidationException
   */
  protected function failedValidation(Validator $validator)
  {
    if ($this->ajax()) {
      throw new HttpResponseException((new ResourceService())->setParams($validator->errors())->setStatusCode(422)->error('验证错误'));
    } else {
      parent::failedValidation($validator);
    }
  }

  /**
   * @return array
   */
  public function getAll()
  {
    return $this->except('_env');
  }
}
