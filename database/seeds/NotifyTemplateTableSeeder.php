<?php

use Illuminate\Database\Seeder;

class NotifyTemplateTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    \App\Models\Notify\NotifyTemplate::create([
      'id' => 1,
      'template_id' => '-JrKtqryqqHGkwPmLxRGsUh-Utcn4nz1uJFJX0zCar0',
      'title' => '个人认证通过通知',
      'content' => '亲爱的{nickname}，您好，您的个人认证已通过！',
      'remark' => '您的个人认证申请已通过，进入【我的-设置-清除缓存】可更新状态！',
      'host' => env('APP_M_URL'),
      'url' => '/user',
      'url_params' => '',
      'keyword_names' => 'name,姓名|datetime,通过时间',
      'is_push_official_account' => 1,
      'is_push_message' => 1
    ]);
    \App\Models\Notify\NotifyTemplate::create([
      'id' => 2,
      'template_id' => '2bOJ-heIY_2IQc8M968w7BkA3cb0L6HZXD0qUD5UCPA',
      'title' => '个人认证不通过通知',
      'content' => '您提交的个人认证信息，审批不通过',
      'remark' => '如有疑问可咨询原草客服',
      'host' => env('APP_M_URL'),
      'url' => '/user',
      'url_params' => '',
      'keyword_names' => 'refuse_reason,拒绝理由|name,审核人',
      'is_push_official_account' => 1,
      'is_push_message' => 1
    ]);
    \App\Models\Notify\NotifyTemplate::create([
      'id' => 3,
      'template_id' => '-JrKtqryqqHGkwPmLxRGsUh-Utcn4nz1uJFJX0zCar0',
      'title' => '企业认证通过通知',
      'content' => '亲爱的{nickname}，您好，您的企业认证已通过！',
      'remark' => '您的企业认证申请已通过，进入【我的-设置-清除缓存】可更新状态！',
      'host' => env('APP_M_URL'),
      'url' => '/user',
      'url_params' => '',
      'keyword_names' => 'company,公司名|datetime,通过时间',
      'is_push_official_account' => 1,
      'is_push_message' => 1
    ]);
    \App\Models\Notify\NotifyTemplate::create([
      'id' => 4,
      'template_id' => '2bOJ-heIY_2IQc8M968w7BkA3cb0L6HZXD0qUD5UCPA',
      'title' => '企业认证不通过通知',
      'content' => '您提交的企业认证信息，审批不通过',
      'remark' => '如有疑问可咨询原草客服',
      'host' => env('APP_M_URL'),
      'url' => '/user',
      'url_params' => '',
      'keyword_names' => 'refuse_reason,拒绝理由|name,审核人',
      'is_push_official_account' => 1,
      'is_push_message' => 1
    ]);
    \App\Models\Notify\NotifyTemplate::create([
      'id' => 5,
      'template_id' => 'R2HkhhoO9sul3aR6aOqJldE3incm1dz_wXJIsdMeDdQ',
      'title' => '职位信息添加审核通过通知',
      'content' => '职位信息添加审核通过',
      'remark' => '点击详情可进行管理',
      'host' => env('APP_M_URL'),
      'url' => '/hr/job/show',
      'url_params' => 'id',
      'keyword_names' => 'title,职位信息|datetime,审核时间|result,审核结果|remark,审核意见',
      'is_push_official_account' => 1,
      'is_push_message' => 1
    ]);
    \App\Models\Notify\NotifyTemplate::create([
      'id' => 6,
      'template_id' => 'R2HkhhoO9sul3aR6aOqJldE3incm1dz_wXJIsdMeDdQ',
      'title' => '职位信息修改审核通过通知',
      'content' => '职位信息修改审核通过',
      'remark' => '点击详情可进行管理',
      'host' => env('APP_M_URL'),
      'url' => '/hr/job/show',
      'url_params' => 'id',
      'keyword_names' => 'title,职位信息|datetime,审核时间|result,审核结果|remark,审核意见',
      'is_push_official_account' => 1,
      'is_push_message' => 1
    ]);
    \App\Models\Notify\NotifyTemplate::create([
      'id' => 7,
      'template_id' => 'R2HkhhoO9sul3aR6aOqJldE3incm1dz_wXJIsdMeDdQ',
      'title' => '简历信息添加审核通过通知',
      'content' => '简历信息添加审核通过',
      'remark' => '点击详情可进行管理',
      'host' => env('APP_M_URL'),
      'url' => '/hr/resume/show',
      'url_params' => 'id',
      'keyword_names' => 'title,简历信息|datetime,审核时间|result,审核结果|remark,审核意见',
      'is_push_official_account' => 1,
      'is_push_message' => 1
    ]);
    \App\Models\Notify\NotifyTemplate::create([
      'id' => 8,
      'template_id' => 'R2HkhhoO9sul3aR6aOqJldE3incm1dz_wXJIsdMeDdQ',
      'title' => '简历信息修改审核通过通知',
      'content' => '简历信息修改审核通过',
      'remark' => '点击详情可进行管理',
      'host' => env('APP_M_URL'),
      'url' => '/hr/resume/show',
      'url_params' => 'id',
      'keyword_names' => 'title,简历信息|datetime,审核时间|result,审核结果|remark,审核意见',
      'is_push_official_account' => 1,
      'is_push_message' => 1
    ]);
    \App\Models\Notify\NotifyTemplate::create([
      'id' => 9,
      'template_id' => 'R2HkhhoO9sul3aR6aOqJldE3incm1dz_wXJIsdMeDdQ',
      'title' => '职位信息添加审核失败通知',
      'content' => '职位信息添加审核失败',
      'remark' => '点击详情可进行管理',
      'host' => env('APP_M_URL'),
      'url' => '/user/hr/job',
      'url_params' => '',
      'keyword_names' => 'title,职位信息|datetime,审核时间|result,审核结果|remark,审核意见',
      'is_push_official_account' => 1,
      'is_push_message' => 1
    ]);
    \App\Models\Notify\NotifyTemplate::create([
      'id' => 10,
      'template_id' => 'R2HkhhoO9sul3aR6aOqJldE3incm1dz_wXJIsdMeDdQ',
      'title' => '职位信息修改审核失败通知',
      'content' => '职位信息修改审核失败',
      'remark' => '点击详情可进行管理',
      'host' => env('APP_M_URL'),
      'url' => '/user/hr/job',
      'url_params' => '',
      'keyword_names' => 'title,职位信息|datetime,审核时间|result,审核结果|remark,审核意见',
      'is_push_official_account' => 1,
      'is_push_message' => 1
    ]);
    \App\Models\Notify\NotifyTemplate::create([
      'id' => 11,
      'template_id' => 'R2HkhhoO9sul3aR6aOqJldE3incm1dz_wXJIsdMeDdQ',
      'title' => '简历信息添加审核失败通知',
      'content' => '简历信息添加审核失败',
      'remark' => '点击详情可进行管理',
      'host' => env('APP_M_URL'),
      'url' => '/user/hr/resume',
      'url_params' => '',
      'keyword_names' => 'title,简历信息|datetime,审核时间|result,审核结果|remark,审核意见',
      'is_push_official_account' => 1,
      'is_push_message' => 1
    ]);
    \App\Models\Notify\NotifyTemplate::create([
      'id' => 12,
      'template_id' => 'R2HkhhoO9sul3aR6aOqJldE3incm1dz_wXJIsdMeDdQ',
      'title' => '简历信息修改审核失败通知',
      'content' => '简历信息修改审核失败',
      'remark' => '点击详情可进行管理',
      'host' => env('APP_M_URL'),
      'url' => '/user/hr/resume',
      'url_params' => '',
      'keyword_names' => 'title,简历信息|datetime,审核时间|result,审核结果|remark,审核意见',
      'is_push_official_account' => 1,
      'is_push_message' => 1
    ]);
    \App\Models\Notify\NotifyTemplate::create([
      'id' => 13,
      'template_id' => 'CYqMq0rj4Vc7c28JGJZvbK83Dct8Zg5-fvQ4Ztp66-Q',
      'title' => '职位已到期通知',
      'content' => '{nickname}，您发布的招聘信息已到期',
      'remark' => '过期后，其他用户将无法查看联系您，您也无法再领取每日招聘券，如需继续，点击详情修改时间免费延期。',
      'host' => env('APP_M_URL'),
      'url' => '/user/hr/job/form',
      'url_params' => 'id',
      'keyword_names' => 'title,职位信息|created_at,发布时间|end_time,到期时间',
      'is_push_official_account' => 1,
      'is_push_message' => 1
    ]);
    \App\Models\Notify\NotifyTemplate::create([
      'id' => 14,
      'template_id' => 'CYqMq0rj4Vc7c28JGJZvbK83Dct8Zg5-fvQ4Ztp66-Q',
      'title' => '职位即将到期通知',
      'content' => '{nickname}，您发布的招聘信息即将到期',
      'remark' => '过期后，其他用户将无法查看联系您，您也无法再领取每日招聘券，如需继续，点击详情修改时间免费延期。',
      'host' => env('APP_M_URL'),
      'url' => '/user/hr/job/form',
      'url_params' => 'id',
      'keyword_names' => 'title,职位信息|created_at,发布时间|end_time,到期时间',
      'is_push_official_account' => 1,
      'is_push_message' => 1
    ]);
    \App\Models\Notify\NotifyTemplate::create([
      'id' => 15,
      'template_id' => 'CYqMq0rj4Vc7c28JGJZvbK83Dct8Zg5-fvQ4Ztp66-Q',
      'title' => '简历已到期通知',
      'content' => '{nickname}，您发布的简历信息已到期',
      'remark' => '过期后，其他用户将无法查看联系您，您也无法再领取每日求职券，如需继续，点击详情修改时间免费延期。',
      'host' => env('APP_M_URL'),
      'url' => '/user/hr/resume/form',
      'url_params' => 'id',
      'keyword_names' => 'title,简历信息|created_at,发布时间|end_time,到期时间',
      'is_push_official_account' => 1,
      'is_push_message' => 1
    ]);
    \App\Models\Notify\NotifyTemplate::create([
      'id' => 16,
      'template_id' => 'CYqMq0rj4Vc7c28JGJZvbK83Dct8Zg5-fvQ4Ztp66-Q',
      'title' => '简历即将到期通知',
      'content' => '{nickname}，您发布的简历信息即将到期',
      'remark' => '过期后，其他用户将无法查看联系您，您也无法再领取每日求职券，如需继续，点击详情修改时间免费延期。',
      'host' => env('APP_M_URL'),
      'url' => '/user/hr/resume/form',
      'url_params' => 'id',
      'keyword_names' => 'title,简历信息|created_at,发布时间|end_time,到期时间',
      'is_push_official_account' => 1,
      'is_push_message' => 1
    ]);
    \App\Models\Notify\NotifyTemplate::create([
      'id' => 17,
      'template_id' => 'CYqMq0rj4Vc7c28JGJZvbK83Dct8Zg5-fvQ4Ztp66-Q',
      'title' => '职位信息下架通知',
      'content' => '{nickname}，您发布的招聘信息已下架。',
      'remark' => '感谢您使用原草互助，因获得反馈，客服设定您的职位为已下架，如未能解决您的问题，请及时改为发布状态，以免耽误您的招聘，每日招聘券也不再赠送！谢谢您的支持！',
      'host' => env('APP_M_URL'),
      'url' => '/user/hr/job/form',
      'url_params' => 'id',
      'keyword_names' => 'title,职位信息|created_at,发布时间|end_time,到期时间',
      'is_push_official_account' => 1,
      'is_push_message' => 1
    ]);
    \App\Models\Notify\NotifyTemplate::create([
      'id' => 18,
      'template_id' => 'CYqMq0rj4Vc7c28JGJZvbK83Dct8Zg5-fvQ4Ztp66-Q',
      'title' => '简历信息下架通知',
      'content' => '{nickname}，您发布的简历信息已下架。',
      'remark' => '感谢您使用原草互助，因获得反馈，客服设定您的简历为已下架，如未能解决您的问题，请及时改为发布状态，以免耽误您的求职，每日求职券也不再赠送！谢谢您的支持！',
      'host' => env('APP_M_URL'),
      'url' => '/user/hr/resume/form',
      'url_params' => 'id',
      'keyword_names' => 'title,简历信息|created_at,发布时间|end_time,到期时间',
      'is_push_official_account' => 1,
      'is_push_message' => 1
    ]);
    \App\Models\Notify\NotifyTemplate::create([
      'id' => 19,
      'template_id' => 'CYqMq0rj4Vc7c28JGJZvbK83Dct8Zg5-fvQ4Ztp66-Q',
      'title' => '职位信息解决通知',
      'content' => '{nickname}，您发布的招聘信息已解决。',
      'remark' => '感谢您使用原草互助，因获得反馈，客服设定您的职位为已解决，如未能解决您的问题，请及时改为发布状态，以免耽误您的招聘，每日招聘券也不再赠送！谢谢您的支持！',
      'host' => env('APP_M_URL'),
      'url' => '/user/hr/job/form',
      'url_params' => 'id',
      'keyword_names' => 'title,职位信息|created_at,发布时间|end_time,到期时间',
      'is_push_official_account' => 1,
      'is_push_message' => 1
    ]);
    \App\Models\Notify\NotifyTemplate::create([
      'id' => 20,
      'template_id' => 'CYqMq0rj4Vc7c28JGJZvbK83Dct8Zg5-fvQ4Ztp66-Q',
      'title' => '简历信息解决通知',
      'content' => '{nickname}，您发布的简历信息已解决。',
      'remark' => '感谢您使用原草互助，因获得反馈，客服设定您的简历为已解决，如未能解决您的问题，请及时改为发布状态，以免耽误您的求职，每日求职券也不再赠送！谢谢您的支持！',
      'host' => env('APP_M_URL'),
      'url' => '/user/hr/resume/form',
      'url_params' => 'id',
      'keyword_names' => 'title,简历信息|created_at,发布时间|end_time,到期时间',
      'is_push_official_account' => 1,
      'is_push_message' => 1
    ]);
    \App\Models\Notify\NotifyTemplate::create([
      'id' => 21,
      'template_id' => '1h1a7y7pLYmKVYwhpXHvz4YQbXsnFgVdxDYvqIfMaro',
      'title' => '招聘信息推送',
      'content' => '您好，您收到一份职位，请查阅。',
      'remark' => '点击查看职位详情！如推送信息不准确，请在【个人中心-设置】修改行业和地区，及选择订阅开关！',
      'host' => env('APP_M_URL'),
      'queue' => 7,
      'url' => '/hr/job/show',
      'url_params' => 'id',
      'keyword_names' => 'company,公司名称|title,职位信息|industry,职位类别|city,工作地点|monthly,薪资',
      'is_push_official_account' => 1,
      'is_push_message' => 1
    ]);
    \App\Models\Notify\NotifyTemplate::create([
      'id' => 22,
      'template_id' => '1h1a7y7pLYmKVYwhpXHvz4YQbXsnFgVdxDYvqIfMaro',
      'title' => '投递后职位信息推送',
      'content' => '您好，您发布《{title}》的简历，有企业意中，招聘岗位详情如下，请点击查看联系！',
      'remark' => '点击查看职位详情！\n提示：可在个人中心，我的投递记录中再次查看！',
      'host' => env('APP_M_URL'),
      'url' => '/hr/job/show',
      'url_params' => 'id,source',
      'keyword_names' => 'company,公司名称|title,职位信息|industry,职位类别|city,工作地点|monthly,薪资',
      'is_push_official_account' => 1,
      'is_push_message' => 1
    ]);
    \App\Models\Notify\NotifyTemplate::create([
      'id' => 23,
      'template_id' => 'GqdTmbzbOJGpO0G30Kw_OQi7b1cnHk8T9Z_iIFIDG-A',
      'title' => '简历信息推送',
      'content' => '您好，您收到一份简历，请查阅。',
      'remark' => '点击查看简历详情！如推送信息不准确，请在【个人中心-设置】修改行业和地区，及选择订阅开关！',
      'host' => env('APP_M_URL'),
      'queue' => 7,
      'url' => '/hr/resume/show',
      'url_params' => 'id',
      'keyword_names' => 'title,应聘岗位|city,岗位城市|contacts,应聘人|created_at,发布时间',
      'is_push_official_account' => 1,
      'is_push_message' => 1
    ]);
    \App\Models\Notify\NotifyTemplate::create([
      'id' => 24,
      'template_id' => 'GqdTmbzbOJGpO0G30Kw_OQi7b1cnHk8T9Z_iIFIDG-A',
      'title' => '投递后简历信息推送',
      'content' => '您好，您发布的《{title}》有师傅应聘，详情如下，请点击查看联系！',
      'remark' => '点击查看简历详情！\n提示：可在个人中心，我的投递记录中再次查看！',
      'host' => env('APP_M_URL'),
      'url' => '/hr/resume/show',
      'url_params' => 'id,source',
      'keyword_names' => 'title,应聘岗位|city,岗位城市|contacts,应聘人|created_at,发布时间',
      'is_push_official_account' => 1,
      'is_push_message' => 1
    ]);
    \App\Models\Notify\NotifyTemplate::create([
      'id' => 25,
      'template_id' => 'vmsl5BmY3Dk1pXHSrIbbJiLSuMFTCAmVBe99Jn9a6Zo',
      'title' => '运营管理员审核信息通知',
      'content' => '您有新的派单审核，详情如下',
      'remark' => '请在三十分钟内审核处理完毕！',
      'host' => env('APP_ADMIN_URL'),
      'url' => '/hr/info-check',
      'url_params' => '_model',
      'keyword_names' => 'id,服务单号|title,项目名称|contacts,请求用户|description,请求内容|created_at,创建时间',
      'is_push_official_account' => 1,
      'is_push_message' => 0
    ]);
    \App\Models\Notify\NotifyTemplate::create([
      'id' => 26,
      'template_id' => 'vmsl5BmY3Dk1pXHSrIbbJiLSuMFTCAmVBe99Jn9a6Zo',
      'title' => '运营管理员审核个人认证通知',
      'content' => '您有新的个人认证审核，详情如下',
      'remark' => '请在三十分钟内审核处理完毕！',
      'host' => env('APP_ADMIN_URL'),
      'url' => '/user/member/personal-auth',
      'url_params' => '',
      'keyword_names' => 'id,服务单号|title,项目名称|contacts,用户姓名|description,请求内容|created_at,创建时间',
      'is_push_official_account' => 1,
      'is_push_message' => 0
    ]);
    \App\Models\Notify\NotifyTemplate::create([
      'id' => 27,
      'template_id' => 'vmsl5BmY3Dk1pXHSrIbbJiLSuMFTCAmVBe99Jn9a6Zo',
      'title' => '运营管理员审核企业认证通知',
      'content' => '您有新的企业认证审核，详情如下',
      'remark' => '请在三十分钟内审核处理完毕！',
      'host' => env('APP_ADMIN_URL'),
      'url' => '/user/member/enterprise-auth',
      'url_params' => '',
      'keyword_names' => 'id,服务单号|title,项目名称|contacts,企业名称|description,请求内容|created_at,创建时间',
      'is_push_official_account' => 1,
      'is_push_message' => 0
    ]);
    \App\Models\Notify\NotifyTemplate::create([
      'id' => 28,
      'template_id' => 'WouafHsnIV6HfqZvT5KZHlEK7Fzi38DeCCEZCQ0AQ6Y',
      'title' => '运营管理员审核投诉信息通知',
      'content' => '您有新的投诉审核，详情如下',
      'remark' => '请在三十分钟内审核处理完毕！',
      'host' => env('APP_ADMIN_URL'),
      'url' => '/hr/info-complaint',
      'url_params' => '_model',
      'keyword_names' => 'nickname,用户昵称|phone,用户手机|title,投诉标题|content,投诉内容',
      'is_push_official_account' => 1,
      'is_push_message' => 0
    ]);
    \App\Models\Notify\NotifyTemplate::create([
      'id' => 29,
      'template_id' => 'BPTCSvr53VLsucbFd6z4CZ3VJkXlQU4LHMZd4OP_FGQ',
      'title' => '推送给用户职位投诉结果通知',
      'content' => '投诉处理结果',
      'remark' => '感谢您的支持与理解！',
      'host' => env('APP_M_URL'),
      'url' => '/hr/job/show',
      'url_params' => 'id',
      'keyword_names' => 'updated_at,处理时间|handle_content,处理结果',
      'is_push_official_account' => 1,
      'is_push_message' => 1
    ]);
    \App\Models\Notify\NotifyTemplate::create([
      'id' => 30,
      'template_id' => 'BPTCSvr53VLsucbFd6z4CZ3VJkXlQU4LHMZd4OP_FGQ',
      'title' => '推送给用户简历投诉结果通知',
      'content' => '投诉处理结果',
      'remark' => '感谢您的支持与理解！',
      'host' => env('APP_M_URL'),
      'url' => '/hr/resume/show',
      'url_params' => 'id',
      'keyword_names' => 'updated_at,处理时间|handle_content,处理结果',
      'is_push_official_account' => 1,
      'is_push_message' => 1
    ]);
    \App\Models\Notify\NotifyTemplate::create([
      'id' => 31,
      'template_id' => 'sQUHqkEfnxiIKwuFXPnh8smOAD8lm6dHPH8aDA6I-pw',
      'title' => '邀请好友互助券赠送成功通知',
      'content' => '您邀请了朋友{nickname}加入原草互助，赠送您{giveCouponsText}，请注意查收！',
      'remark' => '点击进入互助卷页面查看！原草互助，互帮互助！',
      'host' => env('APP_M_URL'),
      'url' => '/user/coupon/my-coupon',
      'url_params' => '',
      'keyword_names' => 'expiry_day,到期时间|start_at,开始时间|end_at,结束时间',
      'is_push_official_account' => 1,
      'is_push_message' => 1
    ]);
    \App\Models\Notify\NotifyTemplate::create([
      'id' => 32,
      'template_id' => 'sQUHqkEfnxiIKwuFXPnh8smOAD8lm6dHPH8aDA6I-pw',
      'title' => '管理员赠送互助券成功通知',
      'content' => '您获得管理员推送{giveCouponsText}，请查收',
      'remark' => '点击了解更多的互助券免费获得方式！',
      'host' => env('APP_M_URL'),
      'url' => '/user/help',
      'url_params' => '',
      'keyword_names' => 'expiry_day,到期时间|start_at,开始时间|end_at,结束时间',
      'is_push_official_account' => 1,
      'is_push_message' => 1
    ]);
    \App\Models\Notify\NotifyTemplate::create([
      'id' => 33,
      'template_id' => 'sQUHqkEfnxiIKwuFXPnh8smOAD8lm6dHPH8aDA6I-pw',
      'title' => '简历分享任务互助券赠送成功通知',
      'content' => '您完成了《{title}》分享任务，赠送您{giveCouponsText}，可以用来查看职位信息联系方式，请注意查收！',
      'remark' => '点击进入互助卷页面查看！原草互助，互帮互助！',
      'host' => env('APP_M_URL'),
      'url' => '/user/coupon/my-coupon',
      'url_params' => '',
      'keyword_names' => 'expiry_day,到期时间|start_at,开始时间|end_at,结束时间',
      'is_push_official_account' => 1,
      'is_push_message' => 1
    ]);
    \App\Models\Notify\NotifyTemplate::create([
      'id' => 34,
      'template_id' => 'sQUHqkEfnxiIKwuFXPnh8smOAD8lm6dHPH8aDA6I-pw',
      'title' => '企业每天登陆互助券赠送成功通知',
      'content' => '{nickname}您好，感谢今天登录，获得1张当日招聘券',
      'remark' => '点击了解更多的互助券免费获得方式',
      'host' => env('APP_M_URL'),
      'url' => '/user/help',
      'url_params' => '',
      'keyword_names' => 'expiry_day,到期时间|start_at,开始时间|end_at,结束时间',
      'is_push_official_account' => 1,
      'is_push_message' => 1
    ]);
    \App\Models\Notify\NotifyTemplate::create([
      'id' => 35,
      'template_id' => 'sQUHqkEfnxiIKwuFXPnh8smOAD8lm6dHPH8aDA6I-pw',
      'title' => '个人每天登陆互助券赠送成功通知',
      'content' => '{nickname}您好，感谢今天登录，获得1张当日求职券',
      'remark' => '点击了解更多的互助券免费获得方式',
      'host' => env('APP_M_URL'),
      'url' => '/user/help',
      'url_params' => '',
      'keyword_names' => 'expiry_day,到期时间|start_at,开始时间|end_at,结束时间',
      'is_push_official_account' => 1,
      'is_push_message' => 1
    ]);
    \App\Models\Notify\NotifyTemplate::create([
      'id' => 36,
      'template_id' => 'sQUHqkEfnxiIKwuFXPnh8smOAD8lm6dHPH8aDA6I-pw',
      'title' => '信息提供互助券赠送成功通知',
      'content' => '{push_text}',
      'remark' => '点击进入互助卷页面！',
      'host' => env('APP_M_URL'),
      'url' => '/user/coupon/my-coupon',
      'url_params' => '',
      'keyword_names' => 'expiry_day,到期时间|start_at,开始时间|end_at,结束时间',
      'is_push_official_account' => 1,
      'is_push_message' => 1
    ]);
    \App\Models\Notify\NotifyTemplate::create([
      'id' => 37,
      'template_id' => 'FbzwkSKeRTH7cOpBWDS_CxGzscxw1dP-HaRG2MHLbtQ',
      'title' => '互助券出售成功通知',
      'content' => '{nickname}您好，您的{couponFullName}已成功出售。',
      'remark' => '感谢您的使用，可在个人中心查看资金明细及提现！',
      'host' => env('APP_M_URL'),
      'url' => '/user/coupon/sell-coupon',
      'url_params' => '',
      'keyword_names' => 'couponName,优惠券|amount,金额|datetime,出售时间',
      'is_push_official_account' => 1,
      'is_push_message' => 1
    ]);
    \App\Models\Notify\NotifyTemplate::create([
      'id' => 38,
      'template_id' => 'yShlcXGqSl-jN7H61OopQlnqHdA7FAY4ylQPwIyjfh8',
      'title' => '互助券到期通知',
      'content' => '{nickname}您好，您在售的{couponFullName}，有效期少于1天，已下架，请您在有效期内使用！',
      'remark' => '如有疑问，请联系客服！',
      'host' => env('APP_M_URL'),
      'url' => '/user/coupon/my-coupon',
      'url_params' => '',
      'keyword_names' => 'type,变更类型|result,变更结果',
      'is_push_official_account' => 1,
      'is_push_message' => 1
    ]);
    \App\Models\Notify\NotifyTemplate::create([
      'id' => 39,
      'template_id' => 'sQUHqkEfnxiIKwuFXPnh8smOAD8lm6dHPH8aDA6I-pw',
      'title' => '职位分享任务互助券赠送成功通知',
      'content' => '您完成了《{title}》分享任务，赠送您{giveCouponsText}，可以用来查看简历信息联系方式，请注意查收！',
      'remark' => '点击进入互助卷页面查看！原草互助，互帮互助！',
      'host' => env('APP_M_URL'),
      'url' => '/user/coupon/my-coupon',
      'url_params' => '',
      'keyword_names' => 'expiry_day,到期时间|start_at,开始时间|end_at,结束时间',
      'is_push_official_account' => 1,
      'is_push_message' => 1
    ]);
    \App\Models\Notify\NotifyTemplate::create([
      'id' => 40,
      'template_id' => 'sQUHqkEfnxiIKwuFXPnh8smOAD8lm6dHPH8aDA6I-pw',
      'title' => '绑定手机号任务互助券赠送成功通知',
      'content' => '您已完成绑定手机号任务，赠送您{giveCouponsText}，希望能帮到您，查收在【我的-互助卷】！',
      'remark' => '点击了解更多的互助券免费获得方式！\n如果您是求职者、招聘企业，发布求职、招聘信息，审核通过后，第二天每天将会获得1张求职卷或者招聘卷，解决您迫切的需求！',
      'host' => env('APP_M_URL'),
      'url' => '/other/help',
      'url_params' => '',
      'keyword_names' => 'expiry_day,到期时间|start_at,开始时间|end_at,结束时间',
      'is_push_official_account' => 1,
      'is_push_message' => 1
    ]);
    \App\Models\Notify\NotifyTemplate::create([
      'id' => 41,
      'template_id' => 'sQUHqkEfnxiIKwuFXPnh8smOAD8lm6dHPH8aDA6I-pw',
      'title' => '完善个人资料任务互助券赠送成功通知',
      'content' => '您已完成完善个人资料任务，赠送您{giveCouponsText}，希望能帮到您，查收在【我的-互助卷】！',
      'remark' => '点击了解更多的互助券免费获得方式！\n如果您是求职者、招聘企业，发布求职、招聘信息，审核通过后，第二天每天将会获得1张求职卷或者招聘卷，解决您迫切的需求！',
      'host' => env('APP_M_URL'),
      'url' => '/other/help',
      'url_params' => '',
      'keyword_names' => 'expiry_day,到期时间|start_at,开始时间|end_at,结束时间',
      'is_push_official_account' => 1,
      'is_push_message' => 1
    ]);
    \App\Models\Notify\NotifyTemplate::create([
      'id' => 42,
      'template_id' => 'sQUHqkEfnxiIKwuFXPnh8smOAD8lm6dHPH8aDA6I-pw',
      'title' => '关注公众号任务互助券赠送成功通知',
      'content' => '您已完成关注公众号任务，赠送您{giveCouponsText}，希望能帮到您，查收在【我的-互助卷】！',
      'remark' => '点击了解更多的互助券免费获得方式！\n如果您是求职者、招聘企业，发布求职、招聘信息，审核通过后，第二天每天将会获得1张求职卷或者招聘卷，解决您迫切的需求！',
      'host' => env('APP_M_URL'),
      'url' => '/other/help',
      'url_params' => '',
      'keyword_names' => 'expiry_day,到期时间|start_at,开始时间|end_at,结束时间',
      'is_push_official_account' => 1,
      'is_push_message' => 1
    ]);
    \App\Models\Notify\NotifyTemplate::create([
      'id' => 43,
      'template_id' => 'sQUHqkEfnxiIKwuFXPnh8smOAD8lm6dHPH8aDA6I-pw',
      'title' => '完善企业资料任务互助券赠送成功通知',
      'content' => '您已完成完善企业资料任务，赠送您{giveCouponsText}，希望能帮到您，查收在【我的-互助卷】！',
      'remark' => '点击了解更多的互助券免费获得方式！\n如果您是求职者、招聘企业，发布求职、招聘信息，审核通过后，第二天每天将会获得1张求职卷或者招聘卷，解决您迫切的需求！',
      'host' => env('APP_M_URL'),
      'url' => '/other/help',
      'url_params' => '',
      'keyword_names' => 'expiry_day,到期时间|start_at,开始时间|end_at,结束时间',
      'is_push_official_account' => 1,
      'is_push_message' => 1
    ]);
  }
}
