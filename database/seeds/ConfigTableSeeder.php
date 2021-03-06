<?php

use Illuminate\Database\Seeder;

class ConfigTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $this->createOptions('_global:seniority', '工作年限', ['一年以下', '1-2年', '3-5年', '5-10年', '10-15年', '15-20年', '20年以上', '无要求']);
    $this->createOptions('UserPersonal:tags', '自我评价', ['诚信正直', '沟通力强', '执行力强', '学习力强', '创业经历', '责任心强', '有领导力', '吃苦耐劳']);
    $this->createOptions('UserEnterprise:tags', '公司标签', ['按时发薪', '福利优厚', '环境优美', '工作轻松', '实力雄厚', '前景无限', '上市公司', '勤快多金']);
    $this->createOptions('UserEnterprise:company_scale', '企业规模', ['10人以下', '10~50人', '50~100人', '100~500人', '500~1000人', '1000~3000人', '3000~5000人', '5000人以上']);
    $this->createOptions('UserCoupon:coupon_status', '优惠券状态', ['未使用', [
      'display_name' => '已使用',
      'color' => 'success'
    ], '已过期', '挂售中', '已出售']);
    $this->createOptions('UserOrder:pay_status', '支付状态', ['未支付', [
      'display_name' => '已支付',
      'color' => 'success'
    ], '支付失败']);
    $this->createOptions('UserPersonalAuth:status', '个人认证状态', ['审核中', [
      'display_name' => '已通过',
      'color' => 'success'
    ], [
      'display_name' => '已拒绝',
      'color' => 'error'
    ]]);
    $this->createOptions('UserEnterpriseAuth:status', '企业认证状态', ['审核中', [
      'display_name' => '已通过',
      'color' => 'success'
    ], [
      'display_name' => '已拒绝',
      'color' => 'error'
    ]]);
    $this->createOptions('InfoCheck:status', '审核状态', ['待审核', [
      'display_name' => '已通过',
      'color' => 'success'
    ], [
      'display_name' => '已拒绝',
      'color' => 'error'
    ]]);
    $this->createOptions('HrJob:status', '发布状态', ['已发布', '已解决', '已下架', '已到期
']);
    $this->createOptions('_global:treatment', '要求待遇', ['包吃', '包住', '加班补助', '房补', '面谈', '社保', '公积金', '上班26天', '上班28天', '11小时/天', '产值奖']);
    $this->createOptions('_global:education', '学历', ['初中', '高中', '技校', '中专', '大专', '本科', '硕士', '博士', '无学历要求']);
    $this->createOptions('UserPersonal:position_attr', '职位属性', ['技术工程师', '管理人员', '普通工人']);
    $this->createOptions('UserEnterprise:industry_attr', '行业属性', ['材料供应商', '加工企业', '设备供应商']);
    $this->createOptions('HrResume:status', '发布状态', ['已发布', '已解决', '已下架', '已到期']);
    $this->createOptions('UserCash:status', '提现状态', ['申请中', [
      'display_name' => '已通过',
      'color' => 'success'
    ], '已拒绝', '已撤回', [
      'display_name' => '已转款',
      'color' => 'success'
    ]]);
    $this->createOptions('InfoComplaint:complaint_type', '投诉类型', ['已招到', '中介', '电话有误', '其他']);
    $this->createOptions('	InfoProvide:status', '信息提供状态', ['待审核', '已发布', '中介', '已招到', '面试中', '不需要', '未接通', '电话错', '态度差', '正在忙', '已关机', '挂电话', '难沟通']);
    $this->createOptions('Task:task_type', '任务类型', ['通用任务', '个人任务', '企业任务']);
    $this->createOptions('CouponMarket:status', '出售状态', ['出售中', '待支付', '已出售', '已下架', '已撤回']);
    $this->createOptions('CouponOrder:payment', '支付方式', ['微信', '余额']);
    $this->createOptions('CouponOrder:pay_status', '支付状态', ['未支付', [
      'display_name' => '已支付',
      'color' => 'success'
    ], '已过期', '已放弃']);
    $this->createConfig('HrJob@amount', 3, '查看招聘金额');
    $this->createConfig('HrJob@original_amount', 10, '查看招聘金额原价');
    $this->createConfig('HrResume@amount', 3, '查看求职金额');
    $this->createConfig('HrResume@original_amount', 10, '查看求职金额原价');
  }

  private function createOptions($name, $display_name, $options)
  {
    $options = collect($options)->map(function ($option, $index) {
      if (is_array($option)) {
        if (!isset($option['value'])) {
          $option['value'] = $index + 1;
        }
        if (!isset($option['sort'])) {
          $option['sort'] = 0;
        }
        return $option;
      } else {
        return [
          'display_name' => $option,
          'value' => $index + 1,
          'sort' => 0
        ];
      }
    })->toArray();
    $Config = new \App\Models\Config();
    $configData = $Config->create([
      'name' => trim($name),
      'display_name' => $display_name,
      'guard_name' => 'options'
    ]);
    $configData->options()->createMany($options);
  }

  private function createConfig($name, $value, $display_name) {
    \App\Models\Config::create([
      'name' => $name,
      'display_name' => $display_name,
      'value' => $value,
      'guard_name' => 'config'
    ]);
  }
}
