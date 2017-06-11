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

	public function getFormCreate($user_id,$year)
	{
    $user = $this->userRepository->getById($user_id);
		return view('dashboard/create_update', compact('user','year'))->with('action','create');
	}

  public function getFormUpdate($user_id,$project_id,$year)
	{
    $user = $this->userRepository->getById($user_id);
    $project = $this->projectRepository->getById($project_id);
    for ($i = 1; $i <= 12; $i++) {
      $activity_forecast = $this->projectRepository->getByOTL($year,$i,$user->id,$project->id, 0);
      if (!isset($activity_forecast)){
        $activity_forecast = $this->projectRepository->getByOTL($year,$i,$user->id,$project->id, null);
      }
      $activity_OTL = $this->projectRepository->getByOTL($year,$i,$user->id,$project->id, 1);
    }
    die();
		return view('dashboard/create_update', compact('user','project','year'))->with('action','update');
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

	public function postFormUpdate(ProjectUpdateRequest $request, $user_id,$project_id)
	{
    return '';
	}

}
