<?php

namespace App\Models\Info;

use App\Models\Base;
use App\Models\User\User;
use Kra8\Snowflake\HasSnowflakePrimary;

class InfoCheck extends Base
{
  use HasSnowflakePrimary;

  protected $fillable = [
    'info_checkable_type',
    'info_checkable_id',
    'info_title',
    'user_id',
    'contents',
    'status',
    'refuse_reason'
  ];

  protected $casts = [
    'contents' => 'array'
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphTo
   */
  public function info_checkable()
  {
    return $this->morphTo();
  }

  /**
   * @param $input
   * @return InfoCheck|\Illuminate\Database\Eloquent\Model
   */
  public static function createInfo($input)
  {
    $input['user_id'] = \App\Models\Api\User::getUserId();
    return InfoCheck::create([
      'info_checkable_type' => $input['_model'],
      'info_checkable_id' => $input['id'],
      'info_title' => $input['title'],
      'user_id' => $input['user_id'],
      'contents' => $input,
      'status' => InfoCheck::getOptionsValue(47, '待审核')
    ]);
  }
}
