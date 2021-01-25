$(function () {
    am4core.ready(function () {

        let colors = [
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

        let chartBody = $('#chart-body');

        let charts = [
            {
                "id": "1",
                "action": "3rd-party-by-source",
                "title": "3RD PARTY BY SOURCE"
            }, {
                "id": "2",
                "action": "3rd-party-by-office",
                "title": "3RD PARTY BY OFFICE",
            }, {
                "id": "3",
                "action": "hot-clients-by-source",
                "title": "Hot clients by source"
            }, {
                "id": "4",
                "action": "hot-clients",
                "title": "Hot clients"
            }, {
                "id": "5",
                "action": "cold-clients",
                "title": "Cold clients"
            }, {
                "id": "6",
                "action": "behandlede-ubehandlede",
                "title": "Behandlede / Ubehandlede"
            }, {
                "id": "7",
                "action": "kontorer-meglere",
                "title": "Kontorer / Meglere"
            }
        ];

        am4core.useTheme(am4themes_animated);

        for (let i = 0; i < charts.length; i++) {

            let chart_div = $("#chart-div-" + charts[i]["id"]);
            $.ajax({
                url: charts[i]["action"],
                dataType: 'json',
                success: function (result) {
                    if (result !== null) {
                        if (result['type'] === 'v1') pieChartV1(result['data'], 'chart-div-' + charts[i]["id"]);
                        else pieChartV2(result['data'], 'chart-div-' + charts[i]["id"]);
                        chart_div.prev().html(charts[i]["title"]);
                    }
                    chart_div.parent().removeClass("d-none");
                    chart_div.find('g[aria-labelledby]').remove();
                }
            });
        }


        function pieChartV1(data, divId) {

            $(`#${divId}`).css({height: 500 + (data.length * 20) + "px"});
            var chart = am4core.create(divId, am4charts.PieChart);

            chart.hiddenState.properties.opacity = 0; // this creates initial fade-in
            chart.legend = new am4charts.Legend();
            chart.legend.valueLabels.template.fill = am4core.color("white");
            chart.legend.valueLabels.template.text = "{value.percent.formatNumber('#.0')}% ({child_count})";
            chart.legend.labels.template.fill = am4core.color("white");
            chart.data = data;

            var series = chart.series.push(new am4charts.PieSeries());
            series.dataFields.value = "child_count";
            series.dataFields.category = "child_name";

            if (window.screen.width < 426) {
                series.ticks.template.disabled = true;
                series.alignLabels = false;
                series.labels.template.text = "{value.percent.formatNumber('#.0')}%";
                series.labels.template.radius = am4core.percent(-40);
            } else {
                series.labels.template.text = "{child_name} {value.percent.formatNumber('#.0')}% ({child_count})";
            }
            series.labels.template.fill = am4core.color("white");
            series.colors.list = colors;
            series.slices.template.stroke = am4core.color("#fff");
            series.slices.template.strokeWidth = 1;
            series.slices.template.strokeOpacity = 1;
            series.hiddenState.properties.opacity = 1;
            series.hiddenState.properties.endAngle = -90;
            series.hiddenState.properties.startAngle = -90;
            series.slices.template.strokeOpacity = 1;
            series.slices.template.propertyFields.url = "link";
            series.slices.template.urlTarget = "_blank";

            $("#" + divId).parent().removeClass('d-none');
        }

        function pieChartV2(data, divId) {
            // Themes end
            var container = am4core.create(divId, am4core.Container);
            container.width = am4core.percent(85);
            container.height = am4core.percent(100);
            container.layout = "horizontal";


            var chart = container.createChild(am4charts.PieChart);

            // Add data
            chart.data = data;
            // Add and configure Series
            var pieSeries = chart.series.push(new am4charts.PieSeries());
            pieSeries.dataFields.value = "parent_count";
            pieSeries.colors.list = colors;
            pieSeries.labels.template.fill = am4core.color("white");
            pieSeries.dataFields.category = "parent_name";
            pieSeries.slices.template.states.getKey("active").properties.shiftRadius = 0;

            if (window.screen.width < 426) {
                $(`#${divId}`).css({height: "400px"});
                pieSeries.ticks.template.disabled = true;
                pieSeries.alignLabels = false;
                pieSeries.labels.template.text = "{value.percent.formatNumber('#.0')}%";
                pieSeries.labels.template.radius = am4core.percent(-40);
            } else {
                $(`#${divId}`).css({height: "650px"});
                chart.legend = new am4charts.Legend();
                chart.legend.labels.template.fill = am4core.color("white");
                chart.legend.valueLabels.template.fill = am4core.color("white");
                chart.legend.valueLabels.template.text = "{value.percent.formatNumber('#.0')}% ({parent_count})";
                pieSeries.labels.template.text = "{parent_name} {value.percent.formatNumber('#.0')}% ({parent_count})";
            }

            pieSeries.labels.template.fill = am4core.color("white");
            pieSeries.slices.template.stroke = am4core.color("#fff");
            pieSeries.slices.template.strokeWidth = 1;
            pieSeries.slices.template.strokeOpacity = 1;
            pieSeries.hiddenState.properties.opacity = 1;
            pieSeries.hiddenState.properties.endAngle = -90;
            pieSeries.hiddenState.properties.startAngle = -90;
            //pieSeries.labels.template.text = "{category}\n{value.percent.formatNumber('#.#')}%";

            pieSeries.slices.template.events.on("hit", function (event) {
                selectSlice(event.target.dataItem);
            });

            var chart2 = container.createChild(am4charts.PieChart);
            chart2.width = am4core.percent(25);
            chart2.radius = am4core.percent(100);

            // Add and configure Series
            var pieSeries2 = chart2.series.push(new am4charts.PieSeries());
            pieSeries2.dataFields.value = "child_count";
            pieSeries2.dataFields.category = "child_name";
            pieSeries2.colors.list = colors;
            pieSeries2.labels.template.fill = am4core.color("white");
            pieSeries2.slices.template.states.getKey("active").properties.shiftRadius = 0;
            //pieSeries2.labels.template.radius = am4core.percent(50);
            //pieSeries2.labels.template.inside = true;
            //pieSeries2.labels.template.fill = am4core.color("#ffffff");
            pieSeries2.labels.template.disabled = true;
            pieSeries2.ticks.template.disabled = true;
            pieSeries2.alignLabels = false;
            pieSeries2.events.on("positionchanged", updateLines);

            pieSeries2.slices.template.stroke = am4core.color("#fff");
            pieSeries2.slices.template.strokeWidth = 1;
            pieSeries2.slices.template.strokeOpacity = 1;
            pieSeries2.hiddenState.properties.opacity = 1;
            pieSeries2.hiddenState.properties.endAngle = -90;
            pieSeries2.hiddenState.properties.startAngle = -90;
            pieSeries2.slices.template.propertyFields.url = "link";
            pieSeries2.slices.template.urlTarget = "_blank";
            $("#" + divId).parent().removeClass('d-none');

            var interfaceColors = new am4core.InterfaceColorSet();

            var line1 = container.createChild(am4core.Line);
            line1.strokeDasharray = "2,2";
            line1.strokeOpacity = 1;
            line1.stroke = am4core.color("#fff");
            line1.isMeasured = false;

            var line2 = container.createChild(am4core.Line);
            line2.strokeDasharray = "2,2";
            line2.strokeOpacity = 1;
            line2.stroke = am4core.color("#fff");
            line2.isMeasured = false;

            var selectedSlice;

            function selectSlice(dataItem) {

                selectedSlice = dataItem.slice;

                var fill = selectedSlice.fill;

                var count = dataItem.dataContext.childes.length;
                pieSeries2.colors.list = colors;

                chart2.data = dataItem.dataContext.childes;
                pieSeries2.appear();

                var middleAngle = selectedSlice.middleAngle;
                var firstAngle = pieSeries.slices.getIndex(0).startAngle;
                var animation = pieSeries.animate([{
                    property: "startAngle",
                    to: firstAngle - middleAngle
                }, {property: "endAngle", to: firstAngle - middleAngle + 360}], 600, am4core.ease.sinOut);
                animation.events.on("animationprogress", updateLines);

                selectedSlice.events.on("transformed", updateLines);

                //  var animation = chart2.animate({property:"dx", from:-container.pixelWidth / 2, to:0}, 2000, am4core.ease.elasticOut)
                //  animation.events.on("animationprogress", updateLines)
            }


            function updateLines() {
                if (selectedSlice) {
                    var p11 = {
                        x: selectedSlice.radius * am4core.math.cos(selectedSlice.startAngle),
                        y: selectedSlice.radius * am4core.math.sin(selectedSlice.startAngle)
                    };
                    var p12 = {
                        x: selectedSlice.radius * am4core.math.cos(selectedSlice.startAngle + selectedSlice.arc),
                        y: selectedSlice.radius * am4core.math.sin(selectedSlice.startAngle + selectedSlice.arc)
                    };

                    p11 = am4core.utils.spritePointToSvg(p11, selectedSlice);
                    p12 = am4core.utils.spritePointToSvg(p12, selectedSlice);

                    var p21 = {x: 0, y: -pieSeries2.pixelRadius};
                    var p22 = {x: 0, y: pieSeries2.pixelRadius};

                    p21 = am4core.utils.spritePointToSvg(p21, pieSeries2);
                    p22 = am4core.utils.spritePointToSvg(p22, pieSeries2);

                    line1.x1 = p11.x;
                    line1.x2 = p21.x;
                    line1.y1 = p11.y;
                    line1.y2 = p21.y;

                    line2.x1 = p12.x;
                    line2.x2 = p22.x;
                    line2.y1 = p12.y;
                    line2.y2 = p22.y;
                }
            }

            chart.events.on("datavalidated", function () {
                setTimeout(function () {
                    selectSlice(pieSeries.dataItems.getIndex(0));
                }, 1000);
            });
        }


    });
});