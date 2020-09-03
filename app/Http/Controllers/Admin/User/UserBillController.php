<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\User\UserBill;
use Illuminate\Http\Request;

class UserBillController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $data = UserBill::searchQuery()->orderByDesc('id')->pagination();
    return $this->setParams($data)->success();
  }
}
