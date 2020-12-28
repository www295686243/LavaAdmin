<?php

namespace App\Models\Info;

use App\Models\Base\Base;
use App\Models\User\User;

/**
 * App\Models\Info\InfoComplaint
 *
 * @property int|null|string $id
 * @property string $user_id
 * @property string $info_complaintable_type
 * @property string|null $info_complaintable_id
 * @property int $complaint_type 投诉类型
 * @property string|null $complaint_content 投诉内容
 * @property string|null $handle_content 处理结果
 * @property int $is_solve 是否解决
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $user_coupon_id
 * @property-read string $user_order_id
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $info_complaintable
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Base listQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InfoComplaint newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InfoComplaint newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base pagination()
 * @method static \Illuminate\Database\Eloquent\Builder|InfoComplaint query()
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchModel($typeField, $model = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base simplePagination()
 * @method static \Illuminate\Database\Eloquent\Builder|InfoComplaint whereComplaintContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoComplaint whereComplaintType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoComplaint whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoComplaint whereHandleContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoComplaint whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoComplaint whereInfoComplaintableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoComplaint whereInfoComplaintableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoComplaint whereIsSolve($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoComplaint whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoComplaint whereUserId($value)
 * @mixin \Eloquent
 */
class InfoComplaint extends Base
{
  protected $fillable = [
    'user_id',
    'info_complaintable_type',
    'info_complaintable_id',
    'complaint_type',
    'complaint_content',
    'handle_content',
    'is_solve',
  ];

  protected $casts = [
    'info_complaintable_id' => 'string'
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
  public function info_complaintable()
  {
    return $this->morphTo();
  }
}
