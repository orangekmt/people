<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProjectUpdateRequest extends Request
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
    $id = $this->id;
    $project_name = $this->project_name;

    $customer_name = $this->customer_name;
    $otl_project_code = $this->otl_project_code;
    $meta_activity = $this->meta_activity;
    $task_name = $this->task_name;


    /**
    *          Forcing A Unique Rule To Ignore A Given ID:
    *
    *          Sometimes, you may wish to ignore a given ID during the unique check. For example, consider an "update profile" screen that includes the project's name, e-mail address, and location. Of course, you will want to verify that the e-mail address is unique. However, if the project only changes the name field and not the e-mail field, you do not want a validation error to be thrown because the project is already the owner of the e-mail address. You only want to throw a validation error if the project provides an e-mail address that is already used by a different project. To tell the unique rule to ignore the project's ID, you may pass the ID as the third parameter:
    *
    *          'email' => 'unique:projects,email_address,'.$project->id
    *
    *          If your table uses a primary key column name other than id, you may specify it as the fourth parameter:
    *
    *          'email' => 'unique:projects,email_address,'.$project->id.',project_id'
    **/


    return [
      'project_name' => 'required|max:255|unique:projects,project_name,' . $id . ',id',
      'task_name' => 'required|max:255|unique:projects,task_name,' . $id . ',id,customer_name,'.$customer_name.',otl_project_code,'.$otl_project_code.',meta_activity,'.$meta_activity,
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
