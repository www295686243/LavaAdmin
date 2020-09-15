<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Traits\PayTrait;
use App\Http\Controllers\Controller;
use App\Models\News;

class NewsController extends Controller
{
  use PayTrait;
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $data = News::pagination();
    return $this->setParams($data)->success();
  }
}
