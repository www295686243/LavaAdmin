<?php

namespace App\Models\User;

use App\Models\Base;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kra8\Snowflake\HasSnowflakePrimary;

/**
 * App\Models\User\UserWallet
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base listQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\UserWallet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\UserWallet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base pagination()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\UserWallet query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base searchQuery()
 * @mixin \Eloquent
 */
class UserWallet extends Base
{
  use SoftDeletes, HasSnowflakePrimary;

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
