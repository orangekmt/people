@extends('layouts.app',['main_title' => 'Dashboard','second_title'=>'activities','url'=>[['name'=>'home','url'=>route('home')],['name'=>'list','url'=>'#']]])

@section('style')
<!-- CSS -->
<!-- Select2 -->
<link href="{{ asset('/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('/plugins/datatables/dataTables.bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('/css/datatables.css') }}">
@stop

@section('scriptsrc')
<!-- JS -->
<!-- Select2 -->
<script src="{{ asset('/plugins/select2/select2.full.min.js') }}" type="text/javascript"></script>
<!-- DataTables -->
<script src="{{ asset('/plugins/datatables/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
<!-- Bootbox -->
<script src="{{ asset('/plugins/bootbox/bootbox.min.js') }}"></script>
@stop

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="box box-primary">
      <div class="box-header">
        <i class="fa fa-wrench"></i>
        <h3 class="box-title">Tools</h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div><!-- /.box-tools -->
      </div>
      <div class="box-body">
        <div class="row">
          <div class="form-group col-xs-2">
            <label for="year" class="control-label">Year</label>
            <select class="form-control select2" style="width: 100%;" id="year" name="year" data-placeholder="Select a year">
              @foreach($years as $year)
              <option value="{{ $year['id'] }}" {{ $year['selected'] }}>{{ $year['value'] }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group col-xs-2">
            <label for="manager" class="control-label">Manager</label>
            <select class="form-control select2" style="width: 100%;" id="manager" name="manager" data-placeholder="Select a manager" multiple="multiple">
              @foreach($manager_list as $key => $value)
              <option value="{{ $key }}">{{ $value }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group col-xs-2">
            <label for="meta_activity" class="control-label">OTL Meta-activity</label>
            <select class="form-control select2" style="width: 100%;" id="meta_activity" name="meta_activity" data-placeholder="Select an OTL meta-activity" multiple="multiple">
              @foreach(config('select.meta_activity') as $key => $value)
              <option value="{{ $key }}">{{ $value }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group col-xs-2">
            <label for="project_status" class="control-label">Project status</label>
            <select class="form-control select2" style="width: 100%;" id="project_status" name="project_status" data-placeholder="Select a project status" multiple="multiple">
              @foreach(config('select.project_status') as $key => $value)
              <option value="{{ $key }}">{{ $value }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group col-xs-2">
            <label for="project_type" class="control-label">Project type</label>
            <select class="form-control select2" style="width: 100%;" id="project_type" name="project_type" data-placeholder="Select a project type" multiple="multiple">
              @foreach(config('select.project_type') as $key => $value)
              <option value="{{ $key }}">{{ $value }}</option>
              @endforeach
            </select>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <!-- table widget -->
    <div class="box box-info direct-chat direct-chat-info">

      <div class="box-header with-border">
        <i class="fa fa-cloud-download"></i>
        <h3 class="box-title">Activities (days)</h3>
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
          <div style="direct-chat-messages">
            <table id="activitiesTable" class="display table-bordered table-hover table-responsive my_data">
              <thead>
                <tr>
                  <th>Manager ID</th>
                  <th>Manager name</th>
                  <th>User ID</th>
                  <th>User name</th>
                  <th>Year</th>
                  <th>Jan</th>
                  <th>OTL</th>
                  <th>Feb</th>
                  <th>OTL</th>
                  <th>Mar</th>
                  <th>OTL</th>
                  <th>Apr</th>
                  <th>OTL</th>
                  <th>May</th>
                  <th>OTL</th>
                  <th>Jun</th>
                  <th>OTL</th>
                  <th>Jul</th>
                  <th>OTL</th>
                  <th>Aug</th>
                  <th>OTL</th>
                  <th>Sep</th>
                  <th>OTL</th>
                  <th>Oct</th>
                  <th>OTL</th>
                  <th>Nov</th>
                  <th>OTL</th>
                  <th>Dec</th>
                  <th>OTL</th>
                  <th></th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Manager ID</th>
                  <th>Manager name</th>
                  <th>User ID</th>
                  <th>User name</th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                </tr>
              </tfoot>
            </table>
          </div>
          <div class="direct-chat-contacts">
            <ul class="contacts-list">
              <li>

                  <div class="contacts-list-info">
                    <span class="contacts-list-name">

                    </span>
                    <span class="contacts-list-msg"></span>
                  </div>
                  <!-- /.contacts-list-info -->
                </a>
              </li>
            </ul>
            <!-- /.contatcts-list -->
          </div>
          <!-- /.direct-chat-pane -->
        </div>



      </div>
    </div>
  </div>
  @stop

  @section('script')
  <script>
  var activitiesTable;
  var year = [];
  var manager = [];
  var meta_activity = [];
  var project_status = [];
  var project_type = [];

  //alert($.fn.dataTable.version);
  $("#year option:selected").each(function()
  {
    // log the value and text of each option
    year.push($(this).val());
  });

  $("#manager option:selected").each(function()
  {
    // log the value and text of each option
    manager.push($(this).val());
  });

  $("#meta_activity option:selected").each(function()
  {
    // log the value and text of each option
    meta_activity.push($(this).val());
  });

  $("#project_status option:selected").each(function()
  {
    // log the value and text of each option
    project_status.push($(this).val());
  });

  $("#project_type option:selected").each(function()
  {
    // log the value and text of each option
    project_type.push($(this).val());
  });


  function ajaxData(){
    var obj = {
      'year[]': year,
      'manager[]': manager,
      'meta_activity[]': meta_activity,
      'project_status[]': project_status,
      'project_type[]': project_type
    };
    return obj;
  }
  // Here we are going to get from PHP the list of roles and their value for the logged in activities

  var permissions = jQuery.parseJSON('{!! $perms !!}');

  // Roles check finished.

  //console.log(permissions);

  $(document).ready(function() {

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    //Init select2 boxes
    $("#year").select2({
      allowClear: false
    });
    //Init select2 boxes
    $("#manager").select2({
      allowClear: false,
      disabled: {{ $manager_select_disabled }}
    });
    //Init select2 boxes
    $("#meta_activity").select2({
      allowClear: false
    });
    //Init select2 boxes
    $("#project_status").select2({
      allowClear: false
    });
    //Init select2 boxes
    $("#project_type").select2({
      allowClear: false
    });

    $('#year').on('change', function() {
      year = [];
      $("#year option:selected").each(function()
      {
        // log the value and text of each option
        year.push($(this).val());

      });
      activitiesTable.ajax.reload();
    });

    $('#manager').on('change', function() {
      manager = [];
      $("#manager option:selected").each(function()
      {
        // log the value and text of each option
        manager.push($(this).val());

      });
      activitiesTable.ajax.reload();
    });

    $('#meta_activity').on('change', function() {
      meta_activity = [];
      $("#meta_activity option:selected").each(function()
      {
        // log the value and text of each option
        meta_activity.push($(this).val());

      });
      activitiesTable.ajax.reload();
    });

    $('#project_status').on('change', function() {
      project_status = [];
      $("#project_status option:selected").each(function()
      {
        // log the value and text of each option
        project_status.push($(this).val());

      });
      activitiesTable.ajax.reload();
    });

    $('#project_type').on('change', function() {
      project_type = [];
      $("#project_type option:selected").each(function()
      {
        // log the value and text of each option
        project_type.push($(this).val());

      });
      activitiesTable.ajax.reload();
    });

    activitiesTable = $('#activitiesTable').DataTable({
      scrollX: true,
      ajax: {
        url: "{!! route('listOfLoadPerUserAjax') !!}",
        type: "POST",
        data: ajaxData,
        dataType: "JSON"
      },
      columns: [
        { name: 'u2.id', data: 'manager_id' , searchable: false , visible: false},
        { name: 'u2.name', data: 'manager_name', width: '150px' },
        { name: 'u.id', data: 'user_id' , searchable: false , visible: false},
        { name: 'u.name', data: 'user_name' , width: '150px'},
        { name: 'activities.year', data: 'year' , searchable: false , visible: false},
        { name: 'jan_com', data: 'jan_com', width: '30px', searchable: false },
        { name: 'jan_otl', data: 'jan_otl', width: '10px', searchable: false , visible: false},
        { name: 'feb_com', data: 'feb_com', width: '30px', searchable: false },
        { name: 'feb_otl', data: 'feb_otl', width: '10px', searchable: false , visible: false},
        { name: 'mar_com', data: 'mar_com', width: '30px', searchable: false },
        { name: 'mar_otl', data: 'mar_otl', width: '10px', searchable: false , visible: false},
        { name: 'apr_com', data: 'apr_com', width: '30px', searchable: false },
        { name: 'apr_otl', data: 'apr_otl', width: '10px', searchable: false , visible: false},
        { name: 'may_com', data: 'may_com', width: '30px', searchable: false },
        { name: 'may_otl', data: 'may_otl', width: '10px', searchable: false , visible: false},
        { name: 'jun_com', data: 'jun_com', width: '30px', searchable: false },
        { name: 'jun_otl', data: 'jun_otl', width: '10px', searchable: false , visible: false},
        { name: 'jul_com', data: 'jul_com', width: '30px', searchable: false },
        { name: 'jul_otl', data: 'jul_otl', width: '10px', searchable: false , visible: false},
        { name: 'aug_com', data: 'aug_com', width: '30px', searchable: false },
        { name: 'aug_otl', data: 'aug_otl', width: '10px', searchable: false , visible: false},
        { name: 'sep_com', data: 'sep_com', width: '30px', searchable: false },
        { name: 'sep_otl', data: 'sep_otl', width: '10px', searchable: false , visible: false},
        { name: 'oct_com', data: 'oct_com', width: '30px', searchable: false },
        { name: 'oct_otl', data: 'oct_otl', width: '10px', searchable: false , visible: false},
        { name: 'nov_com', data: 'nov_com', width: '30px', searchable: false },
        { name: 'nov_otl', data: 'nov_otl', width: '10px', searchable: false , visible: false},
        { name: 'dec_com', data: 'dec_com', width: '30px', searchable: false },
        { name: 'dec_otl', data: 'dec_otl', width: '10px', searchable: false , visible: false},
        {
          name: 'actions',
          data: null,
          sortable: false,
          searchable: false,
          render: function (data) {
            var actions = '';
            return actions;
          }
        }
      ],
      order: [[2, 'asc']],
      initComplete: function () {
        var columns = this.api().init().columns;
        this.api().columns().every(function () {
          var column = this;
          // this will get us the index of the column
          index = column[0][0];
          //console.log(columns[index].searchable);

          // Now we need to skip the column if it is not searchable and we return true, meaning we go to next iteration
          if (columns[index].searchable == false) {
            return true;
          }
          else {
            var input = document.createElement("input");
            $(input).appendTo($(column.footer()).empty())
            .on('keyup change', function () {
              column.search($(this).val(), false, false, true).draw();
            });
          }
        });
      },
      rowCallback: function(row, data, index){
        if(data.jan_com<= 0){
          $(row).find('td:eq(2)').addClass('zero');
        }
        else if(data.jan_com> 176){
          $(row).find('td:eq(2)').addClass('too_high');
        }
        else if(data.jan_otl> 0){
          $(row).find('td:eq(2)').addClass('otl');
        }
        else {
          $(row).find('td:eq(2)').addClass('forecast');
        }
        if(data.feb_com<= 0){
          $(row).find('td:eq(3)').addClass('zero');
        }
        else if(data.feb_com> 176){
          $(row).find('td:eq(3)').addClass('too_high');
        }
        else if(data.feb_otl> 0){
          $(row).find('td:eq(3)').addClass('otl');
        }
        else {
          $(row).find('td:eq(3)').addClass('forecast');
        }
        if(data.mar_com<= 0){
          $(row).find('td:eq(4)').addClass('zero');
        }
        else if(data.mar_com> 176){
          $(row).find('td:eq(4)').addClass('too_high');
        }
        else if(data.mar_otl> 0){
          $(row).find('td:eq(4)').addClass('otl');
        }
        else {
          $(row).find('td:eq(4)').addClass('forecast');
        }
        if(data.apr_com<= 0){
          $(row).find('td:eq(5)').addClass('zero');
        }
        else if(data.apr_com> 176){
          $(row).find('td:eq(5)').addClass('too_high');
        }
        else if(data.apr_otl> 0){
          $(row).find('td:eq(5)').addClass('otl');
        }
        else {
          $(row).find('td:eq(5)').addClass('forecast');
        }
        if(data.may_com<= 0){
          $(row).find('td:eq(6)').addClass('zero');
        }
        else if(data.may_com> 176){
          $(row).find('td:eq(6)').addClass('too_high');
        }
        else if(data.may_otl> 0){
          $(row).find('td:eq(6)').addClass('otl');
        }
        else {
          $(row).find('td:eq(6)').addClass('forecast');
        }
        if(data.jun_com<= 0){
          $(row).find('td:eq(7)').addClass('zero');
        }
        else if(data.jun_com> 176){
          $(row).find('td:eq(7)').addClass('too_high');
        }
        else if(data.jun_otl> 0){
          $(row).find('td:eq(7)').addClass('otl');
        }
        else {
          $(row).find('td:eq(7)').addClass('forecast');
        }
        if(data.jul_com<= 0){
          $(row).find('td:eq(8)').addClass('zero');
        }
        else if(data.jul_com> 176){
          $(row).find('td:eq(8)').addClass('too_high');
        }
        else if(data.jul_otl> 0){
          $(row).find('td:eq(8)').addClass('otl');
        }
        else {
          $(row).find('td:eq(8)').addClass('forecast');
        }
        if(data.aug_com<= 0){
          $(row).find('td:eq(9)').addClass('zero');
        }
        else if(data.aug_com> 176){
          $(row).find('td:eq(9)').addClass('too_high');
        }
        else if(data.aug_otl> 0){
          $(row).find('td:eq(9)').addClass('otl');
        }
        else {
          $(row).find('td:eq(9)').addClass('forecast');
        }
        if(data.sep_com<= 0){
          $(row).find('td:eq(10)').addClass('zero');
        }
        else if(data.sep_com> 176){
          $(row).find('td:eq(10)').addClass('too_high');
        }
        else if(data.sep_otl> 0){
          $(row).find('td:eq(10)').addClass('otl');
        }
        else {
          $(row).find('td:eq(10)').addClass('forecast');
        }
        if(data.oct_com<= 0){
          $(row).find('td:eq(11)').addClass('zero');
        }
        else if(data.oct_com> 176){
          $(row).find('td:eq(11)').addClass('too_high');
        }
        else if(data.oct_otl> 0){
          $(row).find('td:eq(11)').addClass('otl');
        }
        else {
          $(row).find('td:eq(11)').addClass('forecast');
        }
        if(data.nov_com<= 0){
          $(row).find('td:eq(12)').addClass('zero');
        }
        else if(data.nov_com> 176){
          $(row).find('td:eq(12)').addClass('too_high');
        }
        else if(data.nov_otl> 0){
          $(row).find('td:eq(12)').addClass('otl');
        }
        else {
          $(row).find('td:eq(12)').addClass('forecast');
        }
        if(data.dec_com<= 0){
          $(row).find('td:eq(13)').addClass('zero');
        }
        else if(data.dec_com> 176){
          $(row).find('td:eq(13)').addClass('too_high');
        }
        else if(data.dec_otl> 0){
          $(row).find('td:eq(13)').addClass('otl');
        }
        else {
          $(row).find('td:eq(13)').addClass('forecast');
        }
      }
    });

  } );
  </script>
  @stop
