@extends('layouts.app',['main_title' => 'User','second_title'=>'form','url'=>[['name'=>'home','url'=>route('home')],['name'=>'form','url'=>'#']]])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @if($action == 'create')
                      Create user
                    @elseif($action == 'update')
                      Update user
                    @endif
                </div>
                <div class="panel-body">
                    <div class="row">
                    @if(session()->has('ok'))
                    <div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
                    @endif
                    </div>
                        @if($action == 'create')
                          {!! Form::open(['url' => 'userFormCreate', 'method' => 'post', 'class' => 'form-horizontal panel']) !!}
                        @elseif($action == 'update')
                          {!! Form::open(['url' => 'userFormUpdate/'.$user->id, 'method' => 'post', 'class' => 'form-horizontal panel']) !!}
                          {!! Form::hidden('id', $user->id, ['class' => 'form-control', 'placeholder' => 'id']) !!}
                        @endif

                        <div class="row">
                            <div class="form-group {!! $errors->has('name') ? 'has-error' : '' !!} col-md-12">
                                <div class="col-md-3">
                                    {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
                                </div>
                                <div class="col-md-9">
                                    {!! Form::text('name', (isset($user)) ? $user->name : '', ['class' => 'form-control', 'placeholder' => 'name']) !!}
                                    {!! $errors->first('name', '<small class="help-block">:message</small>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group {!! $errors->has('email') ? 'has-error' : '' !!} col-md-12">
                                <div class="col-md-3">
                                    {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
                                </div>
                                <div class="col-md-9">
                                    {!! Form::text('email', (isset($user)) ? $user->email : '', ['class' => 'form-control', 'placeholder' => 'email']) !!}
                                    {!! $errors->first('email', '<small class="help-block">:message</small>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group {!! $errors->has('password') ? 'has-error' : '' !!} col-md-12">
                                <div class="col-md-3">
                                    {!! Form::label('password', 'Password', ['class' => 'control-label']) !!}
                                </div>
                                <div class="col-md-9">
                                    {!! Form::password('password', ['class' => 'form-control']) !!}
                                    {!! $errors->first('password', '<small class="help-block">:message</small>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group {!! $errors->has('confirm-password') ? 'has-error' : '' !!} col-md-12">
                                <div class="col-md-3">
                                    {!! Form::label('confirm-password', 'Confirm', ['class' => 'control-label']) !!}
                                </div>
                                <div class="col-md-9">
                                    {!! Form::password('confirm-password', ['class' => 'form-control']) !!}
                                    {!! $errors->first('confirm-password', '<small class="help-block">:message</small>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="col-md-3">
                                    {!! Form::label('manager_id', 'Manager', ['class' => 'control-label']) !!}
                                </div>
                                <div class="col-md-9">
                                    {!! Form::select('manager_id', $manager_list, (isset($manager[0])) ? $manager[0]->manager_id : '', ['class' => 'form-control']) !!}
                                    {!! $errors->first('manager_id', '<small class="help-block">:message</small>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="col-md-3">
                                    {!! Form::label('employee_type', 'Type', ['class' => 'control-label']) !!}
                                </div>
                                <div class="col-md-9">
                                    {!! Form::select('employee_type', config('select.employee_type'), (isset($user)) ? $user->employee_type : '', ['class' => 'form-control']) !!}
                                    {!! $errors->first('employee_type', '<small class="help-block">:message</small>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="col-md-3">
                                    {!! Form::label('job_role', 'Team', ['class' => 'control-label']) !!}
                                </div>
                                <div class="col-md-9">
                                    {!! Form::select('job_role', config('select.job_role'), (isset($user)) ? $user->job_role : '', ['class' => 'form-control']) !!}
                                    {!! $errors->first('job_role', '<small class="help-block">:message</small>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="col-md-3">
                                    {!! Form::label('region', 'Region', ['class' => 'control-label']) !!}
                                </div>
                                <div class="col-md-9">
                                    {!! Form::select('region', config('select.region'), (isset($user)) ? $user->region : '', ['class' => 'form-control']) !!}
                                    {!! $errors->first('region', '<small class="help-block">:message</small>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="col-md-3">
                                    {!! Form::label('country', 'Country', ['class' => 'control-label']) !!}
                                </div>
                                <div class="col-md-9">
                                    {!! Form::select('country', config('select.country'), (isset($user)) ? $user->country : '', ['class' => 'form-control']) !!}
                                    {!! $errors->first('country', '<small class="help-block">:message</small>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="col-md-3">
                                    {!! Form::label('domain', 'Domain', ['class' => 'control-label']) !!}
                                </div>
                                <div class="col-md-9">
                                    {!! Form::select('domain', config('select.domain'), (isset($user)) ? $user->domain : '', ['class' => 'form-control']) !!}
                                    {!! $errors->first('domain', '<small class="help-block">:message</small>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="col-md-3">
                                    {!! Form::label('management_code', 'MC', ['class' => 'control-label']) !!}
                                </div>
                                <div class="col-md-9">
                                    {!! Form::text('management_code', (isset($user)) ? $user->management_code : '', ['class' => 'form-control', 'placeholder' => 'management code']) !!}
                                    {!! $errors->first('management_code', '<small class="help-block">:message</small>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="col-md-3">
                                    {!! Form::label('is_manager', 'Is manager?', ['class' => 'control-label']) !!}
                                </div>
                                <div class="col-md-9">
                                    {!! Form::checkbox('is_manager', 'yes', (isset($user)) ? $user->is_manager : '', ['class' => 'checkbox']) !!}
                                    {!! $errors->first('manager_id', '<small class="help-block">:message</small>') !!}
                                </div>
                            </div>
                        </div>
                        @permission('role-assign')
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Role:</strong>
                                {!! Form::select('roles[]', $roles,(isset($userRole))?$userRole:[2], array('class' => 'form-control','multiple')) !!}
                          </div>
                        @endpermission
                      </div>

                        <div class="row">
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
            <a href="javascript:history.back()" class="btn btn-primary">
                <span class="glyphicon glyphicon-circle-arrow-left"></span> Back
            </a>
        </div>
    </div>
</div>
@stop
