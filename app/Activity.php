<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{

    protected $table = 'activities';
    public $timestamps = true;
    protected $fillable = array('year','month','project_id','user_id','task_hour','from_otl');

    public function activities()
    {
        return $this->hasMany('App\Activity', 'activity_id');
    }

}
