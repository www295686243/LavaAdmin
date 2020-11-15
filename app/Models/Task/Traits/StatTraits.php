<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/11/11
 * Time: 18:03
 */

namespace App\Models\Task\Traits;

use App\Models\Api\User;
use App\Models\Info\Hr\HrJob;
use App\Models\Info\Hr\HrResume;
use App\Models\Info\InfoProvide;
use App\Models\Task\TaskRuleRecord;
use App\Models\User\UserEnterprise;
use App\Models\User\UserPersonal;

trait StatTraits {
  public function statShareResumeRegisterViewTaskRule(TaskRuleRecord $taskRuleRecordData)
  {
    $id = request()->input('id');
    $infoData = HrResume::findOrFail($id);
    $count = $infoData->info_view()
      ->where('share_user_id', $taskRuleRecordData->user_id)
      ->where('is_new_user', 1)
      ->count();
    $taskRuleRecordData->complete_number = $count;
    $taskRuleRecordData->save();
  }

  public function statShareJobRegisterViewTaskRule(TaskRuleRecord $taskRuleRecordData)
  {
    $id = request()->input('id');
    $infoData = HrJob::findOrFail($id);
    $count = $infoData->info_view()
      ->where('share_user_id', $taskRuleRecordData->user_id)
      ->where('is_new_user', 1)
      ->count();
    $taskRuleRecordData->complete_number = $count;
    $taskRuleRecordData->save();
  }

  public function statShareResumeViewTaskRule(TaskRuleRecord $taskRuleRecordData)
  {
    $id = request()->input('id');
    $infoData = HrResume::findOrFail($id);
    $count = $infoData->info_view()
      ->where('share_user_id', $taskRuleRecordData->user_id)
      ->count();
    $taskRuleRecordData->complete_number = $count;
    $taskRuleRecordData->save();
  }

  public function statShareJobViewTaskRule(TaskRuleRecord $taskRuleRecordData)
  {
    $id = request()->input('id');
    $infoData = HrJob::findOrFail($id);
    $count = $infoData->info_view()
      ->where('share_user_id', $taskRuleRecordData->user_id)
      ->count();
    $taskRuleRecordData->complete_number = $count;
    $taskRuleRecordData->save();
  }

  public function statFollowWeChatTaskRule(TaskRuleRecord $taskRuleRecordData)
  {
    $userData = User::getUserData($taskRuleRecordData->user_id);
    if ($userData->is_follow_official_account) {
      $taskRuleRecordData->complete_number = 1;
      $taskRuleRecordData->save();
    }
  }

  public function statBindPhoneTaskRule(TaskRuleRecord $taskRuleRecordData)
  {
    $userData = User::getUserData($taskRuleRecordData->user_id);
    if ($userData->phone) {
      $taskRuleRecordData->complete_number = 1;
      $taskRuleRecordData->save();
    }
  }

  public function statPerfectPersonalInfoTaskRule(TaskRuleRecord $taskRuleRecordData)
  {
    $userPersonalData = UserPersonal::where('user_id', $taskRuleRecordData->user_id)->firstOrFail();
    if (
      $userPersonalData->tags &&
      ($userPersonalData->education_experience && count($userPersonalData->education_experience)) &&
      ($userPersonalData->work_experience && count($userPersonalData->work_experience))
    ) {
      $taskRuleRecordData->complete_number = 1;
      $taskRuleRecordData->save();
    }
  }

  public function statPerfectEnterpriseInfoTaskRule(TaskRuleRecord $taskRuleRecordData)
  {
    $userEnterpriseData = UserEnterprise::where('user_id', $taskRuleRecordData->user_id)->firstOrFail();
    if (
      $userEnterpriseData->tags &&
      $userEnterpriseData->intro &&
      $userEnterpriseData->company_scale
    ) {
      $taskRuleRecordData->complete_number = 1;
      $taskRuleRecordData->save();
    }
  }

  public function statEnterpriseEveryDayLoginTaskRule(TaskRuleRecord $taskRuleRecordData)
  {
    $taskRuleRecordData->complete_number = 1;
    $taskRuleRecordData->save();
  }

  public function statPersonalEveryDayLoginTaskRule(TaskRuleRecord $taskRuleRecordData)
  {
    $taskRuleRecordData->complete_number = 1;
    $taskRuleRecordData->save();
  }

  public function statInviteUserTaskRule(TaskRuleRecord $taskRuleRecordData)
  {
    $userData = User::getUserData();
    if ($userData->phone && $userData->invite_user_id === $taskRuleRecordData->user_id) {
      $taskRuleRecordData->complete_number = 1;
      $taskRuleRecordData->save();
    }
  }

  public function statProvideJobTaskRule(TaskRuleRecord $taskRuleRecordData)
  {
    $userData = User::getUserData();
    if ($userData->is_admin) {
      $id = request()->input('id');
      $infoData = InfoProvide::findOrFail($id);
      if ($infoData->status !== InfoProvide::getStatusValue(1, '待审核')) {
        $taskRuleRecordData->complete_number = 1;
        $taskRuleRecordData->save();
      }
    }
  }

  public function statProvideResumeTaskRule(TaskRuleRecord $taskRuleRecordData)
  {
    $userData = User::getUserData();
    if ($userData->is_admin) {
      $id = request()->input('id');
      $infoData = InfoProvide::findOrFail($id);
      if ($infoData->status !== InfoProvide::getStatusValue(1, '待审核')) {
        $taskRuleRecordData->complete_number = 1;
        $taskRuleRecordData->save();
      }
    }
  }
}