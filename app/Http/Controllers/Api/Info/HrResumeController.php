<?php

namespace App\Http\Controllers\Api\Info;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Info\HrResumeRequest;
use App\Models\Api\User;
use App\Models\Info\Hr\HrResume;
use Illuminate\Http\Request;

class HrResumeController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $data = HrResume::pagination();
    return $this->setParams($data)->success();
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function show($id)
  {
    $resumeData = HrResume::findOrFail($id);
    $resumeSubData = $resumeData->info_sub()->first();
    $resumeData->description = $resumeSubData->description;
    return $this->setParams($resumeData)->success();
  }
}
