<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ImageRequest;
use App\Models\Api\User;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
  /**
   * @param ImageRequest $request
   * @return \Illuminate\Http\JsonResponse
   * @throws \Throwable
   */
  public function store(ImageRequest $request)
  {
    $info_id = $request->input('info_id');
    $type = $request->input('type');
    $urlPath = $type.'/'.($info_id ?? 'temp');
    $file = $request->file('file');
    $file->isValid();
    $fileInfo = getimagesize($file);
    $input['imageable_type'] = 'App\Models\\'.$type;
    $input['imageable_id'] = $info_id;
    $input['width'] = $fileInfo[0];
    $input['height'] = $fileInfo[1];
    $input['user_id'] = User::getUserId();
    $input['name'] = $file->getClientOriginalName();
    $input['mime'] = $file->getMimeType();
    $input['size'] = $file->getSize();
    $input['marking'] = $request->input('marking');

    // 执行事务
    DB::beginTransaction();
    try {
      $input['url'] = Storage::putFile($urlPath, $file);
      $data = Image::create($input);
      DB::commit();
      return $this->setParams($data)->success('上传成功');
    } catch (\Exception $e) {
      DB::rollBack();
      \Log::error($e->getMessage());
      return $this->error('上传失败');
    }
  }
}
