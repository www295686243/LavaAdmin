<?php

namespace App\Models\Old;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
  protected $connection = 'zhizao';

  protected $casts = [
    'avatar' => 'array',
    'tags' => 'array',
    'education_experience' => 'array',
    'work_experience' => 'array',
    'honorary_certificate' => 'array',
    'company_images' => 'array'
  ];

  /**
   * @param $value
   * @return array|mixed
   */
  public function getAvatarAttribute($value)
  {
    return $value ? json_decode($value) : [];
  }

  /**
   * @param $value
   * @return array|mixed
   */
  public function getTagsAttribute($value)
  {
    return $value ? json_decode($value) : [];
  }

  /**
   * @param $value
   * @return array|mixed
   */
  public function getEducationExperienceAttribute($value)
  {
    return $value ? json_decode($value) : [];
  }

  /**
   * @param $value
   * @return array|mixed
   */
  public function getWorkExperienceAttribute($value)
  {
    return $value ? json_decode($value) : [];
  }

  /**
   * @param $value
   * @return array|mixed
   */
  public function getHonoraryCertificateAttribute($value)
  {
    return $value ? json_decode($value) : [];
  }

  /**
   * @param $value
   * @return array|mixed
   */
  public function getCompanyImagesAttribute($value)
  {
    return $value ? json_decode($value) : [];
  }
}
