<?php

namespace App\Models\Info;

use App\Models\Base\Base;
use App\Models\User\User;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Info\InfoCheck
 *
 * @property int|null|string $id
 * @property string $info_checkable_type
 * @property string|null $info_checkable_id
 * @property string $info_title 信息标题
 * @property string $user_id 发布者
 * @property array $contents 内容
 * @property int $status 状态(0待审核，1已审核，2未通过)
 * @property string|null $refuse_reason 拒绝原因
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read string $user_coupon_id
 * @property-read string $user_order_id
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $info_checkable
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Base listQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InfoCheck newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InfoCheck newQuery()
 * @method static \Illuminate\Database\Query\Builder|InfoCheck onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Base pagination()
 * @method static \Illuminate\Database\Eloquent\Builder|InfoCheck query()
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchModel($typeField, $model = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base simplePagination()
 * @method static \Illuminate\Database\Eloquent\Builder|InfoCheck whereContents($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoCheck whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoCheck whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoCheck whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoCheck whereInfoCheckableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoCheck whereInfoCheckableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoCheck whereInfoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoCheck whereRefuseReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoCheck whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoCheck whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoCheck whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|InfoCheck withTrashed()
 * @method static \Illuminate\Database\Query\Builder|InfoCheck withoutTrashed()
 * @mixin \Eloquent
 */
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
