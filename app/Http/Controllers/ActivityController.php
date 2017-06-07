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
    $result = $this->activityRepository->create($inputs);
    return redirect('activityList')->with($result->result,$result->msg);
	}

	public function postFormUpdate(ActivityUpdateRequest $request, $id)
	{
    $inputs = $request->all();
    $result = $this->activityRepository->update($id, $inputs);
    return redirect('activityList')->with($result->result,$result->msg);
	}

	public function delete($id)
	{
    $result = $this->activityRepository->destroy($id);
		return json_encode($result);
	}

  public function ListOfactivities()
  {
    return $this->activityRepository->getListOfActivities();
  }
}
