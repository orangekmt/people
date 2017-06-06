<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Role;
use App\Repositories\UserRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\PasswordUpdateRequest;
use DB;
use Entrust;
use Auth;

class UserController extends Controller {

  protected $userRepository;

  public function __construct(UserRepository $userRepository)
  {
    $this->userRepository = $userRepository;
	}
	public function getList()
	{
		return view('user/list');
	}

	public function show($id)
	{
    $user = $this->userRepository->getById($id);
		return view('user/show',  compact('user'));
	}

  public function profile($id)
	{
    $user = $this->userRepository->getById($id);
    if (Auth::user()->id != $id){
      return redirect('userList')->with('error','You are not user '.  $user->name.'!!!');
    }
		return view('user/profile',  compact('user'));
	}

  public function passwordUpdate(PasswordUpdateRequest $request, $id)
  {
    if (Auth::user()->id != $id){
      $user = $this->userRepository->getById($id);
      return redirect('userList')->with('error','You are not user '.  $user->name.'!!!');
    }
    $inputs = $request->all();
    $user = $this->userRepository->update_password($id, $inputs);
    return redirect('profile/'.$id)->with('success','Password updated !');
  }

	public function getFormCreate()
	{
    $roles = Role::lists('display_name','id');
		$manager_list = $this->userRepository->getManagersList();
    //\Debugbar::info($manager_list);
    // Now we need to add 1 record so that we can chose without a manager
    $manager_list[-1] = null;
    // We will use the function asort that is sorting an array but for that, we need to convert the object to an associative array
    $manager_list = json_decode(json_encode($manager_list),TRUE);
    ksort($manager_list);

		//\Debugbar::info($manager_list);
		return view('user/create_update', compact('manager_list','roles'))->with('action','create');
	}

	public function getFormUpdate($id)
	{
    $user = User::find($id);
    $roles = Role::lists('display_name','id');
    $userRole = $user->roles->lists('id','id')->toArray();

    $manager_list = $this->userRepository->getManagersList();
    //\Debugbar::info($manager_list);
    // Now we need to add 1 record so that we can chose without a manager
    $manager_list[-1] = null;
    // We will use the function asort that is sorting an array but for that, we need to convert the object to an associative array
    $manager_list = json_decode(json_encode($manager_list),TRUE);
    ksort($manager_list);
    $user = $this->userRepository->getById($id);
    $manager = $this->userRepository->getMyManagersList($id);

		//\Debugbar::info($manager_list);
		return view('user/create_update', compact('manager_list','user','manager','roles','userRole'))->with('action','update');
	}

  public function postFormCreate(UserCreateRequest $request)
	{
    $inputs = $request->all();
    $user = $this->userRepository->createIfNotFound($inputs);
    return redirect('userList')->with('success','Record '.$inputs['name'].' created !');
	}

	public function postFormUpdate(UserUpdateRequest $request, $id)
	{
    $inputs = $request->all();
    $user = $this->userRepository->update($id, $inputs);
    return redirect('userList')->with('success','Record '.$inputs['name'].' updated !');
	}

	public function delete($id)
	{
    $name = $this->userRepository->getById($id)->name;
    // When using stdClass(), we need to prepend with \ so that Laravel won't get confused...
    $result = new \stdClass();
    $result->result = true;
    $result->msg = '';
    if (Auth::user()->id == $id){
      $result->result = false;
      $result->msg = 'User '.Auth::user()->name.' cannot delete himself';
      return json_encode($result);
    }

    try {
        $user = $this->userRepository->destroy($id);
    }
    catch (\Illuminate\Database\QueryException $ex){
        $result->result = false;
        $result->msg = 'Message:</BR>'.$ex->getMessage();
        return json_encode($result);
    }
//\Debugbar::info($manager_list);
    $result->msg = 'Record '.$name.' deleted successfully';
		return json_encode($result);
	}

  public function ListOfusers()
  {
    return $this->userRepository->getListOfUsers();
  }

}
