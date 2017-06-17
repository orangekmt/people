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

  public function projectsAssignedAndNot()
  {
    $year = date("Y");
    $manager_list = [];
    return view('tools/projects_assigned_and_not', compact('manager_list','year'));
  }

	public function getFormCreate($year)
	{
    $edit_project_name = '';
    $edit_otl_name = '';
    $user_selected = '';
    $project_type_select_disabled = 'false';
    $activity_type_select_disabled = 'false';
    $project_status_select_disabled = 'false';
    $region_select_disabled = 'false';
    $country_select_disabled = 'false';
    $domain_select_disabled = 'false';

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

		return view('tools/create_update', compact('year','edit_project_name','edit_otl_name',
      'user_list','user_selected','user_select_disabled','created_by_user_id',
      'meta_activity_select_disabled','project_type_select_disabled','activity_type_select_disabled','project_status_select_disabled',
      'region_select_disabled','country_select_disabled','domain_select_disabled'))
      ->with('action','create');
	}

  public function postFormCreate(ToolsCreateRequest $request)
	{
    $inputs = $request->all();
    $project = $this->projectRepository->create($inputs);

    // Here I will test if a user has been selected or not
    if (!empty($inputs['user_id'])) {
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
    // Here we setup all the disabled fields to be disabled
    $edit_project_name = '';
    $edit_otl_name = '';
    $meta_activity_select_disabled = false;
    $project_type_select_disabled = 'true';
    $activity_type_select_disabled = 'true';
    $project_status_select_disabled = 'true';
    $region_select_disabled = 'true';
    $country_select_disabled = 'true';
    $domain_select_disabled = 'true';
    $user_select_disabled = 'true';

    $user_list = [];

    // Here we will define if we can select a user for this project and activity or not
    // Attention, we need to prevent in the user_list to have ids when already assigned to a project
    if (Entrust::can('tools-activity-all-view')){
      $user_list_temp = $this->userRepository->getAllUsersListNoManagers();

      if ($user_id == '0') {
        foreach ($user_list_temp as $key => $value){
          if ($this->activityRepository->user_assigned_on_project($year,$key,$project_id) == 0){
            $user_list[$key] = $value;
          }
        }
        $user_select_disabled = 'false';
        $user_selected = '';
      } else {
        $user_list = $user_list_temp;
        $user_select_disabled = 'true';
        $user_selected = $user_id;
      }
    }
    elseif (Auth::user()->is_manager == 1) {
      $user_list_temp = Auth::user()->employees()->lists('name','user_id');

      if ($user_id == '0') {
        foreach ($user_list_temp as $key => $value){
          if ($this->activityRepository->user_assigned_on_project($year,$key,$project_id) == 0){
            $user_list[$key] = $value;
          }
        }
        $user_select_disabled = 'false';
        $user_selected = '';
      } else {
        $user_list = $user_list_temp;
        $user_select_disabled = 'true';
        $user_selected = $user_id;
      }
    }
    else {
      $user_list = [Auth::user()->id => Auth::user()->name];
      if ($user_id == '0') {
        $user_select_disabled = 'true';
        $user_selected = '';
      } else {
        $user_select_disabled = 'true';
        $user_selected = $user_id;
      }
    }

    // Here we find the information about the project
    $project = $this->projectRepository->getById($project_id);

    $created_by_user_name = isset($project->created_by_user_id) ? $this->userRepository->getById($project->created_by_user_id)->name : 'Admin';

    // Here we can check what can be edited for this project
    if ((isset($project->created_by_user_id) && (Auth::user()->id == $project->created_by_user_id)) || Entrust::can('tools-activity-all-edit')){
      $edit_project_name = '';
      $project_type_select_disabled = 'false';
      $activity_type_select_disabled = 'false';
      $project_status_select_disabled = 'false';
      $region_select_disabled = 'false';
      $country_select_disabled = 'false';
      $domain_select_disabled = 'false';
    }

    if ($project->otl_validated == 1) {
      $edit_otl_name = 'disabled';
      $meta_activity_select_disabled = true;
    }

    $activities = [];
    $from_otl = [];

    if ($user_id != '0') {
      $user = $this->userRepository->getById($user_id);
      $activity_forecast = $this->activityRepository->getByOTL($year,$user->id,$project->id, 0);
      $activity_OTL = $this->activityRepository->getByOTL($year,$user->id,$project->id, 1);
    }

    for ($i = 1; $i <= 12; $i++) {
      if (isset($activity_OTL[$i])){
        $activities[$i] = $activity_OTL[$i];
        $from_otl[$i] = 'disabled';
      } elseif (isset($activity_forecast[$i])){
        $activities[$i] = $activity_forecast[$i];
        $from_otl[$i] = '';

      } else {
        $activities[$i] = '0';
        $from_otl[$i] = '';
      }
    }

		return view('tools/create_update', compact('user_id','project','year','activities','from_otl',
      'edit_project_name','edit_otl_name',
      'meta_activity_select_disabled','project_type_select_disabled','activity_type_select_disabled','project_status_select_disabled',
      'region_select_disabled','country_select_disabled','domain_select_disabled','user_list','user_selected','user_select_disabled','created_by_user_name'))
      ->with('action','update');
	}

	public function postFormUpdate(ToolsUpdateRequest $request)
	{
    $inputs = $request->all();

    $project = $this->projectRepository->update($inputs['project_id'],$inputs);

    if ($inputs['user_id'] != 0) {
      foreach ($inputs['month'] as $key => $value){
        $inputs_new = $inputs;
        $inputs_new['month'] = $key;
        $inputs_new['task_hour'] = $value;
        $inputs_new['from_otl'] = 0;
        $activity = $this->activityRepository->createOrUpdate($inputs_new);
      }
    }
    return redirect('toolsActivities')->with('success','Project updated successfully');
	}

}
