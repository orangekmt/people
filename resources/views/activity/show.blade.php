@extends('layouts.app')

@section('content')
<!-- Page title -->
<div class="page-title">
  <div class="title_left">
    <h3>Activity</h3>
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
        <h2>Info</small></h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- Window title -->

      <!-- Window content -->
      <div class="x_content">
        <br />
        <p>{!! $activity->task_hour !!}</p>
      </div>
      <!-- Window content -->

    </div>
  </div>
</div>
<!-- Window -->

@stop
