@extends('layouts.app',['main_title' => 'Activity','second_title'=>'form','url'=>[['name'=>'home','url'=>route('home')],['name'=>'list','url'=>route('activityList')],['name'=>'form','url'=>'#']]])

@section('content')
<div class="box box-info">
  <div class="box-header">
    <i class="fa fa-activity"></i>
    <h3 class="box-title">
      @if($action == 'create')
      Create activity
      @elseif($action == 'update')
      Update activity
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
    {!! Form::open(['url' => 'activityFormCreate', 'method' => 'post', 'class' => 'form-horizontal']) !!}
    {!! Form::hidden('from_otl', 0, ['class' => 'form-control']) !!}

    @elseif($action == 'update')
    {!! Form::open(['url' => 'activityFormUpdate/'.$activity->id, 'method' => 'post', 'class' => 'form-horizontal']) !!}
    {!! Form::hidden('id', $activity->id, ['class' => 'form-control']) !!}
    {!! Form::hidden('from_otl', $activity->from_otl, ['class' => 'form-control']) !!}
    @endif

    <div class="row">
      <div class="form-group col-md-12">
        <div class="col-md-2">
          {!! Form::label('year', 'Year', ['class' => 'control-label']) !!}
        </div>
        <div class="col-md-10">
          {!! Form::select('year', config('select.year'), (isset($activity)) ? $activity->year : '', ['class' => 'form-control']) !!}
          {!! $errors->first('year', '<small class="help-block">:message</small>') !!}
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-group col-md-12">
        <div class="col-md-2">
          {!! Form::label('month', 'Month', ['class' => 'control-label']) !!}
        </div>
        <div class="col-md-10">
          {!! Form::select('month', config('select.month'), (isset($activity)) ? $activity->month : '', ['class' => 'form-control']) !!}
          {!! $errors->first('month', '<small class="help-block">:message</small>') !!}
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-group col-md-12">
        <div class="col-md-2">
          {!! Form::label('user_id', 'User', ['class' => 'control-label']) !!}
        </div>
        <div class="col-md-10">
          {!! Form::select('user_id', $allUsers_list, (isset($activity)) ? $activity->user_id : '', ['class' => 'form-control']) !!}
          {!! $errors->first('user_id', '<small class="help-block">:message</small>') !!}
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-group col-md-12">
        <div class="col-md-2">
          {!! Form::label('project_id', 'Project', ['class' => 'control-label']) !!}
        </div>
        <div class="col-md-10">
          {!! Form::select('project_id', $allProjects_list, (isset($activity)) ? $activity->project_id : '', ['class' => 'form-control']) !!}
          {!! $errors->first('project_id', '<small class="help-block">:message</small>') !!}
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-group {!! $errors->has('task_hour') ? 'has-error' : '' !!} col-md-12">
        <div class="col-md-2">
          {!! Form::label('task_hour', 'Task hour', ['class' => 'control-label']) !!}
        </div>
        <div class="col-md-10">
          {!! Form::text('task_hour', (isset($activity)) ? $activity->task_hour : '', ['class' => 'form-control', 'placeholder' => 'Task hour']) !!}
          {!! $errors->first('task_hour', '<small class="help-block">:message</small>') !!}
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
