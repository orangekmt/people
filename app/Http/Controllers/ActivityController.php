<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Activity;
use App\Role;
use App\Repositories\ActivityRepository;
use App\Repositories\UserRepository;
use App\Repositories\ProjectRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\ActivityCreateRequest;
use App\Http\Requests\ActivityUpdateRequest;
use App\Http\Requests\PasswordUpdateRequest;
use DB;
use Entrust;
use Auth;

class ActivityController extends Controller {

  protected $activityRepository;
  protected $userRepository;
  protected $projectRepository;

  public function __construct(ActivityRepository $activityRepository,UserRepository $userRepository,ProjectRepository $projectRepository)
  {
    $this->activityRepository = $activityRepository;
    $this->userRepository = $userRepository;
    $this->projectRepository = $projectRepository;
	}
	public function getList()
	{
		return view('activity/list');
	}

	public function show($id)
	{
    $activity = $this->activityRepository->getById($id);
		return view('activity/show',  compact('activity'));
	}

	public function getFormCreate()
	{
    $allUsers_list = $this->userRepository->getAllUsersList();
    $allProjects_list = $this->projectRepository->getAllProjectsList();
		return view('activity/create_update', compact('allUsers_list','allProjects_list'))->with('action','create');
	}

	public function getFormUpdate($id)
	{
    $activity = $this->activityRepository->getById($id);
    $allUsers_list = $this->userRepository->getAllUsersList();
    $allProjects_list = $this->projectRepository->getAllProjectsList();
		return view('activity/create_update', compact('activity','allUsers_list','allProjects_list'))->with('action','update');
	}

  public function postFormCreate(ActivityCreateRequest $request)
	{
    $inputs = $request->all();
    $activity = $this->activityRepository->create($inputs);
    return redirect('activityList')->with('success','Record created successfully');
	}

	public function postFormUpdate(ActivityUpdateRequest $request, $id)
	{
    $inputs = $request->all();
    $activity = $this->activityRepository->update($id, $inputs);
    return redirect('activityList')->with('success','Record updated successfully');
	}

	public function delete($id)
	{
    // When using stdClass(), we need to prepend with \ so that Laravel won't get confused...
    $result = new \stdClass();
    $result->result = 'success';
    $result->msg = 'Record deleted successfully';
    $activity = $this->activityRepository->destroy($id);
		return json_encode($result);
	}

  public function ListOfactivities()
  {
    return $this->activityRepository->getListOfActivities();
  }
  public function ListOfactivitiesPerUser($for_manager,$id,$year)
  {
    return $this->activityRepository->getListOfActivitiesPerUser($for_manager,$id,$year);
  }
}
