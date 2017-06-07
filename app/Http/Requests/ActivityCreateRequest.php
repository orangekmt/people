<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ActivityCreateRequest extends Request
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
    $activity_name = $this->activity_name;

    $customer_name = $this->customer_name;
    $otl_activity_code = $this->otl_activity_code;
    $meta_activity = $this->meta_activity;
    $task_name = $this->task_name;

    return [
      'activity_name' => 'required|max:255|unique:activities',
      'customer_name' => 'required|max:255|unique:activities,customer_name,NULL,id,task_name,'.$task_name.',otl_activity_code,'.$otl_activity_code.',meta_activity,'.$meta_activity,
      'otl_activity_code' => 'required|max:255|unique:activities,otl_activity_code,NULL,id,customer_name,'.$customer_name.',task_name,'.$task_name.',meta_activity,'.$meta_activity,
      'meta_activity' => 'required|max:255|unique:activities,meta_activity,NULL,id,customer_name,'.$customer_name.',otl_activity_code,'.$otl_activity_code.',task_name,'.$task_name,
      'task_name' => 'required|max:255|unique:activities,task_name,NULL,id,customer_name,'.$customer_name.',otl_activity_code,'.$otl_activity_code.',meta_activity,'.$meta_activity,
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

  public function messages()
  {
    return [
      'task_name.unique' => 'This task name needs to be unique.'
    ];
  }
}
