@extends('layouts.app',['main_title' => 'User','second_title'=>'profile','url'=>[['name'=>'home','url'=>route('home')],['name'=>'profile','url'=>'#']]])

@section('content')
    <!-- upload widget -->
    <div class="box box-info">
        <div class="box-header">
            <i class="fa fa-user"></i>
            <h3 class="box-title">Change password</h3>
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
        <div class="box-footer">
        </div>
    </div>
@stop
