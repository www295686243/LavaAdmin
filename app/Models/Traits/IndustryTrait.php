<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/9/27
 * Time: 17:14
 */

namespace App\Models\Traits;

use App\Models\Info\Industry;

trait IndustryTrait
{
  public function attachIndustry()
  {
    $industries = request()->input('industry', []);
    $arr = [];
    $time = date('Y-m-d H:i:s');
    foreach ($industries as $industry_id) {
      $industryPath = Industry::ancestorsAndSelf($industry_id)->pluck('id');
      $arr[$industry_id] = [
        'industry_root_id' => $industryPath[0],
        'industry_path' => ','.$industryPath->implode(',').',',
        'created_at' => $time,
        'updated_at' => $time
      ];
    }
    $this->industry()->sync($arr);
  }
}
