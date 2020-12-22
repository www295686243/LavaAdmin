<?php

namespace Database\Seeders\Data;

use App\Models\Old\Auth;
use App\Models\Old\ModelHasRole;
use App\Models\Old\User;
use App\Models\Old\UserBill;
use App\Models\Old\UserCash;
use App\Models\Old\UserEnterpriseAuth;
use App\Models\Old\UserPersonalAuth;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Kra8\Snowflake\Snowflake;

class UserTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    User::whereHas('user_info')
//      ->where(function ($query) {
//        $query->orWhere('is_admin', 1)
//          ->orWhereNotNull('phone')
//          ->orWhere('is_follow_official_account', 1);
//      })
      ->get()
      ->chunk(500)
      ->each(function ($lists) {
        $userDatas = $this->getUserArr($lists);
        $userPersonalDatas = $this->getUserPersonalArr($lists);
        $userEnterpriseDatas = $this->getUserEnterpriseArr($lists);
        $userControlDatas = $this->getUserControlArr($lists);
        $userWalletDatas = $this->getUserWalletArr($lists);
        $userRoleDatas = $this->setUserRole($lists);
        DB::table('users')->insert($userDatas);
        DB::table('user_personals')->insert($userPersonalDatas);
        DB::table('user_enterprises')->insert($userEnterpriseDatas);
        DB::table('user_controls')->insert($userControlDatas);
        DB::table('user_wallets')->insert($userWalletDatas);
        DB::table('model_has_roles')->insert($userRoleDatas);
        $userAuthDatas = $this->getUserAuthArr(Auth::whereIn('user_id', $lists->pluck('id'))->get());
        DB::table('user_auths')->insert($userAuthDatas);
      });
    $userPersonalAuthDatas = $this->getUserPersonalAuthArr(UserPersonalAuth::all());
    DB::table('user_personal_auths')->insert($userPersonalAuthDatas);
    $userEnterpriseAuthDatas = $this->getUserEnterpriseAuthArr(UserEnterpriseAuth::all());
    DB::table('user_enterprise_auths')->insert($userEnterpriseAuthDatas);
    $userCashDatas = $this->getUserCashArr(UserCash::where('status', 2)->get());
    DB::table('user_cashes')->insert($userCashDatas);
    $userBillDatas = $this->getUserBillArr(UserBill::all());
    DB::table('user_bills')->insert($userBillDatas);
    $this->setUserRole2();

    $adminUsers = \App\Models\User\User::where('is_admin', 1)->get();
    foreach ($adminUsers as $adminUser) {
      $adminUser->password = '111111';
      $adminUser->save();
    }
    $root = \App\Models\User\User::find(1);
    $root->assignRole('root');
  }

  private function getUserArr($data)
  {
    $result = [];
    $arr = [];
    foreach ($data as $item) {
      $arr['id'] = $item->id;
      $arr['invite_user_id'] = $item->invite_user_id;
      $arr['nickname'] = $item->nickname;
      $arr['username'] = $item->username;
      $arr['phone'] = $item->phone;
      $arr['head_url'] = $item->head_url;
      $arr['city'] = $item->city;
      $arr['current_role'] = 'Personal Member';
      $arr['is_follow_official_account'] = $item->is_follow_official_account;
      $arr['follow_official_account_scene'] = $item->follow_official_account_scene;
      $arr['is_admin'] = $item->is_admin;
      $arr['register_at'] = $item->register_at;
      $arr['last_login_at'] = $item->last_login_at;
      $arr['created_at'] = $item->created_at->format('Y-m-d H:i:s');
      $arr['updated_at'] = $item->updated_at->format('Y-m-d H:i:s');
      $result[] = $arr;
    }
    return $result;
  }

  private function getUserPersonalArr($data)
  {
    $result = [];
    $arr = [];
    foreach ($data as $item) {
      $arr['id'] = app(Snowflake::class)->next();
      $arr['user_id'] = $item->id;
      $arr['avatar'] = optional($item->user_info->avatar)['url'] ?: $item->head_url;
      $arr['name'] = $item->name;
      $arr['id_card'] = $item->id_card;
      $arr['seniority'] = $item->seniority ?: null;
      $arr['intro'] = $item->user_info->intro;
      $arr['company'] = $item->user_info->company;
      $arr['position'] = $item->user_info->position;
      $arr['position_attr'] = $this->getPositionAttr($item->industry_attr);
      $arr['city'] = $item->city;
      $arr['address'] = $item->address;
      $arr['phone'] = $item->phone;
      $arr['tags'] = implode(',', $item->user_info->tags);
      $arr['education_experience'] = json_encode($item->user_info->education_experience);
      $arr['work_experience'] = json_encode($item->user_info->work_experience);
      $arr['honorary_certificate'] = $this->getHonoraryCertificate($item->user_info->honorary_certificate);
      $arr['created_at'] = $item->created_at->format('Y-m-d H:i:s');
      $arr['updated_at'] = $item->updated_at->format('Y-m-d H:i:s');
      $result[] = $arr;
    }
    return $result;
  }

  private function getUserEnterpriseArr($data)
  {
    $result = [];
    $arr = [];
    foreach ($data as $item) {
      $arr['id'] = app(Snowflake::class)->next();
      $arr['user_id'] = $item->id;
      $arr['avatar'] = optional($item->user_info->avatar)['url'] ?: $item->head_url;
      $arr['company'] = $item->company;
      $arr['business_license'] = $item->business_license;
      $arr['city'] = $item->city;
      $arr['address'] = $item->address;
      $arr['intro'] = $item->user_info->intro;
      $arr['industry_attr'] = $this->getIndustryAttr($item->industry_attr);
      $arr['tags'] = implode(',', $item->user_info->tags);
      $arr['company_scale'] = $item->user_info->company_scale;
      $arr['name'] = $item->name;
      $arr['id_card'] = $item->id_card;
      $arr['position'] = $item->position;
      $arr['phone'] = $item->phone;
      $arr['created_at'] = $item->created_at->format('Y-m-d H:i:s');
      $arr['updated_at'] = $item->updated_at->format('Y-m-d H:i:s');
      $result[] = $arr;
    }
    return $result;
  }

  private function getUserControlArr($data)
  {
    $result = [];
    $arr = [];
    foreach ($data as $item) {
      $arr['user_id'] = $item->id;
      $arr['is_disable_all_push'] = 0;
      $arr['is_open_resume_push'] = $item->user_info->is_open_resume_push;
      $arr['is_open_job_push'] = $item->user_info->is_open_job_push;
      $arr['created_at'] = $item->created_at->format('Y-m-d H:i:s');
      $arr['updated_at'] = $item->updated_at->format('Y-m-d H:i:s');
      $result[] = $arr;
    }
    return $result;
  }

  private function getUserWalletArr($data) {
    $result = [];
    $arr = [];
    foreach ($data as $item) {
      $arr['user_id'] = $item->id;
      $arr['money'] = $item->money;
      $arr['total_earning'] = $item->total_earning;
      $arr['created_at'] = $item->created_at->format('Y-m-d H:i:s');
      $arr['updated_at'] = $item->updated_at->format('Y-m-d H:i:s');
      $result[] = $arr;
    }
    return $result;
  }

  private function setUserRole($data) {
    $result = [];
    $arr = [];
    foreach ($data as $item) {
      $roleId = 9;
      if ($item->is_admin) {
        if (in_array($item->id, [136, 878, 5412, 10363, 12198])) {
          $roleId = 5;
        } else if (in_array($item->id, [6364, 11154])) {
          $roleId = 3;
        } else if ($item->id === 1) {
          $roleId = 1;
        } else if ($item->id === 2) {
          $roleId = 2;
        }
      }
      $arr['role_id'] = $roleId;
      $arr['model_type'] = $item->is_admin ? \App\Models\User\User::class : \App\Models\User\User::class;
      $arr['model_id'] = $item->id;
      $result[] = $arr;
    }
    return $result;
  }

  private function setUserRole2() {
    $data = ModelHasRole::whereIn('role_id', [7, 8])->get();
    foreach ($data as $datum) {
      $userData = \App\Models\User\User::findOrFail($datum->model_id);
      if ($datum->role_id === 7) {
        $userData->assignRole(['Personal Auth']);
      } else {
        $userData->assignRole(['Enterprise Member', 'Enterprise Auth']);
        $userData->current_role = 'Enterprise Member';
        $userData->save();
      }
    }
  }

  private function getUserPersonalAuthArr($data)
  {
    $result = [];
    $arr = [];
    foreach ($data as $item) {
      $arr['user_id'] = $item->user_id;
      $arr['name'] = $item->name;
      $arr['company'] = $item->company;
      $arr['position'] = $item->position;
      $arr['city'] = $item->city;
      $arr['address'] = $item->address;
      $arr['intro'] = $item->intro;
      $arr['certificates'] = json_encode(collect($item->certificates)->map(function ($row) {
        return $row->url;
      })->toArray());
      $arr['status'] = $item->auth_status;
      $arr['refuse_reason'] = $item->refuse_reason;
      $arr['created_at'] = $item->created_at->format('Y-m-d H:i:s');
      $arr['updated_at'] = $item->updated_at->format('Y-m-d H:i:s');
      $result[] = $arr;
    }
    return $result;
  }

  private function getUserEnterpriseAuthArr($data)
  {
    $result = [];
    $arr = [];
    foreach ($data as $item) {
      $arr['user_id'] = $item->user_id;
      $arr['company'] = $item->company;
      $arr['business_license'] = $item->business_license;
      $arr['city'] = $item->city;
      $arr['address'] = $item->address;
      $arr['intro'] = $item->intro;
      $arr['certificates'] = json_encode(collect($item->certificates)->map(function ($row) {
        return $row->url;
      })->toArray());
      $arr['status'] = $item->auth_status;
      $arr['refuse_reason'] = $item->refuse_reason;
      $arr['created_at'] = $item->created_at->format('Y-m-d H:i:s');
      $arr['updated_at'] = $item->updated_at->format('Y-m-d H:i:s');
      $result[] = $arr;
    }
    return $result;
  }

  private function getUserCashArr($data)
  {
    $result = [];
    $arr = [];
    foreach ($data as $item) {
      $arr['user_id'] = $item->id;
      $arr['amount'] = $item->amount;
      $arr['status'] = $item->status;
      $arr['created_at'] = $item->created_at->format('Y-m-d H:i:s');
      $arr['updated_at'] = $item->updated_at->format('Y-m-d H:i:s');
      $result[] = $arr;
    }
    return $result;
  }

  private function getUserBillArr($data)
  {
    $result = [];
    $arr = [];
    foreach ($data as $item) {
      $arr['user_id'] = $item->id;
      $arr['total_amount'] = $item->amount;
      $arr['coupon_amount'] = $item->amount;
      $arr['desc'] = $item->desc;
      $arr['created_at'] = $item->created_at->format('Y-m-d H:i:s');
      $arr['updated_at'] = $item->updated_at->format('Y-m-d H:i:s');
      $result[] = $arr;
    }
    return $result;
  }

  private function getUserAuthArr($data)
  {
    $result = [];
    $arr = [];
    foreach ($data as $item) {
      $arr['id'] = app(Snowflake::class)->next();
      $arr['user_id'] = $item->user_id;
      $arr['wx_openid'] = $item->wx_openid;
      $arr['wx_unionid'] = $item->wx_unionid;
      $arr['created_at'] = $item->created_at->format('Y-m-d H:i:s');
      $arr['updated_at'] = $item->updated_at->format('Y-m-d H:i:s');
      $result[] = $arr;
    }
    return $result;
  }

  private function getIndustryAttr ($attr) {
    if ($attr > 0 && $attr < 4) {
      return $attr;
    } else {
      return null;
    }
  }

  private function getPositionAttr ($attr) {
    if ($attr === 4) {
      return 1;
    } else if ($attr === 5) {
      return 2;
    } else if ($attr === 6) {
      return 3;
    } else {
      return null;
    }
  }

  private function getHonoraryCertificate ($data) {
    collect($data)->map(function ($item) {
      return [
        'name' => $item->name,
        'images' => collect($item->images)->map(function ($image) {
          return $image->url;
        })->toArray()
      ];
    })->toArray();
  }
}
