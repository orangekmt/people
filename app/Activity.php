<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{

    protected $table = 'activities';
    public $timestamps = true;
    protected $fillable = array('customer_name', 'activity_name', 'task_name', 'from_otl', 'activity_type', 'task_category', 'meta_activity', 'region', 'country', 'customer_location', 'domain', 'description', 'estimated_end_date', 'comments', 'LoE_onshore', 'LoE_nearshore', 'LoE_offshore', 'LoE_contractor', 'gold_order_number', 'product_code', 'revenue', 'activity_status', 'otl_activity_code', 'win_ratio', 'created_at', 'updated_at');

    public function activities()
    {
        return $this->hasMany('App\Activity', 'activity_id');
    }

}
