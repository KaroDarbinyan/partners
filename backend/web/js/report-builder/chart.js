class Chart {
    selectors = {
        deptSelector: $('#dept-select'),
        userSelector: $('#user-select'),
        chartDiv: $('#chart-div'),
        chartLoader: $('#chart-loader')
    };

    chartDiv = 'chart-div';
    ranges = {
        'I dag': [moment().startOf('day'), moment()],
        'I går': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Denne uke': [moment().startOf('isoWeek'), moment().endOf('isoWeek')],
        'Forrige uke': [moment().subtract(1, 'weeks').startOf('isoWeek'), moment().subtract(1, 'weeks').endOf('isoWeek')],
        'Denne mnd': [moment().startOf('month'), moment()],
        'Forrige mnd': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
        'Hittil i år': [moment().startOf('year'), moment().endOf('year')],
        'I fjor': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
        'Sammenlagt': [moment(0), moment().endOf('year')]
    };
    colors = [
        am4core.color("#1a4447"),
        am4core.color("#046a60"),
        am4core.color("#132f31"),
        am4core.color("#024348"),
        am4core.color("#1b484c"),
        am4core.color("#073c40"),
        am4core.color("#1a3f40"),
        am4core.color("#0a3d40"),
        am4core.color("#114746"),
        am4core.color("#09686a"),
        am4core.color("#132f31"),
        am4core.color("#024348"),
        am4core.color("#0f3c4c"),
        am4core.color("#0d3340"),
        am4core.color("#244038"),
        am4core.color("#0a3d40"),
    ];

    constructor(departments) {
        this.departments = departments;
        this.deptSelectInit();

        this.filter = {
            "chartType": "pieChart",
            "query": {
                "where": {
                    "like": {},
                    "not like": {},
                    "in": {},
                    "not in": {},
                    "between": {
                        "forms.created_at": {
                            "start": moment().startOf('year').unix(),
                            "end": moment().endOf('year').unix()
                        }
                    }
                },
                "rest": {}
            }
        };

        $(`button[data-range-key="Hittil i år"], button[data-chart-type="${this.filter.chartType}"], i[data-chart-type="${this.filter.chartType}"]`)
            .removeClass('btn-success').addClass('btn-dark');

        this.eventsInit();
        this.changeDateRangePicker();
    }

    deptSelectInit() {
        this.selectors.deptSelector.empty();
        this.selectors.deptSelector.append(new Option('All', 'all'));
        for (let key in this.departments) {
            this.selectors.deptSelector.append(new Option(this.departments[key].short_name, key));
        }
        this.selectors.deptSelector.selectpicker('refresh');
        this.selectors.deptSelector.change((e) => {
            this.deptSelectChange(e.target.value)
        });
    }

    userSelectInit(department) {
        if (department === 'all') {
            this.selectors.userSelector.parent().parent().addClass('d-none');
        } else {
            this.selectors.userSelector.parent().parent().removeClass('d-none');
            let users = this.departments[department].users;
            this.selectors.userSelector.empty();
            this.selectors.userSelector.append(new Option('All', 'all'));
            for (let key in users) {
                this.selectors.userSelector.append(new Option(users[key].navn, users[key].url));
            }
            this.selectors.userSelector.change((e) => {
                this.userSelectChange(e.target.value)
            });
        }
        this.selectors.userSelector.selectpicker('refresh');
    }

    deptSelectChange(department) {
        // this.userSelectInit(department);
        // delete this.filter.query.where.user;
        this.filter.query.where['department'] = {1: "url", 2: department};
        if (department === 'all') delete this.filter.query.where.department;
        this.getDataForCharts();
    }

    userSelectChange(user) {
        this.filter.query.where['user'] = {1: "url", 2: user};
        this.getDataForCharts();
    }

    changeDateRangePicker() {

        let start = moment.unix(this.filter.query.where.between["forms.created_at"].start);
        let end = moment.unix(this.filter.query.where.between["forms.created_at"].end);

        let dateRangePicker = $('.dateRangePicker');
        dateRangePicker.daterangepicker({
            // locale: {
            //     "customRangeLabel": "zgvsdfgrsdgbsdfgv",
            // },
            showDropdowns: true,
            opens: 'right',
            // showDropdowns: true,
            // opens: 'left',
            "alwaysShowCalendars": true,
            // autoApply: true,
            startDate: start,
            endDate: end,
            // ranges: this.ranges
        }, this.cb);

        this.cb(start, end);

        dateRangePicker.on('apply.daterangepicker', (ev, picker) => {
            $(`button[data-range-key]`).removeClass('btn-dark').addClass('btn-success');
            this.filter.query.where.between["forms.created_at"].start = picker.startDate.unix();
            this.filter.query.where.between["forms.created_at"].end = picker.endDate.unix();
            this.changeDateRangePicker();
        });

        this.getDataForCharts();
    }

    cb(start, end) {
        $('.dateRangePicker').find('span').html(start.format('M.DD.YYYY') + ' - ' + end.format('M.DD.YYYY'));
    }

    getDataForCharts() {
        switch (this.filter.chartType) {
            case "simpleColumnChart":
                delete this.filter.query.rest;
                break;
            case "stackedAreaChart":
                delete this.filter.query.rest;
                this.filter.query.rest = {
                    "orderBy": {0: "step"},
                    "groupBy": {"step": "SORT_ASC"},
                };
                break;
            case "dateBasedDataChart":
                delete this.filter.query.rest;
                this.filter.query.rest = {
                    "orderBy": {"year": "SORT_ASC"},
                    "groupBy": {0: "year", 1: "month"},
                };
            case "pieChart":
                delete this.filter.query.rest;
                break;
        }

        this.selectors.chartLoader.show();
        this.selectors.chartDiv.empty();
        $.ajax({
            url: window.location.href,
            method: 'GET',
            data: this.filter,
            success: (result) => {
                if (result.length === 0) {
                    this.selectors.chartDiv.empty().html($('<p>', {
                        class: 'rb_not_data text-center',
                        text: 'Not data',
                        css: {
                            fontSize: '20px'
                        }
                    }));
                } else {
                    this[this.filter.chartType](result);
                }
                this.selectors.chartLoader.hide();
            },
            error: () => {
                this.selectors.chartLoader.hide();
            }

        });

    }

    simpleColumnChart(data) {
        am4core.disposeAllCharts();
        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        let chart = am4core.create(this.chartDiv, am4charts.XYChart);

        // Add data
        chart.data = data;
        chart.colors.list = this.colors;

        // Create axes

        let categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = "parent_name";
        categoryAxis.renderer.grid.template.location = 0;
        categoryAxis.renderer.minGridDistance = 30;

        categoryAxis.renderer.labels.template.adapter.add("dy", function (dy, target) {
            if (target.dataItem && target.dataItem.index && 2 === 2) {
                return dy + 25;
            }
            return dy;
        });

        let valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

        // Create series
        let series = chart.series.push(new am4charts.ColumnSeries());
        series.dataFields.valueY = "parent_count";
        series.dataFields.categoryX = "parent_name";
        series.name = "Visits";
        series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
        series.columns.template.fillOpacity = .8;
        let columnTemplate = series.columns.template;
        columnTemplate.strokeWidth = 2;
        columnTemplate.strokeOpacity = 1;
    }

    stackedAreaChart(data) {
        am4core.disposeAllCharts();
        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end
        let chart = am4core.create(this.chartDiv, am4charts.XYChart);

        chart.colors.list = this.colors;
        chart.data = data;
        chart.dateFormatter.inputDateFormat = "yyyy-MM-dd";
        let dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        dateAxis.renderer.minGridDistance = 1;
        dateAxis.startLocation = 0.5;
        dateAxis.endLocation = 0.5;
        dateAxis.baseInterval = {
            timeUnit: "month",
            count: 1
        };

        let valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        valueAxis.tooltip.disabled = true;
        console.log(data[0]);
        for (let key in data[0]) {
            if (key !== 'year' && key !== 'month' && key !== 'step') {
                let series = chart.series.push(new am4charts.LineSeries());
                let name = key.replace(/-/g, ' ');
                series.dataFields.dateX = "step";
                series.name = name;
                series.dataFields.valueY = key;
                series.tooltipHTML = "<span style='vertical-align:bottom; margin-right: 10px; width:28px; height:21px;'><span style='font-size:14px; color:#000000;'><b>" + name + " ({valueY.value})</b></span>";
                series.tooltipText = "[#000]{valueY.value}[/]";
                series.tooltip.background.fill = am4core.color("#FFF");
                series.tooltip.getStrokeFromObject = true;
                series.tooltip.background.strokeWidth = 3;
                series.tooltip.getFillFromObject = false;
                series.fillOpacity = 0.6;
                series.strokeWidth = 2;
                series.stacked = true;
            }
        }


        chart.cursor = new am4charts.XYCursor();
        chart.cursor.xAxis = dateAxis;
        chart.scrollbarX = new am4core.Scrollbar();

        // Add a legend
        chart.legend = new am4charts.Legend();
        chart.legend.position = "top";

        // axis ranges
        let range = dateAxis.axisRanges.create();
        range.date = new Date(2001, 0, 1);
        range.endDate = new Date(2003, 0, 1);
        range.axisFill.fill = chart.colors.getIndex(7);
        range.axisFill.fillOpacity = 0.2;

        range.label.text = "Fines for speeding increased";
        range.label.inside = true;
        range.label.rotation = 90;
        range.label.horizontalCenter = "right";
        range.label.verticalCenter = "bottom";

        let range2 = dateAxis.axisRanges.create();
        range2.date = new Date(2007, 0, 1);
        range2.grid.stroke = chart.colors.getIndex(7);
        range2.grid.strokeOpacity = 0.6;
        range2.grid.strokeDasharray = "5,2";


        range2.label.text = "Motorcycle fee introduced";
        range2.label.inside = true;
        range2.label.rotation = 90;
        range2.label.horizontalCenter = "right";
        range2.label.verticalCenter = "bottom";
    }

    dateBasedDataChart(data) {
        am4core.disposeAllCharts();
        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        let chart = am4core.create(this.chartDiv, am4charts.XYChart);

        // Add data

        chart.data = data
        // Set input format for the dates
        chart.dateFormatter.inputDateFormat = "yyyy-MM-dd";

        // Create axes
        let dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        let valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

        // Create series
        let series = chart.series.push(new am4charts.LineSeries());
        series.dataFields.valueY = "value";
        series.dataFields.dateX = "date";
        series.tooltipText = "{value}";
        series.strokeWidth = 2;
        series.minBulletDistance = 15;

        // Drop-shaped tooltips
        series.tooltip.background.cornerRadius = 20;
        series.tooltip.background.strokeOpacity = 0;
        series.tooltip.pointerOrientation = "vertical";
        series.tooltip.label.minWidth = 40;
        series.tooltip.label.minHeight = 40;
        series.tooltip.label.textAlign = "middle";
        series.tooltip.label.textValign = "middle";

        // Make bullets grow on hover
        let bullet = series.bullets.push(new am4charts.CircleBullet());
        bullet.circle.strokeWidth = 2;
        bullet.circle.radius = 4;
        bullet.circle.fill = am4core.color("#fff");

        let bullethover = bullet.states.create("hover");
        bullethover.properties.scale = 1.3;

        // Make a panning cursor
        chart.cursor = new am4charts.XYCursor();
        chart.cursor.behavior = "panXY";
        chart.cursor.xAxis = dateAxis;
        chart.cursor.snapToSeries = series;

        // Create vertical scrollbar and place it before the value axis
        chart.scrollbarY = new am4core.Scrollbar();
        chart.scrollbarY.parent = chart.leftAxesContainer;
        chart.scrollbarY.toBack();

        // Create a horizontal scrollbar with previe and place it underneath the date axis
        chart.scrollbarX = new am4charts.XYChartScrollbar();
        chart.scrollbarX.series.push(series);
        chart.scrollbarX.parent = chart.bottomAxesContainer;


        dateAxis.start = 0;
        dateAxis.keepSelection = true;
    }

    pieChart(data) {
        am4core.disposeAllCharts();
        let chart = am4core.create(this.chartDiv, am4charts.PieChart);

        chart.hiddenState.properties.opacity = 0; // this creates initial fade-in
        chart.legend = new am4charts.Legend();
        chart.legend.valueLabels.template.fill = am4core.color("white");
        chart.legend.valueLabels.template.text = "{value.percent.formatNumber('#.0')}% ({parent_count})";
        chart.legend.labels.template.fill = am4core.color("white");
        chart.data = data;

        let series = chart.series.push(new am4charts.PieSeries());
        series.dataFields.value = "parent_count";
        series.dataFields.category = "parent_name";
        series.labels.template.text = "{parent_name} {value.percent.formatNumber('#.0')}% ({parent_count})";
        series.labels.template.fill = am4core.color("white");
        series.colors.list = this.colors;
        series.slices.template.stroke = am4core.color("#fff");
        series.slices.template.strokeWidth = 1;
        series.slices.template.strokeOpacity = 1;
        series.hiddenState.properties.opacity = 1;
        series.hiddenState.properties.endAngle = -90;
        series.hiddenState.properties.startAngle = -90;
        series.slices.template.strokeOpacity = 1;
        series.slices.template.propertyFields.url = "link";
        series.slices.template.urlTarget = "_blank";
    }

    eventsInit() {
        $(`button[data-range-key="Hittil i år"], button[data-chart-type="${this.filter.chartType}"], i[data-chart-type="${this.filter.chartType}"]`)
            .removeClass('btn-success').addClass('btn-dark');

        $('button[data-chart-type], i[data-chart-type]').click((e) => {
            let chartType = e.target.dataset.chartType;
            $(`button[data-chart-type]`).removeClass('btn-dark').addClass('btn-success');
            $(`button[data-chart-type="${chartType}"]`).removeClass('btn-success').addClass('btn-dark');
            this.filter.chartType = chartType;
            this.getDataForCharts()
        });

        $('button[data-range-key]').click((e) => {
            let rangeKey = e.target.dataset.rangeKey;
            let element = $(`button[data-range-key="${rangeKey}"]`);
            $(`button[data-range-key]`).removeClass('btn-dark').addClass('btn-success');
            element.removeClass('btn-success').addClass('btn-dark');
            this.filter.query.where.between["forms.created_at"].start = this.ranges[element.data('range-key')][0].unix();
            this.filter.query.where.between["forms.created_at"].end = this.ranges[element.data('range-key')][1].unix();
            this.changeDateRangePicker();

        });



    }
}

$(function () {
    let data_deps = $('#data-deps');
    let departments = data_deps.data('deps');
    data_deps.removeAttr('data-deps');
    new Chart(departments);
});


