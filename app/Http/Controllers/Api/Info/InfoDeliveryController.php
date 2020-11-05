<?php

namespace App\Http\Controllers\Api\Info;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Info\InfoDeliveryRequest;
use App\Models\Api\User;
use App\Models\Info\InfoDelivery;
use Illuminate\Http\Request;

class InfoDeliveryController extends Controller
{
  /**
   * @param InfoDeliveryRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function index(InfoDeliveryRequest $request)
  {
    $isSend = $request->input('type') === 'send'; // 我投递的
    $isReceive = $request->input('type') === 'receive'; // 投递给我的
    $data = [];
    if ($isSend) {
      $data = $this->getSendInfo($request);
    } else if ($isReceive) {
      $data = $this->getReceiveInfo($request);
    }
    return $this->setParams($data)->success();
  }

  /**
   * @param InfoDeliveryRequest $request
   * @return mixed
   */
  private function getSendInfo(InfoDeliveryRequest $request)
  {
    $receive_info_type = $this->getModelPath($request->input('receive_info_type'));
    return InfoDelivery::with('receive_info:id,title')
      ->where('send_user_id', User::getUserId())
      ->where('receive_info_type', $receive_info_type)
      ->orderByDesc('id')
      ->pagination();
  }

  /**
   * @param InfoDeliveryRequest $request
   * @return mixed
   */
  private function getReceiveInfo(InfoDeliveryRequest $request)
  {
    $send_info_type = $this->getModelPath($request->input('send_info_type'));
    return InfoDelivery::with('send_info:id,title')
      ->where('receive_user_id', User::getUserId())
      ->where('send_info_type', $send_info_type)
      ->orderByDesc('id')
      ->pagination();
  }

  /**
   * @param InfoDeliveryRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(InfoDeliveryRequest $request)
  {
    $input = $this->getInput($request);

    if ($input['send_user_id'] === $input['receive_user_id']) {
      return $this->error('不可以自己投递给自己发布的信息');
    }
    $isExists = $this->getExistsQuery($input)->exists();
    if ($isExists) {
      return $this->error('您已经投递过了');
    }

    $sendInfo = (new $input['send_info_type']())->findOrFail($input['send_info_id']);
    if ($sendInfo->status !== $input['send_info_type']::getOptionsValue2('status', '已发布')) {
      return $this->error('信息状态错误');
    }

    $receiveInfo = (new $input['receive_info_type']())->findOrFail($input['receive_info_id']);
    if ($receiveInfo->status !== $input['receive_info_type']::getOptionsValue2('status', '已发布')) {
      return $this->error('信息状态错误');
    }

    InfoDelivery::create($input);
    return $this->success('投递成功');
  }

  /**
   * @param InfoDeliveryRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function show(InfoDeliveryRequest $request)
  {
    $input = $this->getInput($request);
    $data = $this->getExistsQuery($input)->first();
    return $this->setParams($data)->success();
  }

  /**
   * @param $input
   * @return InfoDelivery|\Illuminate\Database\Eloquent\Builder
   */
  private function getExistsQuery($input)
  {
    return InfoDelivery::with('send_info:id,title')->where([
      ['send_user_id', '=', $input['send_user_id']],
      ['receive_user_id', '=', $input['receive_user_id']],
      ['send_info_type', '=', $input['send_info_type']],
      ['receive_info_type', '=', $input['receive_info_type']],
      ['receive_info_id', '=', $input['receive_info_id']]
    ]);
  }

  /**
   * @param InfoDeliveryRequest $request
   * @return array
   */
  private function getInput(InfoDeliveryRequest $request)
  {
    $input = [];
    $input['send_info_type'] = $this->getModelPath($request->input('send_info_type'));
    $input['send_info_id'] = $request->input('send_info_id');
    $input['receive_info_type'] = $this->getModelPath($request->input('receive_info_type'));
    $input['receive_info_id'] = $request->input('receive_info_id');
    $receiveInfo = (new $input['receive_info_type']())->findOrFail($input['receive_info_id']);
    $input['receive_user_id'] = $receiveInfo->user_id;
    $input['send_user_id'] = User::getUserId();
    return $input;
  }

  /**
   * @param InfoDeliveryRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function getInfoList(InfoDeliveryRequest $request)
  {
    $send_info_type = $this->getModelPath($request->input('send_info_type'));
    $data = $send_info_type::select(['id', 'title', 'status'])->where('user_id', User::getUserId())
      ->orderByDesc('id')
      ->simplePagination();
    return $this->setParams($data)->success();
  }
}
