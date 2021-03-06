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

    $meta_activity = $this->meta_activity;

    return [

      'project_name' => 'required|max:255|unique:projects',
      'customer_name' => 'required|max:255',
      'otl_project_code' => 'sometimes|max:255|unique:projects,otl_project_code,NULL,id,meta_activity,'.$meta_activity,
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
    'otl_project_code.unique' => 'This OTL project code and meta-activity already exists in the database.'
  ];
  }
}
