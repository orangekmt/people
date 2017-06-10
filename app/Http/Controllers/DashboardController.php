<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Role;
use App\Http\Controllers\Controller;
use DB;
use Entrust;
use Auth;
use App\Repositories\UserRepository;

class DashboardController extends Controller {

  protected $userRepository;

  public function __construct(UserRepository $userRepository)
  {
    $this->userRepository = $userRepository;
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

}
