<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\ImageTrait;
use App\Http\Requests\Api\ImageRequest;
use App\Models\User\User;

class ImageController extends Controller
{
  use ImageTrait;
  /**
   * @param ImageRequest $request
   * @return \Illuminate\Http\JsonResponse
   * @throws \Throwable
   */
  public function store(ImageRequest $request)
  {
    return $this->_store($request, User::getUserId());
  }
}
