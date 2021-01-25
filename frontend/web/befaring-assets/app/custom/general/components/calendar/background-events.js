"use strict";
var activeDate = null;
let activeData = [];
var token = $('meta[name="csrf-token"]').attr('content');
const calendar = $('#kt_calendar');
var KTCalendarBackgroundEvents = function () {

    for (let key in propertyEvens) {
        let event = propertyEvens[key];
        let id = event.id.toString().concat(event.start)
        activeData[id] = propertyEvens[key];
    }
    return {
        init: function () {
            calendar.fullCalendar({
                isRTL: KTUtil.isRTL(),
                header: {
                    left: 'title',
                    center: '',
                    right: 'prev,next'
                },
                lang: 'nb',
                locale: 'nb',
                firstDay: 1,
                contentHeight: 700,
                editable: false,
                eventLimit: 2, // allow "more" link when too many events
                views: {
                    timeGrid: {
                        eventLimit: 0  // adjust to 6 only for timeGridWeek/timeGridDay
                    }
                },
                navLinks: false,
                businessHours: false, // no weekends :'(
                timeZone: 'local',
                events: KTAppEvents,

                dayClick: function (date, allDay, jsEvent, view) {
                    $("img.event-check-mark").hide();
                    for (let key in activeData) {
                        if (activeData[key].start === date.format())
                            $(`input.event-checkbox[value=${activeData[key].id}]`).closest("label").find("img.event-check-mark").show();
                    }
                },

                eventClick: function (calEvent, jsEvent, view) {

                },

                addEvent: function (e) {

                },

                dayRender: function (date, element) {
                    if (!$.isEmptyObject(events)) {
                        $('[data-date="' + date.format() + '"]:not(.fc-past)').click(function () {
                            activeDate = date.format();

                            $('.modal-title').text(date.format('dddd, ll'));
                            $('#event-list').modal('toggle');

                            $('.event-checkbox')
                                .prop('checked', false)
                                .closest('label')
                                .removeClass('fc-event-solid-success');

                            calendar.fullCalendar('clientEvents', function (event) {
                                if (event.start.format() === date.format()) {
                                    $('.event-checkbox[value="' + event.id_event + '"]')
                                        .prop('checked', true)
                                        .closest('label')
                                        .addClass('fc-event-solid-success');
                                }
                            });
                        });
                    }
                },
                eventRender: function (event, element) {
                    if (element.hasClass('fc-day-grid-event')) {
                        element.prepend("<i class='close-on flaticon-close '></i>");
                        element.find(".close-on").click(function () {
                            $('#kt_calendar').fullCalendar('removeEvents', event._id);
                            delete activeData[event.id];
                            $.ajax({
                                url: '',
                                method: 'post',
                                headers: {
                                    'X-CSRF-Token': token
                                },
                                data: {remove: event.id_event, date: event.start.format()},
                                success: function (req) {

                                }
                            })
                        });
                        element.data('content', event.description);
                        element.data('placement', 'top');
                        KTApp.initPopover(element);
                    } else if (element.hasClass('fc-time-grid-event')) {
                        element.find('.fc-title').append('<div class="fc-description">' + event.description + '</div>');
                    } else if (element.find('.fc-list-item-title').lenght !== 0) {
                        element.find('.fc-list-item-title').append('<div class="fc-description">' + event.description + '</div>');
                    }
                }
            });
        }
    };
}();


jQuery(document).ready(function () {

    KTCalendarBackgroundEvents.init();
    $('.event-checkbox').change(function () {
        let eventId = $(this).val();
        let uniqueId = eventId.concat(activeDate);

        if ($(this).is(':checked')) {

            let event = events[eventId];
            let dat = {
                id: uniqueId,
                id_event: uniqueId,
                title: event.name,
                start: activeDate,
                description: event.description,
                className: event.classes
            };
            if (!activeData[uniqueId]) {

                activeData[uniqueId] = dat;
                calendar.fullCalendar('renderEvent', dat);
                $.ajax({
                    url: '',
                    method: 'post',
                    headers: {
                        'X-CSRF-Token': token
                    },
                    data: {data: JSON.stringify([$(this).val()]), date: activeDate},
                    success: function (req) {

                    }
                })
            } else {
                removeEvent(uniqueId);
            }

        } else {
            removeEvent(uniqueId);
        }

        $(this)
            .closest('label')
            .toggleClass('fc-event-solid-success');
        $('#event-list').modal("hide");
    });

    function removeEvent(uniqueId) {
        calendar.fullCalendar('clientEvents', function (event) {
            if (event.id === uniqueId) {
                calendar.fullCalendar('removeEvents', event.id);
                delete activeData[uniqueId];
                $.ajax({
                    url: '',
                    method: 'post',
                    headers: {
                        'X-CSRF-Token': token
                    },
                    data: {remove: uniqueId.charAt(0), date: event.start.format()},
                    success: function (req) {

                    }
                })
            }
        });
    }

    $('.fc-center').append(
        $('<button type="button" class="fc-button fc-state-default fc-corner-left fc-corner-right">SEND E-POST</button>')
            .on('click', function () {
                let message = "";
                for (let key in activeData) {
                    let date = new Date(activeData[key].start);
                    message = `${message} ${activeData[key].name ?? activeData[key].title}:  ${activeData[key].description ?? ""}\n ${moment(date).format('DD.MM.YYYY')} \n\r`;
                }

                $("#mail-response").empty();
                $(".help-block").empty();
                let textarea = $("textarea#mail-message");
                $('#send-email-modal').modal("show").find("textarea#mail-message").val(textarea.data("value") + message + textarea.data("from"));
            })
    );

    $('#mailing-form').submit(function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        $.ajax({
            url: window.Schala.baseUrl + '/befaring/mailing',
            data: $(this).serializeArray(),
            method: 'POST',
            dataType: 'json',
            success: function (result) {
                $('#mail-subject').next().html(result.subject || '');
                $('#mail-message').next().html(result.message || '');
                $('#mail-email').next().html(result.email || '');
                $('#mail-emails').next().html(result.emails || '');
                $('#mail-from').next().html((result.from ? result.from[0].replace("From", "E-post") : false) || '');

                if (result.success) {
                    $("#mail-response").html(`<div class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>${result.success}</div>`)
                        .find("div.alert").animate({opacity: '0'}, 5000, function () {
                        $(this).remove();
                    });
                }

                if (result.error) {
                    $("#mail-response").html(`<div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>${result.error}</div>`)
                        .find("div.alert").animate({opacity: '0'}, 5000, function () {
                        $(this).remove();
                    });
                }
            }
        });
    });
});