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
      'task_name.unique' => 'This record needs to have a unique customer name, OTL project code, meta-activity and task name.'
    ];
  }
}
