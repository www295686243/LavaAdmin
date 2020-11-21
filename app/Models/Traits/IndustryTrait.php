<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/9/27
 * Time: 17:14
 */

namespace App\Models\Traits;

trait IndustryTrait
{
  public function attachIndustry($input = null)
  {
    $industries = isset($input['industry']) ? $input['industry'] : request()->input('industry');
    if (is_array($industries)) {
      $this->industry()->sync($industries);
    }
  }
}
