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
  public function ListOfactivitiesPerUser(Request $request)
  {
    $input = $request->all();
    return $this->activityRepository->getListOfActivitiesPerUser($input);
  }
  public function listOfLoadPerUserAjax (Request $request)
  {
    $input = $request->all();
    return $this->activityRepository->getlistOfLoadPerUser($input);
  }
  public function listOfLoadPerUserChartAjax (Request $request)
  {
    $inputs = $request->all();
    $theoreticalCapacity = $this->userRepository->getTheoreticalCapacity($inputs);
    $dscpresales = $this->activityRepository->getListOfLoadPerUserChart($inputs,'DSC','Pre-Sales');
    $iscpresales = $this->activityRepository->getListOfLoadPerUserChart($inputs,'ISC','Pre-Sales');
    $dscstarted = $this->activityRepository->getListOfLoadPerUserChart($inputs,'DSC','Started');
    $iscstarted = $this->activityRepository->getListOfLoadPerUserChart($inputs,'ISC','Started');
    $data = [];

    $data ["dscvstotal"] = [];
    $data ["dscvstotal"][0] = new \stdClass();
    $data ["dscvstotal"][0]->year = $inputs['year'][0];
    $data ["dscvstotal"][0]->jan_com = ($dscpresales[0]->jan_com+$dscstarted[0]->jan_com+$iscpresales[0]->jan_com+$iscstarted[0]->jan_com) != 0 ? 100*($dscpresales[0]->jan_com+$dscstarted[0]->jan_com)/($dscpresales[0]->jan_com+$dscstarted[0]->jan_com+$iscpresales[0]->jan_com+$iscstarted[0]->jan_com):0;
    $data ["dscvstotal"][0]->feb_com = ($dscpresales[0]->feb_com+$dscstarted[0]->feb_com+$iscpresales[0]->feb_com+$iscstarted[0]->feb_com) != 0 ? 100*($dscpresales[0]->feb_com+$dscstarted[0]->feb_com)/($dscpresales[0]->feb_com+$dscstarted[0]->feb_com+$iscpresales[0]->feb_com+$iscstarted[0]->feb_com):0;
    $data ["dscvstotal"][0]->mar_com = ($dscpresales[0]->mar_com+$dscstarted[0]->mar_com+$iscpresales[0]->mar_com+$iscstarted[0]->mar_com) != 0 ? 100*($dscpresales[0]->mar_com+$dscstarted[0]->mar_com)/($dscpresales[0]->mar_com+$dscstarted[0]->mar_com+$iscpresales[0]->mar_com+$iscstarted[0]->mar_com):0;
    $data ["dscvstotal"][0]->apr_com = ($dscpresales[0]->apr_com+$dscstarted[0]->apr_com+$iscpresales[0]->apr_com+$iscstarted[0]->apr_com) != 0 ? 100*($dscpresales[0]->apr_com+$dscstarted[0]->apr_com)/($dscpresales[0]->apr_com+$dscstarted[0]->apr_com+$iscpresales[0]->apr_com+$iscstarted[0]->apr_com):0;
    $data ["dscvstotal"][0]->may_com = ($dscpresales[0]->may_com+$dscstarted[0]->may_com+$iscpresales[0]->may_com+$iscstarted[0]->may_com) != 0 ? 100*($dscpresales[0]->may_com+$dscstarted[0]->may_com)/($dscpresales[0]->may_com+$dscstarted[0]->may_com+$iscpresales[0]->may_com+$iscstarted[0]->may_com):0;
    $data ["dscvstotal"][0]->jun_com = ($dscpresales[0]->jun_com+$dscstarted[0]->jun_com+$iscpresales[0]->jun_com+$iscstarted[0]->jun_com) != 0 ? 100*($dscpresales[0]->jun_com+$dscstarted[0]->jun_com)/($dscpresales[0]->jun_com+$dscstarted[0]->jun_com+$iscpresales[0]->jun_com+$iscstarted[0]->jun_com):0;
    $data ["dscvstotal"][0]->jul_com = ($dscpresales[0]->jul_com+$dscstarted[0]->jul_com+$iscpresales[0]->jul_com+$iscstarted[0]->jul_com) != 0 ? 100*($dscpresales[0]->jul_com+$dscstarted[0]->jul_com)/($dscpresales[0]->jul_com+$dscstarted[0]->jul_com+$iscpresales[0]->jul_com+$iscstarted[0]->jul_com):0;
    $data ["dscvstotal"][0]->aug_com = ($dscpresales[0]->aug_com+$dscstarted[0]->aug_com+$iscpresales[0]->aug_com+$iscstarted[0]->aug_com) != 0 ? 100*($dscpresales[0]->aug_com+$dscstarted[0]->aug_com)/($dscpresales[0]->aug_com+$dscstarted[0]->aug_com+$iscpresales[0]->aug_com+$iscstarted[0]->aug_com):0;
    $data ["dscvstotal"][0]->sep_com = ($dscpresales[0]->sep_com+$dscstarted[0]->sep_com+$iscpresales[0]->sep_com+$iscstarted[0]->sep_com) != 0 ? 100*($dscpresales[0]->sep_com+$dscstarted[0]->sep_com)/($dscpresales[0]->sep_com+$dscstarted[0]->sep_com+$iscpresales[0]->sep_com+$iscstarted[0]->sep_com):0;
    $data ["dscvstotal"][0]->oct_com = ($dscpresales[0]->oct_com+$dscstarted[0]->oct_com+$iscpresales[0]->oct_com+$iscstarted[0]->oct_com) != 0 ? 100*($dscpresales[0]->oct_com+$dscstarted[0]->oct_com)/($dscpresales[0]->oct_com+$dscstarted[0]->oct_com+$iscpresales[0]->oct_com+$iscstarted[0]->oct_com):0;
    $data ["dscvstotal"][0]->nov_com = ($dscpresales[0]->nov_com+$dscstarted[0]->nov_com+$iscpresales[0]->nov_com+$iscstarted[0]->nov_com) != 0 ? 100*($dscpresales[0]->nov_com+$dscstarted[0]->nov_com)/($dscpresales[0]->nov_com+$dscstarted[0]->nov_com+$iscpresales[0]->nov_com+$iscstarted[0]->nov_com):0;
    $data ["dscvstotal"][0]->dec_com = ($dscpresales[0]->dec_com+$dscstarted[0]->dec_com+$iscpresales[0]->dec_com+$iscstarted[0]->dec_com) != 0 ? 100*($dscpresales[0]->dec_com+$dscstarted[0]->dec_com)/($dscpresales[0]->dec_com+$dscstarted[0]->dec_com+$iscpresales[0]->dec_com+$iscstarted[0]->dec_com):0;

    $data ["theoreticalCapacity"] = $theoreticalCapacity;
    $data ["theoreticalCapacity"] = [];
    $data ["theoreticalCapacity"][0] = new \stdClass();
    $data ["theoreticalCapacity"][0]->year = $inputs['year'][0];
    $data ["theoreticalCapacity"][0]->jan_com = $theoreticalCapacity[0];
    $data ["theoreticalCapacity"][0]->feb_com = $theoreticalCapacity[1];
    $data ["theoreticalCapacity"][0]->mar_com = $theoreticalCapacity[2];
    $data ["theoreticalCapacity"][0]->apr_com = $theoreticalCapacity[3];
    $data ["theoreticalCapacity"][0]->may_com = $theoreticalCapacity[4];
    $data ["theoreticalCapacity"][0]->jun_com = $theoreticalCapacity[5];
    $data ["theoreticalCapacity"][0]->jul_com = $theoreticalCapacity[6];
    $data ["theoreticalCapacity"][0]->aug_com = $theoreticalCapacity[7];
    $data ["theoreticalCapacity"][0]->sep_com = $theoreticalCapacity[8];
    $data ["theoreticalCapacity"][0]->oct_com = $theoreticalCapacity[9];
    $data ["theoreticalCapacity"][0]->nov_com = $theoreticalCapacity[10];
    $data ["theoreticalCapacity"][0]->dec_com = $theoreticalCapacity[11];

    $data ["dscpresales"] = $dscpresales;
    $data ["iscpresales"] = $iscpresales;
    $data ["dscstarted"] = $dscstarted;
    $data ["iscstarted"] = $iscstarted;

    return json_encode($data);
  }
  public function test ()
  {
    return $this->activityRepository->test();
  }
}
