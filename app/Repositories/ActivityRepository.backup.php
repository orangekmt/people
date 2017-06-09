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

  public function getByOTL($year,$month,$user_id,$project_id, $from_otl)
  {
    return $this->activity->where('year', $year)->where('month', $month)->where('user_id', $user_id)->where('project_id', $project_id)->where('from_otl', $from_otl)->first();
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
    // Required fields
    if (isset($inputs['year'])) {$activity->year = $inputs['year'];}
    if (isset($inputs['month'])) {$activity->month = $inputs['month'];}
    if (isset($inputs['project_id'])) {$activity->project_id = $inputs['project_id'];}
    if (isset($inputs['user_id'])) {$activity->user_id = $inputs['user_id'];}
    if (isset($inputs['task_hour'])) {$activity->task_hour = $inputs['task_hour'];}

    // Boolean
    if (isset($inputs['from_otl'])) {$activity->from_otl = $inputs['from_otl'];}

    $activity->save();

    return $activity;
  }

  public function destroy($id)
  {
    $activity = $this->getById($id);
    $activity->delete();

    return $activity;
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
  public function getListOfActivitiesPerUser($id,$year)
  {
    /** We create here a SQL statement and the Datatables function will add the information it got from the AJAX request to have things like search or limit or show.
    *   So we need to have a proper SQL search that the ajax can use via get with parameters given to it.
    *   In the ajax datatables (view), there will be a parameter name that is going to be used here for the extra parameters so if we use a join,
    *   Then we will need to use in the view page the name of the table.column. This is so that it knows how to do proper sorting or search.
    **/
      $activityList = DB::table('projects')
      ->select( 'u2.name AS manager_name','users.id','users.name','projects.id','projects.project_name',
      'jan.task_hour as jan_task_hour','jan.from_otl as jan_otl',
      'feb.task_hour as feb_task_hour','feb.from_otl as feb_otl',
      'mar.task_hour as mar_task_hour','mar.from_otl as mar_otl',
      'apr.task_hour as apr_task_hour','apr.from_otl as apr_otl',
      'may.task_hour as may_task_hour','may.from_otl as may_otl',
      'jun.task_hour as jun_task_hour','jun.from_otl as jun_otl',
      'jul.task_hour as jul_task_hour','jul.from_otl as jul_otl',
      'aug.task_hour as aug_task_hour','aug.from_otl as aug_otl',
      'sep.task_hour as sep_task_hour','sep.from_otl as sep_otl',
      'oct.task_hour as oct_task_hour','oct.from_otl as oct_otl',
      'nov.task_hour as nov_task_hour','nov.from_otl as nov_otl',
      'dec.task_hour as dec_task_hour','dec.from_otl as dec_otl'
      )
      ->leftjoin('activities', 'projects.id', '=', 'activities.project_id')
      ->leftjoin('users', 'users.id', '=', 'activities.user_id')
      ->leftjoin('users_users', 'users.id', '=', 'users_users.user_id')
      ->leftjoin('users AS u2', 'u2.id', '=', 'users_users.manager_id')
      ->leftjoin('activities as jan', function ($join) use ($id) {
        $join->on('projects.id', '=', 'jan.project_id')
        ->where('jan.month', '=', 1)
        ->where('jan.user_id', '=', $id);
      })
      ->leftjoin('activities as feb', function ($join) use ($id) {
        $join->on('projects.id', '=', 'feb.project_id')
        ->where('feb.month', '=', 2)
        ->where('feb.user_id', '=', $id);
      })
      ->leftjoin('activities as mar', function ($join) use ($id) {
        $join->on('projects.id', '=', 'mar.project_id')
        ->where('mar.month', '=', 3)
        ->where('mar.user_id', '=', $id);
      })
      ->leftjoin('activities as apr', function ($join) use ($id) {
        $join->on('projects.id', '=', 'apr.project_id')
        ->where('apr.month', '=', 4)
        ->where('apr.user_id', '=', $id);
      })
      ->leftjoin('activities as may', function ($join) use ($id) {
        $join->on('projects.id', '=', 'may.project_id')
        ->where('may.month', '=', 5)
        ->where('may.user_id', '=', $id);
      })
      ->leftjoin('activities as jun', function ($join) use ($id) {
        $join->on('projects.id', '=', 'jun.project_id')
        ->where('jun.month', '=', 6)
        ->where('jun.user_id', '=', $id);
      })
      ->leftjoin('activities as jul', function ($join) use ($id) {
        $join->on('projects.id', '=', 'jul.project_id')
        ->where('jul.month', '=', 7)
        ->where('jul.user_id', '=', $id);
      })
      ->leftjoin('activities as aug', function ($join) use ($id) {
        $join->on('projects.id', '=', 'aug.project_id')
        ->where('aug.month', '=', 8)
        ->where('aug.user_id', '=', $id);
      })
      ->leftjoin('activities as sep', function ($join) use ($id) {
        $join->on('projects.id', '=', 'sep.project_id')
        ->where('sep.month', '=', 9)
        ->where('sep.user_id', '=', $id);
      })
      ->leftjoin('activities as oct', function ($join) use ($id) {
        $join->on('projects.id', '=', 'oct.project_id')
        ->where('oct.month', '=', 10)
        ->where('oct.user_id', '=', $id);
      })
      ->leftjoin('activities as nov', function ($join) use ($id) {
        $join->on('projects.id', '=', 'nov.project_id')
        ->where('nov.month', '=', 11)
        ->where('nov.user_id', '=', $id);
      })
      ->leftjoin('activities as dec', function ($join) use ($id) {
        $join->on('projects.id', '=', 'dec.project_id')
        ->where('dec.month', '=', 12)
        ->where('dec.user_id', '=', $id);
      })
      ->where('users.id', '=', $id)
      ->where('projects.id','=',37)
      ->where('activities.year', '=', $year);

      //$data = $activityList->get();
      $data = $activityList->toSql();

      dd($data);
      //$data = Datatables::of($activityList)->make(true);
      return $data;
  }
}
