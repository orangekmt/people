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
    <!-- table widget -->
    <div class="box box-info">

        <div class="box-header">
            <i class="fa fa-cloud-download"></i>
            <h3 class="box-title">Activities</h3>
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
            <table id="activitiesTable" class="display table-bordered table-hover table-responsive">
                <thead>
                    <tr>
                        <th>Manager ID</th>
                        <th>Manager name</th>
                        <th>User ID</th>
                        <th>User name</th>
                        <th>Project ID</th>
                        <th>Project name</th>
                        <th>Year</th>
                        <th>Jan (fcst)</th>
                        <th>Jan (OTL)</th>
                        <th>Jan</th>
                        <th>Feb (fcst)</th>
                        <th>Feb (OTL)</th>
                        <th>Feb</th>
                        <th>Mar (fcst)</th>
                        <th>Mar (OTL)</th>
                        <th>Mar</th>
                        <th>Apr (fcst)</th>
                        <th>Apr (OTL)</th>
                        <th>Apr</th>
                        <th>May (fcst)</th>
                        <th>May (OTL)</th>
                        <th>May</th>
                        <th>Jun (fcst)</th>
                        <th>Jun (OTL)</th>
                        <th>Jun</th>
                        <th>Jul (fcst)</th>
                        <th>Jul (OTL)</th>
                        <th>Jul</th>
                        <th>Aug (fcst)</th>
                        <th>Aug (OTL)</th>
                        <th>Aug</th>
                        <th>Sep (fcst)</th>
                        <th>Sep (OTL)</th>
                        <th>Sep</th>
                        <th>Oct (fcst)</th>
                        <th>Oct (OTL)</th>
                        <th>Oct</th>
                        <th>Nov (fcst)</th>
                        <th>Nov (OTL)</th>
                        <th>Nov</th>
                        <th>Dec (fcst)</th>
                        <th>Dec (OTL)</th>
                        <th>Dec</th>
                        <th class="last_column">
                          @permission('activities-create')
                            <a href="{{ route('activitiesFormCreate') }}" class="btn btn-info btn-xs" align="right"><span class="glyphicon glyphicon-plus"> New</span></a>
                          @endpermission
                        </th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Manager ID</th>
                        <th>Manager name</th>
                        <th>User ID</th>
                        <th>User name</th>
                        <th>Project ID</th>
                        <th>Project name</th>
                        <th>Year</th>
                        <th>Jan (fcst)</th>
                        <th>Jan (OTL)</th>
                        <th>Jan</th>
                        <th>Feb (fcst)</th>
                        <th>Feb (OTL)</th>
                        <th>Feb</th>
                        <th>Mar (fcst)</th>
                        <th>Mar (OTL)</th>
                        <th>Mar</th>
                        <th>Apr (fcst)</th>
                        <th>Apr (OTL)</th>
                        <th>Apr</th>
                        <th>May (fcst)</th>
                        <th>May (OTL)</th>
                        <th>May</th>
                        <th>Jun (fcst)</th>
                        <th>Jun (OTL)</th>
                        <th>Jun</th>
                        <th>Jul (fcst)</th>
                        <th>Jul (OTL)</th>
                        <th>Jul</th>
                        <th>Aug (fcst)</th>
                        <th>Aug (OTL)</th>
                        <th>Aug</th>
                        <th>Sep (fcst)</th>
                        <th>Sep (OTL)</th>
                        <th>Sep</th>
                        <th>Oct (fcst)</th>
                        <th>Oct (OTL)</th>
                        <th>Oct</th>
                        <th>Nov (fcst)</th>
                        <th>Nov (OTL)</th>
                        <th>Nov</th>
                        <th>Dec (fcst)</th>
                        <th>Dec (OTL)</th>
                        <th>Dec</th>
                        <th class="last_column"></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

@stop

@section('script')
    <script>
        var activitiesTable;
        var record_id;

        // Here we are going to get from PHP the list of roles and their value for the logged in activities

        <?php
          $options = array(
              'validate_all' => true,
              'return_type' => 'both'
          );
          list($validate, $allValidations) = Entrust::ability(null,array('activities-view','activities-edit','activities-delete','activities-create'),$options);
          echo "var permissions = jQuery.parseJSON('".json_encode($allValidations['permissions'])."');";
        ?>
        // Roles check finished.

        //console.log(permissions);


        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            activitiesTable = $('#activitiesTable').DataTable({
                serverSide: true,
                processing: true,
                scrollX: true,
                ajax: {
                        url: "{!! route('listOfActivitiesPerUserAjax') !!}",
                        type: "GET",
                    },
                columns: [
                    { name: 'manager_id', data: 'manager_id' },
                    { name: 'manager_name', data: 'manager_name' },
                    { name: 'user_id', data: 'user_id' },
                    { name: 'user_name', data: 'user_name' },
                    { name: 'project_id', data: 'project_id' },
                    { name: 'project_name', data: 'project_name' },
                    { name: 'year', data: 'year' },
                    { name: 'jan_forecast', data: 'jan_forecast' },
                    { name: 'jan_otl', data: 'jan_otl' },
                    { name: 'jan_com', data: 'jan_com' },
                    { name: 'feb_forecast', data: 'feb_forecast' },
                    { name: 'feb_otl', data: 'feb_otl' },
                    { name: 'feb_com', data: 'feb_com' },
                    { name: 'mar_forecast', data: 'mar_forecast' },
                    { name: 'mar_otl', data: 'mar_otl' },
                    { name: 'mar_com', data: 'mar_com' },
                    { name: 'apr_forecast', data: 'apr_forecast' },
                    { name: 'apr_otl', data: 'apr_otl' },
                    { name: 'apr_com', data: 'apr_com' },
                    { name: 'may_forecast', data: 'may_forecast' },
                    { name: 'may_otl', data: 'may_otl' },
                    { name: 'may_com', data: 'may_com' },
                    { name: 'jun_forecast', data: 'jun_forecast' },
                    { name: 'jun_otl', data: 'jun_otl' },
                    { name: 'jun_com', data: 'jun_com' },
                    { name: 'jul_forecast', data: 'jul_forecast' },
                    { name: 'jul_otl', data: 'jul_otl' },
                    { name: 'jul_com', data: 'jul_com' },
                    { name: 'aug_forecast', data: 'aug_forecast' },
                    { name: 'aug_otl', data: 'aug_otl' },
                    { name: 'aug_com', data: 'aug_com' },
                    { name: 'sep_forecast', data: 'sep_forecast' },
                    { name: 'sep_otl', data: 'sep_otl' },
                    { name: 'sep_com', data: 'sep_com' },
                    { name: 'oct_forecast', data: 'oct_forecast' },
                    { name: 'oct_otl', data: 'oct_otl' },
                    { name: 'oct_com', data: 'oct_com' },
                    { name: 'nov_forecast', data: 'nov_forecast' },
                    { name: 'nov_otl', data: 'nov_otl' },
                    { name: 'nov_com', data: 'nov_com' },
                    { name: 'dec_forecast', data: 'dec_forecast' },
                    { name: 'dec_otl', data: 'dec_otl' },
                    { name: 'dec_com', data: 'dec_com' },
                    {
                        name: 'actions',
                        data: null,
                        sortable: false,
                        searchable: false,
                        render: function (data) {
                            var actions = '';
                            actions += '<div class="btn-group btn-group-xs">';
                            if (permissions['activities-view']){
                              actions += '<button id="'+data.id+'" class="buttonView btn btn-success"><span class="glyphicon glyphicon-eye-open"></span></button>';
                            };
                            if (permissions['activities-edit']){
                              actions += '<button id="'+data.id+'" class="buttonUpdate btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></button>';
                            };
                            actions += '</div>';
                            return actions;
                        }
                    }
                    ],
                columnDefs: [
                    {
                        "targets": [], "visible": false, "searchable": false
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
                }
            });


            $(document).on('click', '.buttonUpdate', function () {
                window.location.href = "#";
            } );

            $(document).on('click', '.buttonView', function () {
                window.location.href = "#";
            } );

        } );
    </script>
@stop
