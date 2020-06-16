<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ImageRequest;
use App\Models\Admin\User;
use App\Models\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
  /**
   * @param ImageRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function index(ImageRequest $request)
  {
    $type = $request->input('type');
    $modelName = '\App\Models\\'.$type;
    $info_id = $request->input('info_id');
    $limit = $request->input('limit');
    $data = Image::where('imageable_type', $modelName)
      ->when($info_id, function ($query, $info_id) {
        return $query->where('imageable_id', $info_id);
      }, function ($query) {
        return $query->where(function ($query) {
          $query->whereNull('imageable_id')->orWhere('imageable_id', 0);
        });
      })
      ->orderByDesc('id')
      ->paginate($limit);
    return $this->setParams($data)->success();
  }

  /**
   * @param ImageRequest $request
   * @return \Illuminate\Http\JsonResponse
   * @throws \Throwable
   */
  public function store(ImageRequest $request)
  {
    $info_id = $request->input('info_id');
    $type = $request->input('type');
    $urlPath = $type;
    $file = $request->file('file');
    $file->isValid();
    $fileInfo = getimagesize($file);
    $input['imageable_type'] = '\App\Models\\'.$type;
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
      return $this->error('上传失败');
    }
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   * @throws \Throwable
   */
  public function destroy($id)
  {
    $data = Image::findOrFail($id);
    // 执行事务
    DB::beginTransaction();
    try {
      Storage::delete($data->url);
      $data->delete();
      DB::commit();
      return $this->success('删除成功');
    } catch (\Exception $e) {
      DB::rollBack();
      return $this->error('删除失败');
    }
  }

  /**
   * @param ImageRequest $request
   * @return \Illuminate\Http\JsonResponse
   * @throws \Throwable
   */
  public function destroyMore(ImageRequest $request)
  {
    $ids = $request->input('ids', []);
    DB::beginTransaction();
    try {
      $query = Image::whereIn('id', $ids);
      foreach ($query->get() as $item) {
        Storage::delete($item->url);
      }
      $query->delete();
      DB::commit();
      return $this->success('删除成功');
    } catch (\Exception $e) {
      DB::rollBack();
      return $this->error('删除失败');
    }
  }
}
