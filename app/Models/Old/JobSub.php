<?php

namespace App\Models\Old;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Old\JobSub
 *
 * @property int $id
 * @property array|null $treatment 待遇
 * @property string|null $description 岗位描述
 * @property string|null $address 工作详细地址
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|JobSub newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JobSub newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JobSub query()
 * @method static \Illuminate\Database\Eloquent\Builder|JobSub whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobSub whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobSub whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobSub whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobSub whereTreatment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobSub whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class JobSub extends Model
{
  protected $connection = 'zhizao';

  protected $casts = [
    'treatment' => 'array',
  ];
}
