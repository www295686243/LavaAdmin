<?php

namespace App\Http\Controllers\Api\Info;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Info\HrJobRequest;
use App\Models\Api\User;
use App\Models\Info\Hr\HrJob;
use Illuminate\Http\Request;

class HrJobController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function show($id)
  {
    $jobData = HrJob::findOrFail($id);
    $jobSubData = $jobData->info_sub()->first();
    $jobData->description = $jobSubData->description;
    return $this->setParams($jobData)->success();
  }
}
