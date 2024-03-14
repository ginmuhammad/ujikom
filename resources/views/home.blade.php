@extends('layouts.admin')

@section('content-header', __('dashboard.title'))

@section('content')
    <div class="container-fluid">
        <div class="row">
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                  <h4>{{$orders_count}}</h3>
                <p>{{ __('dashboard.Orders_Count') }}</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="{{route('orders.index')}}" class="small-box-footer">{{ __('common.More_info') }} <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                  <h3><p> Rp.{{config('settings.currency_symbol')}} {{number_format($income, 0, ',', '.')}}</p></h3>
                <p>{{ __('dashboard.Income') }}</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="{{route('orders.index')}}" class="small-box-footer">{{ __('common.More_info') }} <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><p> Rp.{{config('settings.currency_symbol')}} {{number_format($income_today, 0, ',', '.')}}</p></h3>

                <p>{{ __('dashboard.Income_Today') }}</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="{{route('orders.index')}}" class="small-box-footer">{{ __('common.More_info') }} <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>
        <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <figure class="highcharts-figure">
        <div id="container"></div>
      </figure>
    </div>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script>

  
    // console.log('{{ $bulanan }}');
    // console.log('{{ $pendapatan }}');
    var bulan = JSON.parse({!! json_encode($bulanan) !!});
    var pendapatan = JSON.parse({!! json_encode($pendapatan) !!});

    console.log(bulan);
    console.log(pendapatan);

    console.log('su');
    console.log(bulan);
    console.log(pendapatan);

    Highcharts.chart('container', {
        title: {
            text: null,
            align: 'left'
        },
        yAxis: {
            title: {
                text: null
            }
        },
        xAxis: {
            accessibility: {
                rangeDescription: 'Month'
            },
            categories: bulan
        },
        legend: {
            
            layout: 'horizontal',
            align: 'center',
            verticalAlign: 'bottom'
        },
        plotOptions: {
            series: {
                label: {
                    connectorAllowed: false
                }, 
                pointStart: 0
            }
        },
        series: [{
            name: 'Pendapatan',
            data: pendapatan
        }],
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 300
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }
    });
    </script>
    @endsection
