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
use App\Http\Requests\ToolsCreateRequest;
use App\Http\Requests\ToolsUpdateRequest;

class ToolsController extends Controller {

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
    $manager_selected = '';
    $user_selected = '';

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

    if (Entrust::can('tools-activity-all-view')){
      // Format of $manager_list is [ 1=> 'manager1', 2=>'manager2',...]
      $manager_list = $this->userRepository->getManagersList();
      $user_list = $this->userRepository->getAllUsersListNoManagers();
      $manager_select_disabled = 'false';
      $user_select_disabled = 'false';
    }
    elseif (Auth::user()->is_manager == 1) {
      $manager_list = [Auth::user()->id => Auth::user()->name];
      $user_list = Auth::user()->employees()->lists('name','user_id');
      $manager_selected = Auth::user()->id;
      $manager_select_disabled = 'true';
      $user_select_disabled = 'false';
    }
    else {
      $manager_list = [Auth::user()->managers()->first()->id => Auth::user()->managers()->first()->name];
      $user_list = [Auth::user()->id => Auth::user()->name];
      $manager_selected = Auth::user()->managers()->first()->id;
      $user_selected = Auth::user()->id;
      $manager_select_disabled = 'true';
      $user_select_disabled = 'true';
    }

		return view('tools/list', compact('manager_list','today','years','manager_select_disabled','manager_selected','user_select_disabled','user_selected','user_list','perms'));
	}

	public function getFormCreate($user_id,$year)
	{
    $edit_project_name = '';
    $edit_otl_name = '';
    $user_selected = '';
    $created_by_user_id = Auth::user()->id;

    if (Entrust::can('tools-activity-all-view')){
      $user_list = $this->userRepository->getAllUsersListNoManagers();
      $user_select_disabled = 'false';
    }
    elseif (Auth::user()->is_manager == 1) {
      $user_list = Auth::user()->employees()->lists('name','user_id');
      $user_select_disabled = 'false';
    }
    else {
      $user_list = [Auth::user()->id => Auth::user()->name];
      $user_selected = Auth::user()->id;
      $user_select_disabled = 'true';
    }

    $user = $this->userRepository->getById($user_id);
		return view('tools/create_update', compact('user','year','edit_project_name','edit_otl_name','user_list','user_selected','user_select_disabled','created_by_user_id'))->with('action','create');
	}

  public function postFormCreate(ToolsCreateRequest $request)
	{
    $inputs = $request->all();
    $project = $this->projectRepository->create($inputs);
    // Here I will test if a user has been selected or not => -1 means no user selected
    if (intval($inputs['user_id']) > 0) {
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
    }
    return redirect('toolsActivities')->with('success','New project created successfully');
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

		return view('tools/create_update', compact('user','project','year','activities','editable_activities','edit_project_name','edit_otl_name'))->with('action','update');
	}

	public function postFormUpdate(ToolsUpdateRequest $request)
	{
    $inputs = $request->all();
    $project = $this->projectRepository->update($inputs['project_id'],$inputs);
    foreach ($inputs['activities_id'] as $key => $value){
      $inputsActivities = [
        'task_hour' => $value
      ];
      $activity = $this->activityRepository->update($key,$inputsActivities);
    }
    return redirect('toolsActivities')->with('success','Project updated successfully');
	}

}
