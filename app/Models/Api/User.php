<?php

namespace App\Models\Api;

class User extends \App\Models\User
{
  /**
   * @var string
   */
  protected $guard_name = 'api';
}
