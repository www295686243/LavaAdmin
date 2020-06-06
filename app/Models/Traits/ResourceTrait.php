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
   */
  public function error($message = '')
  {
    if (!$this->res) {
      $this->res = new ResourceService();
    }
    throw new HttpResponseException($this->res->error($message));
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
