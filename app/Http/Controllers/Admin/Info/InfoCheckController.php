<?php

namespace App\Http\Controllers\Admin\Info;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Info\InfoCheckRequest;
use App\Models\Info\Hr\HrJob;
use App\Models\Info\InfoCheck;

class InfoCheckController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $data = InfoCheck::with('user:id,nickname')
      ->searchType()
      ->where('status', InfoCheck::getOptionsValue(47, '待审核'))
      ->orderByDesc('id')
      ->pagination();
    return $this->setParams($data)->success();
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function show($id)
  {
    $data = InfoCheck::findOrFail($id);
    return $this->setParams($data)->success();
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function update(InfoCheckRequest $request, $id)
  {
    $infoCheckData = InfoCheck::findOrFail($id);
    $checkStatus = $request->input('status');
    $refuseReason = $request->input('refuse_reason');
    $contents = $request->input('contents');
    $infoCheckData->contents = $contents;
    $infoCheckData->save();


  }
}
