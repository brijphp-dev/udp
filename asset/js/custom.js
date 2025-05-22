"use strict";
var BrijCustomJs = function() {

    return {
        userDataTable: function() {
            var table = $('#user_datatable');
            
            table.on('change', '.group-checkable', function() {
                var set = $(this).closest('table').find('td:first-child .checkable');
                var checked = $(this).is(':checked');

                $(set).each(function() {
                    if (checked) {
                        $(this).prop('checked', true);
                        $(this).closest('tr').addClass('active');
                    }
                    else {
                        $(this).prop('checked', false);
                        $(this).closest('tr').removeClass('active');
                    }
                });
            });

            table.on('change', 'tbody tr .checkbox', function() {
                $(this).parents('tr').toggleClass('active');
            });
        }
    }
}();

$.fn.formValidation = function(rules, messages = ''){
    this.validate({
        validClass: "success",
        rules:rules,
        messages:messages,
        errorPlacement: function(label, element) {
            label.addClass('mt-2 text-danger');
            if($( element ).data( "datepicker" ))
            {
                label.insertAfter(element.parent());
            }
            else if($( element ).data( "radio" )){
                var parent = element.parent().parent().parent();
                parent.append(label);
            }
            else if($( element ).data( "treeview" )){
                var parent = element.closest('.roles-treeview');
                parent.append(label);
            }
            else if($( element ).data( "fileupload" )){
                var parent = element.parent().parent();
                parent.append(label);
            }
            else{
                label.insertAfter(element);
            }
        },
        highlight: function(element, errorClass) {
            $(element).parent().addClass('has-danger')
            $(element).addClass('form-control-danger')
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).parent().removeClass('has-danger').addClass(validClass);
          $(element).removeClass('form-control-danger').addClass(validClass);
        },
        submitHandler: function (form) {
            $('button[type=submit]').attr('disabled','disabled');
            form.submit();
        }
    });
}

$.fn.resetForm = function(formData){
    $('form').get(0).reset();
    this.trigger("reset");
    $(formData + " label.error").hide();
    $(formData + " .form-control-danger").removeClass("form-control-danger");
    $(formData + " .has-danger").removeClass("has-danger");
}

var showcommonDeleteAlert = function(currentObject){

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false,
    })

    swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        text: $(currentObject).attr('data-alertMessage'),
        icon: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'ml-2',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: $(currentObject).attr('data-deleteurl'),
                type: 'POST',
                data:{'_method':'DELETE', "_token": $('meta[name="_token"]').attr('content')},
                dataType:"json",
            }).done(function(response) {
                if(response.status === 1)
                {
                    swalWithBootstrapButtons.fire(
                    {
                        title: 'Deleted!',
                        text : response.message,
                        icon : 'success',
                        onClose: () => {
                            /*if(config.reload_page){
                                location.reload();
                            }*/
                        }
                    }
                    )
                    $($(currentObject).attr('data-dataTableReloadid')).DataTable().ajax.reload();
                }else if(response.status === 10)
                {
                    swalWithBootstrapButtons.fire({
                        title: 'Cancelled!',
                        icon: 'error',
                        html: response.message,
                        showConfirmButton: false,
                        showCancelButton: true,
                        focusConfirm: false,
                        cancelButtonText:
                            '<i class="la la-thumbs-down"></i> Ok',
                        cancelButtonAriaLabel: 'Thumbs down',
                    });

                } else{
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        response.message,
                        'success'
                    )
                }
            }).fail(function() {
                swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Something went wrong please try again!',
                    'error'
                )
            });
        }
    })
}
var showcommonActivateAlert = function(currentObject){

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false,
        })

        swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        text: $(currentObject).attr('data-alertMessage'),
        icon: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'ml-2',
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
        reverseButtons: true
        }).then((result) => {
        if (result.value) {
            $.ajax({
                url: $(currentObject).attr('data-activateURL'),
                type: 'GET',
                dataType:"json",
            }).done(function(response) {
                if(response.status)
                {
                    swalWithBootstrapButtons.fire(
                        $(currentObject).attr('data-title'),
                        response.message,
                        'success'
                    )
                }else{
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        response.message,
                        'success'
                    )
                }
                $($(currentObject).attr('data-dataTableReloadid')).DataTable().ajax.reload();
            }).fail(function() {
                swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Something went wrong please try again!',
                    'error'
                )
            });


        }
        })
}
var showTostAlert = function(message)
{
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 5000
    });

    Toast.fire({
        icon: 'error',
        title: message
    });
}
var erroMesssage = function(message)
{
    if($.isArray(message))
    {
        $.each(message, function( key, value ) {
            showTostAlert(value);
        });
    }else{
        showTostAlert(message);
    }
}

var _initMixedWidgetBrij = function() {
    var element = document.getElementById("kt_chart_lineBrij");
    var height = parseInt(KTUtil.css(element, 'height'));

    if (!element) {
        return;
    }

    var strokeColor = '#CCBD5AE3';

    var options = {
        series: [{
            name: 'Net Profit',
            data: [1230, 2245, 1132, 1270, 1040, 1040, 1150, 1642, 1785, 125, 1123, 1542]
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
            },
            dropShadow: {
                enabled: true,
                enabledOnSeries: undefined,
                top: 5,
                left: 0,
                blur: 3,
                color: strokeColor,
                opacity: 0.5
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
            opacity: 0
        },
        stroke: {
            curve: 'smooth',
            show: true,
            width: 3,
            colors: [strokeColor]
        },
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
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
                    return "$" + val + " thousands"
                }
            },
            marker: {
                show: false
            }
        },
        colors: ['transparent'],
        markers: {
            colors: [KTApp.getSettings()['colors']['theme']['light']['danger']],
            strokeColor: [strokeColor],
            strokeWidth: 3
        }
    };

    var chart = new ApexCharts(element, options);
    chart.render();
}
var _initStatsWidgetUserBrij = function () {
    var element = document.getElementById("kt_chart_lineUserBrij");

    var height = parseInt(KTUtil.css(element, 'height'));
    if (!element) {
        return;
    }

    var options = {
        series: [{
            name: 'Net Profit',
            data: [140, 740, 230, 130, 305, 350, 50, 120, 15, 156, 235, 654]
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
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
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
                    return "$" + val + " thousands"
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

var _initStatsWidgetsaleBrij = function () {
    var element = document.getElementById("kt_chart_lineSaleBrij");

    if (!element) {
        return;
    }

    var options = {
        series: [{
            name: 'Net Profit',
            data: [30, 45, 32, 170, 540, 1523, 225, 1235, 201, 20, 1150, 3560]
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
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
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
                    return "$" + val + " thousands"
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
$(function() {});