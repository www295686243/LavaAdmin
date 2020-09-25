<?php

namespace App\Models\Info;

use App\Models\Base;
use Kalnoy\Nestedset\NodeTrait;

class Industry extends Base
{
  use NodeTrait;

  protected $fillable = [
    'parent_id',
    'display_name',
    'sort',
    'hr_job_amount',
    'hr_resume_amount',
  ];

  protected $hidden = [
    'created_at',
    'updated_at'
  ];

  protected $casts = [
    'hr_job_amount' => 'float',
    'hr_resume_amount' => 'float',
  ];
}
