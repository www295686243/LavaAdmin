<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/9/11
 * Time: 16:09
 */

namespace App\Http\Controllers\Traits;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

trait ImageTrait
{
  /**
   * @param Request $request
   * @param $user_id
   * @return mixed
   * @throws \Throwable
   */
  protected function _store(Request $request, $user_id)
  {
    $info_id = $request->input('info_id');
    $_model = $request->input('_model');
    $urlPath = $_model.'/'.($info_id ?? 'temp');
    $file = $request->file('file');
    $file->isValid();
    $fileInfo = getimagesize($file);
    $input['imageable_type'] = $this->getModelPath();
    $input['imageable_id'] = $info_id;
    $input['width'] = $fileInfo[0];
    $input['height'] = $fileInfo[1];
    $input['user_id'] = $user_id;
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
