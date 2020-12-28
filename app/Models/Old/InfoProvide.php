<?php

namespace App\Models\Old;

use App\Models\Base\Base;

/**
 * App\Models\Old\InfoProvide
 *
 * @property int|null|string $id
 * @property string $user_id
 * @property string $description
 * @property string $phone
 * @property string $status 0待审核1已发布2中介3已招到4面试中5不需要6未接通7电话错8态度差
 * @property string $type_name 招聘job/订单对接order
 * @property int|null $admin_user_id 信息归属人，用于查看是后台哪个账户操作的
 * @property int $is_admin 是否管理员
 * @property int $is_reward 是否奖励过
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $user_coupon_id
 * @property-read string $user_order_id
 * @method static \Illuminate\Database\Eloquent\Builder|Base listQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InfoProvide newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InfoProvide newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base pagination()
 * @method static \Illuminate\Database\Eloquent\Builder|InfoProvide query()
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchModel($typeField, $model = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base simplePagination()
 * @method static \Illuminate\Database\Eloquent\Builder|InfoProvide whereAdminUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoProvide whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoProvide whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoProvide whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoProvide whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoProvide whereIsReward($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoProvide wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoProvide whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoProvide whereTypeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoProvide whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoProvide whereUserId($value)
 * @mixin \Eloquent
 */
class InfoProvide extends Base
{
  protected $connection = 'zhizao';
}
