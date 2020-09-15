<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\ImageTrait;
use App\Http\Requests\Admin\ImageRequest;
use App\Models\Admin\User;
use App\Models\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
  use ImageTrait;
  /**
   * @param ImageRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function index(ImageRequest $request)
  {
    $type = $request->input('type');
    $modelName = 'App\Models\\'.str_replace('/', '\\', $type);
    $info_id = $request->input('info_id');
    $marking = $request->input('marking');
    $data = Image::when($info_id, function ($query, $info_id) {
        return $query->where('imageable_id', $info_id);
      }, function ($query) use ($marking) {
        return $query->where('marking', $marking);
      })
      ->where('imageable_type', $modelName)
      ->orderByDesc('id')
      ->pagination();
    return $this->setParams($data)->success();
  }

  /**
   * @param ImageRequest $request
   * @return \Illuminate\Http\JsonResponse
   * @throws \Throwable
   */
  public function store(ImageRequest $request)
  {
    return $this->_store($request, User::getUserId());
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
