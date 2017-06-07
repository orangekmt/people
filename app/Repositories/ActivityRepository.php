<?php

namespace App\Repositories;

use App\Activity;
use Datatables;
use DB;
use Entrust;
use Auth;

class ActivityRepository
{

  protected $activity;

  public function __construct(Activity $activity)
	{
		$this->activity = $activity;
	}

  public function getById($id)
	{
		return $this->activity->findOrFail($id);
	}

  public function create(Array $inputs)
  {
    $activity = new $this->activity;
    return $this->save($activity, $inputs);
  }

  public function update($id, Array $inputs)
	{
		return $this->save($this->getById($id), $inputs);
	}

	private function save(Activity $activity, Array $inputs)
	{
    $result = new \stdClass();
    $result->result = 'success';
    $result->msg = '';

    // Required fields
    if (isset($inputs['year'])) {$activity->year = $inputs['year'];}
    if (isset($inputs['month'])) {$activity->month = $inputs['month'];}
    if (isset($inputs['project_id'])) {$activity->project_id = $inputs['project_id'];}
    if (isset($inputs['user_id'])) {$activity->user_id = $inputs['user_id'];}
    if (isset($inputs['task_hour'])) {$activity->task_hour = $inputs['task_hour'];}

    // Boolean
    if (isset($inputs['from_otl'])) {$activity->from_otl = $inputs['from_otl'];}

    try {
      $activity->save();
    }
    catch (\Illuminate\Database\QueryException $ex){
        $result->result = 'error';
        $result->msg = 'Message:</BR>'.$ex->getMessage();
        return $result;
    }

    $result->msg = 'Activity saved successfully.';

    return $result;
	}

	public function destroy($id)
	{
    $result = new \stdClass();
    $result->result = 'success';
    $result->msg = '';

    $activity = $this->getById($id);

    try {
		    $activity->delete();
      } catch (\Illuminate\Database\QueryException $ex){
          $result->result = 'error';
          $result->msg = '</BR>Message:</BR>'.$ex->getMessage();
          return $result;
      }

      $result->msg = 'Activity deleted successfully.';
    return $result;
	}

  public function getListOfActivities()
  {
    /** We create here a SQL statement and the Datatables function will add the information it got from the AJAX request to have things like search or limit or show.
    *   So we need to have a proper SQL search that the ajax can use via get with parameters given to it.
    *   In the ajax datatables (view), there will be a parameter name that is going to be used here for the extra parameters so if we use a join,
    *   Then we will need to use in the view page the name of the table.column. This is so that it knows how to do proper sorting or search.
    **/

    $activityList = DB::table('activities')
    ->select( 'activities.id', 'activities.year','activities.month','activities.task_hour','activities.from_otl',
    'activities.project_id','projects.project_name','activities.user_id','users.name')
    ->leftjoin('projects', 'projects.id', '=', 'activities.project_id')
    ->leftjoin('users', 'users.id', '=', 'activities.user_id');
    $data = Datatables::of($activityList)->make(true);
    return $data;
  }
}
