@extends('layouts.app',['main_title' => 'Project','second_title'=>'list','url'=>[['name'=>'home','url'=>route('home')],['name'=>'list','url'=>'#']]])

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
@stop

@section('content')
    <!-- table widget -->
    <div class="box box-info">

        <div class="box-header">
            <i class="fa fa-cloud-download"></i>
            <h3 class="box-title">Unassigned projects</h3>
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
            <div class="row button_in_row">
              <div class="col-md-12">
                @permission('tools-activity-new')
                <button id="new_project" class="btn btn-info btn-xs" align="right"><span class="glyphicon glyphicon-plus"> New Project</span></button>
                @endpermission
              </div>
            </div>
            <div id="delete_message">
            </div>
            <table id="projectTable" class="display table-bordered table-hover table-responsive">
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
                        <th class="last_column"></th>
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
    </div>
@stop

@section('script')
    <script>
        var projectTable;

        function ajaxData(){
          var obj = {
            'unassigned': 'true'
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
                ajax: {
                        url: "{!! route('listOfProjectsAjax') !!}",
                        type: "POST",
                        data: ajaxData,
                        dataType: "JSON"
                    },
                columns: [
                    { name: 'id', data: 'id', searchable: false , visible: false },
                    { name: 'project_name', data: 'project_name' },
                    { name: 'customer_name', data: 'customer_name' },
                    { name: 'otl_project_code', data: 'otl_project_code', searchable: false , visible: false },
                    { name: 'project_type', data: 'project_type', searchable: false , visible: false},
                    { name: 'meta_activity', data: 'meta_activity', searchable: false , visible: false },
                    { name: 'region', data: 'region' },
                    { name: 'country', data: 'country' },
                    { name: 'domain', data: 'domain' },
                    { name: 'description', data: 'description', searchable: false , visible: false },
                    { name: 'estimated_start_date', data: 'estimated_start_date' },
                    { name: 'estimated_end_date', data: 'estimated_end_date' },
                    { name: 'comments', data: 'comments', searchable: false , visible: false },
                    { name: 'LoE_onshore', data: 'LoE_onshore', searchable: false , visible: false },
                    { name: 'LoE_nearshore', data: 'LoE_nearshore' , searchable: false , visible: false},
                    { name: 'LoE_offshore', data: 'LoE_offshore', searchable: false , visible: false },
                    { name: 'LoE_contractor', data: 'LoE_contractor', searchable: false , visible: false },
                    { name: 'gold_order_number', data: 'gold_order_number', searchable: false , visible: false },
                    { name: 'product_code', data: 'product_code', searchable: false , visible: false },
                    { name: 'revenue', data: 'revenue' },
                    { name: 'project_status', data: 'project_status', searchable: false , visible: false },
                    { name: 'win_ratio', data: 'win_ratio', searchable: false , visible: false },
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
                }
            });

            $('#new_project').on('click', function() {
              window.location.href = "{!! route('toolsFormCreate',$year) !!}";
            });

        } );
    </script>
@stop
