<?php
namespace App\Http\Controllers;
use App\Http\Requests\OtlUploadRequest;
use App\Repositories\UserRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\ActivityRepository;
class OtlUploadController extends Controller
{
  protected $userRepository;
  public function __construct(UserRepository $userRepository, ProjectRepository $projectRepository, ActivityRepository $activityRepository)
  {
    $this->userRepository = $userRepository;
    $this->projectRepository = $projectRepository;
    $this->activityRepository = $activityRepository;
  }
  public function getForm()
  {
    return view('dataFeed.otlupload');
  }
  public function postForm(OtlUploadRequest $request)
  {
    $result = new \stdClass();
    $result->result = 'success';
    $result->msg = '';


    $file = $request->file('uploadfile');
    if($file->isValid())
    {
      $filename = $file->getClientOriginalName();
      $fileextension = $file->getClientOriginalExtension();
      $filenametemp = explode(".", $filename);
      $yearmonth = explode("-", $filenametemp[0]);

      config(['excel.import.startRow' => 2 ]);
      $sheet = \Excel::selectSheetsByIndex(0)
      ->load($file);
      // This command helps getting a view on what we get from $sheet
      //$sheet->dd();
      $result = $sheet->get();

      // dd($result);

      $messages = [];
      $i = 1;
      foreach ($result as $row){
        array_push($messages,['status'=>'BEGIN LINE '.$i,'msg'=>'************************']);
        $missing = 0;
        $managerInDB = $this->userRepository->getByName($row->manager_name);
        $userInDB = $this->userRepository->getByName($row->employee_name);
        $projectInDBnum = $this->projectRepository->getByOTLnum($row->project_name,$row->meta_activity);

        if (empty($managerInDB)){
          array_push($messages,['status'=>'error','msg'=>'Manager '.$row->manager_name.' not in DB']);
          $missing = 1;
        } else {
          array_push($messages,['status'=>'pass','msg'=>'Manager '.$row->manager_name.' already in DB']);
        }
        if (empty($userInDB)){
          array_push($messages,['status'=>'error','msg'=>'User '.$row->employee_name.' not in DB']);
          $missing = 1;
        }
        else {
          array_push($messages,['status'=>'pass','msg'=>'User '.$row->employee_name.' already in DB']);
        }
        if ($projectInDBnum > 1){
          array_push($messages,['status'=>'error',
              'msg'=>'Found '.$projectInDBnum.' instance of '.$row->project_name.' with meta '.$row->meta_activity.' for user '.$row->employee_name]);
        }
        elseif ($projectInDBnum == 1) {
          // Only if we can find 1 instance of a mix of otl_project_code and meta-activity then we enter the activity
          array_push($messages,['status'=>'update','msg'=>'Found '.$projectInDBnum.' instance of '.$row->project_name.' with meta '.$row->meta_activity]);
          $projectInDB = $this->projectRepository->getByOTL($row->project_name,$row->meta_activity);
          $project_input = [];
          $project_input['otl_validated'] = 1;
          $this->projectRepository->update($projectInDB->id,$project_input);
          if ($missing == 0) {
            $activity = [];
            // Now we need to check if we need to update or create an activity
            $activity['year'] = $yearmonth[0];
            $activity['month'] = $yearmonth[1];
            $activity['user_id'] = $userInDB->id;
            $activity['project_id'] = $projectInDB->id;
            $activity['task_hour'] = $row->original_time / config('options.time_trak')['hours_in_day'];
            $activity['from_otl'] = 1;
            $activityInDB = $this->activityRepository->checkIfExists($activity);
            if (!$activityInDB){
              $this->activityRepository->create($activity);
              array_push($messages,['status'=>'add','msg'=>'Activity created in DB']);
            } else {
              $this->activityRepository->update($activityInDB->id,$activity);
              array_push($messages,['status'=>'update','msg'=>'Activity updated in DB']);
            }
          }
        }
        else {
          array_push($messages,['status'=>'error',
            'msg'=>'Found '.$projectInDBnum.' instance of '.$row->project_name.' with meta '.$row->meta_activity.' for user '.$row->employee_name]);
        }
        array_push($messages,['status'=>'END LINE '.$i,'msg'=>'************************']);
        $i += 1;
      }
    }
    /*

    foreach ($sheet as $row){
    $manager = [];
    $manager['name'] = $row->manager_name;
    $manager['is_manager'] = true;
    $manager['manager_id'] = 1;
    $manager['from_otl'] = 1;
    $manager = $this->userRepository->createIfNotFound($manager);
    $user = [];
    $user['name'] = $row->user_name;
    $user['manager_id'] = $manager->id;
    $user['from_otl'] = 1;
    $user = $this->userRepository->createIfNotFound($user);
    $project = [];
    $project['customer_name'] = $row->customer_name;
    $project['project_name'] = $row->project_name;
    $project['task_name'] = $row->task_name;
    $project['meta_activity'] = $row->meta_activity;
    $project['project_type'] = $row->project_type;
    $project['task_category'] = $row->task_category;
    $project['from_otl'] = 1;
    $project = $this->projectRepository->createIfNotFound($project);
    $activity = [];
    $activity['year'] = $request->input('year');
    $activity['month'] = $request->input('month');
    $activity['project_id'] = $project->id;
    $activity['user_id'] = $user->id;
    $activity['task_hour'] = $row->original_time;
    $activity['from_otl'] = 1;
    $activity = $this->activityRepository->createOrUpdate($activity);

    $key = in_array($user['name'], array_column($results, 'name'));
    if ($key == false)
    {
    array_push($results,['name'=>$user['name'],'status'=>'updated']);
  }
};
*/
return view('dataFeed.otlupload',  compact('messages'))->with('success','File processed');
}
}
