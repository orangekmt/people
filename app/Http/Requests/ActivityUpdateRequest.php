<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ActivityUpdateRequest extends Request
{
  /**
  * Determine if the activity is authorized to make this request.
  *
  * @return bool
  */
  public function authorize()
  {
    return true;
  }

  /**
  * Get the validation rules that apply to the request.
  *
  * @return array
  */
  public function rules()
  {
    $id = $this->id;
    $activity_name = $this->activity_name;

    $customer_name = $this->customer_name;
    $otl_activity_code = $this->otl_activity_code;
    $meta_activity = $this->meta_activity;
    $task_name = $this->task_name;


    /**
    *          Forcing A Unique Rule To Ignore A Given ID:
    *
    *          Sometimes, you may wish to ignore a given ID during the unique check. For example, consider an "update profile" screen that includes the activity's name, e-mail address, and location. Of course, you will want to verify that the e-mail address is unique. However, if the activity only changes the name field and not the e-mail field, you do not want a validation error to be thrown because the activity is already the owner of the e-mail address. You only want to throw a validation error if the activity provides an e-mail address that is already used by a different activity. To tell the unique rule to ignore the activity's ID, you may pass the ID as the third parameter:
    *
    *          'email' => 'unique:activities,email_address,'.$activity->id
    *
    *          If your table uses a primary key column name other than id, you may specify it as the fourth parameter:
    *
    *          'email' => 'unique:activities,email_address,'.$activity->id.',activity_id'
    **/


    return [
      'activity_name' => 'required|max:255|unique:activities,activity_name,' . $id . ',id',
      'customer_name' => 'required|max:255|unique:activities,customer_name,' . $id . ',id,task_name,'.$task_name.',otl_activity_code,'.$otl_activity_code.',meta_activity,'.$meta_activity,
      'otl_activity_code' => 'required|max:255|unique:activities,otl_activity_code,' . $id . ',id,customer_name,'.$customer_name.',task_name,'.$task_name.',meta_activity,'.$meta_activity,
      'meta_activity' => 'required|max:255|unique:activities,meta_activity,' . $id . ',id,customer_name,'.$customer_name.',otl_activity_code,'.$otl_activity_code.',task_name,'.$task_name,
      'task_name' => 'required|max:255|unique:activities,task_name,' . $id . ',id,customer_name,'.$customer_name.',otl_activity_code,'.$otl_activity_code.',meta_activity,'.$meta_activity,
      'estimated_start_date' => 'date',
      'estimated_end_date' => 'date',
      'LoE_onshore' => 'numeric',
      'LoE_nearshore' => 'numeric',
      'LoE_offshore' => 'numeric',
      'LoE_contractor' => 'numeric',
      'revenue' => 'numeric',
      'win_ratio' => 'integer'
    ];
  }
}
