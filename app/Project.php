<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    protected $table = 'projects';
    public $timestamps = true;
    protected $fillable = array('created_by_user_id','otl_validated','customer_name', 'project_name', 'project_type', 'meta_activity', 'region', 'country', 'customer_location', 'domain', 'description', 'estimated_end_date', 'comments', 'LoE_onshore', 'LoE_nearshore', 'LoE_offshore', 'LoE_contractor', 'gold_order_number', 'product_code', 'revenue', 'project_status', 'otl_project_code', 'win_ratio', 'created_at', 'updated_at');

    public function activities()
    {
        return $this->hasMany('App\Activity', 'project_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'created_by_user_id');
    }

}
