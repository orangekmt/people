<?php

namespace App\Repositories;

use App\User;
use Datatables;
use DB;
use Entrust;
use Auth;

class UserRepository
{

  protected $user;

  public function __construct(User $user)
	{
		$this->user = $user;
	}

  public function getById($id)
	{
		return $this->user->findOrFail($id);
	}

  public function createIfNotFound(Array $inputs)
  {
    $user = $this->user->where('name', $inputs['name'])->first();

    if (!isset($user)){
        $user = new $this->user;
        return $this->save($user, $inputs);
    }
    else {
      return $user;
    }
  }

  public function update($id, Array $inputs)
	{
		$this->save($this->getById($id), $inputs);
	}

  public function update_password($id, Array $inputs)
	{
    $user = $this->getById($id);
    if (isset($inputs['password']) && trim($inputs['password']) != ''){
      $user->password = bcrypt($inputs['password']);
    }
		$user->save();
	}

	private function save(User $user, Array $inputs)
	{

    // Required fields
		$user->name = $inputs['name'];
    $user->email = $inputs['email'];
    // Password special case
    if (isset($inputs['password']) && trim($inputs['password']) != ''){
      $user->password = bcrypt($inputs['password']);
    }

    // Nullable
    $user->country = isset($inputs['country'])?$inputs['country']:null;
    $user->region = isset($inputs['region'])?$inputs['region']:null;
    $user->domain = isset($inputs['domain'])?$inputs['domain']:null;
    $user->management_code = isset($inputs['management_code'])?$inputs['management_code']:null;
    $user->job_role = isset($inputs['job_role'])?$inputs['job_role']:null;
    $user->employee_type = isset($inputs['employee_type'])?$inputs['employee_type']:null;
    // Boolean
    $user->is_manager = isset($inputs['is_manager']);
    $user->from_otl = isset($inputs['from_otl']);
    $user->save();

    // Now we have to treat the manager
    if ($inputs['manager_id'] != -1){
      /** We need first to check that there is not already a manager defined in which case we have to delete it
      *   Because we want to remove all traces of previous managers, we do a detach without giving
      *   the manager_id as parameter.
      **/
      $user->managers()->detach();
      /** Now we need to create the link in the pivot table
      *   For this we have a function defined in our model User.php called managers()
      *   We only need to say we want to attach the manager_id to this user_id.
      **/
      $user->managers()->attach($inputs['manager_id']);
    }
    else {
      // In this case, we need to remove any trace of manager for this user
      $user->managers()->detach();
    }

    // Now we need to save the roles
    if (Entrust::can('role-assign')){
      DB::table('role_user')->where('user_id',$user->id)->delete();
      foreach ($inputs['roles'] as $key => $value) {
              $user->attachRole($value);
          }
    }
    return $user;
	}

	public function destroy($id)
	{
    $user = $this->getById($id);
    $user->managers()->detach();
		$this->getById($id)->delete();
    return 'success';
	}

  public function getListOfUsers()
  {
    /** We create here a SQL statement and the Datatables function will add the information it got from the AJAX request to have things like search or limit or show.
    *   So we need to have a proper SQL search that the ajax can use via get with parameters given to it.
    *   In the ajax datatables (view), there will be a parameter name that is going to be used here for the extra parameters so if we use a join,
    *   Then we will need to use in the view page the name of the table.column. This is so that it knows how to do proper sorting or search.
    **/
    $userList = DB::table('users')
      ->select( 'users.id', 'users.name','users.email','users.is_manager', 'users.region',
                'users.country', 'users.domain', 'users.management_code', 'users.job_role',
                'users.employee_type','users_users.manager_id','u2.name AS manager_name')
      ->leftjoin('users_users', 'users.id', '=', 'users_users.user_id')
      ->leftjoin('users AS u2', 'u2.id', '=', 'users_users.manager_id');
    $data = Datatables::of($userList)->make(true);
    return $data;
  }

  public function getMyManagersList($id)
	{
    $data = $this->user->findOrFail($id)->managers()->select('manager_id','name')->get();
    return $data;
	}

  public function getManagersList()
	{
    return $this->user->where('is_manager', '=','1')->lists('name','id');
	}
}
