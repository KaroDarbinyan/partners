$(function () {
    am4core.ready(function () {

        let colors = [
            am4core.color("#FF0000"),
            am4core.color("#FF1493"),
            am4core.color("#28a745"),
            am4core.color("#FFFF00"),
            am4core.color("#FF00FF"),
            am4core.color("#A52A2A"),
            am4core.color("#0000FF"),
            am4core.color("#32CD32"),
            am4core.color("#008000"),
            am4core.color("#008B8B"),
            am4core.color("#00CED1"),
            am4core.color("#7B68EE"),
            am4core.color("#2F4F4F")
        ];

        let index = 0;

        am4core.useTheme(am4themes_dark);
        am4core.useTheme(am4themes_animated);

        let chart = am4core.create("chartdiv", am4charts.XYChart);
        chart.data = $('#chart-data').data('json');
        let years = $('#chart-data').data('years');
        $('#chart-data').remove();

        let categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = "month";
        categoryAxis.renderer.opposite = false;

        let valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        valueAxis.renderer.inversed = false;
        valueAxis.renderer.minLabelPosition = 0.01;

        for (let key in years) {
            let circleBullet = new am4charts.CircleBullet();
            circleBullet.circle.fill = colors[index];
            circleBullet.circle.stroke = am4core.color("black");
            circleBullet.circle.strokeWidth = 1.5;

            let series = chart.series.push(new am4charts.LineSeries());
            series.dataFields.valueY = years[key];
            series.dataFields.categoryX = "month";
            series.name = years[key].toString();
            series.strokeWidth = 1;
            series.bullets.push(circleBullet);

            series.tooltip.background.fillOpacity = 0;
            series.tooltip.background.stroke = colors[index];
            series.tooltip.autoTextColor = false;

            series.tooltipText = "{name} : {valueY}";
            series.legendSettings.valueText = "{valueY}";
            series.visible = false;
            series.tensionX = 0.8;
            series.stroke = colors[index];
            index++;
        }

        // if (window.location.pathname.includes("/statistikk/signeringer") || window.location.pathname.includes("/statistikk/aktiviteter")) {
        //     chart.series.pop();
        // }

        chart.cursor = new am4charts.XYCursor();
        chart.cursor.behavior = "zoomY";
        chart.legend = new am4charts.Legend();
    });

    $('#statistikk-date').change(function () {
        $.ajax({
            url: window.location.pathname + '?year=' + $(this).val(),
            dataType: 'json',
            success: function (result) {
                $('span.pr-3').html('0');
                $('#provisjon_tilrettelegging').html(result.provisjon_tilrettelegging);
                $('#omsetningsverdi').html(result.omsetningsverdi);
                $('#befaring').html(result.befaring);
                $('#salg').html(result.salg);
                $('#signeringer').html(result.signeringer);
            }
        });
    });

});

$(function () {

    loadOptions();

    function loadOptions() {
        let input = $("input");
        input.focus(function () {
            $(this).css({"outline": "none", "background": "transparent"});
            if ($(this).val() === "0") $(this).val("")
        }).blur(function () {
            if ($(this).val() === "") $(this).val("0")
        });

        $('.budsjett-calc').bind("keyup", function () {
            let inntekt = $(this).find('input.inntekt');
            let snittprovisjon = $(this).find('input.snittprovisjon');
            let hitrate = $(this).find('input.hitrate');
            let befaringer = $(this).find('td.befaringer');
            let befaringer_input = $(this).find('input.befaringer');
            let salg = $(this).find('td.salg');
            let salg_input = $(this).find('input.salg');

            if (inntekt.val() > 0 && snittprovisjon.val() > 0) {
                let salgValue = Math.floor(inntekt.val() / snittprovisjon.val());
                salg.html(salgValue);
                salg_input.val(salgValue);
                if (hitrate.val() > 0) {
                    let befaringerValue = Math.floor(salgValue / hitrate.val() * 100);
                    befaringer.html(befaringerValue);
                    befaringer_input.val(befaringerValue);
                } else {
                    befaringer.html('0');
                    befaringer_input.val('0');
                }
            } else {
                inntekt.css({"background": "transparent", "opacity": "1"}).attr("title", "");
                snittprovisjon.css({"background": "transparent", "opacity": "1"}).attr("title", "");
                hitrate.val('0').css({"background": "transparent", "opacity": "1"}).attr("title", "");
                befaringer.html('0').css({"background": "transparent", "opacity": "1"}).attr("title", "");
                befaringer_input.val('0').css({"background": "transparent", "opacity": "1"}).attr("title", "");
                salg.html('0').css({"background": "transparent", "opacity": "1"}).attr("title", "");
                salg_input.val('0').css({"background": "transparent", "opacity": "1"}).attr("title", "");
            }

            let x = [$('.inntekt'), $('.snittprovisjon'), $('.hitrate'), $('.befaringer'), $('.salg')];
            $.each(x, function (i) {
                let arr = x[i].serializeArray();
                let num = [];
                $.each(arr, function (i, field) {
                    num.push(+field.value)
                });
                $('#' + x[i][0].className).html(num.reduce((a, b) => a + b, 0).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1 '))
            });

            $('#sum').html($('#sum-row'));
            $(this).attr('data-change', 1);
        });

        $('#sum').html($('#sum-row'));
    }

    $('#budsjett-form').submit(function (e) {
        e.preventDefault();
        let error = false;
        let budsjett_data = [];
        let budsjetts = $('#budsjett-form').find('tr[data-change=1]');
        budsjetts.each(function () {
            let inntekt = $(this).find('input.inntekt');
            let snittprovisjon = $(this).find('input.snittprovisjon');
            let hitrate = $(this).find('input.hitrate');
            let befaringer = $(this).find('input.befaringer');
            let salg = $(this).find('input.salg');
            let user_id = $(this).data('id');
            let avdeling_id = $(this).data('avdeling_id');
            let year = $('select[name="year"]');

            if (inntekt.val() === "0" && (snittprovisjon.val() !== "0" || hitrate.val() !== "0")) {
                inntekt.css({"background": "red", "opacity": "0.5"}).attr("title", "Vennligst fyll dem ut");
                error = true;
            }
            if (snittprovisjon.val() === "0" && (inntekt.val() !== "0" || hitrate.val() !== "0")) {
                snittprovisjon.css({"background": "red", "opacity": "0.5"}).attr("title", "Vennligst fyll dem ut");
                error = true;
            }
            if (hitrate.val() === "0" && (snittprovisjon.val() !== "0" || inntekt.val() !== "0")) {
                hitrate.css({"background": "red", "opacity": "0.5"}).attr("title", "Vennligst fyll dem ut");
                error = true;
            }

            budsjett_data.push({
                inntekt: inntekt.val(),
                snittprovisjon: snittprovisjon.val(),
                hitrate: hitrate.val(),
                befaringer: befaringer.val(),
                salg: salg.val(),
                user_id: user_id,
                avdeling_id: avdeling_id,
                year: year.val()
            });
        });

        if (error) {
            $('#budsjett-modal').find("div.modal-body").html('<h3 class="text-center text-danger">Oops !!. Du har kanskje lagt igjen noen felt tomme. Vennligst fyll dem ut.</h3>');
            $('#budsjett-modal-btn').click();
            return false;
        }

        if (budsjett_data.length !== 0) {
            $.ajax({
                url: window.location.pathname,
                type: 'POST',
                dataType: 'json',
                data: {
                    budsjett_data: budsjett_data,
                },
                success: function (result) {
                    $('#budsjett_table_body').html(result);
                    $('#budsjett-modal').find("div.modal-body").html('<h3 class="text-center text-success">Lagret vellykket</h3>');
                    $('#budsjett-modal-btn').click();
                    loadOptions();
                }
            });
        }

    });

    $('select[name="year"]').change(function () {
        $.ajax({
            url: window.location.pathname,
            type: 'POST',
            dataType: 'json',
            data: {
                year: $(this).val()
            },
            success: function (result) {
                $('#budsjett_table_body').html(result);
                $('th[data-sort]').each(function () {
                    $(this).html($(this).html().replace(/[↓↑]/g, ''));
                });
                loadOptions();
            }
        })
    });

    $('th[data-sort]').click(function () {
        $.ajax({
            url: window.location.pathname,
            type: 'POST',
            dataType: 'json',
            data: {
                year: $('select[name="year"]').val(),
                sort: $(this).attr('data-sort'),
                type: $(this).attr('data-sort-type')
            },
            success: function (result) {
                $('#budsjett_table_body').html(result);
                loadOptions();
            }
        });

        $('th[data-sort-type]').each(function () {
            $(this).html($(this).html().replace(/[↓↑]/g, ''));
        });

        $(this).attr('data-sort-type') === '4' ?
            $(this).attr('data-sort-type', '3').html($(this).html() + ' ↑') :
            $(this).attr('data-sort-type', '4').html($(this).html() + ' ↓');


    });

});
