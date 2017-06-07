<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProjectCreateRequest extends Request
{
  /**
  * Determine if the project is authorized to make this request.
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
    $project_name = $this->project_name;

    $customer_name = $this->customer_name;
    $otl_project_code = $this->otl_project_code;
    $meta_activity = $this->meta_activity;
    $task_name = $this->task_name;

    return [
      'project_name' => 'required|max:255|unique:projects',
      'customer_name' => 'required|max:255|unique:projects,customer_name,NULL,id,task_name,'.$task_name.',otl_project_code,'.$otl_project_code.',meta_activity,'.$meta_activity,
      'otl_project_code' => 'required|max:255|unique:projects,otl_project_code,NULL,id,customer_name,'.$customer_name.',task_name,'.$task_name.',meta_activity,'.$meta_activity,
      'meta_activity' => 'required|max:255|unique:projects,meta_activity,NULL,id,customer_name,'.$customer_name.',otl_project_code,'.$otl_project_code.',task_name,'.$task_name,
      'task_name' => 'required|max:255|unique:projects,task_name,NULL,id,customer_name,'.$customer_name.',otl_project_code,'.$otl_project_code.',meta_activity,'.$meta_activity,
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
