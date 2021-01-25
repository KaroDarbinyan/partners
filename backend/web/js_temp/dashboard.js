am4core.useTheme(am4themes_dark);
am4core.useTheme(am4themes_animated);

let chart_funnel_1 = am4core.create("funnel_1", am4charts.SlicedChart);
chart_funnel_1.hiddenState.properties.opacity = 0; // this makes initial fade in effect

chart_funnel_1.data = [{
    "name": "Trafikk",
    "value": 6004
}, {
    "name": "Leads",
    "value": 1072
}, {
    "name": "Befaringer",
    "value": 250
}, {
    "name": "Signeringer",
    "value": 180
}, {
    "name": "Salg",
    "value": 137
}];

let series = chart_funnel_1.series.push(new am4charts.FunnelSeries());
series.colors.step = 2;
series.dataFields.value = "value";
series.dataFields.category = "name";
series.sliceLinks.template.height = 30;
series.sliceLinks.template.fillOpacity = 0.2

series.alignLabels = true;

series.labels.template.text = "{category}: [bold]{value}[/]";
series.labelsContainer.paddingLeft = 15;
series.labelsContainer.width = 100;





var Dashboard = function() {





    //== Revenue Change.
    //** Based on Morris plugin - http://morrisjs.github.io/morris.js/
    var revenueChange_1 = function() {
        if ($('#m_chart_revenue_change_1').length == 0) {
            return;
        }

        Morris.Donut({
            element: 'm_chart_revenue_change_1',
            data: [{
                label: "Carl Barner",
                value: 55450
            },
                {
                    label: "Torshov",
                    value: 48960
                },
                {
                    label: "Sagene",
                    value: 51240
                },
                {
                    label: "Andre",
                    value: 43830
                }
            ],
            backgroundColor: 'rgba(0,0,0,0.1)',
            labelColor: '#fff',
            fillOpacity: 0.1,
            colors: [
                mApp.getColor('accent'),
                mApp.getColor('danger'),
                mApp.getColor('brand'),
                mApp.getColor('metal')
            ],
        });
    }
    var revenueChange_2 = function() {
        if ($('#m_chart_revenue_change_2').length == 0) {
            return;
        }

        Morris.Donut({
            element: 'm_chart_revenue_change_2',
            data: [{
                label: "Carl Barner",
                value: 11450856
            },
                {
                    label: "Torshov",
                    value: 10356832
                },
                {
                    label: "Sagene",
                    value: 9876320
                },
                {
                    label: "Andre",
                    value:  40876900
                }
            ],
            backgroundColor: 'rgba(0,0,0,0)',
            labelColor: '#fff',
            colors: [
                mApp.getColor('accent'),
                mApp.getColor('danger'),
                mApp.getColor('brand'),
                mApp.getColor('metal')
            ],
        });
    }
    var revenueChange = function() {
        if ($('#m_chart_revenue_change').length == 0) {
            return;
        }

        Morris.Donut({
            element: 'm_chart_revenue_change',
            data: [{
                label: "Carl Barner",
                value: 28
            },
                {
                    label: "Kalbakken",
                    value: 20
                },
                {
                    label: "Sagene",
                    value: 10
                },
                {
                    label: "Andre",
                    value: 27
                }
            ],
            backgroundColor: 'rgba(0,0,0,0)',
            labelColor: '#fff',
            colors: [
                mApp.getColor('accent'),
                mApp.getColor('danger'),
                mApp.getColor('brand'),
                mApp.getColor('metal')
            ],
        });
    }

    var daterangepickerInit = function() {
        if ($('#m_dashboard_daterangepicker').length == 0) {
            return;
        }

        var picker = $('#m_dashboard_daterangepicker');
        var start = moment();
        var end = moment();

        function cb(start, end, label) {
            var title = '';
            var range = '';

            if ((end - start) < 100 || label == 'Today') {
                title = 'Today:';
                range = start.format('MMM D');
            } else if (label == 'Yesterday') {
                title = 'Yesterday:';
                range = start.format('MMM D');
            } else {
                range = start.format('MMM D') + ' - ' + end.format('MMM D');
            }

            picker.find('.m-subheader__daterange-date').html(range);
            picker.find('.m-subheader__daterange-title').html(title);
        }

        picker.daterangepicker({
            direction: mUtil.isRTL(),
            startDate: start,
            endDate: end,
            opens: 'left',
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end, '');
    }
    return {
        //== Init demos
        init: function() {
            revenueChange();
            revenueChange_1();
            revenueChange_2();
            daterangepickerInit();
        }
    };
}();

jQuery(document).ready(function() {
    Dashboard.init();
});