<?php

namespace App\Models;

use App\Models\Traits\ResourceTrait;
use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
  use ResourceTrait;

  /**
   * @param \DateTimeInterface $date
   * @return string
   */
  protected function serializeDate(\DateTimeInterface $date)
  {
    return $date->format($this->dateFormat ?: 'Y-m-d H:i:s');
  }
}
