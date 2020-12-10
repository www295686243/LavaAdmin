<?php

namespace App\Models\Old;

use Illuminate\Database\Eloquent\Model;

class ResumeSub extends Model
{
  protected $connection = 'zhizao';

  protected $casts = [
    'treatment' => 'array',
  ];
}
