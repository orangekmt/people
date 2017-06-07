@extends('layouts.app',['main_title' => 'User','second_title'=>'form','url'=>[['name'=>'home','url'=>route('home')],['name'=>'list','url'=>route('userList')],['name'=>'form','url'=>'#']]])

@section('content')
<div class="box box-info">
  <div class="box-header">
    <i class="fa fa-user"></i>
    <h3 class="box-title">
      @if($action == 'create')
      Create user
      @elseif($action == 'update')
      Update user
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
      {!! Form::open(['url' => 'userFormCreate', 'method' => 'post', 'class' => 'form-horizontal']) !!}
      {!! Form::hidden('from_otl', 0, ['class' => 'form-control']) !!}
    @elseif($action == 'update')
      {!! Form::open(['url' => 'userFormUpdate/'.$user->id, 'method' => 'post', 'class' => 'form-horizontal']) !!}
      {!! Form::hidden('id', $user->id, ['class' => 'form-control']) !!}
      {!! Form::hidden('from_otl', $user->from_otl, ['class' => 'form-control']) !!}
    @endif

    <div class="row">
        <div class="form-group {!! $errors->has('name') ? 'has-error' : '' !!} col-md-12">
            <div class="col-md-2">
                {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
            </div>
            <div class="col-md-10">
                {!! Form::text('name', (isset($user)) ? $user->name : '', ['class' => 'form-control', 'placeholder' => 'name']) !!}
                {!! $errors->first('name', '<small class="help-block">:message</small>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group {!! $errors->has('email') ? 'has-error' : '' !!} col-md-12">
            <div class="col-md-2">
                {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
            </div>
            <div class="col-md-10">
                {!! Form::text('email', (isset($user)) ? $user->email : '', ['class' => 'form-control', 'placeholder' => 'email']) !!}
                {!! $errors->first('email', '<small class="help-block">:message</small>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group {!! $errors->has('password') ? 'has-error' : '' !!} col-md-12">
            <div class="col-md-2">
                {!! Form::label('password', 'Password', ['class' => 'control-label']) !!}
            </div>
            <div class="col-md-10">
                {!! Form::password('password', ['class' => 'form-control']) !!}
                {!! $errors->first('password', '<small class="help-block">:message</small>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group {!! $errors->has('confirm-password') ? 'has-error' : '' !!} col-md-12">
            <div class="col-md-2">
                {!! Form::label('confirm-password', 'Confirm', ['class' => 'control-label']) !!}
            </div>
            <div class="col-md-10">
                {!! Form::password('confirm-password', ['class' => 'form-control']) !!}
                {!! $errors->first('confirm-password', '<small class="help-block">:message</small>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group {!! $errors->has('manager_id') ? 'has-error' : '' !!} col-md-12">
            <div class="col-md-2">
                {!! Form::label('manager_id', 'Manager', ['class' => 'control-label']) !!}
            </div>
            <div class="col-md-10">
                {!! Form::select('manager_id', $manager_list, (isset($manager[0])) ? $manager[0]->manager_id : '', ['class' => 'form-control']) !!}
                {!! $errors->first('manager_id', '<small class="help-block">:message</small>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group {!! $errors->has('employee_type') ? 'has-error' : '' !!} col-md-12">
            <div class="col-md-2">
                {!! Form::label('employee_type', 'Type', ['class' => 'control-label']) !!}
            </div>
            <div class="col-md-10">
                {!! Form::select('employee_type', config('select.employee_type'), (isset($user)) ? $user->employee_type : '', ['class' => 'form-control']) !!}
                {!! $errors->first('employee_type', '<small class="help-block">:message</small>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group {!! $errors->has('job_role') ? 'has-error' : '' !!} col-md-12">
            <div class="col-md-2">
                {!! Form::label('job_role', 'Team', ['class' => 'control-label']) !!}
            </div>
            <div class="col-md-10">
                {!! Form::select('job_role', config('select.job_role'), (isset($user)) ? $user->job_role : '', ['class' => 'form-control']) !!}
                {!! $errors->first('job_role', '<small class="help-block">:message</small>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group {!! $errors->has('region') ? 'has-error' : '' !!} col-md-12">
            <div class="col-md-2">
                {!! Form::label('region', 'Region', ['class' => 'control-label']) !!}
            </div>
            <div class="col-md-10">
                {!! Form::select('region', config('select.region'), (isset($user)) ? $user->region : '', ['class' => 'form-control']) !!}
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
                {!! Form::select('country', config('select.country'), (isset($user)) ? $user->country : '', ['class' => 'form-control']) !!}
                {!! $errors->first('country', '<small class="help-block">:message</small>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group {!! $errors->has('domain') ? 'has-error' : '' !!} col-md-12">
            <div class="col-md-2">
                {!! Form::label('domain', 'Domain', ['class' => 'control-label']) !!}
            </div>
            <div class="col-md-10">
                {!! Form::select('domain', config('select.domain'), (isset($user)) ? $user->domain : '', ['class' => 'form-control']) !!}
                {!! $errors->first('domain', '<small class="help-block">:message</small>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group {!! $errors->has('management_code') ? 'has-error' : '' !!} col-md-12">
            <div class="col-md-2">
                {!! Form::label('management_code', 'MC', ['class' => 'control-label']) !!}
            </div>
            <div class="col-md-10">
                {!! Form::text('management_code', (isset($user)) ? $user->management_code : '', ['class' => 'form-control', 'placeholder' => 'management code']) !!}
                {!! $errors->first('management_code', '<small class="help-block">:message</small>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group {!! $errors->has('is_manager') ? 'has-error' : '' !!} col-md-12">
            <div class="col-md-2">
                {!! Form::label('is_manager', 'Is manager?', ['class' => 'control-label']) !!}
            </div>
            <div class="col-md-10">
                {!! Form::checkbox('is_manager', 'yes', (isset($user)) ? $user->is_manager : '', ['class' => 'checkbox']) !!}
                {!! $errors->first('manager_id', '<small class="help-block">:message</small>') !!}
            </div>
        </div>
    </div>
    @permission('role-assign')
    <div class="{!! $errors->has('roles') ? 'has-error' : '' !!} col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Role:</strong>
            {!! Form::select('roles[]', $roles,(isset($userRole))?$userRole:[2], array('class' => 'form-control','multiple')) !!}
      </div>
    @endpermission
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
