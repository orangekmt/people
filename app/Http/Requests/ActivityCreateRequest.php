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
    $year = $this->year;
    $month = $this->month;
    $project_id = $this->project_id;
    $user_id = $this->user_id;
    $from_otl = $this->from_otl;
    //\Debugbar::info($manager_list);

    return [
      'year' => 'unique:activities,year,NULL,id,month,'.$month.',project_id,'.$project_id.',user_id,'.$user_id.',from_otl,'.$from_otl,
      'task_hour' => 'numeric|required'
    ];
  }

  public function messages()
  {
    return [
      'year.unique' => 'This record needs to have a unique year, month, project name and user name.'
    ];
  }
}
