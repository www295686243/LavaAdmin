<?php

namespace App\Models\Old;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Old\UserBill
 *
 * @property int $id
 * @property int $user_id
 * @property string $amount
 * @property int $amount_type 金额类型0占位1现金2余额
 * @property string $desc 账单说明
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserBill newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBill newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBill query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBill whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBill whereAmountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBill whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBill whereDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBill whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBill whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBill whereUserId($value)
 * @mixin \Eloquent
 */
class UserBill extends Model
{
  protected $connection = 'zhizao';
}
