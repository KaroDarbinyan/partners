let i = 0;
$(function() {
    let host = $('meta[name="socket-host"]').attr('content');
    let sockedTime = $('meta[name="socket-time"]').attr('content');
    let socket = new WebSocket(host);
    let runSocked = false;
    socket.onerror = function(e) {
        runSocked = false;
    };
    socket.onmessage = function(e) {
        console.log(sockedTime);
        console.log(host);
        let clone = $('.alter-message').html();
        i++;
        let classSuccess = 'alter-message-'+i;
        $('.main-content-pages').prepend('<div class="'+classSuccess+'">'+clone+'</div>');
        let cloneHtml = $('.'+classSuccess);
        cloneHtml.addClass('alert-message-broker');
        cloneHtml.find('.context').html(e.data);
        cloneHtml.css('top', i*0.1+'%');
    };
    socket.onopen = function(e) {
        runSocked = true;
        if(runSocked === true) {
            let intervalSocket = setInterval(function () {
                socket.send('test');
                if(!runSocked) {
                    clearInterval(intervalSocket);
                }
            }, sockedTime)
        }
    };


});

$(function () {

    $(document).on('click', '.js-reset-deputy', function (event) {
        $.post({
            url: window.Schala.baseUrl + '/department/store-deputy',
            data: {user_id: $(this).data('user-id')},
            type: 'DELETE'
        }).done(function (response) {
            if (response.success) {
                $('.deputy-block-content').html(response.html);
            }
        })
    });

    $(document).on('submit', '.js-director-deputy', function (event) {
        event.preventDefault();

        $.post(window.Schala.baseUrl + '/department/store-deputy',
          $(this).serialize()
        ).done(function (response) {
            if (response.success) {
                $('.deputy-block-content').html(response.html);
            }
        })
    });


    $('#city').easyAutocomplete({
        cssClasses: 'properties-filter',
        adjustWidth: false,
        requestDelay: 250,

        url: function (text) {
            return window.Schala.baseUrl + '/search-locations?q=' + text;
        },

        listLocation: 'locations',
        getValue: 'name',

        list: {
            onChooseEvent: function () {
                const { latitude, longitude } = $('#city').getSelectedItemData();

                let radius = $('#filter_map_circle_radius').val() || 1000;

                let coordinates = $('#filter_map_coordinates');

                if (coordinates.length) {
                    coordinates.val(latitude + ';' + longitude + ';' + radius).change();
                }

                $('#filter_map_latitude').val(latitude).change();
                $('#filter_map_longitude').val(longitude).change();

                $('#filter_map_enable')
                  .prop('checked', true)
                  .trigger('change');
            }
        }
    });

    $(document).on('click', '.js-close-lead-short-info', function (e) {
        e.preventDefault();

        $(this)
            .parents('.table-responsive')
            .remove();
    });

    $('.m-menu__link[href="'+location.pathname+'"]').each(function () {
        $(this)
            .closest('li')
            .addClass('m-menu__item--active')
            .closest('[m-menu-submenu-toggle]')
            .addClass('m-menu__item--active m-menu__item--open');
    });

    $('.js-delete-confirm').click(function (event) {
        event.preventDefault();

        let self = this;

        swal({
            title: 'Er du sikker?',
            text: "Du vil ikke kunne tilbakestille dette!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ja, slett!'
        }).then((result) => {
            if (result.value) {
                $.get($(self).data('action'));
                $(self).closest('.news-card').remove();

                swal(
                    'Slettet!',
                    'Filen din er slettet',
                    'success'
                )
            }
        });
    });

    $('.js-update-property').click(function (event) {
        event.preventDefault();

        let button = $(this);

        $.get(button.prop('href'), function (response) {
            console.log(response)
        })
    });

    $('.js-sp-boost').click(function (event) {
        event.preventDefault();

        let self = $(this);

        swal({
            title: 'Har du husket å postere kostnad i WebMegler.',
            input: 'radio',
            inputOptions: window.property_boosts,
            inputValidator: (value) => {
                if (!value) {
                    return 'Du må velge noe'
                }
            },
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ja',
            cancelButtonText: 'Nei'
        }).then((result) => {
            if (result.value) {
                let url = new URL(self.prop('href'));
                let search_params = url.searchParams;
                search_params.append('boostType', result.value);
                url.search = search_params.toString();
                $.getJSON(url.toString(), function (response) {
                    swal('', response.message, response.success ? 'success' : 'error');
                    if (response.pd_boost) {
                        $("#pd-boost").empty();
                        for (let key in response.pd_boost) {
                            $("#pd-boost").append(`<span class="badge badge-warning mr-1">${key} ${response.pd_boost[key]}</span>`);
                        }
                    }

                });
            }
        });
    });

    const scrollbar = document.querySelector('.perfect-scrollbar');
    if (scrollbar !== null) {
        const perfectScrollbar = new PerfectScrollbar(scrollbar);
    }

    //
    // $('#ev-api-form').submit(function (e) {
    //     e.preventDefault();
    //     $.ajax({
    //         url: '/admin/eiendomsverdi/index',
    //         data: $(this).serializeArray(),
    //         dataType: 'JSON',
    //         method: 'POST',
    //         success: function (result) {
    //             window.open(result.url,'_blank');
    //         }
    //     });
    // });


    $('[data-range-key]').on('click', function () {
        if ($(this).attr('data-range-key') === 'Today') {
            $('.date-form').find('input[name = "label"]').val('Today');
            $('.date-form').find('input[name = "start"]').val(moment().startOf('days').unix());
            $('.date-form').find('input[name = "end"]').val(moment().unix());
            $.ajax({
                url: window.Schala.baseUrl + '/site/set-session',
                data: $('.date-form').serializeArray(),
                success: function () {
                    window.location.reload();
                }
            });
        }
    });

    $('#send-sms-form').submit(function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        let serializeArray = $(this).serializeArray();
        serializeArray.push({name: "lead_id", value: $(this).data("lead_id")});
        $.ajax({
            url: $(this).prop("action"),
            data: serializeArray,
            method: 'POST',
            dataType: 'json',
            success: function (result) {
                if (result.success === undefined) {
                    $('#sms-message').next().html('');
                    $('#sms-phone').next().html('');
                    $('#sms-message').next().html(result.message);
                    $('#sms-phone').next().html(result.phone);
                } else {
                    $('#sms-message').next().html('');
                    $('#sms-phone').next().html('');
                    $('#sms-message').val('');
                    $('#open-modal').click();
                }
            }
        });
    });

    $('#mailing-form').submit(function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        let serializeArray = $(this).serializeArray();
        serializeArray.push({name: "lead_id", value: $(this).data("lead_id")});
        $.ajax({
            url: window.Schala.baseUrl + '/site/mailing',
            data: serializeArray,
            method: 'POST',
            dataType: 'json',
            success: function (result) {
                console.log(result);

                let subject = $('#mail-subject');
                let message = $('#mail-message');
                let email = $('#mail-email');

                subject.next().html('');
                message.next().next().html('');
                email.next().html('');

                if (!result.success) {
                    subject.next().html(result.subject || '');
                    message.next().next().html(result.message || '');
                    email.next().html(result.email || '');

                    if (result.error) {
                        swal({
                            title: '',
                            text: result.error,
                            type: 'error',
                            confirmButtonClass: 'btn btn-secondary m-btn m-btn--wide'
                        })
                    }
                } else {
                    $('#open-modal').click();
                }
            }
        });
    });

    if ($('#open-modal').html() !== '') {
        $('#open-modal').click();
    }

    $('.is-clients-create').click(function (e) {
        e.preventDefault();

        let form = $(this).closest('form');
        let formData = form.serializeArray();

        formData.push({
            name: $(this).attr('name'),
            value: $(this).val()
        });

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                console.log('Response', response);
                if (response.success) {
                    form.find('.help-block').html('');
                    form.resetForm();

                    location.href = response.url;
                } else {
                    form.find('.help-block').html('');
                    form.find('#lead-name').next().html(response.name);
                    form.find('#lead-email').next().html(response.email);
                    form.find('#lead-phone').next().html(response.phone);
                    form.find('#lead-i_agree').parent().next().html(response.i_agree);
                    form.find('#lead-post_number').next().html(response.post_number);
                    form.find('#lead-type').next().html(response.type);
                }
            }
        });
    });

    $('#endre-passord-form').submit(function (e) {
        e.preventDefault();
        let form = $(this);
        $.ajax({
            url: window.location.pathname,
            type: 'POST',
            data: form.serializeArray(),
            dataType: 'JSON',
            success: function (response) {
                $('.help-block').html('');
                if (response === "success") {
                    $("#open-modal").click();
                    form.resetForm();
                } else {
                    $('#user-old_password').next().html(response.old_password);
                    $('#user-new_password').next().html(response.new_password);
                    $('#user-repeat_password').next().html(response.repeat_password);
                }
            }
        });
    });

    $(".spboost-price").focus(function () {
        if ($(this).val() === "0") $(this).val("");
        $(this).blur(function () {
            if ($(this).val() === "") $(this).val("0");
        });
    });

    $('.markedspakke-form').submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let serializeArray = form.serializeArray();
        serializeArray.push({name: "id", value: form.data("sp_boost_id")});
        $.ajax({
            url: window.location.pathname,
            type: 'POST',
            data: serializeArray,
            dataType: 'JSON',
            success: function (response) {
                $('.help-block').html('');
                if (response === "success") {
                    $("#open-modal").click();
                } else {
                    form.find("input.spboost-price").next().html(response.price)
                }
            }
        });
    });

    $('#topplister-data-select, #topplister-type-select').change(function () {
        var data = $('#topplister-data-select').val();
        var type = $('#topplister-type-select').val();
        window.location.replace(window.location.pathname + '?type=' + type + '&data=' + data);
    });


    tinymce.init({
        selector: '.is-tinymce',
        setup: function (editor) {
            editor.on('change', function () {
                tinymce.triggerSave();
            });
        }
    });

});


$(function () {

    let left = $("#signatur-left_content");
    let right = $("#signatur-right_content");
    let canvas = $("#canvas").get(0);
    let ctx = canvas.getContext('2d');
    canvasInit();

    $('#generate-signatur').click(function (e) {
        e.preventDefault();

        $.ajax({
            url: window.location.pathname,
            type: "GET",
            data: $('#signatur-form').serializeArray(),
            success: function (response) {
                $("#signatur-message").html(response);
                $("#open-modal").click();
            }
        });
        canvasInit();

    });

    $("#signatur-theme").change(function (e) {
        canvasInit();
    });


    function str_split(text) {
        let lines = [];
        $.each(text.split(/\n/), function (i, line) {
            lines.push(line ? line : "");
        });
        return lines;
    }

    function canvasInit() {
        let theme = $("#signatur-theme");
        let logo = $("#signatur_logo").get(0);
        let percent = 70 * 100 / logo.height;
        logo.height = 70;
        logo.width = logo.width * percent / 100;
        canvas.width = 650;
        canvas.crossOrigin = "Anonymous";
        canvas.height = 134;
        ctx.beginPath();
        ctx.rect(0, 0, canvas.width, canvas.height);
        ctx.fillStyle = theme.children("option:selected").data("background");
        ctx.fill();
        ctx.fillStyle = theme.children("option:selected").data("color");
        if (logo.width > 0) {
            ctx.drawImage(logo, 20, (canvas.height - logo.height) / 2, logo.width, logo.height);
        }
        setTimeout(function () {
            writeText();
        }, 1000);
    }

    function writeText() {

        let leftY = 20, rightY = 20;

        $.each(str_split(left.val()), function (i, line) {
            ctx.font = (i === 0) ? "bold 10pt Futura-PT-Book" : "10pt Futura-PT-Book";
            if (ctx.measureText(line).width > 200) {
                let arr = line.split(" ");
                let tempStr = "";
                $.each(arr, function (i, subLine) {
                    tempStr = tempStr + subLine + " ";
                    if (tempStr.length > 20) {
                        tempStr.replace(subLine, "");
                        ctx.fillText(tempStr, 220, leftY);
                        leftY += 14;
                        tempStr = "";
                    }
                });
                ctx.fillText(tempStr, 220, leftY);
                leftY += 14
            } else {
                ctx.fillText(line, 220, leftY);
                leftY += 14
            }

        });

        $.each(str_split(right.val()), function (i, line) {
            ctx.font = "10pt Futura-PT-Book";
            if (ctx.measureText(line).width > 200) {
                let arr = line.split(" ");
                let tempStr = "";
                $.each(arr, function (i, subLine) {
                    tempStr = tempStr + subLine + " ";
                    if (tempStr.length > 20) {
                        tempStr.replace(subLine, "");
                        ctx.fillText(tempStr, 440, rightY);
                        rightY += 14;
                        tempStr = "";
                    }
                });
                ctx.fillText(tempStr, 440, rightY);
                rightY += 14
            } else {
                ctx.fillText(line, 440, rightY);
                rightY += 14;
            }
        });

        let download = $("#download-signatur");
        download.attr("href", canvas.toDataURL()).attr("download", `${download.data("user-name")}_signatur.png`);
    }
});

$(function () {

    let dropdown = $('.m-dropdown');

    $(document).mouseup(e => {
        if (dropdown.hasClass("m-dropdown--open")
            && !e.target.closest("a.m-nav__link.m-dropdown__toggle")
            && !e.target.closest("div.m-dropdown__wrapper.sc-kontorvelger")) {
            $('.m-nav__link-icon').click();
        }
    });
});
