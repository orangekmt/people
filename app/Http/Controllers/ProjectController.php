<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Project;
use App\Role;
use App\Repositories\ProjectRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectCreateRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Http\Requests\PasswordUpdateRequest;
use DB;
use Entrust;
use Auth;

class ProjectController extends Controller {

  protected $projectRepository;

  public function __construct(ProjectRepository $projectRepository)
  {
    $this->projectRepository = $projectRepository;
	}
	public function getList()
	{
		return view('project/list');
	}

	public function show($id)
	{
    $project = $this->projectRepository->getById($id);
		return view('project/show',  compact('project'));
	}

	public function getFormCreate()
	{
		return view('project/create_update')->with('action','create');
	}

	public function getFormUpdate($id)
	{
    $project = $this->projectRepository->getById($id);

		return view('project/create_update', compact('project'))->with('action','update');
	}

  public function postFormCreate(ProjectCreateRequest $request)
	{
    $inputs = $request->all();
    $project = $this->projectRepository->createIfNotFound($inputs);
    return redirect('projectFormCreate')->with('success','Record '.$inputs['project_name'].' created !');
	}

	public function postFormUpdate(ProjectUpdateRequest $request, $id)
	{
    $inputs = $request->all();
    $project = $this->projectRepository->update($id, $inputs);
    return redirect('projectFormUpdate/'.$id)->with('success','Record '.$inputs['project_name'].' updated !');
	}

	public function delete($id)
	{
    $name = $this->projectRepository->getById($id)->name;
    // When using stdClass(), we need to prepend with \ so that Laravel won't get confused...
    $result = new \stdClass();
    $result->result = true;
    $result->msg = '';

    try {
        $project = $this->projectRepository->destroy($id);
    }
    catch (\Illuminate\Database\QueryException $ex){
        $result->result = false;
        $result->msg = 'Message:</BR>'.$ex->getMessage();
        return json_encode($result);
    }
    $result->msg = 'Record '.$name.' deleted successfully';
		return json_encode($result);
	}

  public function ListOfprojects()
  {
    return $this->projectRepository->getListOfProjects();
  }
}
