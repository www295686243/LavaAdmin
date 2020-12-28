<?php

namespace App\Models\Info;

use App\Models\Base\Base;

/**
 * App\Models\Info\Industrygable
 *
 * @property int|null|string $id
 * @property int $industry_id
 * @property int $industrygable_id
 * @property string $industrygable_type
 * @property-read string $user_coupon_id
 * @property-read string $user_id
 * @property-read string $user_order_id
 * @method static \Illuminate\Database\Eloquent\Builder|Base listQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Industrygable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Industrygable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base pagination()
 * @method static \Illuminate\Database\Eloquent\Builder|Industrygable query()
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchModel($typeField, $model = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base simplePagination()
 * @method static \Illuminate\Database\Eloquent\Builder|Industrygable whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Industrygable whereIndustryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Industrygable whereIndustrygableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Industrygable whereIndustrygableType($value)
 * @mixin \Eloquent
 */
class Industrygable extends Base
{
}
