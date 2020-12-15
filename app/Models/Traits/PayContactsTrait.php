<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/12/8
 * Time: 16:59
 */

namespace App\Models\Traits;

use App\Models\User\User;
use App\Models\User\UserCoupon;
use App\Models\User\UserOrder;

trait PayContactsTrait {
  /**
   * @return UserOrder
   */
  public function modelGetUserOrder()
  {
    $user_coupon_id = request()->input('user_coupon_id');
    $total_amount = $this->getPayAmount();

    $coupon_amount = (new UserCoupon())->getUsableCouponAmount($user_coupon_id);
    $cash_amount = $total_amount - $coupon_amount;
    $cash_amount = $cash_amount > 0 ? $cash_amount : 0;
    /**
     * @var UserOrder $userOrderData
     */
    $userOrderData = $this->user_order()->create([
      'user_id' => User::getUserId(),
      'total_amount' => $total_amount,
      'cash_amount' => $cash_amount,
      'coupon_amount' => $coupon_amount,
      'user_coupon_id' => $user_coupon_id
    ]);

    return $userOrderData;
  }

  public function modelGetContacts()
  {
    if ($this->modelIsPay()) {
      return [
        'phone' => $this->phone,
        'contacts' => $this->contacts
      ];
    } else {
      $this->error();
    }
  }

  /**
   * @return float
   */
  private function getPayAmount()
  {
    $modelPath = get_class($this);
    $amount = $modelPath::getConfigValue('amount');
    return floatval($amount);
  }
}
