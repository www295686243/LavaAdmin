<?php

namespace App\Models\Old;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Old\ResumeSub
 *
 * @property int $id
 * @property array|null $treatment 待遇
 * @property string|null $description 描述
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ResumeSub newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ResumeSub newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ResumeSub query()
 * @method static \Illuminate\Database\Eloquent\Builder|ResumeSub whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResumeSub whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResumeSub whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResumeSub whereTreatment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResumeSub whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ResumeSub extends Model
{
  protected $connection = 'zhizao';

  protected $casts = [
    'treatment' => 'array',
  ];
}
