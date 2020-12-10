<?php

namespace App\Models\Old;

use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
  protected $connection = 'zhizao';

  protected $casts = [
    'industries' => 'array',
  ];

  public function resume_sub()
  {
    return $this->hasOne(ResumeSub::class, 'id', 'id');
  }
}
