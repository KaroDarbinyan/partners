moment.locale('nb');

let property = window.property;

$.fn.selectpicker.Constructor.BootstrapVersion = '3';

$(document).ready(function () {

    $('.js-range-slider').ionRangeSlider({
        skin: 'flat',
        prettify: function (val) {
            if (this.extra_classes.includes('is-km')) {
                if (val < 1000) {
                    return val + ' m';
                }

                return (val / 1000) + ' km';
            }

            return val;
        }
    });

    let loader = $('.loader');

    if (loader.length) {
        loader.fadeIn('slow', function () {
            $('.loader__icons img')
                .each(function (i) {
                    $(this).delay(100 * i).queue(function () {
                        $(this).addClass('loaded');
                    });
                });

            setTimeout(function () {
                window.location.href = '/befaring/oppdrag/detaljer/' + property;
                loader.fadeOut('slow', function () {
                    $('.index-page').fadeIn();
                });
            }, 2000);
        });
    }

    $('.show-table').on('shown.bs.tab', function (e) {
        $.fn.dataTable.tables({
            visible: true,
            api: true
        })
            .columns
            .adjust();
    });
});

$(document).on('click', '.dit-team .about-tabs_item, .potential-clients .about-tabs_item', function (e) {
    e.preventDefault();

    $('.dit-team .about-tabs_item.tab-active, .potential-clients .about-tabs_item.tab-active')
        .removeClass('tab-active');

    $(this).addClass('tab-active');

    $('.tab-content').hide();

    let id = $(this).find('a').attr('href');

    $(id).fadeIn();
});

$('body').on('click', '.oppdrag .about-tabs_item', function () {
    window.location.href = $(this).attr('href');
});

// $(function () {
    $(".navbar-toggle").click(function () {
        // alert(32123)
        $(".nav-bar").toggleClass("nav-bar-open");
        $('.navbar-toggle').toggleClass("nav-bar-toggle");
    });
// });

// $(".document table").DataTable();
var DatatablesBasicBasic = {
    init: function () {
        var e = $(".oppdrag table");
        e.DataTable({
            // scrollY: "55vh",
            // scrollX: !0,
            responsive: !0,
            dom: "<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-7 '>>",
            pageLength: 100,

            order: [
                [0, "asc"]
            ]
        })
    }
};

if ($('.oppdrag').length) {
    if ($(".oppdrag table").length) {
        DatatablesBasicBasic.init();
    }
}
if ($('#calendarevent-start').length && $('#calendarevent-end').length) {
    $('#calendarevent-start').datetimepicker();
    $('#calendarevent-end ').datetimepicker({
        useCurrent: false //Important! See issue #1075
    });
    $("#calendarevent-start").on("dp.change", function (e) {
        $('#calendarevent-end').data("DateTimePicker").minDate(e.date);
    });
    $("#calendarevent-end").on("dp.change", function (e) {
        $('#calendarevent-start').data("DateTimePicker").maxDate(e.date);
    });

}

if ($('#calendar').length) {
    var KTAppOptions = {
        "colors": {
            "state": {
                "brand": "#5d78ff",
                "dark": "#282a3c",
                "light": "#ffffff",
                "primary": "#5867dd",
                "success": "#34bfa3",
                "info": "#36a3f7",
                "warning": "#ffb822",
                "danger": "#fd3995"
            },
            "base": {
                "label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
                "shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
            }
        }
    };
    KTApp.init(KTAppOptions);
    var todayDate = moment().startOf('day');
    var YM = todayDate.format('YYYY-MM');
    var YESTERDAY = todayDate.clone().subtract(1, 'day').format('YYYY-MM-DD');
    var TODAY = todayDate.format('YYYY-MM-DD');
    var TOMORROW = todayDate.clone().add(1, 'day').format('YYYY-MM-DD');
    var KTAppEventsOld = [
        {
            title: 'All Day dfgt',
            start: YM + '-01',
            end: YM + '+14',
            description: 'Lorem ipsum dolor sit incid idunt ut',
            className: "fc-event-danger fc-event-solid-success"
        },
        {
            title: 'Reporting',
            start: YM + '-14T13:30:00',
            description: 'Lorem ipsum dolor incid idunt ut labore',
            end: YM + '-14',
            className: "fc-event-brand",
            constraint: 'businessHours'
        },
        {
            title: 'Company Trip',
            start: YM + '-02',
            description: 'Lorem ipsum dolor sit tempor incid',
            end: YM + '-03',
            className: "fc-event-light fc-event-solid-primary"
        },
        {
            title: 'Expo',
            start: YM + '-03',
            description: 'Lorem ipsum dolor sit tempor inci',
            end: YM + '-05',
            // className: "fc-event-primary",
            // rendering: 'background',
            // className: "fc-event-danger fc-event-solid-success",
            color: '#d42525'// KTApp.getStateColor('brand')
        },

        {
            title: 'Meeting',
            start: YESTERDAY + 'T10:30:00',
            end: TOMORROW + 'T12:30:00',
            description: 'Lorem ipsum dolor eiu idunt ut labore'
        },
    ];
    var KTAppEvents = [];
    $.each(propertyEvens, function (i, val) {
        KTAppEvents.push({
            id: val.id + val.start,
            id_event: val.id,
            title: val.name,
            start: val.start,
            description: val.description,
            className: val.classes,
        })
    });


}

var KTMorrisChart = function () {
    var chart = function (val) {
        valText = '+';
        if (0 > val) {
            valText = '-';
        }
        // PIE CHART
        var chartData = new Morris.Donut({
            element: 'statistikk-chart',
            backgroundColor: '#ccc',
            labelColor: '#156a5e',
            borderColor: '#156a5e',
            colors: [
                '#156a5e',
                '#262626'
            ],
            select: function (r) {
                alert(r);
            },
            formatter: function (x) {
                return x + "%"
            },
            data: [
                {
                    label: valText,
                    value: Math.abs(val),

                }, {
                    label: "",
                    value: 100 - Math.abs(val),

                },

            ]
        });
        chartData.select(0);
    };

    return {
        init: function (val) {

            chart(val);
        }
    };
}();