<?php

namespace App\Models\User;

use App\Models\Base\Base;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\User\UserWallet
 *
 * @property int|null|string $id
 * @property string $user_id
 * @property string $money 金额
 * @property string $total_earning 总收入
 * @property int $point 积分
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read string $user_coupon_id
 * @property-read string $user_order_id
 * @method static \Illuminate\Database\Eloquent\Builder|Base listQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserWallet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserWallet newQuery()
 * @method static \Illuminate\Database\Query\Builder|UserWallet onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Base pagination()
 * @method static \Illuminate\Database\Eloquent\Builder|UserWallet query()
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchModel($typeField, $model = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base simplePagination()
 * @method static \Illuminate\Database\Eloquent\Builder|UserWallet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserWallet whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserWallet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserWallet whereMoney($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserWallet wherePoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserWallet whereTotalEarning($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserWallet whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserWallet whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|UserWallet withTrashed()
 * @method static \Illuminate\Database\Query\Builder|UserWallet withoutTrashed()
 * @mixin \Eloquent
 */
class UserWallet extends Base
{
  use SoftDeletes;

  protected $fillable = [
    'user_id',
    'money',
    'total_earning',
    'point'
  ];

  protected $hidden = [
    'created_at',
    'updated_at',
    'deleted_at'
  ];

  /**
   * @param $amount
   * @param int $user_id
   */
  public function incrementAmount($amount, int $user_id)
  {
    $userWalletData = self::where('user_id', $user_id)->first();
    if (!$userWalletData) {
      $this->error('该钱包不存在');
    }
    $userWalletData->money += $amount;
    $userWalletData->total_earning += $amount;
    $userWalletData->save();
  }

  /**
   * @param $amount
   * @param int $user_id
   */
  public function decrementAmount($amount, int $user_id)
  {
    $userWalletData = self::where('user_id', $user_id)->first();
    if (!$userWalletData) {
      $this->error('该钱包不存在');
    }
    $userWalletData->money -= $amount;
    $userWalletData->save();
  }
}
