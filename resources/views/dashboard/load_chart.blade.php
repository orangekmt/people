@extends('layouts.app',['main_title' => 'Dashboard','second_title'=>'activities','url'=>[['name'=>'home','url'=>route('home')],['name'=>'list','url'=>'#']]])

@section('style')
<!-- CSS -->
<!-- Select2 -->
<link href="{{ asset('/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ asset('/css/chart.css') }}">
@stop

@section('scriptsrc')
<!-- JS -->
<!-- Select2 -->
<script src="{{ asset('/plugins/select2/select2.full.min.js') }}" type="text/javascript"></script>
<!-- Bootbox -->
<script src="{{ asset('/plugins/bootbox/bootbox.min.js') }}"></script>
<!-- ChartJs -->
<script src="{{ asset('/plugins/adminLTE/plugins/chartjs/Chart.bundle.min.js') }}"></script>
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
        <h3 class="box-title">Chart</h3>
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
            <div class="chart">
              <canvas id="barChart" height="400"></canvas>
            </div>
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
  var barChart;
  var year = [];
  var manager = [];
  var user = [];
  var myvar='';

  function ajaxDataPOST(){

    var obj = {
      'year[]': year,
      'manager[]': manager,
      'user[]': user
    };

    console.log(obj);
    return obj;
  };

  function ajaxdscvstotal(){
    var myarray = [
      myvar.dscvstotal[0].jan_com,
      myvar.dscvstotal[0].feb_com,
      myvar.dscvstotal[0].mar_com,
      myvar.dscvstotal[0].apr_com,
      myvar.dscvstotal[0].may_com,
      myvar.dscvstotal[0].jun_com,
      myvar.dscvstotal[0].jul_com,
      myvar.dscvstotal[0].aug_com,
      myvar.dscvstotal[0].sep_com,
      myvar.dscvstotal[0].oct_com,
      myvar.dscvstotal[0].nov_com,
      myvar.dscvstotal[0].dec_com
    ];
    return myarray;
  };
  function ajaxtheoreticalCapacity(){
    var myarray = [
      myvar.theoreticalCapacity[0].jan_com,
      myvar.theoreticalCapacity[0].feb_com,
      myvar.theoreticalCapacity[0].mar_com,
      myvar.theoreticalCapacity[0].apr_com,
      myvar.theoreticalCapacity[0].may_com,
      myvar.theoreticalCapacity[0].jun_com,
      myvar.theoreticalCapacity[0].jul_com,
      myvar.theoreticalCapacity[0].aug_com,
      myvar.theoreticalCapacity[0].sep_com,
      myvar.theoreticalCapacity[0].oct_com,
      myvar.theoreticalCapacity[0].nov_com,
      myvar.theoreticalCapacity[0].dec_com
    ];
    return myarray;
  };
  function ajaxdscpresales(){
    var myarray = [
      myvar.dscpresales[0].jan_com,
      myvar.dscpresales[0].feb_com,
      myvar.dscpresales[0].mar_com,
      myvar.dscpresales[0].apr_com,
      myvar.dscpresales[0].may_com,
      myvar.dscpresales[0].jun_com,
      myvar.dscpresales[0].jul_com,
      myvar.dscpresales[0].aug_com,
      myvar.dscpresales[0].sep_com,
      myvar.dscpresales[0].oct_com,
      myvar.dscpresales[0].nov_com,
      myvar.dscpresales[0].dec_com
    ];
    return myarray;
  };
  function ajaxiscpresales(){
    var myarray = [
      myvar.iscpresales[0].jan_com,
      myvar.iscpresales[0].feb_com,
      myvar.iscpresales[0].mar_com,
      myvar.iscpresales[0].apr_com,
      myvar.iscpresales[0].may_com,
      myvar.iscpresales[0].jun_com,
      myvar.iscpresales[0].jul_com,
      myvar.iscpresales[0].aug_com,
      myvar.iscpresales[0].sep_com,
      myvar.iscpresales[0].oct_com,
      myvar.iscpresales[0].nov_com,
      myvar.iscpresales[0].dec_com
    ];
    return myarray;
  };
  function ajaxdscstarted(){
    var myarray = [
      myvar.dscstarted[0].jan_com,
      myvar.dscstarted[0].feb_com,
      myvar.dscstarted[0].mar_com,
      myvar.dscstarted[0].apr_com,
      myvar.dscstarted[0].may_com,
      myvar.dscstarted[0].jun_com,
      myvar.dscstarted[0].jul_com,
      myvar.dscstarted[0].aug_com,
      myvar.dscstarted[0].sep_com,
      myvar.dscstarted[0].oct_com,
      myvar.dscstarted[0].nov_com,
      myvar.dscstarted[0].dec_com
    ];
    return myarray;
  };
  function ajaxiscstarted(){
    var myarray = [
      myvar.iscstarted[0].jan_com,
      myvar.iscstarted[0].feb_com,
      myvar.iscstarted[0].mar_com,
      myvar.iscstarted[0].apr_com,
      myvar.iscstarted[0].may_com,
      myvar.iscstarted[0].jun_com,
      myvar.iscstarted[0].jul_com,
      myvar.iscstarted[0].aug_com,
      myvar.iscstarted[0].sep_com,
      myvar.iscstarted[0].oct_com,
      myvar.iscstarted[0].nov_com,
      myvar.iscstarted[0].dec_com
    ];
    return myarray;
  };

  window.chartColors = {
   red: 'rgb(255, 99, 132)',
   orange: 'rgb(255, 159, 64)',
   yellow: 'rgb(255, 205, 86)',
   green: 'rgb(0, 204, 102)',
   green_light: 'rgb(26, 255, 140)',
   blue: 'rgb(0, 51, 255)',
   blue_light: 'rgb(77, 112, 235)',
   purple: 'rgb(153, 102, 255)',
   grey: 'rgb(201, 203, 207)'
  };

  // Here we are going to get from PHP the list of roles and their value for the logged in activities

  var permissions = jQuery.parseJSON('{!! $perms !!}');

  // Roles check finished.

  //console.log(permissions);

  $(document).ready(function() {

    //Init select2 boxes
    $("#year").select2({
      allowClear: false
    });
    //Init select2 boxes
    $("#manager").select2({
      allowClear: false,
      disabled: {{ $manager_select_disabled }}
    });
    $("#user").select2({
      allowClear: false,
      disabled: {{ $user_select_disabled }}
    });

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

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });



    function useReturnData(data){
        myvar = data;
        //console.log(myvar);
    };

    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

     var MONTHS = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
     var color = Chart.helpers.color;


     var barChartData = {
         labels: MONTHS,
         datasets: [
          {
            type: 'line',
             label: 'DSC vs Total capacity',
             yAxisID: "y-axis-2",
             borderColor: window.chartColors.orange,
             borderWidth: 3,
             fill: false,
             data: [
                    ]
          },
          {
          type: 'line',
           label: 'Theoretical capacity',
           yAxisID: "y-axis-1",
           stack: 'Stack 2',
           borderColor: window.chartColors.red,
           borderWidth: 3,
           fill: false,
           pointRadius: 0,
           data: [
                    ]
         },
          {
          type: 'bar',
           label: 'DSC Pre-Sales',
           yAxisID: "y-axis-1",
           stack: 'Stack 1',
           backgroundColor: color(window.chartColors.green).alpha(0.5).rgbString(),
           borderColor: window.chartColors.green,
           borderWidth: 1,
           data: [
           ]
          },
          {
          type: 'bar',
           label: 'ISC Pre-Sales',
           yAxisID: "y-axis-1",
           stack: 'Stack 1',
           backgroundColor: color(window.chartColors.green_light).alpha(0.5).rgbString(),
           borderColor: window.chartColors.green_light,
           borderWidth: 1,
           data: [
           ]
          },
          {
          type: 'bar',
           label: 'DSC Started',
           yAxisID: "y-axis-1",
           stack: 'Stack 1',
           backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
           borderColor: window.chartColors.blue,
           borderWidth: 1,
           data: [
           ]
          },
          {
          type: 'bar',
           label: 'ISC Started',
           yAxisID: "y-axis-1",
           stack: 'Stack 1',
           backgroundColor: color(window.chartColors.blue_light).alpha(0.5).rgbString(),
           borderColor: window.chartColors.blue_light,
           borderWidth: 1,
           data: [
         ]
          }
        ]

     };

     //-------------
     //- BAR CHART -
     //-------------
     var barChartCanvas = $("#barChart").get(0).getContext("2d");
     var barChartOptions = {
        responsive: true,
        legend: {
            position: 'top',
        },
        tooltips: {
            mode: 'index',
            intersect: false,
          },
        title: {
            display: true,
            text: 'LoE Forecast vs Capacity'
        },
        scales: {
                    xAxes: [{
                            stacked: true,
                        }],
                    yAxes: [{
                        type: "linear", // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                        display: true,
                        position: "left",
                        id: "y-axis-1",
                        scaleLabel: {
                          display: true,
                          labelString: '# Mandays'
                        },
                        stacked: true

                        }, {
                        type: "linear", // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                        display: true,
                        position: "right",
                        id: "y-axis-2",
                        scaleLabel: {
                          display: true,
                          labelString: '%'
                        },
                        gridLines: {
                            drawOnChartArea: false
                        },
                        stacked: false
                    }],
                }
      };
     barChart = new Chart(barChartCanvas, {
                type: 'bar',
                data: barChartData,
                options: barChartOptions
            });


    $.ajax({
        url:"{!! route('listOfLoadPerUserChartAjax') !!}",
        type:'POST',
        data: ajaxDataPOST(),
        dataType:"JSON",
        success: function(data) {
          useReturnData(data);
          barChart.data.datasets[0].data = ajaxdscvstotal();
          barChart.data.datasets[1].data = ajaxtheoreticalCapacity();
          barChart.data.datasets[2].data = ajaxdscpresales();
          barChart.data.datasets[3].data = ajaxiscpresales();
          barChart.data.datasets[4].data = ajaxdscstarted();
          barChart.data.datasets[5].data = ajaxiscstarted();
          barChart.update();
        }
      });

    $('#year').on('change', function() {
      year = [];
      $("#year option:selected").each(function()
      {
        // log the value and text of each option
        year.push($(this).val());

      });

      $.ajax({
          url:"{!! route('listOfLoadPerUserChartAjax') !!}",
          type:'POST',
          data: ajaxDataPOST(),
          dataType:"JSON",
          success: function(data) {
            useReturnData(data);
            barChart.data.datasets[0].data = ajaxdscvstotal();
            barChart.data.datasets[1].data = ajaxtheoreticalCapacity();
            barChart.data.datasets[2].data = ajaxdscpresales();
            barChart.data.datasets[3].data = ajaxiscpresales();
            barChart.data.datasets[4].data = ajaxdscstarted();
            barChart.data.datasets[5].data = ajaxiscstarted();
            barChart.update();
          }
        });
      //activitiesTable.ajax.reload();
    });

    $('#manager').on('change', function() {
      manager = [];
      $("#manager option:selected").each(function()
      {
        // log the value and text of each option
        manager.push($(this).val());

      });
      $.ajax({
          url:"{!! route('listOfLoadPerUserChartAjax') !!}",
          type:'POST',
          data: ajaxDataPOST(),
          dataType:"JSON",
          success: function(data) {
            useReturnData(data);
            barChart.data.datasets[0].data = ajaxdscvstotal();
            barChart.data.datasets[1].data = ajaxtheoreticalCapacity();
            barChart.data.datasets[2].data = ajaxdscpresales();
            barChart.data.datasets[3].data = ajaxiscpresales();
            barChart.data.datasets[4].data = ajaxdscstarted();
            barChart.data.datasets[5].data = ajaxiscstarted();
            barChart.update();
          }
        });
      //activitiesTable.ajax.reload();
    });

    $('#user').on('change', function() {
      manager = [];
      $("#user option:selected").each(function()
      {
        // log the value and text of each option
        user.push($(this).val());

      });
      $.ajax({
          url:"{!! route('listOfLoadPerUserChartAjax') !!}",
          type:'POST',
          data: ajaxDataPOST(),
          dataType:"JSON",
          success: function(data) {
            useReturnData(data);
            barChart.data.datasets[0].data = ajaxdscvstotal();
            barChart.data.datasets[1].data = ajaxtheoreticalCapacity();
            barChart.data.datasets[2].data = ajaxdscpresales();
            barChart.data.datasets[3].data = ajaxiscpresales();
            barChart.data.datasets[4].data = ajaxdscstarted();
            barChart.data.datasets[5].data = ajaxiscstarted();
            barChart.update();
          }
        });
      //activitiesTable.ajax.reload();
    });

  } );
  </script>
  @stop
