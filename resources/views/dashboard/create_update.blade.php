@extends('layouts.app',['main_title' => 'Project','second_title'=>'form','url'=>[['name'=>'home','url'=>route('home')],['name'=>'form','url'=>'#']]])

@section('style')
<!-- CSS -->
<link rel="stylesheet" href="{{ asset('/css/datatables.css') }}">
@stop

@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="box box-info direct-chat direct-chat-info">
      <div class="box-header">
        <i class="fa fa-project"></i>
        <h3 class="box-title">
          @if($action == 'create')
          Create project for user {{$user->name}}
          @elseif($action == 'update')
          Update project
          @endif
        </h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Help" data-widget="chat-pane-toggle">
            <i class="fa fa-question"></i>
          </button>
          <button class="btn btn-box-tool" data-widget="collapse">
            <i class="fa fa-minus"></i>
          </button>
          </div><!-- /.box-tools -->
      </div>
      <div class="box-body">
        <div style="direct-chat-messages">
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
          {!! Form::hidden('project_id', $project->id, ['class' => 'form-control']) !!}
          @foreach ($editable_activities as $key => $value)
            {!! Form::hidden('editable_activities['.$key.']', $value, ['class' => 'form-control']) !!}
          @endforeach
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
            @if($action == 'create')
            @for($i = 1; $i <= 12; $i++)
            <div class="form-group {!! $errors->has('month['.$i.']') ? 'has-error' : '' !!} col-md-1">
              {!! Form::label('month['.$i.']', config('select.month_names')[$i], ['class' => 'control-label']) !!}
              {!! Form::text('month['.$i.']', (isset($activities[$i]['task_hour'])) ? $activities[$i]['task_hour'] : 0, ['class' => 'form-control', 'placeholder' => config('select.month_names')[$i], (isset($activities[$i]['from_otl'])) ? 'disabled' : '']) !!}
              {!! $errors->first('month['.$i.']', '<small class="help-block">:message</small>') !!}
            </div>
            @endfor
            @elseif($action == 'update')
            @for($i = 1; $i <= 12; $i++)
            <div class="form-group {!! $errors->has('activities_id['.$activities[$i]['id'].']') ? 'has-error' : '' !!} col-md-1">
              {!! Form::label('activities_id['.$activities[$i]['id'].']', config('select.month_names')[$i], ['class' => 'control-label']) !!}
              {!! Form::text('activities_id['.$activities[$i]['id'].']', (isset($activities[$i]['task_hour'])) ? $activities[$i]['task_hour'] : 0, ['class' => 'form-control', 'placeholder' => config('select.month_names')[$i], (isset($activities[$i]['from_otl'])) ? 'disabled' : '']) !!}
              {!! $errors->first('activities_id['.$activities[$i]['id'].']', '<small class="help-block">:message</small>') !!}
            </div>
            @endfor
            @endif
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="row">
                <div class="form-group {!! $errors->has('project_name') ? 'has-error' : '' !!} col-md-12">
                  <div class="col-md-3">
                    {!! Form::label('project_name', 'Project name', ['class' => 'control-label']) !!}
                  </div>
                  <div class="col-md-9">
                    {!! Form::text('project_name', (isset($project)) ? $project->project_name : '', ['class' => 'form-control', 'placeholder' => 'project name',$edit_project_name]) !!}
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
                    {!! Form::text('customer_name', (isset($project)) ? $project->customer_name : '', ['class' => 'form-control', 'placeholder' => 'customer name',$edit_project_name]) !!}
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
                    {!! Form::text('otl_project_code', (isset($project)) ? $project->otl_project_code : '', ['class' => 'form-control', 'placeholder' => 'OTL project code',$edit_otl_name]) !!}
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
                    {!! Form::select('meta_activity', config('select.meta_activity'), (isset($project)) ? $project->meta_activity : '', ['class' => 'form-control',$edit_otl_name]) !!}
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
                <div class="form-group {!! $errors->has('activity_type') ? 'has-error' : '' !!} col-md-12">
                  <div class="col-md-3">
                    {!! Form::label('activity_type', 'Activity type', ['class' => 'control-label']) !!}
                  </div>
                  <div class="col-md-9">
                    {!! Form::select('activity_type', config('select.activity_type'), (isset($project)) ? $project->activity_type : '', ['class' => 'form-control']) !!}
                    {!! $errors->first('activity_type', '<small class="help-block">:message</small>') !!}
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
        <div class="direct-chat-contacts">
          <ul class="contacts-list">
            <li>

                <div class="contacts-list-info">
                  <span class="contacts-list-name">
                    Options greyed out
                  </span>
                  <span class="contacts-list-msg">Several reasons why an option can be greyed out. It can be because the OTL data has already been uploaded or because you are not the user who created the project.</span>
                </div>
                <!-- /.contacts-list-info -->
              </a>
            </li>

          </ul>
          <!-- /.contatcts-list -->
        </div>
      </div>

    </div>
  </div>
</div>

@stop

@section('script')
@if($action == 'update')

<script>
var year;

$(document).ready(function() {

  $('#year').on('change', function() {
      year=$(this).val();
      window.location.href = "{!! route('dashboardFormUpdate',[$user->id,$project->id,'']) !!}"+"/"+year;
  });

});
</script>

@endif
@stop
