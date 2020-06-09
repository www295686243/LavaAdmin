<?php

namespace App\Models\Admin;

class User extends \App\Models\User
{
  /**
   * @var string
   */
  protected $guard_name = 'admin';
}
