<?php

namespace App\Http\Controllers;

use App\Services\ResourceService;
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
  private $res = null;

  /**
   * Controller constructor.
   */
  public function __construct()
  {
    $this->res = new ResourceService();
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
   * @return ResourceService
   */
  protected function setStatusCode($code = 200)
  {
    return $this->res->setStatusCode($code);
  }

  /**
   * @param string $status
   * @return ResourceService
   */
  protected function setStatus($status = '')
  {
    return $this->res->setStatus($status);
  }

  /**
   * @param $data
   * @return ResourceService
   */
  protected function setParams($data)
  {
    return $this->res->setParams($data);
  }
}
