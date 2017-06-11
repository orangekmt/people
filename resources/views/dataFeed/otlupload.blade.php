@extends('layouts.app',['main_title' => 'OTL','second_title'=>'upload','url'=>[['name'=>'home','url'=>route('home')],['name'=>'form','url'=>'#']]])

@section('content')
<!-- upload widget -->
<div class="row">
  <div class="col-md-12">
    <div class="box box-info">
      <div class="box-header">
        <i class="fa fa-cloud-upload"></i>
        <h3 class="box-title">OTL upload</h3>
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
        {!! Form::open(['url' => 'otlupload', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true]) !!}

        <div class="row">
          <div class="form-group col-md-12">
            <div class="col-md-2">
              {!! Form::label('sample', 'Sample file', ['class' => 'control-label']) !!}
            </div>
            <div class="col-md-10">
              Download this
              <a href="{{ asset('/Samples/otl_upload_sample.xls') }}">this file</a> to get the structure needed. The file needs to be named with the following convention:<year>-<month>.xls so for example for january 2017, you need the file 2017-1.xls
            </div>
          </div>
        </div>

        <div class="row">
          <div class="form-group {!! $errors->has('uploadfile') ? 'has-error' : '' !!} col-md-12">
            <div class="col-md-2">
              {!! Form::label('uploadfile', 'OTL excel file', ['class' => 'control-label']) !!}
            </div>
            <div class="col-md-10">
              {!! Form::file('uploadfile', ['class' => 'form-control']) !!}
              {!! $errors->first('uploadfile', '<small class="help-block">:message</small>') !!}
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-offset-11 col-md-1">
            {!! Form::submit('Send', ['class' => 'btn btn-primary']) !!}
          </div>
        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>

  @if (isset($messages))
  <div class="row">
    <div class="col-md-12">
      <div class="box box-info">
        <div class="box-header">
          <i class="fa fa-cloud-upload"></i>
          <h3 class="box-title">Results</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div><!-- /.box-tools -->
        </div>
        <div class="box-body">
          <div class="text-danger">Errors</div>
          </BR>
          @foreach($messages as $m)
          @if($m['status'] == 'error')
          <div class="row">
            <div class="col-md-1 text-danger">
              {!! $m['status'] !!}
            </div>
            <div class="col-md-offset-1 col-md-10 text-danger">
              {!! $m['msg'] !!}
            </div>
          </div>
          @endif
          @endforeach
          </BR></BR></BR>
          Full results</BR>
          @foreach($messages as $m)
          <?php
          $color = "text-primary";
          if ($m['status'] == 'add'){$color = "text-success";}
          elseif ($m['status'] == 'error'){$color = "text-danger";}
          ?>
          <div class="row">
            <div class="col-md-1 {!! $color !!}">
              {!! $m['status'] !!}
            </div>
            <div class="col-md-offset-1 col-md-10 {!! $color !!}">
              {!! $m['msg'] !!}
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
    @endif
    @stop
