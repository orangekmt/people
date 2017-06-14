<?php

namespace App\Repositories;

use App\Activity;
use Datatables;
use DB;
use Entrust;
use Auth;
use App\Repositories\UserRepository;

class ActivityRepository
{

  protected $activity;
  protected $userRepository;

  public function __construct(Activity $activity,UserRepository $userRepository)
  {
    $this->activity = $activity;
    $this->userRepository = $userRepository;
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
      $activityList->where('year','=',$where['year'][0]);
      $data = $activityList->get();
    }
    elseif (!empty($where['manager'])){
      $users = [];
      foreach ($where['manager'] as $w)
      {
        $usersformanager = $this->userRepository->getById($w)->employees()->pluck('users_users.user_id')->toArray();
        foreach ($usersformanager as $key => $value) {
          array_push($users,$value);
        }
      }
      $activityList->where(function ($query) use ($users) {
        foreach ($users as $w)
        {
            $query->orWhere('user_id',$w);
        }
      });
      $activityList->groupBy('year');
      $activityList->where('p.activity_type','=',$activity_type);
      $activityList->where('p.project_status','=',$project_status);
      $activityList->where('year','=',$where['year'][0]);
      $data = $activityList->get();
    }
    else {
      $managers = $this->userRepository->getManagersList();

      $users = [];
      foreach ($managers as $key => $value)
      {
        $usersformanager = $this->userRepository->getById($key)->employees()->pluck('users_users.user_id')->toArray();
        foreach ($usersformanager as $key => $value) {
          array_push($users,$value);
        }
      }

      $activityList->where(function ($query) use ($users) {
        foreach ($users as $w)
        {
            $query->orWhere('user_id',$w);
        }
      });
      $activityList->groupBy('year');
      $activityList->where('p.activity_type','=',$activity_type);
      $activityList->where('p.project_status','=',$project_status);
      $activityList->where('year','=',$where['year'][0]);
      $data = $activityList->get();
    }

    if (empty($data)){
      $data = [];
      $data[0] = new \stdClass();
      $data [0]->year = $where['year'][0];
      $data [0]->jan_com = 0;
      $data [0]->feb_com = 0;
      $data [0]->mar_com = 0;
      $data [0]->apr_com = 0;
      $data [0]->may_com = 0;
      $data [0]->jun_com = 0;
      $data [0]->jul_com = 0;
      $data [0]->aug_com = 0;
      $data [0]->sep_com = 0;
      $data [0]->oct_com = 0;
      $data [0]->nov_com = 0;
      $data [0]->dec_com = 0;
    } else {
      $data [0]->jan_com = $data [0]->jan_com/8;
      $data [0]->feb_com = $data [0]->feb_com/8;
      $data [0]->mar_com = $data [0]->mar_com/8;
      $data [0]->apr_com = $data [0]->apr_com/8;
      $data [0]->may_com = $data [0]->may_com/8;
      $data [0]->jun_com = $data [0]->jun_com/8;
      $data [0]->jul_com = $data [0]->jul_com/8;
      $data [0]->aug_com = $data [0]->aug_com/8;
      $data [0]->sep_com = $data [0]->sep_com/8;
      $data [0]->oct_com = $data [0]->oct_com/8;
      $data [0]->nov_com = $data [0]->nov_com/8;
      $data [0]->dec_com = $data [0]->dec_com/8;
    }

    return $data;
  }

  public function test()
  {

    /*
    This select will get a temporary table with all the records where if from_otl=0
    then it will check if there is not a record with from_otl=1 and
    if yes, will not include it.
     */

    $temp_table = new create_temp_table_mix_OTL_NONOTL('table_temp_a','table_temp_b');
    

    $activity = DB::table('table_temp_b')
    ->select('year','user_id',
        DB::raw('SUM(jan_com) AS jan_com'),
        DB::raw('SUM(feb_com) AS feb_com'),
        DB::raw('SUM(mar_com) AS mar_com'),
        DB::raw('SUM(apr_com) AS apr_com'),
        DB::raw('SUM(may_com) AS may_com'),
        DB::raw('SUM(jun_com) AS jun_com'),
        DB::raw('SUM(jul_com) AS jul_com'),
        DB::raw('SUM(aug_com) AS aug_com'),
        DB::raw('SUM(sep_com) AS sep_com'),
        DB::raw('SUM(oct_com) AS oct_com'),
        DB::raw('SUM(nov_com) AS nov_com'),
        DB::raw('SUM(dec_com) AS dec_com')
        )
    ->where('project_type','=','Project')
    ->where(function($query){
      $query->where('user_id','=','15');
      $query->orWhere('user_id','=','16');
    })
    ->groupBy('year','user_id')
    ->orderBy('user_id')
    ->get();

    $activity2 = DB::table('table_temp_b')
    ->where(function($query){
      $query->where('user_id','=','15');
      $query->orWhere('user_id','=','16');
    })
    ->get();
    $result = $activity;

    dd($result);
  }


}

class create_temp_table_mix_OTL_NONOTL{
  // We are going to create 2 temporary table and we need to protect them
  // manke sure you use unset() on the object reference so that it will call destruct and free up memory
  private $table_name_lines;
  private $table_name_cols;

  // When creating the object, please pass the name of 2 tables that will be created...
  public function __construct($table_name_lines,$table_name_cols){
    $this->table_name_lines = $table_name_lines;
    $this->table_name_cols = $table_name_cols;
    $this->create_temp_table_with_lines($this->table_name_lines);
    $this->create_temp_table_with_months_as_columns($this->table_name_lines,$this->table_name_cols);
  }

  public function __destruct() {
    $this->destroy_table($this->table_name_lines);
    $this->destroy_table($this->table_name_cols);
  }

  public function create_temp_table_with_lines($table_name){
    $dropTempTables = DB::unprepared(
         DB::raw("
             DROP TABLE IF EXISTS ".$table_name.";
         ")
    );

    $createTempTable = DB::unprepared(DB::raw("
      CREATE TEMPORARY TABLE ".$table_name."
      AS (
            SELECT *
            FROM activities AS a4
            WHERE a4.id NOT IN
              (
                SELECT a3.id
                FROM activities AS a3
                INNER JOIN (SELECT * FROM activities AS a1 where a1.from_otl = 1) AS a2
                ON (a3.user_id = a2.user_id AND a3.project_id = a2.project_id AND a3.year = a2.year AND a3.month = a2.month)
                WHERE a3.from_otl = 0
              )
          )
      "));

      return $createTempTable;
  }

  public function create_temp_table_with_months_as_columns($table_name_lines,$table_name_cols){
    $dropTempTables = DB::unprepared(
         DB::raw("
             DROP TABLE IF EXISTS ".$table_name_cols.";
         ")
    );

    $createTempTable = DB::unprepared(DB::raw("
      CREATE TEMPORARY TABLE ".$table_name_cols."
      AS (
            SELECT
                    temp_a.user_id AS user_id,
                    u.name AS user_name,
                    uu.manager_id AS manager_id,
                    m.name AS manager_name,
                    temp_a.project_id AS project_id,
                    p.project_name AS project_name,
                    p.customer_name AS customer_name,
                    p.otl_project_code AS otl_project_code,
                    p.meta_activity AS meta_activity,
                    p.project_type AS project_type,
                    p.activity_type AS activity_type,
                    p.project_status AS project_status,
                    p.region AS region,
                    p.country AS country,
                    p.customer_location AS customer_location,
                    p.domain AS domain,
                    p.description AS description,
                    p.comments AS comments,
                    p.LoE_onshore AS LoE_onshore,
                    p.LoE_nearshore AS LoE_nearshore,
                    p.LoE_offshore AS LoE_offshore,
                    p.LoE_contractor AS LoE_contractor,
                    p.gold_order_number AS gold_order_number,
                    p.product_code AS product_code,
                    p.revenue AS revenue,
                    p.win_ratio AS win_ratio,
                    p.estimated_start_date AS estimated_start_date,
                    p.estimated_end_date AS estimated_end_date,
                    temp_a.year AS year,
                    sum(CASE WHEN month = 1 THEN task_hour ELSE 0 END) AS jan_com,
                    sum(CASE WHEN month = 2 THEN task_hour ELSE 0 END) AS feb_com,
                    sum(CASE WHEN month = 3 THEN task_hour ELSE 0 END) AS mar_com,
                    sum(CASE WHEN month = 4 THEN task_hour ELSE 0 END) AS apr_com,
                    sum(CASE WHEN month = 5 THEN task_hour ELSE 0 END) AS may_com,
                    sum(CASE WHEN month = 6 THEN task_hour ELSE 0 END) AS jun_com,
                    sum(CASE WHEN month = 7 THEN task_hour ELSE 0 END) AS jul_com,
                    sum(CASE WHEN month = 8 THEN task_hour ELSE 0 END) AS aug_com,
                    sum(CASE WHEN month = 9 THEN task_hour ELSE 0 END) AS sep_com,
                    sum(CASE WHEN month = 10 THEN task_hour ELSE 0 END) AS oct_com,
                    sum(CASE WHEN month = 11 THEN task_hour ELSE 0 END) AS nov_com,
                    sum(CASE WHEN month = 12 THEN task_hour ELSE 0 END) AS dec_com
            FROM ".$table_name_lines." AS temp_a
            LEFT JOIN projects AS p ON p.id = temp_a.project_id
            LEFT JOIN users AS u ON temp_a.user_id = u.id
            LEFT JOIN users_users AS uu ON u.id = uu.user_id
            LEFT JOIN users AS m ON m.id = uu.manager_id
            GROUP BY year,user_id,p.project_name,p.project_type,p.activity_type,p.project_status

          )
      "));

      return $createTempTable;
  }
  public function destroy_table($table_name){
    $dropTempTables = DB::unprepared(
         DB::raw("
             DROP TABLE IF EXISTS ".$table_name.";
         ")
    );
  }
}
