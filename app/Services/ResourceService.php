<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/6/1
 * Time: 16:13
 */

namespace App\Services;

use App\Models\AdminLog;
use App\Models\ApiLog;
use App\Models\Version;
use Illuminate\Http\JsonResponse;

class ResourceService
{
  /**
   * 200 成功, 422 表单验证错误, 423 权限错误, 424 业务逻辑错误
   * @var int
   */
  private $statusCode = 200;
  private $status = '';
  private $message = '操作成功';
  private $params = [];

  /**
   * @param string $message
   * @return JsonResponse
   */
  public function success($message = '')
  {
    return $this->setStatusCode(200)
      ->setStatus($this->status ? $this->status : 'success')
      ->setMessage($message)
      ->response();
  }

  /**
   * @param string $message
   * @return JsonResponse
   */
  public function error($message = '操作失败')
  {
    $statusCode = $this->statusCode === 200 ? 424 : $this->statusCode;
    return $this->setStatusCode($statusCode)
      ->setStatus($this->status ? $this->status : 'error')
      ->setMessage($message)
      ->response();
  }

  /**
   * @param int $code
   * @return $this
   */
  public function setStatusCode($code = 200)
  {
    $this->statusCode = $code;
    return $this;
  }

  /**
   * @param string $status
   * @return $this
   */
  public function setStatus($status = '')
  {
    $this->status = $status;
    return $this;
  }

  /**
   * @param string $message
   * @return $this
   */
  private function setMessage($message)
  {
    if (!$message) {
      $message = $this->getDefaultMessage();
    }
    $this->message = $message;
    return $this;
  }

  /**
   * @return string
   */
  private function getDefaultMessage()
  {
    $statusMessage = $this->status === 'success' ? '成功' : '失败';
    switch (request()->getMethod()) {
      case 'GET':
        {
          return '获取' . $statusMessage;
        }
      case 'POST':
        {
          return '提交' . $statusMessage;
        }
      case 'PUT':
        {
          return '修改' . $statusMessage;
        }
      case 'DELETE':
        {
          return '删除' . $statusMessage;
        }
      default:
        {
          return '操作' . $statusMessage;
        }
    }
  }

  /**
   * @param $data
   * @return $this
   */
  public function setParams($data)
  {
    if (is_string($data)) {
      $this->params = [
        'message' => $data
      ];
    } else {
      $this->params = $data;
    }
    return $this;
  }

  private function init () {
    $this->status = '';
    $this->params = [];
    $this->statusCode = 200;
    $this->message = '';
  }

  /**
   * @return JsonResponse
   */
  public function response()
  {
    if (request()->route()->getPrefix() === 'admin') {
      (new AdminLog())->createLog([
        'desc' => $this->message,
        'status' => $this->status,
        'code' => $this->statusCode
      ]);
    } else if (request()->route()->getPrefix() === 'api') {
      (new ApiLog())->createLog([
        'desc' => $this->message,
        'status' => $this->status,
        'code' => $this->statusCode,
        'params' => $this->params
      ]);
    }

    $res = [
      'message' => $this->message,
      'status' => $this->status,
      'data' => $this->params,
      'code' => $this->statusCode,
      'version' => (new Version())->getList()
    ];
    $this->init();
    return new JsonResponse($res, $this->statusCode);
  }
}