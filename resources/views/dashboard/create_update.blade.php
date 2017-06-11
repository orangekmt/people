@extends('layouts.app',['main_title' => 'Project','second_title'=>'form','url'=>[['name'=>'home','url'=>route('home')],['name'=>'form','url'=>'#']]])

@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="box box-info">
      <div class="box-header">
        <i class="fa fa-project"></i>
        <h3 class="box-title">
          @if($action == 'create')
          Create project for user {{$user->name}}
          @elseif($action == 'update')
          Update project
          @endif
        </h3>
      </div>
      <div class="box-body">

        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible">
          <button href="#" class="close" data-dismiss="alert" aria-label="close">&times;</button>
          {{ $message }}
        </div>
        @endif
        @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible">
          <button href="#" class="close" data-dismiss="alert" aria-label="close">&times;</button>
          {{ $message }}
        </div>
        @endif

        @if($action == 'create')
        {!! Form::open(['url' => 'dashboardFormCreate', 'method' => 'post']) !!}
        @elseif($action == 'update')
        {!! Form::open(['url' => 'dashboardFormUpdate', 'method' => 'post']) !!}
        @endif
        {!! Form::hidden('user_id', $user->id, ['class' => 'form-control']) !!}

        <div class="row">
          <div class="form-group {!! $errors->has('year') ? 'has-error' : '' !!} col-md-12">
              <div class="col-md-1">
                  {!! Form::label('year', 'year', ['class' => 'control-label']) !!}
              </div>
              <div class="col-md-11">
                  {!! Form::select('year', config('select.year'), (isset($year)) ? $year : '', ['class' => 'form-control']) !!}
                  {!! $errors->first('year', '<small class="help-block">:message</small>') !!}
              </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            Number of hours for each month.
          </div>
        </div>
        <div class="row">
          <div class="form-group {!! $errors->has('jan') ? 'has-error' : '' !!} col-md-1">
            {!! Form::label('month[1]', 'January', ['class' => 'control-label']) !!}
            {!! Form::text('month[1]', (isset($month)) ? $month[1] : 0, ['class' => 'form-control', 'placeholder' => 'jan']) !!}
            {!! $errors->first('month[1]', '<small class="help-block">:message</small>') !!}
          </div>
          <div class="form-group {!! $errors->has('feb') ? 'has-error' : '' !!} col-md-1">
            {!! Form::label('month[2]', 'February', ['class' => 'control-label']) !!}
            {!! Form::text('month[2]', (isset($month)) ? $month[2] : 0, ['class' => 'form-control', 'placeholder' => 'feb']) !!}
            {!! $errors->first('month[2]', '<small class="help-block">:message</small>') !!}
          </div>
          <div class="form-group {!! $errors->has('mar') ? 'has-error' : '' !!} col-md-1">
            {!! Form::label('month[3]', 'March', ['class' => 'control-label']) !!}
            {!! Form::text('month[3]', (isset($month)) ? $month[3] : 0, ['class' => 'form-control', 'placeholder' => 'mar']) !!}
            {!! $errors->first('month[3]', '<small class="help-block">:message</small>') !!}
          </div>
          <div class="form-group {!! $errors->has('apr') ? 'has-error' : '' !!} col-md-1">
            {!! Form::label('month[4]', 'April', ['class' => 'control-label']) !!}
            {!! Form::text('month[4]', (isset($month)) ? $month[4] : 0, ['class' => 'form-control', 'placeholder' => 'apr']) !!}
            {!! $errors->first('month[4]', '<small class="help-block">:message</small>') !!}
          </div>
          <div class="form-group {!! $errors->has('may') ? 'has-error' : '' !!} col-md-1">
            {!! Form::label('month[5]', 'May', ['class' => 'control-label']) !!}
            {!! Form::text('month[5]', (isset($month)) ? $month[5] : 0, ['class' => 'form-control', 'placeholder' => 'may']) !!}
            {!! $errors->first('month[5]', '<small class="help-block">:message</small>') !!}
          </div>
          <div class="form-group {!! $errors->has('jun') ? 'has-error' : '' !!} col-md-1">
            {!! Form::label('month[6]', 'June', ['class' => 'control-label']) !!}
            {!! Form::text('month[6]', (isset($month)) ? $month[6] : 0, ['class' => 'form-control', 'placeholder' => 'jun']) !!}
            {!! $errors->first('month[6]', '<small class="help-block">:message</small>') !!}
          </div>
          <div class="form-group {!! $errors->has('jul') ? 'has-error' : '' !!} col-md-1">
            {!! Form::label('month[7]', 'July', ['class' => 'control-label']) !!}
            {!! Form::text('month[7]', (isset($month)) ? $month[7] : 0, ['class' => 'form-control', 'placeholder' => 'jul']) !!}
            {!! $errors->first('month[7]', '<small class="help-block">:message</small>') !!}
          </div>
          <div class="form-group {!! $errors->has('aug') ? 'has-error' : '' !!} col-md-1">
            {!! Form::label('month[8]', 'August', ['class' => 'control-label']) !!}
            {!! Form::text('month[8]', (isset($month)) ? $month[8] : 0, ['class' => 'form-control', 'placeholder' => 'aug']) !!}
            {!! $errors->first('month[8]', '<small class="help-block">:message</small>') !!}
          </div>
          <div class="form-group {!! $errors->has('sep') ? 'has-error' : '' !!} col-md-1">
            {!! Form::label('month[9]', 'September', ['class' => 'control-label']) !!}
            {!! Form::text('month[9]', (isset($month)) ? $month[9] : 0, ['class' => 'form-control', 'placeholder' => 'sep']) !!}
            {!! $errors->first('month[9]', '<small class="help-block">:message</small>') !!}
          </div>
          <div class="form-group {!! $errors->has('oct') ? 'has-error' : '' !!} col-md-1">
            {!! Form::label('month[10]', 'October', ['class' => 'control-label']) !!}
            {!! Form::text('month[10]', (isset($month)) ? $month[10] : 0, ['class' => 'form-control', 'placeholder' => 'oct']) !!}
            {!! $errors->first('month[10]', '<small class="help-block">:message</small>') !!}
          </div>
          <div class="form-group {!! $errors->has('nov') ? 'has-error' : '' !!} col-md-1">
            {!! Form::label('month[11]', 'November', ['class' => 'control-label']) !!}
            {!! Form::text('month[11]', (isset($month)) ? $month[11] : 0, ['class' => 'form-control', 'placeholder' => 'nov']) !!}
            {!! $errors->first('month[11]', '<small class="help-block">:message</small>') !!}
          </div>
          <div class="form-group {!! $errors->has('dec') ? 'has-error' : '' !!} col-md-1">
            {!! Form::label('month[12]', 'December', ['class' => 'control-label']) !!}
            {!! Form::text('month[12]', (isset($month)) ? $month[12] : 0, ['class' => 'form-control', 'placeholder' => 'dec']) !!}
            {!! $errors->first('month[12]', '<small class="help-block">:message</small>') !!}
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="row">
              <div class="form-group {!! $errors->has('project_name') ? 'has-error' : '' !!} col-md-12">
                <div class="col-md-3">
                  {!! Form::label('project_name', 'Project name', ['class' => 'control-label']) !!}
                </div>
                <div class="col-md-9">
                  {!! Form::text('project_name', (isset($project)) ? $project->project_name : '', ['class' => 'form-control', 'placeholder' => 'project name']) !!}
                  {!! $errors->first('project_name', '<small class="help-block">:message</small>') !!}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group {!! $errors->has('customer_name') ? 'has-error' : '' !!} col-md-12">
                <div class="col-md-3">
                  {!! Form::label('customer_name', 'Customer name', ['class' => 'control-label']) !!}
                </div>
                <div class="col-md-9">
                  {!! Form::text('customer_name', (isset($project)) ? $project->customer_name : '', ['class' => 'form-control', 'placeholder' => 'customer name']) !!}
                  {!! $errors->first('customer_name', '<small class="help-block">:message</small>') !!}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group {!! $errors->has('otl_project_code') ? 'has-error' : '' !!} col-md-12">
                <div class="col-md-3">
                  {!! Form::label('otl_project_code', 'OTL project code', ['class' => 'control-label']) !!}
                </div>
                <div class="col-md-9">
                  {!! Form::text('otl_project_code', (isset($project)) ? $project->otl_project_code : '', ['class' => 'form-control', 'placeholder' => 'OTL project code']) !!}
                  {!! $errors->first('otl_project_code', '<small class="help-block">:message</small>') !!}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group {!! $errors->has('otl_project_code') ? 'has-error' : '' !!} col-md-12">
                <div class="col-md-3">
                  {!! Form::label('meta_activity', 'Meta-activity', ['class' => 'control-label']) !!}
                </div>
                <div class="col-md-9">
                  {!! Form::select('meta_activity', config('select.meta_activity'), (isset($project)) ? $project->meta_activity : '', ['class' => 'form-control']) !!}
                  {!! $errors->first('otl_project_code', '<small class="help-block">:message</small>') !!}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group {!! $errors->has('project_type') ? 'has-error' : '' !!} col-md-12">
                <div class="col-md-3">
                  {!! Form::label('project_type', 'Project type', ['class' => 'control-label']) !!}
                </div>
                <div class="col-md-9">
                  {!! Form::select('project_type', config('select.project_type'), (isset($project)) ? $project->project_type : '', ['class' => 'form-control']) !!}
                  {!! $errors->first('project_type', '<small class="help-block">:message</small>') !!}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group {!! $errors->has('project_status') ? 'has-error' : '' !!} col-md-12">
                <div class="col-md-3">
                  {!! Form::label('project_status', 'Project status', ['class' => 'control-label']) !!}
                </div>
                <div class="col-md-9">
                  {!! Form::select('project_status', config('select.project_status'), (isset($project)) ? $project->project_status : '', ['class' => 'form-control']) !!}
                  {!! $errors->first('project_status', '<small class="help-block">:message</small>') !!}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group {!! $errors->has('region') ? 'has-error' : '' !!} col-md-12">
                <div class="col-md-3">
                  {!! Form::label('region', 'Region', ['class' => 'control-label']) !!}
                </div>
                <div class="col-md-9">
                  {!! Form::select('region', config('select.region'), (isset($project)) ? $project->region : '', ['class' => 'form-control']) !!}
                  {!! $errors->first('region', '<small class="help-block">:message</small>') !!}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group {!! $errors->has('country') ? 'has-error' : '' !!} col-md-12">
                <div class="col-md-3">
                  {!! Form::label('country', 'Country', ['class' => 'control-label']) !!}
                </div>
                <div class="col-md-9">
                  {!! Form::select('country', config('select.country'), (isset($project)) ? $project->country : '', ['class' => 'form-control']) !!}
                  {!! $errors->first('country', '<small class="help-block">:message</small>') !!}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group {!! $errors->has('customer_location') ? 'has-error' : '' !!} col-md-12">
                <div class="col-md-3">
                  {!! Form::label('customer_location', 'Customer location', ['class' => 'control-label']) !!}
                </div>
                <div class="col-md-9">
                  {!! Form::text('customer_location', (isset($project)) ? $project->customer_location : '', ['class' => 'form-control', 'placeholder' => 'customer location']) !!}
                  {!! $errors->first('customer_location', '<small class="help-block">:message</small>') !!}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group {!! $errors->has('domain') ? 'has-error' : '' !!} col-md-12">
                <div class="col-md-3">
                  {!! Form::label('domain', 'Domain', ['class' => 'control-label']) !!}
                </div>
                <div class="col-md-9">
                  {!! Form::select('domain', config('select.domain-projects'), (isset($project)) ? $project->domain : '', ['class' => 'form-control']) !!}
                  {!! $errors->first('domain', '<small class="help-block">:message</small>') !!}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group {!! $errors->has('description') ? 'has-error' : '' !!} col-md-12">
                <div class="col-md-3">
                  {!! Form::label('description', 'description', ['class' => 'control-label']) !!}
                </div>
                <div class="col-md-9">
                  {!! Form::text('description', (isset($project)) ? $project->description : '', ['class' => 'form-control', 'placeholder' => 'description']) !!}
                  {!! $errors->first('description', '<small class="help-block">:message</small>') !!}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group {!! $errors->has('comments') ? 'has-error' : '' !!} col-md-12">
                <div class="col-md-3">
                  {!! Form::label('comments', 'Comments', ['class' => 'control-label']) !!}
                </div>
                <div class="col-md-9">
                  {!! Form::text('comments', (isset($project)) ? $project->comments : '', ['class' => 'form-control', 'placeholder' => 'Comments']) !!}
                  {!! $errors->first('comments', '<small class="help-block">:message</small>') !!}
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="row">
              <div class="form-group {!! $errors->has('estimated_start_date') ? 'has-error' : '' !!} col-md-12">
                <div class="col-md-3">
                  {!! Form::label('estimated_start_date', 'Estimated start date', ['class' => 'control-label']) !!}
                </div>
                <div class="col-md-9">
                  {!! Form::date('estimated_start_date', (isset($project)) ? $project->estimated_start_date : '', ['class' => 'form-control']) !!}
                  {!! $errors->first('estimated_start_date', '<small class="help-block">:message</small>') !!}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group {!! $errors->has('estimated_end_date') ? 'has-error' : '' !!} col-md-12">
                <div class="col-md-3">
                  {!! Form::label('estimated_end_date', 'Estimated end date', ['class' => 'control-label']) !!}
                </div>
                <div class="col-md-9">
                  {!! Form::date('estimated_end_date', (isset($project)) ? $project->estimated_end_date : '', ['class' => 'form-control']) !!}
                  {!! $errors->first('estimated_end_date', '<small class="help-block">:message</small>') !!}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group {!! $errors->has('LoE_onshore') ? 'has-error' : '' !!} col-md-12">
                <div class="col-md-3">
                  {!! Form::label('LoE_onshore', 'LoE onshore (days)', ['class' => 'control-label']) !!}
                </div>
                <div class="col-md-9">
                  {!! Form::text('LoE_onshore', (isset($project)) ? $project->LoE_onshore : '', ['class' => 'form-control', 'placeholder' => 'LoE onshore (days)']) !!}
                  {!! $errors->first('LoE_onshore', '<small class="help-block">:message</small>') !!}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group {!! $errors->has('LoE_nearshore') ? 'has-error' : '' !!} col-md-12">
                <div class="col-md-3">
                  {!! Form::label('LoE_nearshore', 'LoE nearshore (days)', ['class' => 'control-label']) !!}
                </div>
                <div class="col-md-9">
                  {!! Form::text('LoE_nearshore', (isset($project)) ? $project->LoE_nearshore : '', ['class' => 'form-control', 'placeholder' => 'LoE nearshore (days)']) !!}
                  {!! $errors->first('LoE_nearshore', '<small class="help-block">:message</small>') !!}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group {!! $errors->has('LoE_offshore') ? 'has-error' : '' !!} col-md-12">
                <div class="col-md-3">
                  {!! Form::label('LoE_offshore', 'LoE offshore (days)', ['class' => 'control-label']) !!}
                </div>
                <div class="col-md-9">
                  {!! Form::text('LoE_offshore', (isset($project)) ? $project->LoE_offshore : '', ['class' => 'form-control', 'placeholder' => 'LoE offshore (days)']) !!}
                  {!! $errors->first('LoE_offshore', '<small class="help-block">:message</small>') !!}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group {!! $errors->has('LoE_contractor') ? 'has-error' : '' !!} col-md-12">
                <div class="col-md-3">
                  {!! Form::label('LoE_contractor', 'LoE contractor (days)', ['class' => 'control-label']) !!}
                </div>
                <div class="col-md-9">
                  {!! Form::text('LoE_contractor', (isset($project)) ? $project->LoE_contractor : '', ['class' => 'form-control', 'placeholder' => 'LoE contractor (days)']) !!}
                  {!! $errors->first('LoE_contractor', '<small class="help-block">:message</small>') !!}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group {!! $errors->has('gold_order_number') ? 'has-error' : '' !!} col-md-12">
                <div class="col-md-3">
                  {!! Form::label('gold_order_number', 'Gold order', ['class' => 'control-label']) !!}
                </div>
                <div class="col-md-9">
                  {!! Form::text('gold_order_number', (isset($project)) ? $project->gold_order_number : '', ['class' => 'form-control', 'placeholder' => 'Gold order']) !!}
                  {!! $errors->first('gold_order_number', '<small class="help-block">:message</small>') !!}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group {!! $errors->has('product_code') ? 'has-error' : '' !!} col-md-12">
                <div class="col-md-3">
                  {!! Form::label('product_code', 'Product code', ['class' => 'control-label']) !!}
                </div>
                <div class="col-md-9">
                  {!! Form::text('product_code', (isset($project)) ? $project->product_code : '', ['class' => 'form-control', 'placeholder' => 'Product code']) !!}
                  {!! $errors->first('product_code', '<small class="help-block">:message</small>') !!}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group {!! $errors->has('revenue') ? 'has-error' : '' !!} col-md-12">
                <div class="col-md-3">
                  {!! Form::label('revenue', 'Revenue (€)', ['class' => 'control-label']) !!}
                </div>
                <div class="col-md-9">
                  {!! Form::text('revenue', (isset($project)) ? $project->revenue : '', ['class' => 'form-control', 'placeholder' => 'Revenue (€)']) !!}
                  {!! $errors->first('revenue', '<small class="help-block">:message</small>') !!}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group {!! $errors->has('win_ratio') ? 'has-error' : '' !!} col-md-12">
                <div class="col-md-3">
                  {!! Form::label('win_ratio', 'Win ratio (%)', ['class' => 'control-label']) !!}
                </div>
                <div class="col-md-9">
                  {!! Form::text('win_ratio', (isset($project)) ? $project->win_ratio : '', ['class' => 'form-control', 'placeholder' => 'Win ratio (%)']) !!}
                  {!! $errors->first('win_ratio', '<small class="help-block">:message</small>') !!}
                </div>
              </div>
            </div>
          </div>
          <div class="row"></div>
          <div class="row"></div>
        </div>
        <div class="row">
          <div class="col-md-offset-1 col-md-1">
            <a href="javascript:history.back()" class="btn btn-primary">
              <span class="glyphicon glyphicon-circle-arrow-left"></span> Back
            </a>
          </div>
          <div class="col-md-offset-9 col-md-1">
            @if($action == 'create')
            {!! Form::submit('Create', ['class' => 'btn btn-primary']) !!}
            @elseif($action == 'update')
            {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
            @endif
          </div>
        </div>

        {!! Form::close() !!}

      </div>
    </div>
  </div>
</div>




@stop
