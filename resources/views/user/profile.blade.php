@extends('layouts.app')

@section('content')
<!-- Page title -->
<div class="page-title">
  <div class="title_left">
    <h3>Profile</h3>
  </div>
</div>
<div class="clearfix"></div>
<!-- Page title -->

<!-- Window -->
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

      <!-- Window title -->
      <div class="x_title">
        <h2>Change password</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- Window title -->

      <!-- Window content -->
      <div class="x_content">
        <br />
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
          {!! Form::open(['url' => 'passwordUpdate/'.$user->id, 'method' => 'post', 'class' => 'form-horizontal']) !!}
          {!! Form::hidden('id', $user->id, ['class' => 'form-control', 'placeholder' => 'id']) !!}

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
              <div class="col-md-offset-11 col-md-1">
                {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
              </div>
          </div>
          {!! Form::close() !!}
      </div>
      <!-- Window content -->

    </div>
  </div>
</div>
<!-- Window -->

@stop
