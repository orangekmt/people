@extends('layouts.app')

@section('style')
    <!-- CSS -->
    <!-- DataTables -->
    <link href="{{ asset('/plugins/gentelella/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/gentelella/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/gentelella/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/gentelella/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/gentelella/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">
    <!-- Select2 -->
    <link href="{{ asset('/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />

@stop

@section('scriptsrc')
    <!-- JS -->
    <!-- DataTables -->
    <script src="{{ asset('/plugins/gentelella/vendors/datatables.net/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/plugins/gentelella/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/plugins/gentelella/vendors/datatables.net-buttons/js/dataTables.buttons.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/plugins/gentelella/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/plugins/gentelella/vendors/datatables.net-buttons/js/buttons.flash.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/plugins/gentelella/vendors/datatables.net-buttons/js/buttons.html5.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/plugins/gentelella/vendors/datatables.net-buttons/js/buttons.print.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/plugins/gentelella/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/plugins/gentelella/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/plugins/gentelella/vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/plugins/gentelella/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/plugins/gentelella/vendors/datatables.net-scroller/js/dataTables.scroller.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/plugins/gentelella/vendors/jszip/dist/jszip.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/plugins/gentelella/vendors/pdfmake/build/pdfmake.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/plugins/gentelella/vendors/pdfmake/build/vfs_fonts.js') }}" type="text/javascript"></script>
    <!-- Select2 -->
    <script src="{{ asset('/plugins/select2/select2.full.min.js') }}" type="text/javascript"></script>
    <!-- Bootbox -->
    <script src="{{ asset('/plugins/bootbox/bootbox.min.js') }}"></script>
@stop

@section('content')
<!-- Page title -->
<div class="page-title">
  <div class="title_left">
    <h3>Team load</h3>
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
        <h2>Tools</small></h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- Window title -->

      <!-- Window content -->
      <div class="x_content">
        <br />
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
                <option value="{{ $key }}" <?php if ($key == $manager_selected) { echo 'selected'; }?>>{{ $value }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group col-xs-2">
              <label for="user" class="control-label">User</label>
              <select class="form-control select2" style="width: 100%;" id="user" name="user" data-placeholder="Select a user" multiple="multiple">
                @foreach($user_list as $key => $value)
                <option value="{{ $key }}" <?php if ($key == $user_selected) { echo 'selected'; }?>>{{ $value }}</option>
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
      <!-- Window content -->

    </div>
  </div>
</div>
<!-- Window -->

<!-- Window -->
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

      <!-- Window title -->
      <div class="x_title">
        <h2>Load (days)</small></h2>
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
            <table id="activitiesTable" class="table table-striped table-hover table-bordered" width="100%">
              <thead>
                <tr>
                  <th>Manager ID</th>
                  <th>Manager name</th>
                  <th>User ID</th>
                  <th>User name</th>
                  <th>Year</th>
                  <th>Jan</th>
                  <th>Feb</th>
                  <th>Mar</th>
                  <th>Apr</th>
                  <th>May</th>
                  <th>Jun</th>
                  <th>Jul</th>
                  <th>Aug</th>
                  <th>Sep</th>
                  <th>Oct</th>
                  <th>Nov</th>
                  <th>Dec</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Manager ID</th>
                  <th>Manager name</th>
                  <th>User ID</th>
                  <th>User name</th>
                  <th>Year</th>
                  <th>Jan</th>
                  <th>Feb</th>
                  <th>Mar</th>
                  <th>Apr</th>
                  <th>May</th>
                  <th>Jun</th>
                  <th>Jul</th>
                  <th>Aug</th>
                  <th>Sep</th>
                  <th>Oct</th>
                  <th>Nov</th>
                  <th>Dec</th>
                </tr>
              </tfoot>
            </table>
      </div>
<!-- Window content -->

      </div>
    </div>
  </div>
  @stop

  @section('script')
  <script>
  var activitiesTable;
  var year = [];
  var manager = [];
  var user = [];
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

  $("#user option:selected").each(function()
  {
    // log the value and text of each option
    user.push($(this).val());
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
      'user[]': user,
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
    $("#user").select2({
      allowClear: false,
      disabled: {{ $user_select_disabled }}
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

    $('#user').on('change', function() {
      user = [];
      $("#user option:selected").each(function()
      {
        // log the value and text of each option
        user.push($(this).val());

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
      serverSide: true,
      processing: true,
      ajax: {
        url: "{!! route('listOfLoadPerUserAjax') !!}",
        type: "POST",
        data: function ( d ) {
          $.extend(d,ajaxData());
        },
        dataType: "JSON"
      },
      columns: [
        { name: 'manager_id', data: 'manager_id' , searchable: false , visible: false},
        { name: 'manager_name', data: 'manager_name', width: '150px' },
        { name: 'user_id', data: 'user_id' , searchable: false , visible: false},
        { name: 'user_name', data: 'user_name' , width: '150px'},
        { name: 'year', data: 'year' , searchable: false , visible: false},
        { name: 'jan_com', data: 'jan_com', width: '30px', searchable: false },
        { name: 'feb_com', data: 'feb_com', width: '30px', searchable: false },
        { name: 'mar_com', data: 'mar_com', width: '30px', searchable: false },
        { name: 'apr_com', data: 'apr_com', width: '30px', searchable: false },
        { name: 'may_com', data: 'may_com', width: '30px', searchable: false },
        { name: 'jun_com', data: 'jun_com', width: '30px', searchable: false },
        { name: 'jul_com', data: 'jul_com', width: '30px', searchable: false },
        { name: 'aug_com', data: 'aug_com', width: '30px', searchable: false },
        { name: 'sep_com', data: 'sep_com', width: '30px', searchable: false },
        { name: 'oct_com', data: 'oct_com', width: '30px', searchable: false },
        { name: 'nov_com', data: 'nov_com', width: '30px', searchable: false },
        { name: 'dec_com', data: 'dec_com', width: '30px', searchable: false }
      ],
      order: [[2, 'asc']],
      lengthMenu: [
          [ 5, 10, 25, 50, -1 ],
          [ '5 rows', '10 rows', '25 rows', '50 rows', 'Show all' ]
      ],
      dom: 'Bfrtip',
      buttons: [
        {
          extend: "pageLength",
          className: "btn-sm"
        },
        {
          extend: "csv",
          className: "btn-sm",
          exportOptions: {
              columns: [ 1, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16 ]
          }
        },
        {
          extend: "excel",
          className: "btn-sm",
          exportOptions: {
              columns: [ 1, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16 ]
          }
        },
        {
          extend: "print",
          className: "btn-sm",
          exportOptions: {
              columns: [ 1, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16 ]
          }
        },
      ],
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
        else if(data.jan_com> {{ config('options.time_trak')['days_in_month'] }}){
          $(row).find('td:eq(2)').addClass('too_high');
        }
        else {
          $(row).find('td:eq(2)').addClass('forecast');
        }
        if(data.feb_com<= 0){
          $(row).find('td:eq(3)').addClass('zero');
        }
        else if(data.feb_com> {{ config('options.time_trak')['days_in_month'] }}){
          $(row).find('td:eq(3)').addClass('too_high');
        }
        else {
          $(row).find('td:eq(3)').addClass('forecast');
        }
        if(data.mar_com<= 0){
          $(row).find('td:eq(4)').addClass('zero');
        }
        else if(data.mar_com> {{ config('options.time_trak')['days_in_month'] }}){
          $(row).find('td:eq(4)').addClass('too_high');
        }
        else {
          $(row).find('td:eq(4)').addClass('forecast');
        }
        if(data.apr_com<= 0){
          $(row).find('td:eq(5)').addClass('zero');
        }
        else if(data.apr_com> {{ config('options.time_trak')['days_in_month'] }}){
          $(row).find('td:eq(5)').addClass('too_high');
        }
        else {
          $(row).find('td:eq(5)').addClass('forecast');
        }
        if(data.may_com<= 0){
          $(row).find('td:eq(6)').addClass('zero');
        }
        else if(data.may_com> {{ config('options.time_trak')['days_in_month'] }}){
          $(row).find('td:eq(6)').addClass('too_high');
        }
        else {
          $(row).find('td:eq(6)').addClass('forecast');
        }
        if(data.jun_com<= 0){
          $(row).find('td:eq(7)').addClass('zero');
        }
        else if(data.jun_com> {{ config('options.time_trak')['days_in_month'] }}){
          $(row).find('td:eq(7)').addClass('too_high');
        }
        else {
          $(row).find('td:eq(7)').addClass('forecast');
        }
        if(data.jul_com<= 0){
          $(row).find('td:eq(8)').addClass('zero');
        }
        else if(data.jul_com> {{ config('options.time_trak')['days_in_month'] }}){
          $(row).find('td:eq(8)').addClass('too_high');
        }
        else {
          $(row).find('td:eq(8)').addClass('forecast');
        }
        if(data.aug_com<= 0){
          $(row).find('td:eq(9)').addClass('zero');
        }
        else if(data.aug_com> {{ config('options.time_trak')['days_in_month'] }}){
          $(row).find('td:eq(9)').addClass('too_high');
        }
        else {
          $(row).find('td:eq(9)').addClass('forecast');
        }
        if(data.sep_com<= 0){
          $(row).find('td:eq(10)').addClass('zero');
        }
        else if(data.sep_com> {{ config('options.time_trak')['days_in_month'] }}){
          $(row).find('td:eq(10)').addClass('too_high');
        }
        else {
          $(row).find('td:eq(10)').addClass('forecast');
        }
        if(data.oct_com<= 0){
          $(row).find('td:eq(11)').addClass('zero');
        }
        else if(data.oct_com> {{ config('options.time_trak')['days_in_month'] }}){
          $(row).find('td:eq(11)').addClass('too_high');
        }
        else {
          $(row).find('td:eq(11)').addClass('forecast');
        }
        if(data.nov_com<= 0){
          $(row).find('td:eq(12)').addClass('zero');
        }
        else if(data.nov_com> {{ config('options.time_trak')['days_in_month'] }}){
          $(row).find('td:eq(12)').addClass('too_high');
        }
        else {
          $(row).find('td:eq(12)').addClass('forecast');
        }
        if(data.dec_com<= 0){
          $(row).find('td:eq(13)').addClass('zero');
        }
        else if(data.dec_com> {{ config('options.time_trak')['days_in_month'] }}){
          $(row).find('td:eq(13)').addClass('too_high');
        }
        else {
          $(row).find('td:eq(13)').addClass('forecast');
        }
      }
    });

  } );
  </script>
  @stop
