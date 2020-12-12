<?php

namespace App\Models\User;

use App\Models\Base\Base;
use App\Models\Info\Industry;
use App\Models\Task\Traits\PerfectEnterpriseInfoTaskTraits;
use App\Models\Traits\IndustryTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;

class UserEnterprise extends Base
{
  use SoftDeletes, IndustryTrait, PerfectEnterpriseInfoTaskTraits;

  protected $fillable = [
    'user_id',
    'avatar',
    'company',
    'business_license',
    'city',
    'address',
    'intro',
    'industry_attr',
    'email',
    'tags',
    'company_images',
    'company_scale',
    'name',
    'id_card',
    'position',
    'phone'
  ];

  protected $hidden = [
    'created_at',
    'updated_at',
    'deleted_at'
  ];

  protected $casts = [
    'company_images' => 'array'
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
   */
  public function industry()
  {
    return $this->morphToMany(Industry::class, 'industrygable');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  /**
   * @param $input
   * @param int $userId
   * @throws \Exception
   */
  public static function updateInfo($input, $userId = 0)
  {
    $userId = $userId ?: User::getUserId();
    $data = static::where('user_id', $userId)->firstOrFail();
    $data->update(Arr::only($input, self::getFillFields()));
    $data->attachIndustry($input);
    if (isset($input['city'])) {
      $data->user()->update(['city' => $input['city']]);
    }
    $data->checkPerfectEnterpriseInfoFinishTask();
  }

  /**
   * @return bool
   */
  public function isPerfectInfo()
  {
    return $this->tags && $this->intro && $this->company_scale;
  }
}
