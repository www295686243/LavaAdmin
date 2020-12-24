<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/11/19
 * Time: 10:35
 */

namespace App\Models\Info\Hr\Traits;

use App\Models\City;
use App\Models\Info\Industry;

trait InfoQueryTraits {
  /**
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @param $industries
   * @param $city
   * @param $order
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeAiQuery($query, $industries, $city, $order)
  {
    $limit = request()->input('limit', 10);
    $page = request()->input('page', 1);
    $industryGather = Industry::getGather($industries);
    $cityGather = City::getGather($city);
    return $query
      ->with('industry')
      ->where('status', static::getStatusValue(1, '已发布'))
      ->get()
//      ->where(function (Builder $query) use ($industryGather, $cityGather) {
//        $query
//          ->when(count($industryGather), function (Builder $query) use ($industryGather) {
//            $ids = Industrygable::whereIn('industry_id', $industryGather[0])
//              ->where('industrygable_type', static::class)
//              ->pluck('industrygable_id')
//              ->unique()
//              ->values();
//            return $query->whereIn('id', $ids);
//          })
//          ->when(count($cityGather), function (Builder $query) use ($cityGather) {
//            return $query->orWhereBetween('city', $cityGather[0]);
//          });
//      })
//      ->when(request()->input('end_time'), function (Builder $query, $end_time) {
//        return $query->where('end_time', '<=', $end_time);
//      })
      ->map(function ($item) use ($industryGather, $cityGather, $order) {
        $item->filterPoint = 0;
        $item->filterPoint += $this->getIndustryPoint($industryGather, $item->industry->pluck('id')->toArray());
        if ($item->filterPoint > 0) {
          $item->filterPoint += $this->getCityPoint($cityGather, $item->city);
        }
        $item->point = $item->filterPoint;
        if (intval($order) === 0) {
          $item->point = intval($item->filterPoint.strtotime($item->created_at));
        } else if (intval($order) === 1) {
          $item->point = intval($item->filterPoint.strtotime($item->end_time));
        }
        return $item;
      })
      ->sortByDesc('point')
      ->forPage($page, $limit)
      ->values();
  }

  private function getIndustryPoint($industryGather, $industryIds)
  {
    if (count($industryGather) === 0) return 0;
    $point = 0;
    foreach ($industryGather as $index => $item) {
      $result = collect($industryIds)->intersect($item);
      $point += $result->count() * (pow($index, 6) + 2);
    }
    return $point;
  }

  /**
   * @param $cityGather
   * @param $city
   * @return int
   */
  private function getCityPoint($cityGather, $city)
  {
    if (count($cityGather) === 0) return 0;
    $point = 0;
    foreach ($cityGather as $index => $item) {
      if (count($item) === 1 && intval($item[0]) === intval($city)) { // 精准匹配
        $point += 50;
      } else if (count($item) === 2 && $city > $item[0] && $city < $item[1]) { // 相关匹配
        $point += $index + $index + 1;
      }
    }
    return $point;
  }
}
