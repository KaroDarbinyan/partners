$(document).ready(function () {
    let success = '<div class="pop" id="lagre_ditt_sok_result"><form><div class="iTAKK"></div><div class="it_title">TAKK!</div><div class="it_info">Vi kontakter deg i løpet av kort tid</div></form></div>';
    let options = {
        padding: 0,
        helpers: {
            overlay: {
                locked: false,
                closeClick: false
            }
        }
    };

    let filter_xhr = false;

    (function ($) {
        let fc_val = $('.fc_val');

        fc_val
            .find('.header-div')
            .click(function () {
                $(this).toggleClass('is-open');

                $('.header-div').removeClass('opacityZero');
                $('.fc_values').removeClass('block_display');

                if ($(this).hasClass('is-open')) {
                    $(this)
                        .closest('.fc_val')
                        .children('.fc_values')
                        .addClass('block_display');
                }
            });

        $(document).on('click', function (e) {
            if ($(e.target).closest('.fc_val').length === 0) {
                fc_val.children('.header-div')
                    .removeClass('opacityZero is-open');

                fc_val.children('.fc_values')
                    .removeClass('block_display');
            }
        });
    })(jQuery);


    (function ($) {
        let buildLoadMoreButton = $("[data-building-load-more]");
        let buildingCardsParent = $("[data-building-cards]");
        let offsetCards = 16;
        buildLoadMoreButton.click(function (button) {
            let hiddenFilter = $("[data-hidden-filter]");
            let url = hiddenFilter.val() === '' ? '?offset=' + offsetCards : hiddenFilter.val() + '&offset=' + offsetCards;
            button.preventDefault();
            $.ajax({
                url: '/eiendommer/get-more-properties' + url,
                type: 'GET',
                success: function (data) {
                    buildingCardsParent.append(data.cards_html);
                    if (data.finish_cards_load === false) {
                        offsetCards += 16;
                    } else {
                        buildLoadMoreButton.html("Ingen mer");
                        buildLoadMoreButton.attr("disabled", true);
                    }
                },
                error: function () {

                },
            });
        })
    })(jQuery);


    (function ($) {

        let queryParams = new URLSearchParams(location.search);
        let entries = queryParams.entries();
        let cleaners = [];

        function addCleaner(el, key = null, val = null) {
            cleaners.push({
                inputName: key || el.prop('name'),
                inputValue: val || el.val(),
                item: el
            })
        }

        $('input[name="area[]"]:checked, input[name="parent_area[]"]:checked').each(function () {
            if (!$(this).val().includes('Oslo')) {
                addCleaner($(this));
            }
        });

        for (let pair of entries) {
            let key = pair[0];
            let val = pair[1];

            $('[data-to-name="' + key + '"], [data-from-name="' + key + '"], input[name="' + key + '"][value="' + val + '"]:checked')
                .each(function () {
                    addCleaner($(this), key, val);
                });
        }

        if (cleaners.length > 0) {
            updateCleaners(cleaners);
        }

        let ionRangeSlider = $('.js-range-slider-decoration').ionRangeSlider({
            skin: 'flat'
        });

        ionRangeSlider.on('change', function () {
            let input = $(this);

            $('#dwellingform-' + input.prop('name') + '_from')
                .val(input.data('from'));

            $('#dwellingform-' + input.prop('name') + '_to')
                .val(input.data('to'));
        });

        let filterForm = $(".filter_form");
        let rangeSlider = $(".js-range-slider");
        let filterFormInput = $(".filter_form :input:not(.js-range-slider)");

        rangeSlider.ionRangeSlider({
            onFinish: function (data) {
                onFilterEvent();
            }
        });

        filterFormInput.change(
            function (e) {
                onFilterEvent();
            }
        );

        $(document).on('click', '.pagination a', function (event) {
            let hash = $(this).prop('hash') || null;

            if (hash && hash.includes('#ajax')) {
                event.preventDefault();

                let page = $(this).data('page') + 1;

                if (!$(this).closest('li').is('.active')) {
                    onFilterEvent(['page='.concat(page)]);
                }
            }
        });

        // on click childes
        $(document).on('click', '.omrade-parent', function () {
            let childes = $('[data-parent-name="' + $(this).data('omrade-name') + '"]').find('input');
            let checked = $(this).find('div.jq-checkbox.styler').hasClass('checked');
            if (checked) {
                childes.each(function () {
                    $(this).prop('checked', true).parent().addClass('checked');
                });
            } else {
                childes.each(function () {
                    $(this).prop('checked', false).parent().removeClass('checked');
                });
            }
            $(this).find('input').trigger('change');
        });

        $(document).on('click', '.omrade-child', function () {

            let data = [];
            let omrade_childes = $('[data-parent-name="' + $(this).data('parent-name') + '"]');
            let active_childes = omrade_childes.find('input:checked');
            let childes = omrade_childes.find('input');
            let parent = $(this).closest('ul').prev().find('input');
            let checked = !$(this).children('div.jq-checkbox.styler').hasClass('checked')
            if (checked) {
                if ((childes.length - 1) === active_childes.length) {
                    childes.each(function () {
                        $(this).prop('checked', false).parent().removeClass('checked');
                    });
                    parent.prop('checked', true).parent().addClass('checked');
                    $(this).find('input').prop('checked', true).parent().addClass('checked');
                    data = [$(this).find('input').prop('name') + '=' + $(this).find('input').val()];
                    $(this).find('input').trigger('change');
                }
            } else {
                active_childes.each(function () {
                    data.push($(this).prop('name') + '=' + $(this).val());
                });
            }

            if (window.location.pathname === '/eiendommer') {
                onFilterEvent([], data);
            }
        });

    })(jQuery);

    function onFilterEvent(params = []) {
        let filterData = params;
        const cleaners = [];

        $(".filter_form .has-filters :input:not(.omrade-p, .omrade-c)").each(function () {
            let input = $(this);
            switch (input.prop('type')) {
                case 'hidden': {
                    if (input.hasClass('js-range-slider')) {
                        if (input.data('min') !== input.data('from')) {
                            cleaners.push({
                                'inputName': input.data('from-name'),
                                'inputValue': input.data('from'),
                                'item': input
                            });
                            filterData.push(input.data('from-name') + '=' + input.data('from'));
                        }
                        if (input.data('max') !== input.data('to')) {
                            cleaners.push({
                                'inputName': input.data('to-name'),
                                'inputValue': input.data('to'),
                                'item': input
                            });
                            filterData.push(input.data('to-name') + '=' + input.data('to'))
                        }
                    }
                }
                    break;
                case 'checkbox': {
                    if (input.prop('checked')) {
                        cleaners.push({
                            'inputName': input.prop('name'),
                            'inputValue': input.val(),
                            'item': input
                        });
                        filterData.push(input.prop('name') + '=' + input.val());
                    }
                }
                    break;
            }
        });


        let dat = [];
        $(".filter_form .has-filters input.omrade-p").each(function () {
            let input = $(this);
            let parent = $(this).parent();
            let childes_wrapper = input.closest('label').next();
            let childes = childes_wrapper.find('input');
            let active_childes = childes_wrapper.find('input:checked');

            if (parent.hasClass('checked') && active_childes.length === 0) {
                var arr = [];
                childes.each(function () {
                    arr.push($(this).val());
                    $(this).prop('checked', true).parent().addClass('checked');
                });
                dat.push($(this).prop('name') + '[' + $(this).val() + ']=' + arr.toString());
                cleaners.push({
                    'inputName': input.prop('name'),
                    'inputValue': input.val(),
                    'item': input
                });
            } else if (parent.hasClass('checked')) {
                var arr = [];
                active_childes.each(function () {
                    arr.push($(this).val());
                    $(this).prop('checked', true).parent().addClass('checked');
                    cleaners.push({
                        'inputName': $(this).prop('name'),
                        'inputValue': $(this).val(),
                        'item': $(this)
                    });
                });
                dat.push($(this).prop('name') + '[' + $(this).val() + ']=' + arr.toString());
            } else if (!parent.hasClass('checked')) {
                childes.each(function () {
                    $(this).prop('checked', false).parent().removeClass('checked');
                });
            }
        });

        let filterDates = $.merge(dat, filterData);

        generateFilterUrlV2(filterDates, cleaners);
    }

    function generateFilterUrlV2(filterData = [], cleaners = false) {
        let href = '';
        if (filterData.length > 0){
            href += '?' + filterData.join('&');
        }
        filterRequest(href,cleaners);
    }

    function generateFilterUrl(url = '') {
        let filterData = [];
        filterData = getCheckboxParams('homeType', filterData);
        filterData = getCheckboxParams('roomsCounts', filterData);

        let queryString = Object.keys(filterData).map(
            key => key + '=' + filterData[key]
        ).join('&');

        let href = '';
        if (queryString) {
            href += '?' + queryString;
            if (url !== '') {
                href += '&' + url;
            }
        } else if (url !== '') {
            href += '?' + url;
        }

        filterRequest(href);

    }

    function filterRequest(href = '', cleaners = false){
        const buildLoadMoreButton = $("[data-building-load-more]");

        let archives = $('#is_archives').val();

        if (archives !== '') {
            archives = 'archives=' + archives;
        }

        href += (href === '' ? '?' : '&') + archives;

        history.pushState(null, document.title, href);

        if (filter_xhr !== false) {
            filter_xhr.abort();
        }
        $("[data-hidden-filter]").val(href);

        filter_xhr = $.ajax({
            url: '/eiendommer/get-more-properties' + href,
            type: 'GET',
            success: function (data) {
                $("[data-building-cards]").html(data.cards_html);
                $("[data-filtered-count]").html(data.cards_count);
                data.finish_cards_load === false
                    ? buildLoadMoreButton.html("Vis mer").attr("disabled", false)
                    : buildLoadMoreButton.html("Ingen mer").attr("disabled", true);

                updateCleaners(cleaners);
            },
            error: function () {

            },
            complete: function (xhr,str) {
                filter_xhr = false;
            }
        });

    }

    /**
     * @function
     * @param cleaners {boolean|Array}
     * */
    function updateCleaners(cleaners = false) {
        console.log(cleaners);


        const cleanersDom = $('.filter-cleaners').html('');
        if (Array.isArray(cleaners)) {
            cleaners.forEach(function (el) {
                let cleanBtn = $('<button type="button"></button>').addClass('btn btn-info');
                switch (el.item.prop('type')) {
                    case 'checkbox': {
                        cleanBtn
                            .html(el.item.data('cleaner-title') + ':&nbsp;' + el.inputValue)
                            .append($('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>'))
                            .on('click', function (e) {
                                $(this).remove();
                                el.item.prop('checked', false).trigger('change');
                            });
                        cleanersDom.append(cleanBtn);
                    } break;
                    case  'hidden': {
                        if (el.item.hasClass('js-range-slider')) {
                            let updates = [];
                            let btn_title = '';
                            if (el.inputName === el.item.data('from-name')) {
                                btn_title = el.item.data('cleaner-from');
                                updates['from'] = el.item.data('min');
                            }
                            if (el.inputName === el.item.data('to-name')) {
                                btn_title = el.item.data('cleaner-to');
                                updates['to'] = el.item.data('max');
                            }
                            btn_title += ':&nbsp;' + new Intl.NumberFormat("ru-RU").format(el.inputValue);
                            if (el.inputName === el.item.data('from-name') && el.item.data('from') === el.item.data('max')) {
                                btn_title += '+';
                            }
                            cleanBtn.html(btn_title)
                                .append($('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>'))
                                .on('click', function (e) {
                                    el.item.data('ionRangeSlider').update(updates);
                                    $(this).remove();
                                    onFilterEvent();
                                });
                            cleanersDom.append(cleanBtn);
                        }
                    } break;
                }
            });
            if (cleanersDom.find('.btn').length > 0){
                let cleanBtn = $('<button type="button"></button>').addClass('btn btn-info')
                    .html('Fjern alt').append($('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>'))
                    .on('click',function (e) {
                        e.preventDefault();
                        location.href = '/eiendommer';
                    });
                cleanersDom.append(cleanBtn);
            }
        }
    }

    function getCheckboxParams(checkboxGroup, filterDataArray) {
        let type_values = [];
        let selector = "input[name='" + checkboxGroup + "[]']:checked";

        $(selector).each(function () {
            type_values.push($(this).val());
        });

        if (type_values.length) {
            filterDataArray[checkboxGroup] = type_values.join(',');;
        }
        return filterDataArray;
    }

    (function ($) {
        $("#post-search").click(function (e) {
            e.preventDefault();
            $.ajax({
                url: '/company/office-search?postNumber=' + $(".vc_body :input").val(),
                type: 'GET',
                success: function (res) {
                    if (res.type === "post_number" || res.type === "all_post_number") {
                        location.href = res.url;
                    } else {
                        $('input.styler').css({'border-bottom': '1px solid red', 'color': 'red'});
                    }
                },
                error: function () {
                }
            });
        });
    })(jQuery);


    $('.forms').submit(function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        let button = $(this).find('button[type="submit"]')
            .prop('disabled', true);

        let url = $(this).attr('id').split('-')[0];
        let formId = $('#' + url + '-form');

        $.ajax({
            url: '/forms/contact',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (res) {
                if (res.success) {
                    formId.find('.help-block').html('');
                    $('.VERDIVURDERING').removeClass('active');
                    $('#lagre_ditt_sok_result').remove();

                    if (res.message) {
                        $(document.body)
                            .append('<div class="pop" id="lagre_ditt_sok_result"><form><div class="iTAKK"></div><div class="it_title">TAKK!</div><div class="it_info">'+res.message+'</div></form></div>');
                    } else {
                        $(document.body).append(success);
                    }

                    formId.find('.popup').click().fancybox(options);
                    formId.find('input[type=text],textarea').val('');

                    // is-checked

                    formId.find('.jq-checkbox').each(function () {
                       if (!$(this).is('.is-checked')) {
                           $(this).removeClass('checked');
                       }
                    });

                    formId.find('input:checkbox').each(function () {
                        if (!$(this).is('.is-checked')) {
                            $(this).prop('checked', false);
                        }
                    });

                    // formId.find('.jq-checkbox').removeClass('checked');
                    //formId.find('input:checkbox').prop('checked', false);

                    if (url === 'salgsoppgave' && $('a.doc-link').length > 0){
                        $('a.doc-link').get(0).click();
                    }
                    if (url === 'boligvarsling'){
                        resetBoligvarslingForm();
                    }
                } else {
                    formId.find('.help-block').html('');
                    formId.find('#forms-property_type-error').html(res.property_type);
                    formId.find('#forms-name').next().html(res.name);
                    formId.find('#forms-email').next().html(res.email);
                    formId.find('#forms-phone').next().html(res.phone);
                    formId.find('#forms-post_number').next().html(res.post_number);
                    formId.find('#forms-i_agree').parent().parent().next().html(res.i_agree);
                }

                button.prop('disabled', false);
            }
        });
    });

    $('#boligvarsling-form').submit(function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        let form = $(this);

        let button = form.find('button[type="submit"]')
            .prop('disabled', true);

        let url = $(this).attr('id').split('-')[0];

        $.ajax({
            url: '/dwelling/form',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json'
        })
            .done(function (response) {
                if (response.success) {
                    form.find('.help-block').html('');
                    $('#lagre_ditt_sok_result').remove();

                    if (response.message) {
                        $(document.body)
                            .append('<div class="pop" id="lagre_ditt_sok_result"><form><div class="iTAKK"></div><div class="it_title">TAKK!</div><div class="it_info">'+response.message+'</div></form></div>');
                    } else {
                        $(document.body).append(success);
                    }
                    
                    form.find('.popup')
                        .click()
                        .fancybox(options);

                    form.find('input[type=text]').val('');

                    form.find('.jq-checkbox').each(function () {
                        if (!$(this).is('.is-checked')) {
                            $(this).removeClass('checked');
                        }
                    });

                    form.find('input:checkbox').each(function () {
                        if (!$(this).is('.is-checked')) {
                            $(this).prop('checked', false);
                        }
                    });

                    resetBoligvarslingForm();
                } else {
                    form.find('.help-block').html('');
                    form.find('#dwellingform-property_type-error').html(response.property_type);
                    form.find('#dwellingform-name').next().html(response.name);
                    form.find('#dwellingform-email').next().html(response.email);
                    form.find('#dwellingform-phone').next().html(response.phone);
                    form.find('#dwellingform-subscribe').parent().parent().next().html(response.subscribe);
                    form.find('#dwellingform-agree').parent().parent().next().html(response.agree);
                }
            })
            .always(function () {
                button.prop('disabled', false);
            })
    });

    /**
     * /BOLIGVARSLING page codes block START
     * */
    (function ($) {
        let rangeSliders = $(".range-slider").ionRangeSlider();
        const fItemsContainer = $('.selected-types');


        $('body').on('change', '.field-items .js-property-type', function (e) {
            const itemVal = $(this).val();

            if (itemVal === '' || itemVal === null) {
                return;
            }

            let data = {
                property_type: [],
                region: {},
                rooms: []
            };

            fItemsContainer.html('');

            $('.js-property-type :input:not(.omrade-p, .omrade-c):checked').each(function () {
                let filedItem = $('<button type="button">')
                    .addClass('btn btn-info form-field')
                    .attr('data-value', $(this).val())
                    .html($(this).val())
                    .append($('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>'))
                    .on('click', function (e) {
                        $('.' + $(this).data('value'))
                            .prop('checked', false)
                            .closest('.jq-checkbox')
                            .removeClass('checked');
                        $(this).remove();
                        preparePropertyTypes();
                    });
                fItemsContainer.append(filedItem);
                let name = $(this)
                    .prop('name')
                    .replace('[]', '');

            let values = $('input[name="' + name + '[]"]:checked')
                .map(function () {
                    return $(this).val();
                })
                .get();

            $('input[name="Boligvarsling[' + name + ']"]')
                .val(JSON.stringify(values));
            data[name].push($(this).val());

                preparePropertyTypes();
            });

            $('.js-property-type.omrade-p :input:checked').each(function () {
                let childes = $('[data-parent-name="' + $(this).val() + '"]').find('input:checked');
                let dataKey = $(this).prop('name').replace('[]', '');
                let parentName = $(this).val();
                if (data[dataKey][parentName] === undefined) {
                    data[dataKey][parentName] = [];
                }

                if (childes.length > 0) {
                    childes.each(function () {
                        let filedItem = $('<button type="button">')
                            .addClass('btn btn-info form-field')
                            .attr('data-value', $(this).data('cleaner-title'))
                            .attr('data-parent-value', parentName)
                            .html(parentName + ' : ' + $(this).val())
                            .append($('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>'))
                            .on('click', function (e) {
                                $('[data-cleaner-title="' + $(this).data('value') + '"]')
                                    .prop('checked', false)
                                    .closest('.jq-checkbox')
                                    .removeClass('checked');
                                let value = $(this).data('value').split('-')[0];
                                $(this).remove();
                                if (fItemsContainer.find('button[data-parent-value=' + value + ']').length === 0) {
                                    let parent = $('input[value=' + value + ']');
                                    parent.prop('checked', false).trigger('change');
                                    delete data[parent.prop('name').replace('[]', '')].value;
                                }
                                preparePropertyTypes();
                            });
                        fItemsContainer.append(filedItem);

                        data[dataKey][parentName].push($(this).val());

                        preparePropertyTypes();
                    });
                } else {
                    let filedItem = $('<button type="button">')
                        .addClass('btn btn-info form-field')
                        .attr('data-value', parentName)
                        .html(parentName)
                        .append($('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>'))
                        .on('click', function (e) {
                            $('.' + $(this).data('value'))
                                .prop('checked', false)
                                .closest('.jq-checkbox')
                                .removeClass('checked');
                            $(this).remove();
                            preparePropertyTypes();
                        });
                    fItemsContainer.append(filedItem);

                    data[dataKey][parentName] = null;

                    preparePropertyTypes();
                }
            });

            for (let k in data) {
                $('input[name="Forms[' + k + ']"]')
                    .val(JSON.stringify(data[k]));
            }

        });
    })(jQuery);

    function preparePropertyTypes(){
        const arr = [];
        let types = $('.selected-types button.form-field');

        if (types.length > 0){
            types.click(function () {
                $('.field-items .js-property-type').change();
            });
            types.each(function () {
                arr.push($(this).data('value'));
            });
        }

        let data = arr.length ? JSON.stringify(arr) : '';

        //$('#dwellingform-property_type').val(data);
    }

    function resetBoligvarslingForm(){
        let form = $('#boligvarsling-form');

        form.find('.selected-types').empty();

        $('#dwellingform-property_type').val('');

        preparePropertyTypes();

        $('.range-slider').each(function () {
            $(this).data('ionRangeSlider').update({
                'to': $(this).data('max'),
                'from': $(this).data('min')
            });
        })
    }

    (function ($) {
        $('.popup').click(function () {
            $('form').trigger('reset');
        });

        //$('form').find('input[id="forms-phone"]').keyup(function (e) {
        $(document).on('keyup', '#forms-phone', function (e) {
            var parentForm = $(this).closest('form');
            var str = '+ 0123456789';
            let phone = $(this).val();

            if (phone.length === 8 || phone.length === 11) {
                phone = phone.substr(0, 3) === '+47' ? phone : '+47' + phone;
                if (phone.length === 11) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    $.ajax({
                        url: '/forms/contact',
                        type: 'POST',
                        data: {phone: phone},
                        dataType: 'JSON',
                        success: function (result) {
                            if (result.code === undefined) {
                                let forms_name = result.key !== undefined ? result.firstName : ucfirst(result.firstName) + ' ' + ucfirst(result.lastName);
                                parentForm.find('input#forms-name').val(forms_name);
                                parentForm.find('input#forms-post_number').val(result.postalCode);
                            }
                        }
                    });
                }
            }
        });

        function ucfirst(str) {
            var result = '';
            var arr = str.split(' ');
            for (var i = 0; i < arr.length; i++) {
                result += arr[i].charAt(0).toUpperCase() + arr[i].substr(1).toLowerCase() + ' ';
            }
            return result;
        }
    })(jQuery);


    /**
     * /BOLIGVARSLING page codes block END
     * */


    // function deltaOrderPush() {
    //     _d7.push({
    //         action:"order",
    //         orderId:"",           //PASS ALONG UNIQUE ORDER ID OR LEAVE AS IS
    //         totalPrice:"",        //PASS ALONG ORDER AMOUNT OR LEAVE AS IS
    //         currency:"",          //PASS ALONG ORDER CURRENCY OR LEAVE AS IS
    //         items:[],             //PASS ALONG ITEMS OR PRODUCTS AS AN ARRAY, PLEASE SEE IMPLEMENTATION GUIDE, OR LEAVE AS IS
    //         pageId:"YOUR_PAGE_ID" //PLEASE MAKE NO CHANGES TO PAGEID UNLESS INSTRUCTED OTHERWISE
    //     });
    // }

    function appendClouds() {
        if($('.clouds').length || !$('body.page-main').length) {
            return false;
        }

        $('body').append('<div class="clouds"></div>');
        $('.clouds').append('<div class="clouds-1"></div>');
        $('.clouds').append('<div class="clouds-2"></div>');
        $('.clouds').append('<div class="clouds-3"></div>');
    }
    appendClouds()
});
