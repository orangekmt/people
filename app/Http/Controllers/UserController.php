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
    $password = $this->userRepository->update_password($id, $inputs);
    return redirect('profile/'.$id)->with('success','Password updated successfully');
  }

	public function getFormCreate()
	{
    $role_select_disabled = 'true';
    $userRole = ['4' => '4'];
    if(Entrust::hasRole('Admin')){
      $roles = Role::lists('display_name','id');
    } else {
      $roles = Role::where('id','!=','1')->lists('display_name','id');
    }

    if (Entrust::can('role-assign')){
      $role_select_disabled = 'false';
    }

		$manager_list = $this->userRepository->getManagersList();
    //\Debugbar::info($manager_list);
    // Now we need to add 1 record so that we can chose without a manager
    $manager_list[-1] = null;
    // We will use the function asort that is sorting an array but for that, we need to convert the object to an associative array
    $manager_list = json_decode(json_encode($manager_list),TRUE);
    ksort($manager_list);

		//\Debugbar::info($manager_list);
		return view('user/create_update', compact('manager_list','roles','role_select_disabled','userRole'))->with('action','create');
	}

	public function getFormUpdate($id)
	{
    $user = User::find($id);
    $role_select_disabled = 'true';
    if(Entrust::hasRole('Admin')){
      $roles = Role::lists('display_name','id');
    } else {
      $roles = Role::where('id','!=','1')->lists('display_name','id');
    }

    if (Entrust::can('role-assign')){
      $role_select_disabled = 'false';
    }

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
		return view('user/create_update', compact('manager_list','user','manager','roles','userRole','role_select_disabled'))->with('action','update');
	}

  public function postFormCreate(UserCreateRequest $request)
	{
    $inputs = $request->all();
    $user = $this->userRepository->create($inputs);
    return redirect('userList')->with('success','Record created successfully');
	}

	public function postFormUpdate(UserUpdateRequest $request, $id)
	{
    $inputs = $request->all();
    $user = $this->userRepository->update($id, $inputs);
    return redirect('userList')->with('success','Record updated successfully');
	}

	public function delete($id)
	{
    // When using stdClass(), we need to prepend with \ so that Laravel won't get confused...
    $result = new \stdClass();
    $result->result = 'success';
    $result->msg = 'Record deleted successfully';

    // First we need to verify that we don't try to delete ourselve.
    if (Auth::user()->id == $id){
      $result->result = 'error';
      $result->msg = 'User '.Auth::user()->name.' cannot delete himself';
      return json_encode($result);
    }

    $user = $this->userRepository->destroy($id);
    if (isset($user['status'])){
      $result->result = 'error';
      $result->msg = $user['msg'];
    }

		return json_encode($result);
	}

  public function ListOfusers()
  {
    return $this->userRepository->getListOfUsers();
  }

}
