{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')


    {{-- Dashboard 1 --}}

    <div class="row">
        {{--<div class="col-lg-6 col-xxl-6">
            @include('pages.widgets._widget-1', ['class' => 'card-stretch gutter-b', 'dashboard_data' => $dashboard_data])
        </div> --}}
        <div class="col-lg-12 col-xxl-12">
            @include('pages.widgets._widget-3', ['class' => 'card-stretch card-stretch-half gutter-b', 'dashboard_data' => $dashboard_data])
            @include('pages.widgets._widget-4', ['class' => 'card-stretch card-stretch-half gutter-b', 'dashboard_data' => $dashboard_data])
        </div>
        <div class="col-xxl-12 order-2 order-xxl-1">
            <div class="row">
                <div class="col-lg-4 col-xxl-4">
                    <!--begin::Card-->
                    <div class="card card-custom card-stretch gutter-b">
                        <div class="card-header border-0 py-5">
                            <div class="card-title align-items-start flex-column">
                                <h3 class="card-label">Members By Ethnicity</h3>
                            </div>
                            <div class="card-toolbar">
                                <a href="{{ route('admin.user.list') }}" class="btn btn-info font-weight-bolder font-size-sm mr-3">List Members</a>
                            </div>
                        </div>
                        <div class="card-body" >
                            <!--begin::Chart-->
                            <div id="chart_13" class="d-flex justify-content-center"></div>
                            <!--end::Chart-->
                        </div>
                    </div>
                    <!--end::Card-->
                </div>
                <div class="col-lg-8 col-xxl-8">
                    @include('pages.widgets._widget-6', ['class' => 'card-stretch gutter-b', 'dashboard_data' => $dashboard_data])
                </div>
            </div>
        </div>
        
        <div class="col-xxl-12 order-2 order-xxl-1">
            <div class="row">
                <div class="col-lg-4 col-xxl-4">
                    <!--begin::Card-->
                    <div class="card card-custom card-stretch gutter-b">
                        <div class="card-header border-0 py-5">
                            <div class="card-title align-items-start flex-column">
                                <h3 class="card-label">Voters By Ethnicity</h3>
                            </div>
                            <div class="card-toolbar">
                                <a href="{{ route('voter.index') }}" class="btn btn-info font-weight-bolder font-size-sm mr-3">List Voters</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="voter_chart_ethnic" class="d-flex justify-content-center"></div>
                        </div>
                    </div>
                    <!--end::Card-->
                </div>
                <div class="col-lg-8 col-xxl-8">
                    @include('pages.widgets._widget-10', ['class' => 'card-stretch gutter-b', 'dashboard_data' => $dashboard_data])
                </div>
            </div>
        </div>
    </div>

@endsection

{{-- Scripts Section --}}
@section('scripts')
    <script src="{{ asset('js/pages/widgets.js') }}" type="text/javascript"></script>
    
    <script src="//www.google.com/jsapi"></script>
    <script>
        $(function() {
            _initMixedWidgetBrij();
            _initStatsWidgetUserBrij();
            _initStatsWidgetVoterBrij();
            _demo14();
            _demo13();
            //main();
        });
        
        // Shared Colors Definition
        const primary = '#6993FF';
        const success = '#1BC5BD';
        const info = '#8950FC';
        const warning = '#FFA800';
        const danger = '#F64E60';
        var _demo12 = function () {
            const apexChart = "#member_chart_ethnic";
            var options = {
                series: [44, 55, 13, 43, 22, 23, 21, 26, 15, 0, 1],
                chart: {
                    width: 380,
                    type: 'pie',
                },
                labels: ['Team A', 'Team B', 'Team C', 'Team D', 'Team E', 'Team A1', 'Team B1', 'Team C1', 'Team D1', 'Team E1', 'Team D1'],
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }],
                colors: [primary, success, warning, danger, info, '#fe3995', '#f6aa33', '#6e4ff5', '#2abe81', '#c7d2e7', '#593ae1']
            };

            var chart = new ApexCharts(document.querySelector(apexChart), options);
            chart.render();
        }
        var _demo14 = function () {
            const apexChart = "#chart_13";
            var options = {
                series: [44, 55, 13, 43, 22, 23, 21, 26, 15, 0, 1],
                chart: {
                    height: 350,
                    type: 'radialBar',
                },
                plotOptions: {
                    radialBar: {
                        dataLabels: {
                            name: {
                                fontSize: '22px',
                            },
                            value: {
                                fontSize: '16px',
                            },
                            total: {
                                show: true,
                                label: 'Total',
                                formatter: function (w) {
                                    // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
                                    return 249
                                }
                            }
                        }
                    }
                },
                labels: ['Apples', 'Oranges', 'Bananas', 'Berries', 'Apples1', 'Oranges1', 'Bananas1', 'Berries1', 'Apples2', 'Oranges2', 'Bananas2'],
                colors: [primary, success, warning, danger, info, '#fe3995', '#f6aa33', '#6e4ff5', '#2abe81', '#c7d2e7', '#593ae1']
            };

            var chart = new ApexCharts(document.querySelector(apexChart), options);
            chart.render();
        }
        
        var _demo13 = function () {
            const apexChart = "#voter_chart_ethnic";
            var options = {
                series: [44, 55, 13, 43, 22],
                chart: {
                    width: 380,
                    type: 'pie',
                },
                labels: ['Team A', 'Team B', 'Team C', 'Team D', 'Team E'],
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }],
                colors: [primary, success, warning, danger, info]
            };

            var chart = new ApexCharts(document.querySelector(apexChart), options);
            chart.render();
        }
        /*var main = function() {
            // GOOGLE CHARTS INIT
            google.load('visualization', '1', {
                packages: ['corechart', 'bar', 'line']
            });

            google.setOnLoadCallback(function() {
                demoPieCharts();
            });
        }*/

        var demoPieCharts = function() {
            var data = google.visualization.arrayToDataTable([
                ['Title', 'Values'],
                ['TBK', 8],
                ['Fluor Corp', 12],
                ['Fluor Group', 41],
                ['Bechtel', 39],
                ['Bechtel1', 615],
            ]);

            var options = {
                title: 'My Daily Activities',
                colors: ['#fe3995', '#f6aa33', '#6e4ff5', '#2abe81', '#c7d2e7', '#593ae1']
            };

            var chart = new google.visualization.PieChart(document.getElementById('kt_gchart_3'));
            chart.draw(data, options);

            var options = {
                pieHole: 0.4,
                colors: ['#fe3995', '#f6aa33', '#6e4ff5', '#2abe81', '#c7d2e7', '#593ae1']
            };

            var chart = new google.visualization.PieChart(document.getElementById('kt_gchart_4'));
            chart.draw(data, options);
        }
        var _initStatsWidgetUserBrij = function () {
            var element = document.getElementById("brij_membercount");

            var height = parseInt(KTUtil.css(element, 'height'));
            if (!element) {
                return;
            }

            var options = {
                series: [{
                    name: '',
                    data: '{!! $dashboard_data["member_chart_count"] !!}'.split(',')
                }],
                chart: {
                    type: 'area',
                    height: height,
                    toolbar: {
                        show: false
                    },
                    zoom: {
                        enabled: false
                    },
                    sparkline: {
                        enabled: true
                    }
                },
                plotOptions: {},
                legend: {
                    show: false
                },
                dataLabels: {
                    enabled: false
                },
                fill: {
                    type: 'solid',
                    opacity: 1
                },
                stroke: {
                    curve: 'smooth',
                    show: true,
                    width: 4,
                    colors: ['#CCBD5AE3']
                },
                xaxis: {
                    categories: '{!! $dashboard_data["member_chart_year"] !!},'.split(','),
                    axisBorder: {
                        show: false,
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        show: false,
                        style: {
                            colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                            fontSize: '12px',
                            fontFamily: KTApp.getSettings()['font-family']
                        }
                    },
                    crosshairs: {
                        show: false,
                        position: 'front',
                        stroke: {
                            color: KTApp.getSettings()['colors']['gray']['gray-300'],
                            width: 1,
                            dashArray: 3
                        }
                    },
                    tooltip: {
                        enabled: true,
                        formatter: undefined,
                        offsetY: 0,
                        style: {
                            fontSize: '12px',
                            fontFamily: KTApp.getSettings()['font-family']
                        }
                    }
                },
                yaxis: {
                    labels: {
                        show: false,
                        style: {
                            colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                            fontSize: '12px',
                            fontFamily: KTApp.getSettings()['font-family']
                        }
                    }
                },
                states: {
                    normal: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    hover: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    active: {
                        allowMultipleDataPointsSelection: false,
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    }
                },
                tooltip: {
                    style: {
                        fontSize: '12px',
                        fontFamily: KTApp.getSettings()['font-family']
                    },
                    y: {
                        formatter: function (val) {
                            return val + " Members Join"
                        }
                    }
                },
                colors: [KTApp.getSettings()['colors']['theme']['light']['primary']],
                markers: {
                    colors: [KTApp.getSettings()['colors']['theme']['light']['primary']],
                    strokeColor: [KTApp.getSettings()['colors']['theme']['base']['primary']],
                    strokeWidth: 3
                }
            };

            var chart = new ApexCharts(element, options);
            chart.render();
        }

        var _initStatsWidgetVoterBrij = function () {
            var element = document.getElementById("brij_votercount");

            if (!element) {
                return;
            }

            var options = {
                series: [{
                    name: '',
                    data: '{!! $dashboard_data["voter_chart_count"] !!}'.split(',')
                }],
                chart: {
                    type: 'area',
                    height: 150,
                    toolbar: {
                        show: false
                    },
                    zoom: {
                        enabled: false
                    },
                    sparkline: {
                        enabled: true
                    }
                },
                plotOptions: {},
                legend: {
                    show: false
                },
                dataLabels: {
                    enabled: false
                },
                fill: {
                    type: 'solid',
                    opacity: 1
                },
                stroke: {
                    curve: 'smooth',
                    show: true,
                    width: 3,
                    colors: [KTApp.getSettings()['colors']['theme']['base']['success']]
                },
                xaxis: {
                    categories: '{!! $dashboard_data["voter_chart_year"] !!},'.split(','),
                    axisBorder: {
                        show: false,
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        show: false,
                        style: {
                            colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                            fontSize: '12px',
                            fontFamily: KTApp.getSettings()['font-family']
                        }
                    },
                    crosshairs: {
                        show: false,
                        position: 'front',
                        stroke: {
                            color: KTApp.getSettings()['colors']['gray']['gray-300'],
                            width: 1,
                            dashArray: 3
                        }
                    },
                    tooltip: {
                        enabled: true,
                        formatter: undefined,
                        offsetY: 0,
                        style: {
                            fontSize: '12px',
                            fontFamily: KTApp.getSettings()['font-family']
                        }
                    }
                },
                yaxis: {
                    labels: {
                        show: false,
                        style: {
                            colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                            fontSize: '12px',
                            fontFamily: KTApp.getSettings()['font-family']
                        }
                    }
                },
                states: {
                    normal: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    hover: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    active: {
                        allowMultipleDataPointsSelection: false,
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    }
                },
                tooltip: {
                    style: {
                        fontSize: '12px',
                        fontFamily: KTApp.getSettings()['font-family']
                    },
                    y: {
                        formatter: function (val) {
                            return val + " Voters Join"
                        }
                    }
                },
                colors: [KTApp.getSettings()['colors']['theme']['light']['success']],
                markers: {
                    colors: [KTApp.getSettings()['colors']['theme']['light']['success']],
                    strokeColor: [KTApp.getSettings()['colors']['theme']['base']['success']],
                    strokeWidth: 3
                }
            };

            var chart = new ApexCharts(element, options);
            chart.render();
        }
    </script>
@endsection
