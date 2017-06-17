@extends('layouts.app')

@section('style')
<!-- CSS -->
<!-- DataTables -->
<link href="{{ asset('/plugins/gentelella/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('/plugins/gentelella/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('/plugins/gentelella/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('/plugins/gentelella/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('/plugins/gentelella/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">

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

<!-- Bootbox -->
<script src="{{ asset('/plugins/bootbox/bootbox.min.js') }}"></script>
@stop

@section('content')
<!-- Page title -->
<div class="page-title">
  <div class="title_left">
    <h3>Home</h3>
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
        <h2>General<small>info</small></h2>
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
        <div id="delete_message">
        </div>
        <table id="projectTable" class="table table-striped table-hover table-bordered" width="100%">
          <thead>
            <tr>
              <th>ID</th>
              <th>Project name</th>
              <th>Customer name</th>
              <th>OTL project code</th>
              <th>Project type</th>
              <th>Meta-activity</th>
              <th>Region</th>
              <th>Country</th>
              <th>Domain</th>
              <th>Description</th>
              <th>Estimated start date</th>
              <th>Estimated end date</th>
              <th>Comments</th>
              <th>LoE onshore</th>
              <th>LoE nearshore</th>
              <th>LoE offshore</th>
              <th>LoE contractor</th>
              <th>Gold order</th>
              <th>FPC</th>
              <th>Revenue (€)</th>
              <th>Project status</th>
              <th>Win ratio (%)</th>
              <th class="last_column">
                @permission('project-create')
                <a href="{{ route('projectFormCreate') }}" class="btn btn-info btn-xs" align="right"><span class="glyphicon glyphicon-plus"> New</span></a>
                @endpermission
              </th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>ID</th>
              <th>Project name</th>
              <th>Customer name</th>
              <th>OTL project code</th>
              <th>Project type</th>
              <th>Meta-activity</th>
              <th>Region</th>
              <th>Country</th>
              <th>Domain</th>
              <th>Description</th>
              <th>Estimated start date</th>
              <th>Estimated end date</th>
              <th>Comments</th>
              <th>LoE onshore</th>
              <th>LoE nearshore</th>
              <th>LoE offshore</th>
              <th>LoE contractor</th>
              <th>Gold order</th>
              <th>FPC</th>
              <th>Revenue (€)</th>
              <th>Project status</th>
              <th>Win ratio (%)</th>
              <th class="last_column"></th>
            </tr>
          </tfoot>
        </table>
      </div>
      <!-- Window content -->

    </div>
  </div>
</div>
<!-- Window -->
@stop

@section('script')
<script>
var projectTable;
var record_id;

// Here we are going to get from PHP the list of roles and their value for the logged in project

<?php
  $options = array(
    'validate_all' => true,
    'return_type' => 'both'
  );
  list($validate, $allValidations) = Entrust::ability(null,array('project-view','project-edit','project-delete','project-create'),$options);
  echo "var permissions = jQuery.parseJSON('".json_encode($allValidations['permissions'])."');";
?>
// Roles check finished.

//console.log(permissions);
function ajaxData(){
  var obj = {
    'unassigned': 'no_use'
  };
  return obj;
}


$(document).ready(function() {

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  projectTable = $('#projectTable').DataTable({
    scrollX: true,
    serverSide: true,
    processing: true,
    ajax: {
      url: "{!! route('listOfProjectsAjax') !!}",
      type: "POST",
      data: function ( d ) {
        $.extend(d,ajaxData());
      },
      dataType: "JSON"
    },
    columns: [
      { name: 'id', data: 'id' , searchable: false , visible: false },
      { name: 'project_name', data: 'project_name' },
      { name: 'customer_name', data: 'customer_name' },
      { name: 'otl_project_code', data: 'otl_project_code' },
      { name: 'project_type', data: 'project_type'},
      { name: 'meta_activity', data: 'meta_activity' },
      { name: 'region', data: 'region' },
      { name: 'country', data: 'country' },
      { name: 'domain', data: 'domain' },
      { name: 'description', data: 'description' , searchable: false , visible: false },
      { name: 'estimated_start_date', data: 'estimated_start_date', searchable: false , visible: false  },
      { name: 'estimated_end_date', data: 'estimated_end_date' , searchable: false , visible: false },
      { name: 'comments', data: 'comments', searchable: false , visible: false  },
      { name: 'LoE_onshore', data: 'LoE_onshore' },
      { name: 'LoE_nearshore', data: 'LoE_nearshore' },
      { name: 'LoE_offshore', data: 'LoE_offshore' },
      { name: 'LoE_contractor', data: 'LoE_contractor' },
      { name: 'gold_order_number', data: 'gold_order_number' },
      { name: 'product_code', data: 'product_code' },
      { name: 'revenue', data: 'revenue' },
      { name: 'project_status', data: 'project_status' },
      { name: 'win_ratio', data: 'win_ratio' },
      {
        name: 'actions',
        data: null,
        sortable: false,
        searchable: false,
        render: function (data) {
          var actions = '';
          actions += '<div class="btn-group btn-group-xs">';
          if (permissions['project-view']){
            actions += '<button id="'+data.id+'" class="buttonView btn btn-success"><span class="glyphicon glyphicon-eye-open"></span></button>';
          };
          if (permissions['project-edit']){
            actions += '<button id="'+data.id+'" class="buttonUpdate btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></button>';
          };
          if (permissions['project-delete']){
            actions += '<button id="'+data.id+'" class="buttonDelete btn btn-danger"><span class="glyphicon glyphicon-trash"></span></button>';
          };
          actions += '</div>';
          return actions;
        },
        width: '70px'
      }
    ],
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
          columns: [ 1, 2, 3, 4, 5, 6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21 ]
        }
      },
      {
        extend: "excel",
        className: "btn-sm",
        exportOptions: {
          columns: [ 1, 2, 3, 4, 5, 6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21]
        }
      },
      {
        extend: "print",
        className: "btn-sm",
        exportOptions: {
          columns: [ 1, 2, 3, 4, 5, 6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21]
        }
      },
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
    }
  });


  $(document).on('click', '.buttonUpdate', function () {
    window.location.href = "{!! route('projectFormUpdate','') !!}/"+this.id;
  } );

  $(document).on('click', '.buttonView', function () {
    window.location.href = "{!! route('project','') !!}/"+this.id;
  } );

  $(document).on('click', '.buttonDelete', function () {
    record_id = this.id;
    bootbox.confirm("Are you sure want to delete this record?", function(result) {
      if (result){
        $.ajax({
          type: 'get',
          url: "{!! route('projectDelete','') !!}/"+record_id,
          dataType: 'json',
          success: function(data) {
            //console.log(data);
            if (data.result == 'success'){
              box_type = 'success';
            }
            else {
              box_type = 'danger';
            }
            $('#delete_message').empty();
            var box = $('<div class="alert alert-'+box_type+' alert-dismissible"><button href="#" class="close" data-dismiss="alert" aria-label="close">&times;</button>'+data.msg+'</div>');
            $('#delete_message').append(box);
            projectTable.ajax.reload();
          }
        });
      }
    });
  } );

} );
</script>
@stop
