<?php

namespace App\Repositories;

use App\Activity;
use Datatables;
use DB;
use Entrust;
use Auth;

class ActivityRepository
{

  protected $activity;

  public function __construct(Activity $activity)
	{
		$this->activity = $activity;
	}

  public function getById($id)
	{
		return $this->activity->findOrFail($id);
	}

  public function create(Array $inputs)
  {
    $activity = new $this->activity;
    return $this->save($activity, $inputs);
  }

  public function update($id, Array $inputs)
	{
		return $this->save($this->getById($id), $inputs);
	}

	private function save(Activity $activity, Array $inputs)
	{
    $result = new \stdClass();
    $result->result = 'success';
    $result->msg = '';

    // Required fields
    if (isset($inputs['activity_name'])) {$activity->activity_name = $inputs['activity_name'];}
    if (isset($inputs['customer_name'])) {$activity->customer_name = $inputs['customer_name'];}
    if (isset($inputs['task_name'])) {$activity->task_name = $inputs['task_name'];}
    if (isset($inputs['meta_activity'])) {$activity->meta_activity = $inputs['meta_activity'];}
    if (isset($inputs['otl_activity_code'])) {$activity->otl_activity_code = $inputs['otl_activity_code'];}
    // Nullable
    if (isset($inputs['activity_type'])) {$activity->activity_type = $inputs['activity_type'];}
    if (isset($inputs['task_category'])) {$activity->task_category = $inputs['task_category'];}
    if (isset($inputs['region'])) {$activity->region = $inputs['region'];}
    if (isset($inputs['country'])) {$activity->country = $inputs['country'];}
    if (isset($inputs['customer_location'])) {$activity->customer_location = $inputs['customer_location'];}
    if (isset($inputs['domain'])) {$activity->domain = $inputs['domain'];}
    if (isset($inputs['estimated_start_date'])) {$activity->estimated_start_date = $inputs['estimated_start_date'];}
    if (isset($inputs['estimated_end_date'])) {$activity->estimated_end_date = $inputs['estimated_end_date'];}
    if (isset($inputs['LoE_onshore'])) {$activity->LoE_onshore = $inputs['LoE_onshore'];}
    if (isset($inputs['LoE_nearshore'])) {$activity->LoE_nearshore = $inputs['LoE_nearshore'];}
    if (isset($inputs['LoE_offshore'])) {$activity->LoE_offshore = $inputs['LoE_offshore'];}
    if (isset($inputs['LoE_contractor'])) {$activity->LoE_contractor = $inputs['LoE_contractor'];}
    if (isset($inputs['gold_order_number'])) {$activity->gold_order_number = $inputs['gold_order_number'];}
    if (isset($inputs['product_code'])) {$activity->product_code = $inputs['product_code'];}
    if (isset($inputs['revenue'])) {$activity->revenue = $inputs['revenue'];}
    if (isset($inputs['activity_status'])) {$activity->activity_status = $inputs['activity_status'];}
    if (isset($inputs['win_ratio'])) {$activity->comments = $inputs['win_ratio'];}

    // Boolean
    $activity->from_otl = isset($inputs['from_otl']);

    try {
      $activity->save();
    }
    catch (\Illuminate\Database\QueryException $ex){
        $result->result = 'error';
        $result->msg = 'Message:</BR>'.$ex->getMessage();
        return $result;
    }

    $result->msg = 'Activity '.$activity->name.' saved successfully.';

    return $result;
	}

	public function destroy($id)
	{
    $result = new \stdClass();
    $result->result = 'success';
    $result->msg = '';

    $activity = $this->getById($id);
    $name = $activity->activity_name;

    try {
		    $activity->delete();
      } catch (\Illuminate\Database\QueryException $ex){
          $result->result = 'error';
          $result->msg = '</BR>Message:</BR>'.$ex->getMessage();
          return $result;
      }

      $result->msg = 'Activity '.$name.' deleted successfully.';
    return $result;
	}

  public function getListOfActivities()
  {
    /** We create here a SQL statement and the Datatables function will add the information it got from the AJAX request to have things like search or limit or show.
    *   So we need to have a proper SQL search that the ajax can use via get with parameters given to it.
    *   In the ajax datatables (view), there will be a parameter name that is going to be used here for the extra parameters so if we use a join,
    *   Then we will need to use in the view page the name of the table.column. This is so that it knows how to do proper sorting or search.
    **/
    $activityList = DB::table('activities')
      ->select( '*');
    $data = Datatables::of($activityList)->make(true);
    return $data;
  }
}
