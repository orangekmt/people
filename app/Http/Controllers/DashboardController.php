<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Role;
use App\Http\Controllers\Controller;
use DB;
use Entrust;
use Auth;
use App\Repositories\UserRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\ActivityRepository;
use App\Http\Requests\DashboardCreateRequest;
use App\Http\Requests\DashboardUpdateRequest;

class DashboardController extends Controller {

  protected $activityRepository;
  protected $userRepository;
  protected $projectRepository;

  public function __construct(ActivityRepository $activityRepository,UserRepository $userRepository,ProjectRepository $projectRepository)
  {
    $this->activityRepository = $activityRepository;
    $this->userRepository = $userRepository;
    $this->projectRepository = $projectRepository;
	}

	public function activities()
	{
    $today = date("Y");
    $years = [];


    $options = array(
        'validate_all' => true,
        'return_type' => 'both'
    );
    list($validate, $allValidations) = Entrust::ability(null,array('activities-view','activities-edit','activities-delete','activities-create'),$options);
    $perms = json_encode($allValidations['permissions']);


    foreach(config('select.year')  as $key => $value){
      if ($value == date("Y")) {$selected = 'selected';} else {$selected = '';}
      array_push($years,['id'=>$value,'value'=>$value,'selected'=>$selected]);
    }

    if (Entrust::can('dashboard-all-view')){
      // Format of $manager_list is [ 1=> 'manager1', 2=>'manager2',...]
      $manager_list = $this->userRepository->getManagersList();
      $manager_select_disabled = 'false';
    }
    elseif (Auth::user()->is_manager == 1) {
      $manager_list = [Auth::user()->id => Auth::user()->name];
      $manager_select_disabled = 'true';
    }
    else {
      $manager_list = [Auth::user()->managers()->first()->id => Auth::user()->managers()->first()->name];
      $manager_select_disabled = 'true';
    }
		return view('dashboard/list', compact('manager_list','today','years','manager_select_disabled','perms'));
	}

  public function load()
	{
    $today = date("Y");
    $years = [];


    $options = array(
        'validate_all' => true,
        'return_type' => 'both'
    );
    list($validate, $allValidations) = Entrust::ability(null,array('activities-view','activities-edit','activities-delete','activities-create'),$options);
    $perms = json_encode($allValidations['permissions']);


    foreach(config('select.year')  as $key => $value){
      if ($value == date("Y")) {$selected = 'selected';} else {$selected = '';}
      array_push($years,['id'=>$value,'value'=>$value,'selected'=>$selected]);
    }

    if (Entrust::can('dashboard-all-view')){
      // Format of $manager_list is [ 1=> 'manager1', 2=>'manager2',...]
      $manager_list = $this->userRepository->getManagersList();
      $manager_select_disabled = 'false';
    }
    elseif (Auth::user()->is_manager == 1) {
      $manager_list = [Auth::user()->id => Auth::user()->name];
      $manager_select_disabled = 'true';
    }
    else {
      $manager_list = [Auth::user()->managers()->first()->id => Auth::user()->managers()->first()->name];
      $manager_select_disabled = 'true';
    }
		return view('dashboard/load', compact('manager_list','today','years','manager_select_disabled','perms'));
	}

  public function load_chart()
	{
    $today = date("Y");
    $years = [];


    $options = array(
        'validate_all' => true,
        'return_type' => 'both'
    );
    list($validate, $allValidations) = Entrust::ability(null,array('activities-view','activities-edit','activities-delete','activities-create'),$options);
    $perms = json_encode($allValidations['permissions']);


    foreach(config('select.year')  as $key => $value){
      if ($value == date("Y")) {$selected = 'selected';} else {$selected = '';}
      array_push($years,['id'=>$value,'value'=>$value,'selected'=>$selected]);
    }

    if (Entrust::can('dashboard-all-view')){
      // Format of $manager_list is [ 1=> 'manager1', 2=>'manager2',...]
      $manager_list = $this->userRepository->getManagersList();
      $manager_select_disabled = 'false';
    }
    elseif (Auth::user()->is_manager == 1) {
      $manager_list = [Auth::user()->id => Auth::user()->name];
      $manager_select_disabled = 'true';
    }
    else {
      $manager_list = [Auth::user()->managers()->first()->id => Auth::user()->managers()->first()->name];
      $manager_select_disabled = 'true';
    }
		return view('dashboard/load_chart', compact('manager_list','today','years','manager_select_disabled','perms'));
	}

	public function getFormCreate($user_id,$year)
	{
    $edit_project_name = '';
    $edit_otl_name = '';
    $user = $this->userRepository->getById($user_id);
		return view('dashboard/create_update', compact('user','year','edit_project_name','edit_otl_name'))->with('action','create');
	}

  public function getFormUpdate($user_id,$project_id,$year)
	{
    $edit_project_name = '';
    $edit_otl_name = '';
    $user = $this->userRepository->getById($user_id);
    $project = $this->projectRepository->getById($project_id);
    if (($project->created_by_user_id != null) && !(Auth::user()->id == $project->created_by_user_id)) {
      $edit_project_name = 'disabled';
      $edit_otl_name = 'disabled';
    }
    if ($project->otl_validated == 1) {
      $edit_otl_name = 'disabled';
    }

    $activities = [];
    $editable_activities = [];

    for ($i = 1; $i <= 12; $i++) {
      $activity_forecast = $this->activityRepository->getByOTL($year,$i,$user->id,$project->id, 0);
      $activity_OTL = $this->activityRepository->getByOTL($year,$i,$user->id,$project->id, 1);
      if (isset($activity_OTL)){
        $activities[$i] = [
          'id' => $activity_OTL->id,
          'task_hour' => $activity_OTL->task_hour,
          'from_otl' => 'disabled'
        ];
      } elseif (isset($activity_forecast)){
        $activities[$i] = [
          'id' => $activity_forecast->id,
          'task_hour' => $activity_forecast->task_hour
        ];
        array_push($editable_activities,$activity_forecast->id);
      } else {
        $inputsActivities = [
          'year' => $year,
          'month' => $i,
          'project_id' => $project_id,
          'user_id' => $user_id,
          'task_hour' => 0,
          'from_otl' => 0
        ];
        $activity_forecast = $this->activityRepository->create($inputsActivities);
        $activities[$i] = [
          'id' => $activity_forecast->id,
          'task_hour' => $activity_forecast->task_hour
        ];
        array_push($editable_activities,$activity_forecast->id);
      }
    }

		return view('dashboard/create_update', compact('user','project','year','activities','editable_activities','edit_project_name','edit_otl_name'))->with('action','update');
	}

  public function postFormCreate(DashboardCreateRequest $request)
	{
    $inputs = $request->all();
    $project = $this->projectRepository->create($inputs);
    foreach ($inputs['month'] as $key => $value){
      $inputsActivities = [
        'year' => $inputs['year'],
        'month' => $key,
        'project_id' => $project->id,
        'user_id' => $inputs['user_id'],
        'task_hour' => $value,
        'from_otl' => 0
      ];
      $activity = $this->activityRepository->create($inputsActivities);
    }
    return redirect('dashboardActivities')->with('success','New project created successfully');
	}

	public function postFormUpdate(DashboardUpdateRequest $request)
	{
    $inputs = $request->all();
    $project = $this->projectRepository->update($inputs['project_id'],$inputs);
    foreach ($inputs['activities_id'] as $key => $value){
      $inputsActivities = [
        'task_hour' => $value
      ];
      $activity = $this->activityRepository->update($key,$inputsActivities);
    }
    return redirect('dashboardActivities')->with('success','Project updated successfully');
	}

}
