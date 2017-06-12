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
  var myvar='';;
  var myAjax;

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

  function ajaxDataPOST(){
    var obj = {
      'year[]': year,
      'manager[]': manager
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

    myAjax = $.ajax({
        url:"{!! route('listOfLoadPerUserChartAjax') !!}",
        type:'POST',
        data: ajaxDataPOST,
        dataType:"JSON",
        success: function(data) {
          useReturnData(data);
        }
      });

    function useReturnData(data){
        myvar = data;
        console.log(myvar);
    };

    //Init select2 boxes
    $("#year").select2({
      allowClear: false
    });
    //Init select2 boxes
    $("#manager").select2({
      allowClear: false,
      disabled: {{ $manager_select_disabled }}
    });

    $('#year').on('change', function() {
      year = [];
      $("#year option:selected").each(function()
      {
        // log the value and text of each option
        year.push($(this).val());

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
      //activitiesTable.ajax.reload();
    });

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
             data: [10, 50, 75, 22, 24, 35, 67,54, 12, 8, 45, 64, 4, 78]
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
           data: [300, 300, 300, 300, 300, 300, 300,300, 300, 300, 300, 300, 300, 300]
         },
          {
          type: 'bar',
           label: 'DSC Pre-Sales',
           yAxisID: "y-axis-1",
           stack: 'Stack 1',
           backgroundColor: color(window.chartColors.green).alpha(0.5).rgbString(),
           borderColor: window.chartColors.green,
           borderWidth: 1,
           data: [28, 48, 40, 19, 86, 27, 90,65, 59, 80, 81, 56, 55, 40]
          },
          {
          type: 'bar',
           label: 'ISC Pre-Sales',
           yAxisID: "y-axis-1",
           stack: 'Stack 1',
           backgroundColor: color(window.chartColors.green_light).alpha(0.5).rgbString(),
           borderColor: window.chartColors.green_light,
           borderWidth: 1,
           data: [65, 59, 80, 81, 56, 55, 40,28, 48, 40, 19, 86, 27, 90]
          },
          {
          type: 'bar',
           label: 'DSC Started',
           yAxisID: "y-axis-1",
           stack: 'Stack 1',
           backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
           borderColor: window.chartColors.blue,
           borderWidth: 1,
           data: [10, 50, 100, 142, 175, 25, 40,42, 53, 75, 142, 256, 248, 40]
          },
          {
          type: 'bar',
           label: 'ISC Started',
           yAxisID: "y-axis-1",
           stack: 'Stack 1',
           backgroundColor: color(window.chartColors.blue_light).alpha(0.5).rgbString(),
           borderColor: window.chartColors.blue_light,
           borderWidth: 1,
           data: [14, 45, 85, 147, 54, 73, 24,54, 28, 72, 42, 89, 124, 40]
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

  } );
  </script>
  @stop
