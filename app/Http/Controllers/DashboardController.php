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

  public function get_weekdays($m,$y) {
    $lastday = date("t",mktime(0,0,0,$m,1,$y));
    $weekdays=0;
    for($d=29;$d<=$lastday;$d++) {
        $wd = date("w",mktime(0,0,0,$m,$d,$y));
        if($wd > 0 && $wd < 6) $weekdays++;
        }
    return $weekdays+20;
    }

  public function load()
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

    if (Entrust::can('dashboard-all-view')){
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

		return view('dashboard/load', compact('manager_list','today','years','manager_select_disabled','manager_selected','user_select_disabled','user_selected','user_list','perms'));
	}

  public function load_chart()
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

    if (Entrust::can('dashboard-all-view')){
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

		return view('dashboard/load_chart', compact('manager_list','today','years','manager_select_disabled','manager_selected','user_select_disabled','user_selected','user_list','perms'));
	}

}
