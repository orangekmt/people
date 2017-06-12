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
  public function getListOfActivitiesPerUser($where = null)
  {
    /** We create here a SQL statement and the Datatables function will add the information it got from the AJAX request to have things like search or limit or show.
    *   So we need to have a proper SQL search that the ajax can use via get with parameters given to it.
    *   In the ajax datatables (view), there will be a parameter name that is going to be used here for the extra parameters so if we use a join,
    *   Then we will need to use in the view page the name of the table.column. This is so that it knows how to do proper sorting or search.
    **/

    $activityList = DB::table('activities');

    $activityList->leftjoin('projects as p', 'p.id', '=', 'activities.project_id')
                  ->leftjoin('users as u', 'u.id', '=', 'activities.user_id')
                  ->leftjoin('users_users as uu', 'u.id', '=', 'uu.user_id')
                  ->leftjoin('users AS u2', 'u2.id', '=', 'uu.manager_id');

    $activityList->select( 'u2.id as manager_id','u2.name as manager_name','u.id as user_id','u.name as user_name','p.id as project_id','p.project_name as project_name','p.customer_name as customer_name','activities.year as year',
    //jan

    DB::raw('if(sum(if(activities.from_otl=1 and month=1,task_hour,0))>0,sum(if(activities.from_otl=1 and month=1,task_hour,0)),sum(if(activities.from_otl=0 and month=1,task_hour,0))) jan_com'),
    DB::raw('if(sum(if(activities.from_otl=1 and month=1,task_hour,0))>0,sum(if(activities.from_otl=1 and month=1,activities.from_otl,0)),sum(if(activities.from_otl=0 and month=1,activities.from_otl,0))) jan_otl'),
    //feb

    DB::raw('if(sum(if(activities.from_otl=1 and month=2,task_hour,0))>0,sum(if(activities.from_otl=1 and month=2,task_hour,0)),sum(if(activities.from_otl=0 and month=2,task_hour,0))) feb_com'),
    DB::raw('if(sum(if(activities.from_otl=1 and month=2,task_hour,0))>0,sum(if(activities.from_otl=1 and month=2,activities.from_otl,0)),sum(if(activities.from_otl=0 and month=2,activities.from_otl,0))) feb_otl'),
    //mar

    DB::raw('if(sum(if(activities.from_otl=1 and month=3,task_hour,0))>0,sum(if(activities.from_otl=1 and month=3,task_hour,0)),sum(if(activities.from_otl=0 and month=3,task_hour,0))) mar_com'),
    DB::raw('if(sum(if(activities.from_otl=1 and month=3,task_hour,0))>0,sum(if(activities.from_otl=1 and month=3,activities.from_otl,0)),sum(if(activities.from_otl=0 and month=3,activities.from_otl,0))) mar_otl'),
    //apr

    DB::raw('if(sum(if(activities.from_otl=1 and month=4,task_hour,0))>0,sum(if(activities.from_otl=1 and month=4,task_hour,0)),sum(if(activities.from_otl=0 and month=4,task_hour,0))) apr_com'),
    DB::raw('if(sum(if(activities.from_otl=1 and month=4,task_hour,0))>0,sum(if(activities.from_otl=1 and month=4,activities.from_otl,0)),sum(if(activities.from_otl=0 and month=4,activities.from_otl,0))) apr_otl'),
    //may

    DB::raw('if(sum(if(activities.from_otl=1 and month=5,task_hour,0))>0,sum(if(activities.from_otl=1 and month=5,task_hour,0)),sum(if(activities.from_otl=0 and month=5,task_hour,0))) may_com'),
    DB::raw('if(sum(if(activities.from_otl=1 and month=5,task_hour,0))>0,sum(if(activities.from_otl=1 and month=5,activities.from_otl,0)),sum(if(activities.from_otl=0 and month=5,activities.from_otl,0))) may_otl'),
    //jun

    DB::raw('if(sum(if(activities.from_otl=1 and month=6,task_hour,0))>0,sum(if(activities.from_otl=1 and month=6,task_hour,0)),sum(if(activities.from_otl=0 and month=6,task_hour,0))) jun_com'),
    DB::raw('if(sum(if(activities.from_otl=1 and month=6,task_hour,0))>0,sum(if(activities.from_otl=1 and month=6,activities.from_otl,0)),sum(if(activities.from_otl=0 and month=6,activities.from_otl,0))) jun_otl'),
    //jul

    DB::raw('if(sum(if(activities.from_otl=1 and month=7,task_hour,0))>0,sum(if(activities.from_otl=1 and month=7,task_hour,0)),sum(if(activities.from_otl=0 and month=7,task_hour,0))) jul_com'),
    DB::raw('if(sum(if(activities.from_otl=1 and month=7,task_hour,0))>0,sum(if(activities.from_otl=1 and month=7,activities.from_otl,0)),sum(if(activities.from_otl=0 and month=7,activities.from_otl,0))) jul_otl'),
    //aug

    DB::raw('if(sum(if(activities.from_otl=1 and month=8,task_hour,0))>0,sum(if(activities.from_otl=1 and month=8,task_hour,0)),sum(if(activities.from_otl=0 and month=8,task_hour,0))) aug_com'),
    DB::raw('if(sum(if(activities.from_otl=1 and month=8,task_hour,0))>0,sum(if(activities.from_otl=1 and month=8,activities.from_otl,0)),sum(if(activities.from_otl=0 and month=8,activities.from_otl,0))) aug_otl'),
    //sep

    DB::raw('if(sum(if(activities.from_otl=1 and month=9,task_hour,0))>0,sum(if(activities.from_otl=1 and month=9,task_hour,0)),sum(if(activities.from_otl=0 and month=9,task_hour,0))) sep_com'),
    DB::raw('if(sum(if(activities.from_otl=1 and month=9,task_hour,0))>0,sum(if(activities.from_otl=1 and month=9,activities.from_otl,0)),sum(if(activities.from_otl=0 and month=9,activities.from_otl,0))) sep_otl'),
    //oct

    DB::raw('if(sum(if(activities.from_otl=1 and month=10,task_hour,0))>0,sum(if(activities.from_otl=1 and month=10,task_hour,0)),sum(if(activities.from_otl=0 and month=10,task_hour,0))) oct_com'),
    DB::raw('if(sum(if(activities.from_otl=1 and month=10,task_hour,0))>0,sum(if(activities.from_otl=1 and month=10,activities.from_otl,0)),sum(if(activities.from_otl=0 and month=10,activities.from_otl,0))) oct_otl'),
    //nov

    DB::raw('if(sum(if(activities.from_otl=1 and month=11,task_hour,0))>0,sum(if(activities.from_otl=1 and month=11,task_hour,0)),sum(if(activities.from_otl=0 and month=11,task_hour,0))) nov_com'),
    DB::raw('if(sum(if(activities.from_otl=1 and month=11,task_hour,0))>0,sum(if(activities.from_otl=1 and month=11,activities.from_otl,0)),sum(if(activities.from_otl=0 and month=11,activities.from_otl,0))) nov_otl'),
    //dec

    DB::raw('if(sum(if(activities.from_otl=1 and month=12,task_hour,0))>0,sum(if(activities.from_otl=1 and month=12,task_hour,0)),sum(if(activities.from_otl=0 and month=12,task_hour,0))) dec_com'),
    DB::raw('if(sum(if(activities.from_otl=1 and month=12,task_hour,0))>0,sum(if(activities.from_otl=1 and month=12,activities.from_otl,0)),sum(if(activities.from_otl=0 and month=12,activities.from_otl,0))) dec_otl')
  );




    if (!empty($where['year']))
        {
            $activityList->where(function ($query) use ($where) {
                foreach ($where['year'] as $w)
                {
                    $query->orWhere('year',$w);
                }
            });
        }

    if (Entrust::can('dashboard-all-view')){
      // Format of $manager_list is [ 1=> 'manager1', 2=>'manager2',...]
      if (!empty($where['manager']))
          {
              $activityList->where(function ($query) use ($where) {
                  foreach ($where['manager'] as $w)
                  {
                      $query->orWhere('u2.id',$w);
                  }
              });
          }
    }
    elseif (Auth::user()->is_manager == 1) {
      $activityList->where('u2.id','=',Auth::user()->id);
    }
    else {
      $activityList->where('u.id','=',Auth::user()->id);
    }

    $activityList->groupBy('manager_id','manager_name','user_id','user_name','project_id','project_name','year');



      //$data = $activityList->get();
      //dd($data);
      //dd($data = $activityList->toSql());


      $data = Datatables::of($activityList)->make(true);
      return $data;
  }

  public function getlistOfLoadPerUser($where = null)
  {
    /** We create here a SQL statement and the Datatables function will add the information it got from the AJAX request to have things like search or limit or show.
    *   So we need to have a proper SQL search that the ajax can use via get with parameters given to it.
    *   In the ajax datatables (view), there will be a parameter name that is going to be used here for the extra parameters so if we use a join,
    *   Then we will need to use in the view page the name of the table.column. This is so that it knows how to do proper sorting or search.
    **/

    $activityList = DB::table('activities');

    $activityList->leftjoin('projects as p', 'p.id', '=', 'project_id')
                  ->leftjoin('users as u', 'u.id', '=', 'activities.user_id')
                  ->leftjoin('users_users as uu', 'u.id', '=', 'uu.user_id')
                  ->leftjoin('users AS u2', 'u2.id', '=', 'uu.manager_id');

    $activityList->select( 'u2.id as manager_id','u2.name as manager_name','u.id as user_id','u.name as user_name','year as year',
    //jan

    DB::raw('if(sum(if(activities.from_otl=1 and month=1,task_hour,0))>0,sum(if(activities.from_otl=1 and month=1,task_hour,0)),sum(if(activities.from_otl=0 and month=1,task_hour,0))) jan_com'),
    DB::raw('if(sum(if(activities.from_otl=1 and month=1,task_hour,0))>0,sum(if(activities.from_otl=1 and month=1,activities.from_otl,0)),sum(if(activities.from_otl=0 and month=1,activities.from_otl,0))) jan_otl'),
    //feb

    DB::raw('if(sum(if(activities.from_otl=1 and month=2,task_hour,0))>0,sum(if(activities.from_otl=1 and month=2,task_hour,0)),sum(if(activities.from_otl=0 and month=2,task_hour,0))) feb_com'),
    DB::raw('if(sum(if(activities.from_otl=1 and month=2,task_hour,0))>0,sum(if(activities.from_otl=1 and month=2,activities.from_otl,0)),sum(if(activities.from_otl=0 and month=2,activities.from_otl,0))) feb_otl'),
    //mar

    DB::raw('if(sum(if(activities.from_otl=1 and month=3,task_hour,0))>0,sum(if(activities.from_otl=1 and month=3,task_hour,0)),sum(if(activities.from_otl=0 and month=3,task_hour,0))) mar_com'),
    DB::raw('if(sum(if(activities.from_otl=1 and month=3,task_hour,0))>0,sum(if(activities.from_otl=1 and month=3,activities.from_otl,0)),sum(if(activities.from_otl=0 and month=3,activities.from_otl,0))) mar_otl'),
    //apr

    DB::raw('if(sum(if(activities.from_otl=1 and month=4,task_hour,0))>0,sum(if(activities.from_otl=1 and month=4,task_hour,0)),sum(if(activities.from_otl=0 and month=4,task_hour,0))) apr_com'),
    DB::raw('if(sum(if(activities.from_otl=1 and month=4,task_hour,0))>0,sum(if(activities.from_otl=1 and month=4,activities.from_otl,0)),sum(if(activities.from_otl=0 and month=4,activities.from_otl,0))) apr_otl'),
    //may

    DB::raw('if(sum(if(activities.from_otl=1 and month=5,task_hour,0))>0,sum(if(activities.from_otl=1 and month=5,task_hour,0)),sum(if(activities.from_otl=0 and month=5,task_hour,0))) may_com'),
    DB::raw('if(sum(if(activities.from_otl=1 and month=5,task_hour,0))>0,sum(if(activities.from_otl=1 and month=5,activities.from_otl,0)),sum(if(activities.from_otl=0 and month=5,activities.from_otl,0))) may_otl'),
    //jun

    DB::raw('if(sum(if(activities.from_otl=1 and month=6,task_hour,0))>0,sum(if(activities.from_otl=1 and month=6,task_hour,0)),sum(if(activities.from_otl=0 and month=6,task_hour,0))) jun_com'),
    DB::raw('if(sum(if(activities.from_otl=1 and month=6,task_hour,0))>0,sum(if(activities.from_otl=1 and month=6,activities.from_otl,0)),sum(if(activities.from_otl=0 and month=6,activities.from_otl,0))) jun_otl'),
    //jul

    DB::raw('if(sum(if(activities.from_otl=1 and month=7,task_hour,0))>0,sum(if(activities.from_otl=1 and month=7,task_hour,0)),sum(if(activities.from_otl=0 and month=7,task_hour,0))) jul_com'),
    DB::raw('if(sum(if(activities.from_otl=1 and month=7,task_hour,0))>0,sum(if(activities.from_otl=1 and month=7,activities.from_otl,0)),sum(if(activities.from_otl=0 and month=7,activities.from_otl,0))) jul_otl'),
    //aug

    DB::raw('if(sum(if(activities.from_otl=1 and month=8,task_hour,0))>0,sum(if(activities.from_otl=1 and month=8,task_hour,0)),sum(if(activities.from_otl=0 and month=8,task_hour,0))) aug_com'),
    DB::raw('if(sum(if(activities.from_otl=1 and month=8,task_hour,0))>0,sum(if(activities.from_otl=1 and month=8,activities.from_otl,0)),sum(if(activities.from_otl=0 and month=8,activities.from_otl,0))) aug_otl'),
    //sep

    DB::raw('if(sum(if(activities.from_otl=1 and month=9,task_hour,0))>0,sum(if(activities.from_otl=1 and month=9,task_hour,0)),sum(if(activities.from_otl=0 and month=9,task_hour,0))) sep_com'),
    DB::raw('if(sum(if(activities.from_otl=1 and month=9,task_hour,0))>0,sum(if(activities.from_otl=1 and month=9,activities.from_otl,0)),sum(if(activities.from_otl=0 and month=9,activities.from_otl,0))) sep_otl'),
    //oct

    DB::raw('if(sum(if(activities.from_otl=1 and month=10,task_hour,0))>0,sum(if(activities.from_otl=1 and month=10,task_hour,0)),sum(if(activities.from_otl=0 and month=10,task_hour,0))) oct_com'),
    DB::raw('if(sum(if(activities.from_otl=1 and month=10,task_hour,0))>0,sum(if(activities.from_otl=1 and month=10,activities.from_otl,0)),sum(if(activities.from_otl=0 and month=10,activities.from_otl,0))) oct_otl'),
    //nov

    DB::raw('if(sum(if(activities.from_otl=1 and month=11,task_hour,0))>0,sum(if(activities.from_otl=1 and month=11,task_hour,0)),sum(if(activities.from_otl=0 and month=11,task_hour,0))) nov_com'),
    DB::raw('if(sum(if(activities.from_otl=1 and month=11,task_hour,0))>0,sum(if(activities.from_otl=1 and month=11,activities.from_otl,0)),sum(if(activities.from_otl=0 and month=11,activities.from_otl,0))) nov_otl'),
    //dec

    DB::raw('if(sum(if(activities.from_otl=1 and month=12,task_hour,0))>0,sum(if(activities.from_otl=1 and month=12,task_hour,0)),sum(if(activities.from_otl=0 and month=12,task_hour,0))) dec_com'),
    DB::raw('if(sum(if(activities.from_otl=1 and month=12,task_hour,0))>0,sum(if(activities.from_otl=1 and month=12,activities.from_otl,0)),sum(if(activities.from_otl=0 and month=12,activities.from_otl,0))) dec_otl')
  );




    if (!empty($where['year']))
        {
            $activityList->where(function ($query) use ($where) {
                foreach ($where['year'] as $w)
                {
                    $query->orWhere('year',$w);
                }
            });
        }

    if (!empty($where['meta_activity']))
        {
            $activityList->where(function ($query) use ($where) {
                foreach ($where['meta_activity'] as $w)
                {
                    $query->orWhere('p.meta_activity',$w);
                }
            });
        }

    if (!empty($where['project_status']))
        {
            $activityList->where(function ($query) use ($where) {
                foreach ($where['project_status'] as $w)
                {
                    $query->orWhere('p.project_status',$w);
                }
            });
        }

    if (!empty($where['project_type']))
        {
            $activityList->where(function ($query) use ($where) {
                foreach ($where['project_type'] as $w)
                {
                    $query->orWhere('p.project_type',$w);
                }
            });
        }

    if (Entrust::can('dashboard-all-view')){
      // Format of $manager_list is [ 1=> 'manager1', 2=>'manager2',...]
      if (!empty($where['manager']))
          {
              $activityList->where(function ($query) use ($where) {
                  foreach ($where['manager'] as $w)
                  {
                      $query->orWhere('u2.id',$w);
                  }
              });
          }
    }
    elseif (Auth::user()->is_manager == 1) {
      $activityList->where('u2.id','=',Auth::user()->id);
    }
    else {
      $activityList->where('u.id','=',Auth::user()->id);
    }

    $activityList->groupBy('manager_id','manager_name','user_id','user_name','year');



      //$data = $activityList->get();
      //dd($data);
      //dd($data = $activityList->toSql());


      $data = Datatables::of($activityList)->make(true);
      return $data;
  }

  public function getListOfLoadPerUserChart($where = null,$activity_type,$project_status)
  {
    /** We create here a SQL statement and the Datatables function will add the information it got from the AJAX request to have things like search or limit or show.
    *   So we need to have a proper SQL search that the ajax can use via get with parameters given to it.
    *   In the ajax datatables (view), there will be a parameter name that is going to be used here for the extra parameters so if we use a join,
    *   Then we will need to use in the view page the name of the table.column. This is so that it knows how to do proper sorting or search.
    **/


    $data = 0;
    $where['user'] = [3];

    $activityList = DB::table('activities');
    $activityList->select('year',
    DB::raw('if(sum(if(activities.from_otl=1 and month=1,task_hour,0))>0,sum(if(activities.from_otl=1 and month=1,task_hour,0)),sum(if(activities.from_otl=0 and month=1,task_hour,0))) jan_com'),
    DB::raw('if(sum(if(activities.from_otl=1 and month=2,task_hour,0))>0,sum(if(activities.from_otl=1 and month=2,task_hour,0)),sum(if(activities.from_otl=0 and month=2,task_hour,0))) feb_com'),
    DB::raw('if(sum(if(activities.from_otl=1 and month=3,task_hour,0))>0,sum(if(activities.from_otl=1 and month=3,task_hour,0)),sum(if(activities.from_otl=0 and month=3,task_hour,0))) mar_com'),
    DB::raw('if(sum(if(activities.from_otl=1 and month=4,task_hour,0))>0,sum(if(activities.from_otl=1 and month=4,task_hour,0)),sum(if(activities.from_otl=0 and month=4,task_hour,0))) apr_com'),
    DB::raw('if(sum(if(activities.from_otl=1 and month=5,task_hour,0))>0,sum(if(activities.from_otl=1 and month=5,task_hour,0)),sum(if(activities.from_otl=0 and month=5,task_hour,0))) may_com'),
    DB::raw('if(sum(if(activities.from_otl=1 and month=6,task_hour,0))>0,sum(if(activities.from_otl=1 and month=6,task_hour,0)),sum(if(activities.from_otl=0 and month=6,task_hour,0))) jun_com'),
    DB::raw('if(sum(if(activities.from_otl=1 and month=7,task_hour,0))>0,sum(if(activities.from_otl=1 and month=7,task_hour,0)),sum(if(activities.from_otl=0 and month=7,task_hour,0))) jul_com'),
    DB::raw('if(sum(if(activities.from_otl=1 and month=8,task_hour,0))>0,sum(if(activities.from_otl=1 and month=8,task_hour,0)),sum(if(activities.from_otl=0 and month=8,task_hour,0))) aug_com'),
    DB::raw('if(sum(if(activities.from_otl=1 and month=9,task_hour,0))>0,sum(if(activities.from_otl=1 and month=9,task_hour,0)),sum(if(activities.from_otl=0 and month=9,task_hour,0))) sep_com'),
    DB::raw('if(sum(if(activities.from_otl=1 and month=10,task_hour,0))>0,sum(if(activities.from_otl=1 and month=10,task_hour,0)),sum(if(activities.from_otl=0 and month=10,task_hour,0))) oct_com'),
    DB::raw('if(sum(if(activities.from_otl=1 and month=11,task_hour,0))>0,sum(if(activities.from_otl=1 and month=11,task_hour,0)),sum(if(activities.from_otl=0 and month=11,task_hour,0))) nov_com'),
    DB::raw('if(sum(if(activities.from_otl=1 and month=12,task_hour,0))>0,sum(if(activities.from_otl=1 and month=12,task_hour,0)),sum(if(activities.from_otl=0 and month=12,task_hour,0))) dec_com')
    );
    $activityList->leftjoin('projects as p', 'p.id', '=', 'project_id');

    if (!empty($where['user'])){
      $activityList->where(function ($query) use ($where) {
        foreach ($where['user'] as $w)
        {
            $query->orWhere('user_id',$w);
        }
      });
      $activityList->groupBy('year');
      $activityList->where('p.activity_type','=',$activity_type);
      $activityList->where('p.project_status','=',$project_status);
      $data = $activityList->get();
    }
    elseif (!empty($where['manager'])){

    }
    else {

    }

    return $data;
  }

}
