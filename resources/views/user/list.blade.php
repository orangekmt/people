@extends('layouts.app',['main_title' => 'User','second_title'=>'list','url'=>[['name'=>'home','url'=>route('home')],['name'=>'list','url'=>'#']]])

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
            <h3 class="box-title">User List</h3>
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
            <table id="userTable" class="display table-bordered table-hover table-responsive">
                <thead>
                    <tr>
                        <th class="first_column"></th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Manager name</th>
                        <th>Email</th>
                        <th>Is Manager</th>
                        <th>Region</th>
                        <th>Country</th>
                        <th>Domain</th>
                        <th>Management Code</th>
                        <th>Job role</th>
                        <th>Type</th>
                        <th>From OTL</th>
                        <th class="last_column">
                          @permission('user-create')
                            <a href="{{ route('userFormCreate') }}" class="btn btn-info btn-xs" align="right"><span class="glyphicon glyphicon-plus"> New</span></a>
                          @endpermission
                        </th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th class="first_column"></th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Manager name</th>
                        <th>Email</th>
                        <th>Is Manager</th>
                        <th>Region</th>
                        <th>Country</th>
                        <th>Domain</th>
                        <th>Management Code</th>
                        <th>Job role</th>
                        <th>Type</th>
                        <th>From OTL</th>
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
                    <td><b>Name</b>:</td>
                    <td>@{{ name }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>Manager name</b>:</td>
                    <td>@{{ manager_name }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>Email</b>:</td>
                    <td>@{{ email }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>Management code</b>:</td>
                    <td>@{{ management_code }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>Domain</b>:</td>
                    <td>@{{ domain }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>Region</b>:</td>
                    <td>@{{ region }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>Job role</b>:</td>
                    <td>@{{ job_role }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>User type</b>:</td>
                    <td>@{{ employee_type }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>Is a Manager</b>:</td>
                    <td>@{{ is_manager }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>From OTL</b>:</td>
                    <td>@{{ from_otl }}</td>
                </tr>
            </table>
            </script>
        </div>
    </div>

@stop

@section('script')
    <script>
        var userTable;
        var record_id;

        // Here we are going to get from PHP the list of roles and their value for the logged in user

        <?php
          $options = array(
              'validate_all' => true,
              'return_type' => 'both'
          );
          list($validate, $allValidations) = Entrust::ability(null,array('user-view','user-edit','user-delete','user-create'),$options);
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

            userTable = $('#userTable').DataTable({
                serverSide: true,
                processing: true,
                scrollX: true,
                ajax: {
                        url: "{!! route('listOfUsersAjax') !!}",
                        type: "GET",
                        dataSrc: function ( json ) {
                          //console.log(json);;
                            for ( var i=0, ien=json.data.length ; i<ien ; i++ ) {
                                if (json.data[i].is_manager == 1){
                                    json.data[i].is_manager = 'Yes';
                                }
                                else {
                                    json.data[i].is_manager = 'No';
                                }
                            }
                            return json.data;
                        }
                    },
                columns: [
                    {
                        className:      'details-control',
                        orderable:      false,
                        searchable:     false,
                        data:           null,
                        defaultContent: ''
                    },
                    { name: 'users.id', data: 'id' },
                    { name: 'users.name', data: 'name' },
                    { name: 'u2.name', data: 'manager_name' },
                    { name: 'users.email', data: 'email' },
                    { name: 'users.is_manager', data: 'is_manager'},
                    { name: 'users.region', data: 'region' },
                    { name: 'users.country', data: 'country' },
                    { name: 'users.domain', data: 'domain' },
                    { name: 'users.management_code', data: 'management_code' },
                    { name: 'users.job_role', data: 'job_role' },
                    { name: 'users.employee_type', data: 'employee_type' },
                    { name: 'users.from_otl', data: 'from_otl' },
                    {
                        name: 'actions',
                        data: null,
                        sortable: false,
                        searchable: false,
                        render: function (data) {
                            var actions = '';
                            actions += '<div class="btn-group btn-group-xs">';
                            if (permissions['user-view']){
                              actions += '<button id="'+data.id+'" class="buttonView btn btn-success"><span class="glyphicon glyphicon-eye-open"></span></button>';
                            };
                            if (permissions['user-edit']){
                              actions += '<button id="'+data.id+'" class="buttonUpdate btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></button>';
                            };
                            if (permissions['user-delete']){
                              actions += '<button id="'+data.id+'" class="buttonDelete btn btn-danger"><span class="glyphicon glyphicon-trash"></span></button>';
                            };
                            actions += '</div>';
                            return actions;
                        }
                    }
                    ],
                columnDefs: [
                    {
                        "targets": [1,4,5], "visible": false, "searchable": false
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
            $('#userTable tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = userTable.row( tr );

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
                window.location.href = "{!! route('userFormUpdate','') !!}/"+this.id;
            } );

            $(document).on('click', '.buttonView', function () {
                window.location.href = "{!! route('user','') !!}/"+this.id;
            } );

            $(document).on('click', '.buttonDelete', function () {
                record_id = this.id;
                bootbox.confirm("Are you sure want to delete this record?", function(result) {
                    if (result){
                        $.ajax({
                            type: 'get',
                            url: "{!! route('userDelete','') !!}/"+record_id,
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
                                userTable.ajax.reload();
                            }
                        });
                    }
                });
            } );

        } );
    </script>
@stop
