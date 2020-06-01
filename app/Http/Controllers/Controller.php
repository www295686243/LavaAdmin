<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  /**
   * @var \Illuminate\Foundation\Application|mixed|null|res
   */
  protected $res = null;

  /**
   * Controller constructor.
   */
  public function __construct()
  {
    $this->res = app('res');
  }

  /**
   * @param string $message
   * @return \Illuminate\Http\JsonResponse
   */
  protected function success($message = '')
  {
    return $this->res->success($message);
  }

  /**
   * @param string $message
   * @return \Illuminate\Http\JsonResponse
   */
  protected function error($message = '')
  {
    return $this->res->error($message);
  }

  /**
   * @param int $code
   * @return \App\Tools\Resource
   */
  protected function setStatusCode($code = 200)
  {
    return $this->res->setStatusCode($code);
  }

  /**
   * @param $data
   * @return \App\Tools\Resource
   */
  protected function setParams($data)
  {
    return $this->res->setParams($data);
  }
}
