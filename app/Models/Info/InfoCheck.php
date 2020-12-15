<?php

namespace App\Models\Info;

use App\Models\Base\Base;
use App\Models\User\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class InfoCheck extends Base
{
  use SoftDeletes;
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
    'contents' => 'array',
    'info_checkable_id' => 'string'
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
    $input['user_id'] = User::getUserId();
    return InfoCheck::create([
      'info_checkable_type' => $input['_model'],
      'info_checkable_id' => $input['id'],
      'info_title' => $input['title'],
      'user_id' => $input['user_id'],
      'contents' => $input,
      'status' => InfoCheck::getStatusValue(1, '待审核')
    ]);
  }

  /**
   * @param $input
   * @param $id
   * @return self
   */
  public static function updateInfo($input, $id)
  {
    $infoCheckData = self::findOrAuth($id);
    if ($infoCheckData->status !== self::getStatusValue(3, '已拒绝')) {
      (new self())->error('信息异常');
    }
    $infoCheckData->info_title = $input['title'];
    $infoCheckData->contents = $input;
    $infoCheckData->status = self::getStatusValue(1, '待审核');
    $infoCheckData->save();
    return $infoCheckData;
  }

  /**
   * @param $modelName
   * @return mixed
   */
  public static function getList($modelName)
  {
    return self::select(['id', 'user_id', 'info_title', 'status', 'refuse_reason', 'created_at'])
      ->where('user_id', User::getUserId())
      ->where('info_checkable_type', $modelName)
      ->where('status', '!=', self::getStatusValue(2, '已通过'))
      ->orderByDesc('id')
      ->simplePagination();
  }
}
