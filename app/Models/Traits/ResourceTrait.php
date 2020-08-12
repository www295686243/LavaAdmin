<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/1/10
 * Time: 15:07
 */

namespace App\Models\Traits;

use App\Services\ResourceService;
use Illuminate\Http\Exceptions\HttpResponseException;

trait ResourceTrait
{
  private $res = null;

  /**
   * @param string $message
   * @return \Illuminate\Http\JsonResponse
   */
  public function error($message = '')
  {
    if (!$this->res) {
      $this->res = new ResourceService();
    }
    return $this->res->error($message);
  }

  /**
   * @param int $code
   * @return $this
   */
  public function setStatusCode($code = 200)
  {
    if (!$this->res) {
      $this->res = new ResourceService();
    }
    $this->res->setStatusCode($code);
    return $this;
  }

  /**
   * @param string $status
   * @return $this
   */
  public function setStatus($status = '')
  {
    if (!$this->res) {
      $this->res = new ResourceService();
    }
    $this->res->setStatus($status);
    return $this;
  }

  /**
   * @param $data
   * @return $this
   */
  public function setParams($data)
  {
    if (!$this->res) {
      $this->res = new ResourceService();
    }
    $this->res->setParams($data);
    return $this;
  }
}
