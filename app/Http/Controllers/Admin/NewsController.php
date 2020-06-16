<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewsRequest;
use App\Models\Image;
use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;

class NewsController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $data = News::orderByDesc('id')->paginate();
    return $this->setParams($data)->success();
  }

  /**
   * @param NewsRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(NewsRequest $request)
  {
    $input = $request->only(News::getFillFields());
    $input['user_id'] = User::getUserId();
    $data = News::create($input);
    (new Image())->updateImageableId($data->id);
    return $this->success();
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function show($id)
  {
    $data = News::findOrFail($id);
    return $this->setParams($data)->success();
  }

  /**
   * @param NewsRequest $request
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(NewsRequest $request, $id)
  {
    $input = $request->only(News::getFillFields());
    $data = News::findOrFail($id);
    $data->update($input);
    return $this->success();
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   * @throws \Exception
   */
  public function destroy($id)
  {
    $data = News::findOrFail($id);
    (new Image())->delImages($data->images()->getQuery());
    $data->delete();
    return $this->success();
  }
}
