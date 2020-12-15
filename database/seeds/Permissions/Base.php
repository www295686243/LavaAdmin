<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/12/15
 * Time: 14:14
 */

namespace Database\Seeders\Permissions;

class Base {
  protected $data = [];

  /**
   * @param array $data
   * @param $platform
   * @return array
   */
  protected function setPlatform(array $data, $platform) {
    $data['platform'] = $platform;
    if (isset($data['children'])) {
      $data['children'] = $this->recursionSetField($data['children'], 'platform', $platform);
    }
    return $data;
  }

  /**
   * @param array $data
   * @param $guard_name
   * @return array
   */
  protected function setGuardName(array $data, $guard_name) {
    $data['guard_name'] = $guard_name;
    if (isset($data['children'])) {
      $data['children'] = $this->recursionSetField($data['children'], 'guard_name', $guard_name);
    }
    return $data;
  }

  /**
   * @param array $data
   * @param $field
   * @param $value
   * @return array
   */
  private function recursionSetField(array $data, $field, $value)
  {
    return collect($data)->map(function ($item) use ($field, $value) {
      $item[$field] = $value;
      if (isset($item['children'])) {
        $item['children'] = $this->recursionSetField($item['children'], $field, $value);
      }
      return $item;
    })->toArray();
  }

  /**
   * @return array
   */
  public function get()
  {
    return $this->data;
  }
}
