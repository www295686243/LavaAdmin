<?php

namespace App\Models\Info;

use App\Models\Base\Base;
use App\Models\Task\TaskRecord;
use App\Models\Task\Traits\InfoProvideTaskTraits;
use App\Models\User\User;

/**
 * App\Models\Info\InfoProvide
 *
 * @property int|null|string $id
 * @property string $user_id
 * @property string $description
 * @property string|null $contacts 联系人
 * @property string $phone
 * @property int $status 0待审核1已发布2中介3已招到4面试中5不需要6未接通7电话错8态度差
 * @property string|null $info_provideable_type
 * @property string|null $info_provideable_id
 * @property string|null $admin_user_id 信息归属人，用于查看是后台哪个账户操作的
 * @property int $is_admin 是否管理员发布的
 * @property int $is_reward 是否奖励过
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read User|null $admin_user
 * @property-read string $user_coupon_id
 * @property-read string $user_order_id
 * @property-read \Illuminate\Database\Eloquent\Collection|TaskRecord[] $task_record
 * @property-read int|null $task_record_count
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Base listQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InfoProvide newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InfoProvide newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base pagination()
 * @method static \Illuminate\Database\Eloquent\Builder|InfoProvide query()
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchModel($typeField, $model = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base simplePagination()
 * @method static \Illuminate\Database\Eloquent\Builder|InfoProvide whereAdminUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoProvide whereContacts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoProvide whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoProvide whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoProvide whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoProvide whereInfoProvideableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoProvide whereInfoProvideableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoProvide whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoProvide whereIsReward($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoProvide wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoProvide whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoProvide whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoProvide whereUserId($value)
 * @mixin \Eloquent
 */
class InfoProvide extends Base
{
  use InfoProvideTaskTraits;
  protected $fillable = [
    'user_id',
    'description',
    'contacts',
    'phone',
    'status',
    'info_provideable_type',
    'info_provideable_id',
    'admin_user_id',
    'is_admin',
    'is_reward'
  ];

  protected $casts = [
    'info_provideable_id' => 'string',
    'admin_user_id' => 'string',
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function admin_user()
  {
    return $this->belongsTo(User::class, 'admin_user_id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphMany
   */
  public function task_record()
  {
    return $this->morphMany(TaskRecord::class, 'task_recordable');
  }
}
