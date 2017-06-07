@extends('layouts.app',['main_title' => 'Project','second_title'=>'form','url'=>[['name'=>'home','url'=>route('home')],['name'=>'list','url'=>route('projectList')],['name'=>'form','url'=>'#']]])

@section('content')
<div class="box box-info">
  <div class="box-header">
    <i class="fa fa-project"></i>
    <h3 class="box-title">
      @if($action == 'create')
      Create project
      @elseif($action == 'update')
      Update project
      @endif
    </h3>
    <div class="box-tools pull-right">
      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div><!-- /.box-tools -->
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
    {!! Form::open(['url' => 'projectFormCreate', 'method' => 'post', 'class' => 'form-horizontal']) !!}
    {!! Form::hidden('from_otl', 0, ['class' => 'form-control']) !!}
    @elseif($action == 'update')
    {!! Form::open(['url' => 'projectFormUpdate/'.$project->id, 'method' => 'post', 'class' => 'form-horizontal']) !!}
    {!! Form::hidden('id', $project->id, ['class' => 'form-control']) !!}
    {!! Form::hidden('from_otl', $project->from_otl, ['class' => 'form-control']) !!}
    @endif

    <div class="row">
      <div class="form-group {!! $errors->has('project_name') ? 'has-error' : '' !!} col-md-12">
        <div class="col-md-2">
          {!! Form::label('project_name', 'Project name', ['class' => 'control-label']) !!}
        </div>
        <div class="col-md-10">
          {!! Form::text('project_name', (isset($project)) ? $project->project_name : '', ['class' => 'form-control', 'placeholder' => 'project name']) !!}
          {!! $errors->first('project_name', '<small class="help-block">:message</small>') !!}
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-group {!! $errors->has('task_name') ? 'has-error' : '' !!} col-md-12">
        <div class="col-md-2">
          {!! Form::label('customer_name', 'Customer name', ['class' => 'control-label']) !!}
        </div>
        <div class="col-md-10">
          {!! Form::text('customer_name', (isset($project)) ? $project->customer_name : '', ['class' => 'form-control', 'placeholder' => 'customer name']) !!}
          {!! $errors->first('task_name', '<small class="help-block">:message</small>') !!}
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-group {!! $errors->has('task_name') ? 'has-error' : '' !!} col-md-12">
        <div class="col-md-2">
          {!! Form::label('otl_project_code', 'OTL project code', ['class' => 'control-label']) !!}
        </div>
        <div class="col-md-10">
          {!! Form::text('otl_project_code', (isset($project)) ? $project->otl_project_code : '', ['class' => 'form-control', 'placeholder' => 'OTL project code']) !!}
          {!! $errors->first('task_name', '<small class="help-block">:message</small>') !!}
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-group {!! $errors->has('task_name') ? 'has-error' : '' !!} col-md-12">
        <div class="col-md-2">
          {!! Form::label('task_name', 'Task name', ['class' => 'control-label']) !!}
        </div>
        <div class="col-md-10">
          {!! Form::text('task_name', (isset($project)) ? $project->task_name : '', ['class' => 'form-control', 'placeholder' => 'task name']) !!}
          {!! $errors->first('task_name', '<small class="help-block">:message</small>') !!}
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-group {!! $errors->has('task_name') ? 'has-error' : '' !!} col-md-12">
        <div class="col-md-2">
          {!! Form::label('meta_activity', 'Meta-activity', ['class' => 'control-label']) !!}
        </div>
        <div class="col-md-10">
          {!! Form::select('meta_activity', config('select.meta_activity'), (isset($project)) ? $project->meta_activity : '', ['class' => 'form-control']) !!}
          {!! $errors->first('task_name', '<small class="help-block">:message</small>') !!}
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-group {!! $errors->has('task_category') ? 'has-error' : '' !!} col-md-12">
        <div class="col-md-2">
          {!! Form::label('task_category', 'Task category', ['class' => 'control-label']) !!}
        </div>
        <div class="col-md-10">
          {!! Form::text('task_category', (isset($project)) ? $project->task_category : '', ['class' => 'form-control', 'placeholder' => 'task category']) !!}
          {!! $errors->first('task_category', '<small class="help-block">:message</small>') !!}
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-group {!! $errors->has('project_type') ? 'has-error' : '' !!} col-md-12">
        <div class="col-md-2">
          {!! Form::label('project_type', 'Project type', ['class' => 'control-label']) !!}
        </div>
        <div class="col-md-10">
          {!! Form::text('project_type', (isset($project)) ? $project->project_type : '', ['class' => 'form-control', 'placeholder' => 'project type']) !!}
          {!! $errors->first('project_type', '<small class="help-block">:message</small>') !!}
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-group {!! $errors->has('region') ? 'has-error' : '' !!} col-md-12">
        <div class="col-md-2">
          {!! Form::label('region', 'Region', ['class' => 'control-label']) !!}
        </div>
        <div class="col-md-10">
          {!! Form::select('region', config('select.region'), (isset($project)) ? $project->region : '', ['class' => 'form-control']) !!}
          {!! $errors->first('region', '<small class="help-block">:message</small>') !!}
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-group {!! $errors->has('country') ? 'has-error' : '' !!} col-md-12">
        <div class="col-md-2">
          {!! Form::label('country', 'Country', ['class' => 'control-label']) !!}
        </div>
        <div class="col-md-10">
          {!! Form::select('country', config('select.country'), (isset($project)) ? $project->country : '', ['class' => 'form-control']) !!}
          {!! $errors->first('country', '<small class="help-block">:message</small>') !!}
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-group {!! $errors->has('customer_location') ? 'has-error' : '' !!} col-md-12">
        <div class="col-md-2">
          {!! Form::label('customer_location', 'Customer location', ['class' => 'control-label']) !!}
        </div>
        <div class="col-md-10">
          {!! Form::text('customer_location', (isset($project)) ? $project->customer_location : '', ['class' => 'form-control', 'placeholder' => 'customer location']) !!}
          {!! $errors->first('customer_location', '<small class="help-block">:message</small>') !!}
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-group {!! $errors->has('domain') ? 'has-error' : '' !!} col-md-12">
        <div class="col-md-2">
          {!! Form::label('domain', 'Domain', ['class' => 'control-label']) !!}
        </div>
        <div class="col-md-10">
          {!! Form::select('domain', config('select.domain'), (isset($project)) ? $project->domain : '', ['class' => 'form-control']) !!}
          {!! $errors->first('domain', '<small class="help-block">:message</small>') !!}
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-group {!! $errors->has('description') ? 'has-error' : '' !!} col-md-12">
        <div class="col-md-2">
          {!! Form::label('description', 'description', ['class' => 'control-label']) !!}
        </div>
        <div class="col-md-10">
          {!! Form::text('description', (isset($project)) ? $project->description : '', ['class' => 'form-control', 'placeholder' => 'description']) !!}
          {!! $errors->first('description', '<small class="help-block">:message</small>') !!}
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-group {!! $errors->has('estimated_start_date') ? 'has-error' : '' !!} col-md-12">
        <div class="col-md-2">
          {!! Form::label('estimated_start_date', 'Estimated start date', ['class' => 'control-label']) !!}
        </div>
        <div class="col-md-10">
          {!! Form::date('estimated_start_date', (isset($project)) ? $project->estimated_start_date : '', ['class' => 'form-control']) !!}
          {!! $errors->first('estimated_start_date', '<small class="help-block">:message</small>') !!}
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-group {!! $errors->has('estimated_end_date') ? 'has-error' : '' !!} col-md-12">
        <div class="col-md-2">
          {!! Form::label('estimated_end_date', 'Estimated end date', ['class' => 'control-label']) !!}
        </div>
        <div class="col-md-10">
          {!! Form::date('estimated_end_date', (isset($project)) ? $project->estimated_end_date : '', ['class' => 'form-control']) !!}
          {!! $errors->first('estimated_end_date', '<small class="help-block">:message</small>') !!}
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-group {!! $errors->has('comments') ? 'has-error' : '' !!} col-md-12">
        <div class="col-md-2">
          {!! Form::label('comments', 'Comments', ['class' => 'control-label']) !!}
        </div>
        <div class="col-md-10">
          {!! Form::text('comments', (isset($project)) ? $project->comments : '', ['class' => 'form-control', 'placeholder' => 'Comments']) !!}
          {!! $errors->first('comments', '<small class="help-block">:message</small>') !!}
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-group {!! $errors->has('LoE_onshore') ? 'has-error' : '' !!} col-md-12">
        <div class="col-md-2">
          {!! Form::label('LoE_onshore', 'LoE onshore (days)', ['class' => 'control-label']) !!}
        </div>
        <div class="col-md-10">
          {!! Form::text('LoE_onshore', (isset($project)) ? $project->LoE_onshore : '', ['class' => 'form-control', 'placeholder' => 'LoE onshore (days)']) !!}
          {!! $errors->first('LoE_onshore', '<small class="help-block">:message</small>') !!}
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-group {!! $errors->has('LoE_nearshore') ? 'has-error' : '' !!} col-md-12">
        <div class="col-md-2">
          {!! Form::label('LoE_nearshore', 'LoE nearshore (days)', ['class' => 'control-label']) !!}
        </div>
        <div class="col-md-10">
          {!! Form::text('LoE_nearshore', (isset($project)) ? $project->LoE_nearshore : '', ['class' => 'form-control', 'placeholder' => 'LoE nearshore (days)']) !!}
          {!! $errors->first('LoE_nearshore', '<small class="help-block">:message</small>') !!}
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-group {!! $errors->has('LoE_offshore') ? 'has-error' : '' !!} col-md-12">
        <div class="col-md-2">
          {!! Form::label('LoE_offshore', 'LoE offshore (days)', ['class' => 'control-label']) !!}
        </div>
        <div class="col-md-10">
          {!! Form::text('LoE_offshore', (isset($project)) ? $project->LoE_offshore : '', ['class' => 'form-control', 'placeholder' => 'LoE offshore (days)']) !!}
          {!! $errors->first('LoE_offshore', '<small class="help-block">:message</small>') !!}
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-group {!! $errors->has('LoE_contractor') ? 'has-error' : '' !!} col-md-12">
        <div class="col-md-2">
          {!! Form::label('LoE_contractor', 'LoE contractor (days)', ['class' => 'control-label']) !!}
        </div>
        <div class="col-md-10">
          {!! Form::text('LoE_contractor', (isset($project)) ? $project->LoE_contractor : '', ['class' => 'form-control', 'placeholder' => 'LoE contractor (days)']) !!}
          {!! $errors->first('LoE_contractor', '<small class="help-block">:message</small>') !!}
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-group {!! $errors->has('gold_order_number') ? 'has-error' : '' !!} col-md-12">
        <div class="col-md-2">
          {!! Form::label('gold_order_number', 'Gold order', ['class' => 'control-label']) !!}
        </div>
        <div class="col-md-10">
          {!! Form::text('gold_order_number', (isset($project)) ? $project->gold_order_number : '', ['class' => 'form-control', 'placeholder' => 'Gold order']) !!}
          {!! $errors->first('gold_order_number', '<small class="help-block">:message</small>') !!}
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-group {!! $errors->has('product_code') ? 'has-error' : '' !!} col-md-12">
        <div class="col-md-2">
          {!! Form::label('product_code', 'Product code', ['class' => 'control-label']) !!}
        </div>
        <div class="col-md-10">
          {!! Form::text('product_code', (isset($project)) ? $project->product_code : '', ['class' => 'form-control', 'placeholder' => 'Product code']) !!}
          {!! $errors->first('product_code', '<small class="help-block">:message</small>') !!}
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-group {!! $errors->has('revenue') ? 'has-error' : '' !!} col-md-12">
        <div class="col-md-2">
          {!! Form::label('revenue', 'Revenue (€)', ['class' => 'control-label']) !!}
        </div>
        <div class="col-md-10">
          {!! Form::text('revenue', (isset($project)) ? $project->revenue : '', ['class' => 'form-control', 'placeholder' => 'Revenue (€)']) !!}
          {!! $errors->first('revenue', '<small class="help-block">:message</small>') !!}
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-group {!! $errors->has('project_status') ? 'has-error' : '' !!} col-md-12">
        <div class="col-md-2">
          {!! Form::label('project_status', 'Project status', ['class' => 'control-label']) !!}
        </div>
        <div class="col-md-10">
          {!! Form::select('project_status', config('select.project_status'), (isset($project)) ? $project->project_status : '', ['class' => 'form-control']) !!}
          {!! $errors->first('project_status', '<small class="help-block">:message</small>') !!}
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-group {!! $errors->has('win_ratio') ? 'has-error' : '' !!} col-md-12">
        <div class="col-md-2">
          {!! Form::label('win_ratio', 'Win ratio (%)', ['class' => 'control-label']) !!}
        </div>
        <div class="col-md-10">
          {!! Form::text('win_ratio', (isset($project)) ? $project->win_ratio : '', ['class' => 'form-control', 'placeholder' => 'Win ratio (%)']) !!}
          {!! $errors->first('win_ratio', '<small class="help-block">:message</small>') !!}
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-offset-11 col-md-1">
        @if($action == 'create')
        {!! Form::submit('Create', ['class' => 'btn btn-primary']) !!}
        @elseif($action == 'update')
        {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
        @endif
      </div>
    </div>
    {!! Form::close() !!}
  </div>
  <div class="col-md-1">
    <a href="javascript:history.back()" class="btn btn-primary">
      <span class="glyphicon glyphicon-circle-arrow-left"></span> Back
    </a>
  </div>
</div>
</div>
</div>

@stop
