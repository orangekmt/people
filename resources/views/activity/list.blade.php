@extends('layouts.app',['main_title' => 'Activity','second_title'=>'list','url'=>[['name'=>'home','url'=>route('home')],['name'=>'list','url'=>'#']]])

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
    <script src="{{ asset('/plugins/datatables/handlebars.js') }}"></script>
    <!-- Bootbox -->
    <script src="{{ asset('/plugins/bootbox/bootbox.min.js') }}"></script>
@stop

@section('content')
    <!-- table widget -->
    <div class="box box-info">

        <div class="box-header">
            <i class="fa fa-cloud-download"></i>
            <h3 class="box-title">Activity List</h3>
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
            <div id="delete_message">
            </div>
            <table id="activityTable" class="display table-bordered table-hover table-responsive">
                <thead>
                    <tr>
                        <th class="first_column"></th>
                        <th>ID</th>
                        <th>Activity name</th>
                        <th>Customer name</th>
                        <th>OTL activity code</th>
                        <th>Activity type</th>
                        <th>Task name</th>
                        <th>Task category</th>
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
                        <th>Activity status</th>
                        <th>Win ratio (%)</th>
                        <th class="last_column">
                          @permission('activity-create')
                            <a href="{{ route('activityFormCreate') }}" class="btn btn-info btn-xs" align="right"><span class="glyphicon glyphicon-plus"> New</span></a>
                          @endpermission
                        </th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th class="first_column"></th>
                        <th>ID</th>
                        <th>Activity name</th>
                        <th>Customer name</th>
                        <th>OTL activity code</th>
                        <th>Activity type</th>
                        <th>Task name</th>
                        <th>Task category</th>
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
                        <th>Activity status</th>
                        <th>Win ratio (%)</th>
                        <th class="last_column"></th>
                    </tr>
                </tfoot>
            </table>
            <script id="details-template" type="text/x-handlebars-template">
            <table class="extra_info table-bordered">
                <thead>
                    <th width="20px"></th>
                    <th width="100px"></th>
                    <th></th>
                </thead>

                </tr>
                <tr>
                    <td></td>
                    <td><b>Activity name</b>:</td>
                    <td>@{{ activity_name }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>Customer name</b>:</td>
                    <td>@{{ customer_name }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>OTL activity code</b>:</td>
                    <td>@{{ otl_activity_code }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>Activity type</b>:</td>
                    <td>@{{ activity_type }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>Task name</b>:</td>
                    <td>@{{ task_name }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>Task category</b>:</td>
                    <td>@{{ task_category }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>Meta-activity</b>:</td>
                    <td>@{{ meta_activity }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>Activity type</b>:</td>
                    <td>@{{ employee_type }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>Region</b>:</td>
                    <td>@{{ region }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>Country</b>:</td>
                    <td>@{{ country }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>Domain</b>:</td>
                    <td>@{{ domain }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>Description</b>:</td>
                    <td>@{{ description }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>Comments</b>:</td>
                    <td>@{{ comments }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>Estimated start date</b>:</td>
                    <td>@{{ estimated_start_date }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>Estimated end date</b>:</td>
                    <td>@{{ estimated_end_date }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>LoE onshore</b>:</td>
                    <td>@{{ LoE_onshore }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>LoE nearshore</b>:</td>
                    <td>@{{ LoE_nearshore }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>LoE offshore</b>:</td>
                    <td>@{{ LoE_offshore }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>LoE contractor</b>:</td>
                    <td>@{{ LoE_contractor }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>Gold order</b>:</td>
                    <td>@{{ gold_order_number }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>FPC</b>:</td>
                    <td>@{{ product_code }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>Revenue (€)</b>:</td>
                    <td>@{{ revenue }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>Activity status</b>:</td>
                    <td>@{{ activity_status }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>Win ratio (€)</b>:</td>
                    <td>@{{ win_ratio }}</td>
                </tr>
            </table>
            </script>
        </div>
    </div>

@stop

@section('script')
    <script>
        var activityTable;
        var record_id;

        // Here we are going to get from PHP the list of roles and their value for the logged in activity

        <?php
          $options = array(
              'validate_all' => true,
              'return_type' => 'both'
          );
          list($validate, $allValidations) = Entrust::ability(null,array('activity-view','activity-edit','activity-delete','activity-create'),$options);
          echo "var permissions = jQuery.parseJSON('".json_encode($allValidations['permissions'])."');";
        ?>
        // Roles check finished.

        //console.log(permissions);


        $(document).ready(function() {
            var template = Handlebars.compile($("#details-template").html());

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            activityTable = $('#activityTable').DataTable({
                serverSide: true,
                processing: true,
                scrollX: true,
                ajax: {
                        url: "{!! route('listOfActivitiesAjax') !!}",
                        type: "GET",
                    },
                columns: [
                    {
                        className:      'details-control',
                        orderable:      false,
                        searchable:     false,
                        data:           null,
                        defaultContent: ''
                    },
                    { name: 'id', data: 'id' },
                    { name: 'activity_name', data: 'activity_name' },
                    { name: 'customer_name', data: 'customer_name' },
                    { name: 'otl_activity_code', data: 'otl_activity_code' },
                    { name: 'activity_type', data: 'activity_type'},
                    { name: 'task_name', data: 'task_name' },
                    { name: 'task_category', data: 'task_category' },
                    { name: 'meta_activity', data: 'meta_activity' },
                    { name: 'region', data: 'region' },
                    { name: 'country', data: 'country' },
                    { name: 'domain', data: 'domain' },
                    { name: 'description', data: 'description' },
                    { name: 'estimated_start_date', data: 'estimated_start_date' },
                    { name: 'estimated_end_date', data: 'estimated_end_date' },
                    { name: 'comments', data: 'comments' },
                    { name: 'LoE_onshore', data: 'LoE_onshore' },
                    { name: 'LoE_nearshore', data: 'LoE_nearshore' },
                    { name: 'LoE_offshore', data: 'LoE_offshore' },
                    { name: 'LoE_contractor', data: 'LoE_contractor' },
                    { name: 'gold_order_number', data: 'gold_order_number' },
                    { name: 'product_code', data: 'product_code' },
                    { name: 'revenue', data: 'revenue' },
                    { name: 'activity_status', data: 'activity_status' },
                    { name: 'win_ratio', data: 'win_ratio' },
                    {
                        name: 'actions',
                        data: null,
                        sortable: false,
                        searchable: false,
                        render: function (data) {
                            var actions = '';
                            actions += '<div class="btn-group btn-group-xs">';
                            if (permissions['activity-view']){
                              actions += '<button id="'+data.id+'" class="buttonView btn btn-success"><span class="glyphicon glyphicon-eye-open"></span></button>';
                            };
                            if (permissions['activity-edit']){
                              actions += '<button id="'+data.id+'" class="buttonUpdate btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></button>';
                            };
                            if (permissions['activity-delete']){
                              actions += '<button id="'+data.id+'" class="buttonDelete btn btn-danger"><span class="glyphicon glyphicon-trash"></span></button>';
                            };
                            actions += '</div>';
                            return actions;
                        }
                    }
                    ],
                columnDefs: [
                    {
                        "targets": [1,4,5,6,7,8,12,13,14,15,16,17,18,19,20], "visible": false, "searchable": false
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

            // Add event listener for opening and closing details
            $('#activityTable tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = activityTable.row( tr );

                if ( row.child.isShown() ) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    // Open this row
                    row.child( template(row.data()) ).show();
                    tr.addClass('shown');
                }
            });

            $(document).on('click', '.buttonUpdate', function () {
                window.location.href = "{!! route('activityFormUpdate','') !!}/"+this.id;
            } );

            $(document).on('click', '.buttonView', function () {
                window.location.href = "{!! route('activity','') !!}/"+this.id;
            } );

            $(document).on('click', '.buttonDelete', function () {
                record_id = this.id;
                bootbox.confirm("Are you sure want to delete this record?", function(result) {
                    if (result){
                        $.ajax({
                            type: 'get',
                            url: "{!! route('activityDelete','') !!}/"+record_id,
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
                                activityTable.ajax.reload();
                            }
                        });
                    }
                });
            } );

        } );
    </script>
@stop
