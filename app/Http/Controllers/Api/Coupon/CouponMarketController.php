<?php

namespace App\Http\Controllers\Api\Coupon;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Coupon\CouponMarketRequest;
use App\Models\User\User;
use App\Models\Coupon\CouponMarket;
use App\Models\User\UserCoupon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Kra8\Snowflake\Snowflake;

class CouponMarketController extends Controller
{
  private $sortType = [
    0 => [
      'field' => 'id',
      'sort' => 'desc'
    ],
    1 => [
      'field' => 'amount_sort',
      'sort' => 'asc'
    ],
    2 => [
      'field' => 'amount_sort',
      'sort' => 'desc'
    ],
    3 => [
      'field' => 'end_at',
      'sort' => 'asc'
    ],
    4 => [
      'field' => 'end_at',
      'sort' => 'desc'
    ]
  ];

  /**
   * @param CouponMarketRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function index(CouponMarketRequest $request)
  {
    $coupon_template_id = $request->input('coupon_template_id');
    $sort = $request->input('sort', 0);
    $sortItem = $this->sortType[$sort];

    $data = CouponMarket::with(['user_coupon:id,display_name,desc,amount', 'sell_user:id,nickname'])
      ->when($coupon_template_id, function (Builder $query, $coupon_template_id) {
        return $query->where('coupon_template_id', $coupon_template_id);
      })
      ->where('status', CouponMarket::getStatusValue(1, '出售中'))
      ->orderBy($sortItem['field'], $sortItem['sort'])
      ->simplePagination();
    return $this->setParams($data)->success();
  }

  /**
   * @param CouponMarketRequest $request
   * @return \Illuminate\Http\JsonResponse
   * @throws \Throwable
   */
  public function store(CouponMarketRequest $request)
  {
    $coupon_ids = $request->input('coupon_ids', []);
    $amount = $request->input('amount');

    $couponList = UserCoupon::where('user_id', User::getUserId())
      ->where('coupon_status', UserCoupon::getCouponStatusValue(1, '未使用'))
      ->whereIn('id', $coupon_ids)
      ->get();

    if ($couponList->count() !== count($coupon_ids)) {
      return $this->error('您的通用券状态异常，请重试');
    }
    $isAmountFail = $couponList->some(function ($coupon) use ($amount) {
      return $amount > $coupon->amount;
    });
    if ($isAmountFail) {
      return $this->error('出售的优惠券定价不能超过票面价格');
    }

    $couponMarketSql = $couponList->map(function ($item) use ($amount) {
      return [
        'id' => app(Snowflake::class)->next(),
        'sell_user_id' => User::getUserId(),
        'user_coupon_id' => $item->id,
        'coupon_template_id' => $item->coupon_template_id,
        'amount' => $amount,
        'amount_sort' => $amount * 100,
        'status' => CouponMarket::getStatusValue(1, '出售中'),
        'end_at' => $item->end_at,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
      ];
    })->toArray();

    DB::beginTransaction();
    try {
      DB::table('coupon_markets')->insert($couponMarketSql);
      UserCoupon::whereIn('id', $coupon_ids)->update([
        'coupon_status' => UserCoupon::getCouponStatusValue(4, '挂售中')
      ]);
      DB::commit();
      return $this->success('您已挂售成功!');
    } catch (\Exception $e) {
      DB::rollBack();
      \Log::error($e->getMessage());
      return $this->error('挂售失败');
    }
  }
}
