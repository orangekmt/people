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
      'month' => 'unique:activities,month,NULL,id,year,'.$year.',project_id,'.$project_id.',user_id,'.$user_id.',from_otl,'.$from_otl,
      'project_id' => 'unique:activities,project_id,NULL,id,year,'.$year.',month,'.$month.',user_id,'.$user_id.',from_otl,'.$from_otl,
      'user_id' => 'unique:activities,user_id,NULL,id,year,'.$year.',month,'.$month.',project_id,'.$project_id.',from_otl,'.$from_otl,
      'from_otl' => 'unique:activities,from_otl,NULL,id,year,'.$year.',month,'.$month.',project_id,'.$project_id.',user_id,'.$user_id,
      'task_hour' => 'numeric|required'
    ];
  }
}
