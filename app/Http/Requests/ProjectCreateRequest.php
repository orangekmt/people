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
    $customer_name = $this->customer_name;
    $otl_project_code = $this->otl_project_code;
    $project_name = $this->project_name;
    $meta_activity = $this->meta_activity;
    return [
      'project_name' => 'required|max:255|unique:projects',
      'customer_name' => 'required|max:255',
      'otl_project_code' => 'required|max:255',
      'meta_activity' => 'required|max:255',
      'task_name' => 'required|max:255|unique:projects,task_name,NULL,id,customer_name,'.$customer_name.',otl_project_code,'.$otl_project_code.',meta_activity,'.$meta_activity
    ];
  }

  public function messages()
  {
    return [
      'task_name.unique' => 'This task name needs to be unique.'
    ];
  }
}
