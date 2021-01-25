$(function () {
    let currentYear = new Date();
    let selectMonth = $('#user-income-month').val();
    let user_income = $('#user-income').html();
    let user_income_height = Math.floor($('#user-income').children().height()) + 13;
    let user_incomes_arr = {};

    function getMonths(year) {
        // if (parseInt(year) === currentYear.getFullYear()) return month.slice(0, currentYear.getMonth() + 1);
        return ['Januar', 'Februar', 'Mars', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Desember'];

    }

    function refreshSelectpicker() {
        let arr = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
        let months = getMonths($('#user-income-year').val());
        let monthSelect = $('#user-income-month');
        monthSelect.empty();
        monthSelect.append(new Option('Hittil i år', ''));
        monthSelect.append(new Option('Hele året', 'all'));
        for (let i = months.length - 1; i >= 0; i--) {
            monthSelect.append(new Option(months[i], arr[i]));
        }

        monthSelect.val(selectMonth);
        monthSelect.selectpicker('refresh');

        if (currentYear.getFullYear() === +$('#user-income-year').val()) {
            let active = $('#user-income-month').next().next().find('ul.dropdown-menu li:nth-child(' + (14 - currentYear.getMonth()) + ') a span:last-child');
            active.html(active.html() + ' (nå)').css({color: 'wheat'});
        }
        selectMonth = $('#user-income-month').val();
    }

    $('#user-income-year').change(function () {
        refreshSelectpicker();
        userIncomeBlockInit($('#user-income-year').val(), $('#user-income-month').val());
        updateUserIncomeBlock($('#user-income-year').val(), $('#user-income-month').val());

    });

    $('#user-income-month').change(function () {
        selectMonth = $('#user-income-month').val();
        userIncomeBlockInit($('#user-income-year').val(), $('#user-income-month').val());
        updateUserIncomeBlock($('#user-income-year').val(), $('#user-income-month').val());

    });

    $(".check-all-users").on('click', function () {
        if (+$(this).attr('data-click-state') === 1) {
            $(this).attr('data-click-state', 0).find('i').removeClass("checked");
            let ids = $(this).data("user-ids").split(",");
            for (let i = 0; i < ids.length; i++) {
                $("#user-incomes").find(`.remove-incomes[data-remove=${ids[i]}]`).click();
            }
        } else {
            $(this).attr('data-click-state', 1).find('i').addClass("checked");
            $(this).next().find("a[data-user-id]").each(function () {
                if (+$(this).data('clicked') === 0) $(this).click();
            });
        }
    });


    $('a[data-user-id]').click(function () {

            if ((+$(this).data('clicked') === 1) && (user_incomes_arr[$(this).data('user-id')])) {

                let selectDiv = $('#user-incomes').find('div[data-user-id=' + $(this).data('user-id') + ']');
                $([document.documentElement, document.body]).animate({
                    scrollTop: selectDiv.offset().top - selectDiv.height()
                });

                $(this).removeClass("selected").data('clicked', 0);
                $("#user-incomes").find(`.remove-incomes[data-remove=${$(this).data('user-id')}]`).click();
            } else {
                $(this).parent().find("span.check-user").html('<i class="fas fa-check"></i>');

                let user_incomes = $(user_income).clone();

                let block = $("<div>", {
                    "class": "row m-row--no-padding m-row--col-separator-xl",
                    "data-user-id": $(this).data('user-id'),
                    "style": 'padding-top: ' + (user_income_height / 2 - 15) + 'px',
                    "append": $("<div>", {
                        "class": "col-sm-12 col-md-12 col-xl-3 col-12 h-auto m-widget24 user-info d-flex justify-content-center h-100",
                        "style": "margin-bottom: 1px;",
                        "append": $("<img>", {
                            "src": $(this).data('user-src'),
                            "class": 'm--img-rounded table-schala-img my-auto',
                            "title": $(this).html()
                        })
                            .add("<span>", {
                                "class": "h5 my-auto",
                                "title": $(this).html(),
                                "text": $(this).html()
                            })
                            .add("<button>", {
                                "title": "Close",
                                "data-remove": $(this).data('user-id'),
                                "data-clicked": 0,
                                "class": "btn btn-sm bg-transparent remove-incomes",
                                "append": $("<i>", {"class": "fas fa-times text-white"}),
                                "on": {
                                    "click": function () {
                                        let elem = $(this).closest("div[data-user-id]");
                                        delete user_incomes_arr[parseInt(elem.data('user-id'))];
                                        elem.animate({
                                            paddingTop: 0,
                                            height: 0
                                        }, 'slow', 'linear', function () {
                                            elem.remove();
                                        });
                                        $(`a[data-user-id=${elem.data('user-id')}]`).removeClass("selected").data('clicked', 0).parent().find("span.check-user").empty();
                                    }
                                }
                            })
                    })
                        .add("<div>", {
                            "class": "col-xs-9 col-sm-12 col-md-12 col-xl-9 col-12 h-auto m-widget24",
                            "append": user_incomes
                        })
                })

                addUserIncomeBlock($('#user-income-year').val(), $('#user-income-month').val(), $(this).data('user-id'));

                $('#user-incomes').append(block.animate({
                    paddingTop: '20px',
                }, 'slow', 'linear'));
                block[0].scrollIntoView({block: "center", behavior: "smooth"});
                user_incomes_arr[$(this).data('user-id')] = $(this).data('user-id');

                $(this).addClass("selected").data('clicked', 1);

            }


            let accordion_body = $(this).closest("div.m-accordion__item-body");
            let userIds = accordion_body.find("a.selected[data-user-id][data-clicked]")
            let ids = accordion_body.find("a.check-all-users").data("user-ids").split(",");

            if (userIds.length === ids.length) {
                accordion_body.find(".check-all-users").attr('data-click-state', 1).find('i').addClass("checked");
            } else {
                accordion_body.find(".check-all-users").attr('data-click-state', 0).find('i').removeClass("checked");
            }


        }
    );

    function userIncomeBlockInit(year, month) {

        let url = window.location.href;
        url = url.includes('/site/index') ? url.replace('/site/index', '/site/income') : url + 'site/income';
        url = url.includes('#') ? url.replace('#', '') : url;

        $.ajax({
            url: url + '?year=' + year + '&month=' + month,
            success: function (result) {
                let income_data = result.income_data;
                for (var key in income_data) {
                    let income = $('#user-income').find('.' + key);
                    let count = income_data[key].count.replace(/\s+/g, '');
                    income.find('span.m-widget24__stats').html(income_data[key].price + '%');
                    income.find('div.progress-bar').animate({width: income_data[key].price + '%'}, 'slow', 'linear');
                    income.find('span.m-widget24__number').html(
                        +count > 99999
                            ? `<p class="income-count-first mr-1">${income_data[key].count} /</p><p class="income-count-last"> ${income_data[key].propertyDetailsCount}</p>`
                            : income_data[key].count + ' / ' + income_data[key].propertyDetailsCount
                    );
                }
            }
        });
    }

    function updateUserIncomeBlock(year, month) {
        for (let key in user_incomes_arr) {
            addUserIncomeBlock(year, month, user_incomes_arr[key])
        }
    }

    function addUserIncomeBlock(year, month, userId) {
        let url = window.location.href;
        url = url.includes('/site/index') ? url.replace('/site/index', '/site/income') : url + 'site/income';
        url = url.includes('#') ? url.replace('#', '') : url;

        $.ajax({
            url: url + '?year=' + year + '&month=' + month + '&userId=' + userId,
            success: function (result) {
                let income_data = result.income_data;
                let incomes = $('#user-incomes').find('div[data-user-id=' + userId + ']');
                for (let key in income_data) {
                    let income = incomes.find('.' + key);
                    let count = income_data[key].count.replace(/\s+/g, '');
                    income.find('span.m-widget24__stats').html(income_data[key].price + '%');
                    income.find('div.progress-bar').animate({width: income_data[key].price + '%'}, 'slow', 'linear');
                    income.find('span.m-widget24__number').html(
                        +count > 99999
                            ? `<p class="income-count-first mr-1">${income_data[key].count} /</p><p class="income-count-last"> ${income_data[key].propertyDetailsCount}</p>`
                            : income_data[key].count + ' / ' + income_data[key].propertyDetailsCount
                    );
                }
            }
        });
    }

    if ($('.m-subheader__title--separator').html() === 'Dashboard') {
        user_income = $('#user-income').html();
        userIncomeBlockInit(currentYear.getFullYear(), '');
        refreshSelectpicker();
        let url = window.location.href;
        url = url.includes('/site/index') ? url.replace('/site/index', '/site/rating') : url + 'site/rating';
        url = url.includes('#') ? url.replace('#', '') : url;
        $.ajax({
            url: url,
            success: function (result) {
                $('#user-rating').html(result);
            }
        });
    }

    $(".partner-row").on("click", function () {
        $(`tr[data-partner-id=${$(this).data("id")}]`).toggleClass("d-none");
    });
});
$(function () {
    $("#property-sequence").change(function () {

        let items = $("div[data-lightSlider=3] div[data-alphabet]");

        if ($(this).val() === "alphabet") {
            items.sort(function (a, b) {
                return +$(a).data('alphabet') - +$(b).data('alphabet');
            });
        } else if ($(this).val() === "fra") {
            items.sort(function (a, b) {
                return +$(b).data('fra') - +$(a).data('fra');
            });
        }

        items.appendTo('div[data-lightSlider=3]');
    });
});