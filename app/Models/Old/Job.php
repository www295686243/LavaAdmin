<?php

namespace App\Models\Old;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
  protected $connection = 'zhizao';

  protected $casts = [
    'industries' => 'array',
  ];

  public function job_sub()
  {
    return $this->hasOne(JobSub::class, 'id', 'id');
  }
}
