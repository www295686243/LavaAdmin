<?php

namespace App\Models\Info;

use App\Models\Base;
use App\Models\Info\Hr\HrJob;
use App\Models\Info\Hr\HrResume;
use App\Models\User\UserEnterprise;
use App\Models\User\UserPersonal;
use Illuminate\Support\Arr;
use Kalnoy\Nestedset\NodeTrait;

class Industry extends Base
{
  use NodeTrait;

  protected $fillable = [
    'parent_id',
    'display_name',
    'sort',
    'hr_job_amount',
    'hr_resume_amount',
  ];

  protected $hidden = [
    'created_at',
    'updated_at'
  ];

  protected $casts = [
    'hr_job_amount' => 'float',
    'hr_resume_amount' => 'float',
  ];

  public static function bootHasSnowflakePrimary() {}

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
   */
  public function user_personal()
  {
    return $this->morphedByMany(UserPersonal::class, 'industrygable');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
   */
  public function user_enterprise()
  {
    return $this->morphedByMany(UserEnterprise::class, 'industrygable');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
   */
  public function hr_job()
  {
    return $this->morphedByMany(HrJob::class, 'industrygable');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
   */
  public function hr_resume()
  {
    return $this->morphedByMany(HrResume::class, 'industrygable');
  }

  /**
   * [20, 21, 22] // 第三级id
   * @param array $industries
   * @return array
   */
  public static function getGather($industries = [])
  {
    if (!$industries || count($industries) === 0) return [];
    $industries = Arr::sort($industries);
    $industryGather = collect($industries)
      ->map(function ($industryId) { // [[1, 2, 20], [3, 4, 21], [5, 6, 22]] 每个根id的父级路径
        return Industry::ancestorsAndSelf($industryId)->pluck('id');
      })
      ->map(function ($industryPaths) { // [[[父级下的所有根id], [子级下的所有根id], [根id]], [[父级下的所有根id], [子级下的所有根id], [根id]]]
        return collect($industryPaths)->map(function ($industryId) {
          return Industry::withDepth()->having('depth', '=', 2)->descendantsAndSelf($industryId)->pluck('id');
        });
      })
      ->toArray();
    return array_map(function(...$item){
      return array_unique(array_merge(...$item));
    }, ...$industryGather);
  }
}
