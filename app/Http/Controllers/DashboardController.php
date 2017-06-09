<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Role;
use App\Http\Controllers\Controller;
use DB;
use Entrust;
use Auth;

class DashboardController extends Controller {



  public function __construct()
  {

	}
	public function activities()
	{
		return view('dashboard/list');
	}

}
