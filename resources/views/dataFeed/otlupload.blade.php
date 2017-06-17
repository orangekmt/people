@extends('layouts.app')

@section('content')
<!-- Page title -->
<div class="page-title">
  <div class="title_left">
    <h3>OTL upload</h3>
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
        <h2>Form</small></h2>
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
      <!-- Window content -->

    </div>
  </div>
</div>
<!-- Window -->

<!-- Window -->
@if (isset($messages))
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

      <!-- Window title -->
      <div class="x_title">
        <h2>Results</small></h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- Window title -->

      <!-- Window content -->
      <div class="x_content">
        <br />
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
      <!-- Window content -->

    </div>
  </div>
</div>
@endif
<!-- Window -->

@stop
