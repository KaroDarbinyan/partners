$(function () {
    var daterangepickerLead = function () {
        var daterangepickerInit = function () {
            var $picker = $('#tl-datepicker');
            var $form = $('#tl-date-form');
            var tlRange;
            var label = 'Hittil i år';
            var start = moment().startOf('year').unix();
            var end = moment().endOf('year').unix();

            if (!$picker.length) {
                return;
            }

            function cb(start, end, label) {
                $('input[name="tl-label"]').val(label);
                $('input[name="tl-start"]').val(start);
                $('input[name="tl-end"]').val(end);
                $picker.find('.m-subheader__daterange-date').html(label);
                tlRange = $('.tl-daterangepicker');
                tlRange.find('li').removeClass('active');
                tlRange.find('li[data-range-key="' + label + '"]').addClass('active');
            }

            $picker.on('apply.daterangepicker', applyAndStoreDateFilter);

            $picker.on('cancel.daterangepicker', function (e, picker) {
                picker.setStartDate(start);
                picker.setEndDate(end);

                applyAndStoreDateFilter(e, picker);
            });

            function applyAndStoreDateFilter(event, picker) {
                $('input[name="tl-label"]').val(picker.chosenLabel);
                $('input[name="tl-start"]').val(picker.startDate.unix());
                $('input[name="tl-end"]').val(picker.endDate.unix());

                $form.trigger('change');
            }

            $picker.daterangepicker({
                direction: mUtil.isRTL(),
                startDate: start,
                endDate: end,
                opens: 'left tl-daterangepicker',
                applyClass: 'hidden',
                ranges: {
                    'I dag': [moment().startOf('day'), moment()],
                    'I går': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Denne uke': [moment().startOf('isoWeek'), moment().endOf('isoWeek')],
                    'Forrige uke': [moment().subtract(1, 'weeks').startOf('isoWeek'), moment().subtract(1, 'weeks').endOf('isoWeek')],
                    'Denne mnd': [moment().startOf('month'), moment()],
                    'Forrige mnd': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    'Hittil i år': [moment().startOf('year'), moment()],
                    'I fjor': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
                    'Sammenlagt': [0, moment()]
                },
                locale: {
                    cancelLabel: 'Reset'
                }
            }, cb);

            cb(start, end, label);
        };

        return {
            init: function () {
                daterangepickerInit();
            }
        };
    }();
    daterangepickerLead.init();

    $('.dropdown-menu a.dropdown-toggle').on('mouseover', function (e) {
        if (!$(this).next().hasClass('show')) {
            $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
        }
        var $subMenu = $(this).next(".dropdown-menu");
        $subMenu.toggleClass('show');


        $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function (e) {
            $('.dropdown-submenu .show').removeClass("show");
        });


        return false;
    });

    $(".partner-item").click(function () {
        $('input[name="tl-partner"]').val($(this).data("partner-id"));
        $('input[name="tl-office"]').val("all");
        $("#navbarDropdownMenuLink").html($(this).data("partner-name"))
        $('#tl-date-form').change();
    });

    $(".office-item").click(function () {
        $('input[name="tl-office"]').val($(this).data("office-id"));
        $('input[name="tl-partner"]').val($(this).data("partner-id"));
        $("#navbarDropdownMenuLink").html($(this).data("office-name"));
        $('#tl-date-form').change();
    });

    $('#tl-date-form').change(function () {
        let data = $(this).serializeArray();
        $(this).find('#tl-label').html($('input[name="tl-label"]').val());
        $.ajax({
            method: 'POST',
            data: $(this).serializeArray(),
            success: function (result) {
                $('#tl-container, #aktiviteter-info').html('');
                $('#tl-container').html(result);
                if (data[0].value === 'aktiviteter') {
                    $('#aktiviteter-info').html('salg - 2 poeng, befaringer og visninger - 1 poeng');
                }
                setTimeout(function () {
                    let userBlock = document.querySelector("[data-web_id]");
                    if (userBlock) {
                        userBlock.classList.add("current-user");
                        userBlock.scrollIntoView({block: "center", behavior: "smooth"});
                    }
                }, 1);
            }
        });
    });

});