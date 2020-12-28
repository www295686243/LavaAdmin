<?php

namespace App\Models\Old;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Old\UserInfo
 *
 * @property int $id
 * @property array|mixed $avatar 头像/企业logo
 * @property string|null $intro 个人介绍/公司介绍
 * @property array|mixed $tags 自我评价标签/公司标签
 * @property array|mixed $education_experience 教育经历
 * @property array|mixed $work_experience 工作经历
 * @property array|mixed $honorary_certificate 荣誉证书
 * @property array|mixed $company_images 公司图片
 * @property int|null $company_scale 企业规模
 * @property int $is_open_resume_push 是否开启求职推送
 * @property int $is_open_job_push 是否开启招聘推送
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserInfo whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserInfo whereCompanyImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserInfo whereCompanyScale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserInfo whereEducationExperience($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserInfo whereHonoraryCertificate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserInfo whereIntro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserInfo whereIsOpenJobPush($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserInfo whereIsOpenResumePush($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserInfo whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserInfo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserInfo whereWorkExperience($value)
 * @mixin \Eloquent
 */
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
