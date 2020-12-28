<?php

namespace App\Models\Old;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Old\ModelHasRole
 *
 * @property int $role_id
 * @property string $model_type
 * @property int $model_id
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasRole query()
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasRole whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasRole whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasRole whereRoleId($value)
 * @mixin \Eloquent
 */
class ModelHasRole extends Model
{
  protected $connection = 'zhizao';
}
