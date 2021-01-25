moment.locale('nb');

/**
 * Norwegian translation for bootstrap-datetimepicker
 * Rune Warhuus <rune@dinkdonkd.no>
 */
;(function ($) {
  $.fn.datetimepicker.dates['no'] = {
    days: ["Søndag", "Mandag", "Tirsdag", "Onsdag", "Torsdag", "Fredag", "Lørdag", "Søndag"],
    daysShort: ["Søn", "Man", "Tir", "Ons", "Tor", "Fre", "Lør", "Søn"],
    daysMin: ["Sø", "Ma", "Ti", "On", "To", "Fr", "Lø", "Sø"],
    months: ["Januar", "Februar", "Mars", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Desember"],
    monthsShort: ["Jan", "Feb", "Mar", "Apr", "Mai", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Des"],
    today: "I Dag",
    suffix: [],
    meridiem: []
  };
}(jQuery));

/* begin:: TABLE */

var DatatablesSearchOptionsColumnSearch = function () {
  $.fn.dataTable.Api.register("column().title()", function () {
    return $(this.header()).text().trim()
  });
  return {
    init: function () {
      var t;
      t = $("#m_table_1").DataTable({
        responsive: !0,
        lengthMenu: [1, 2, 25, 50, 100, 250],

        pageLength: 25,
        language: {
          lengthMenu: "Display _MENU_"
        },
        searchDelay: 200,
        // bPaginate: false,
        //bInfo: false,
      });
      t.order([1, 'desc']).draw();
    }
  }
}();

/* end:: TABLE */


/* begin:: RANGE SLIDERS FOR TABLE */
var IONRangeSlider = {
  init: function () {
    $("#m_slider_primaerrom").ionRangeSlider({
      skin: "round",
      type: "double",
      grid: !0,
      min: 0,
      max: 1000,
      from: 0,
      step: 5,
      postfix: "m<sup>2</sup>",
    }), $("#m_slider_prisantydning").ionRangeSlider({
      skin: "round",
      type: "double",
      grid: !0,
      min: 0,
      max: 40000000,
      step: 100000,
      from: 0,
    }), $("#m_slider_salgssum").ionRangeSlider({
      skin: "round",
      type: "double",
      grid: !0,
      min: 0,
      max: 40000000,
      step: 100000,
      from: 0,
    }), $("#m_slider_adresse").ionRangeSlider({
      skin: "round",
      type: "double",
      grid: !0,
      min: 0,
      max: 200,
      step: 1,
      from: 0,
      postfix: " km",
      prefix: "< "
    })
  }
};
/* end:: RANGE SLIDERS FOR TABLE */


/* begin:: DATERANGE PICKER FOR TABLE */
var daterangepickerLead = function () {
  var daterangepickerInit = function () {
    var $picker = $('.m_dashboard_daterangepicker');
    var $form = $('.date-form');
    var start = moment().startOf('year');
    var end = moment().endOf('year');


    $.ajax({
      url: window.Schala.baseUrl + `/site/get-session`,
      type: 'get',
      success: function (result) {
        let label = result.label;
        let start = moment(result.start * 1000);
        let end = moment(result.end * 1000);
        let range = '';
        let title = '';

        if (!result) {
          label = 'Hittil i år';
          start = moment().startOf('year');
          end = moment().endOf('year');
        }

        if (label === 'All') {
          title = label;
        } else if ((end - start) < 100 || label === 'Today' || label === 'Yesterday') {
          range = start.format('MMM D');
          title = label;
        } else {
          range = start.format('MMM D');
          range += ' - ' + end.format('MMM D');
          title = '';
        }
        $picker.find('.m-subheader__daterange-date').html(label);
        $picker.find('.m-subheader__daterange-title').html(title);
        $('input[name = "label"]').val(result.label);
        $('input[name = "start"]').val(result.start);
        $('input[name = "end"]').val(result.end);
        $('.nav-daterangepicker li[data-range-key]').removeClass('active');
        $('.nav-daterangepicker li[data-range-key="' + label + '"]').addClass('active');
      }
    });


    if (!$picker.length) {
      return;
    }

    /**
     * Callback function for date picker on date range changed
     * @param start
     * @param end
     * @param label string
     */
    function cb(start, end, label) {
      var title = '',
        data = {
          'start': start.format('YYYY-MM-DD HH:mm:00'),
          'end': end.format('YYYY-MM-DD HH:mm:00'),
        },
        range = '',
        actionUrl = $picker.attr('data-target-url'),
        $targetContent = $picker.attr('data-target-dynamic-content')
      ;

      if (label === 'All') {
        title = label;
      } else if ((end - start) < 100 || label === 'Today' || label === 'Yesterday') {
        range = start.format('MMM D');
        title = label;
      } else {
        range = start.format('MMM D');
        range += ' - ' + end.format('MMM D');
      }

      $picker.find('.m-subheader__daterange-date').html(label);
      $picker.find('.m-subheader__daterange-title').html(title);
    }

    $picker.on('apply.daterangepicker', applyAndStoreDateFilter);

    $picker.on('cancel.daterangepicker', function (e, picker) {
      picker.setStartDate(moment().startOf('year'));
      picker.setEndDate(moment().endOf('year'));

      applyAndStoreDateFilter(e, picker);
    });

    function applyAndStoreDateFilter(event, picker) {
      $('input[name="label"]').val(picker.chosenLabel);
      $('input[name="start"]').val(picker.startDate.unix());
      $('input[name="end"]').val(picker.endDate.unix());

      $form.trigger('change');

      $.ajax({
        url: window.Schala.baseUrl + '/site/set-session',
        data: $form.serializeArray(),
        success: function () {
          window.location.reload();
        }
      });
    }

    $picker.daterangepicker({
      direction: mUtil.isRTL(),
      startDate: start,
      endDate: end,
      opens: 'left nav-daterangepicker',
      applyClass: 'hidden',
      ranges: {
        'I dag': [moment().startOf('day'), moment()],
        'I går': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Denne uke': [moment().startOf('isoWeek'), moment().endOf('isoWeek')],
        'Forrige uke': [moment().subtract(1, 'weeks').startOf('isoWeek'), moment().subtract(1, 'weeks').endOf('isoWeek')],
        'Denne mnd': [moment().startOf('month'), moment()],
        'Forrige mnd': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
        'Hittil i år': [moment().startOf('year'), moment().endOf('year')],
        'I fjor': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
        'Sammenlagt': [0, moment().endOf('year')]
      },
      locale: {
        cancelLabel: 'Reset'
      }
    }, cb);
    cb(start, end, 'Hittil i år');
  };

  return {
    //== Init demos
    init: function () {

      daterangepickerInit();
    }
  };
}();
/* end:: DATERANGE PICKER FOR TABLE */

/* begin:: Init page */
var page = function () {

  //** Based on Morris plugin - http://morrisjs.github.io/morris.js/
  var revenueChange_1 = function () {
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
  var revenueChange_2 = function () {
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
          value: 40876900
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
  var revenueChange = function () {
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
  var amChart = function () {
    if (!document.querySelector('#funnel_1')) {
      return;
    }

    am4core.useTheme(am4themes_dark);
    am4core.useTheme(am4themes_animated);

    let chart_funnel_1 = am4core.create("funnel_1", am4charts.SlicedChart);
    chart_funnel_1.hiddenState.properties.opacity = 0; // this makes initial fade in effect

    chart_funnel_1.data = [{
      "name": "Trafikk",
      "value": 6004
    }, {
      "name": "Clients",
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

    series.labels.template.text = "{category}: [bold]{value}[/bold]";
    series.labelsContainer.paddingLeft = 15;
    series.labelsContainer.width = 100;
  };

  return {
    //== Init demos
    init: function () {
      revenueChange();
      revenueChange_1();
      revenueChange_2();
      amChart();
    }
  };
}();
/* end:: DATERANGE PICKER FOR TABLE */


/* begin:: SELECT2 FOR TABLE */

/* W E    M U S T    U S E    A J A X.   T H E R E   I S    A N    E X A M P L E */


var Select2 = {
  init: function () {
    $("#m_solgte_postnummer, #m_solgte_postnummer_validate").select2({
      placeholder: "Velg postnummer"
    }), $("#m_solgte_megler, #m_solgte_megler_validate").select2({
      placeholder: "Velg megler"
    }), $("#m_solgte_kontorer, #m_solgte_kontorer_validate").select2({
      placeholder: "Velg kontor"
    }), $("#m_solgte_byggear, #m_solgte_byggear_validate").select2({
      placeholder: "Velg byggeår"
    }), $("#m_solgte_medlem, #m_solgte_medlem_validate").select2({
      placeholder: "Velg medlem"
    }), $("#m_solgte_eindomstype, #m_solgte_eindomstype_validate").select2({
      placeholder: "Velg eindomstype"
    }),
      //TODO: wtf is this
      $("#_________AJAX_______").select2({
        placeholder: "Search for git repositories",
        allowClear: !0,
        ajax: {
          url: "https://api.github.com/search/repositories",
          dataType: "json",
          delay: 250,
          data: function (e) {
            return {
              q: e.term,
              page: e.page
            }
          },
          processResults: function (e, t) {
            return t.page = t.page || 1, {
              results: e.items,
              pagination: {
                more: 30 * t.page < e.total_count
              }
            }
          },
          cache: !0
        },
        escapeMarkup: function (e) {
          return e
        },
        minimumInputLength: 1,
        templateResult: function (e) {
          if (e.loading) return e.text;
          var t = "<div class='select2-result-repository clearfix'><div class='select2-result-repository__meta'><div class='select2-result-repository__title'>" + e.full_name + "</div>";
          return e.description && (t += "<div class='select2-result-repository__description'>" + e.description + "</div>"), t += "<div class='select2-result-repository__statistics'><div class='select2-result-repository__forks'><i class='fa fa-flash'></i> " + e.forks_count + " Forks</div><div class='select2-result-repository__stargazers'><i class='fa fa-star'></i> " + e.stargazers_count + " Stars</div><div class='select2-result-repository__watchers'><i class='fa fa-eye'></i> " + e.watchers_count + " Watchers</div></div></div></div>"
        },
        templateSelection: function (e) {
          return e.full_name || e.text
        }
      })
  }
};

/* end:: SELECT2 FOR TABLE */


jQuery(document).ready(function () {
  daterangepickerLead.init();
  IONRangeSlider.init();
  DatatablesSearchOptionsColumnSearch.init()
  Select2.init();
  $('#collapseFilter1').on('click', function () {
    var text = $('#collapseFilter1').html();
    if (text === '<i class="la la-filter"></i> Vis filter') {
      $(this).html('<i class="la la-filter"></i> Tom filter');
    } else {
      $(this).html('<i class="la la-filter"></i> Vis filter');
    }
  });

  var $location = $(location);
  $(document).on('click', 'tr[href]', function () {
    $location.attr("href", $(this).attr('href'));
  });

  $('[data-moment]').each(function () {
    let timestamp = $(this).data('moment');

    $(this).text(moment.unix(timestamp).fromNow());
  });

  $(document).on('click', '.js-toggle-type-form', function (e) {
    e.preventDefault();

    let formId = $(this).data('form-id');

    $.post(`${window.Schala.baseUrl}/clients/toggle-type/${formId}`, function (response) {
      swal({
        title: 'Leaden er endret til ' + (response.hot ? 'HOT' : 'COLD'),
        html: '<strong>Nå er den type &laquo;' + response.type + '&raquo;</strong>',
        onClose: function () {
          location.reload();
        }
      });
    });
  });

  $(document).on('click', '.js-soft-delete-form', function (e) {
    e.preventDefault();
    let formId = $(this).data('form-id');
    $.post(`${window.Schala.baseUrl}/clients/soft-delete/${formId}`, function () {
      location.reload();
    });
  });

  $(document).on('click', '.js-delegate', function (e) {
    e.preventDefault();
    $('#m_modal_delegere').modal('hide');
    let params = {
      id: $(this).data('id'),
      userId: $(this).data('user-id')
    };
    let $delegated = $('.js-delegate[data-delegated="true"]');
    if ($delegated.length > 0) {
      swal({
        title: 'Leaden er allerede delegert til',
        html: '<br/><h4>' + $delegated.data('department') + '<br/>' + $delegated.text() + '</h4><br/><h5>Er du sikker på at du vil delegere til en annen megler?</h5>',
        type: "warning",
        showCancelButton: true,
        cancelButtonClass: "btn btn-danger",
        confirmButtonText: "Ja, deleger",
        cancelButtonText: "Nei",

      }).then((request) => {
        if (request.value === false) {
          return false
        }
        ;
        if (request.value === true) {
          sendDelegate(params);
          return false
        }
      });
    } else {
      sendDelegate(params);
    }

  });

  $(document).on('click', '.js-ufordelt', function (e) {
    e.preventDefault();
    $('#m_modal_delegere').modal('hide');
    let params = {
      id: $(this).data('id'),
      depId: $(this).data('dep-id'),
      depName: $(this).data('dep-name'),
      brokerName: $(this).data('data-delegated-broker'),
    };
    if (params.brokerName) {
      swal({
        title: 'Leaden er allerede delegert til',
        html: '<br/><h4>' + params.brokerName + ' ' + params.depName + '<br/></h4><br/><h5>Er du sikker på at du vil delegere til en annen avdeling?</h5>',
        type: "warning",
        showCancelButton: true,
        cancelButtonClass: "btn btn-danger",
        confirmButtonText: "Ja, ufordelt",
        cancelButtonText: "Nei",

      }).then((request) => {
        if (request.value === false) {
          return false
        }
        ;
        if (request.value === true) {
          sendUfordelt(params);
          return false
        }
      });
    } else {
      sendUfordelt(params);
    }

  });

  $(document).on('click touch', '.js-lead-contact', function () {
    let params = {
      id: $(this).data('id'),
      type: $(this).data('type')
    };

    $.post(`${window.Schala.baseUrl}/clients/contact`, params, function (response) {

    });
  });

  /**
   * send delegate request
   * @param params
   */
  let sendDelegate = function (params) {
    $.get(`${window.Schala.baseUrl}/clients/delegate/${params.id}`, {d_id: params.userId}, function (response) {
      if (response.success) {
        swal({
          title: `Leaden ble delegert til <br/><br/>${response.user}<br/>${response.dep}`,
          onClose: function () {
            location.reload();
          }
        })
      } else {
        swal({title: response.message, type: 'error'});
      }
    });
  };

  /**
   * Send Ufordelt request
   * @param params
   */
  let sendUfordelt = function (params) {
    console.log('here');
    $.get(`${window.Schala.baseUrl}/clients/ufordelt/${params.id}`, {d_id: params.depId}, function (response) {
      swal({
        title: `Leaden ble ufordelt til <br/><br/>${response.dep}`,
        onClose: function () {
          location.reload();
        }
      })
    });
  };
  let initPage = function () {
    page.init();

    let $slider = $('[data-lightSlider]');

    if ($slider.length) {
      $slider.lightSlider({
        item: 4,
        slideMove: 4,
        responsive: [
          {
            breakpoint: 1930,
            settings: {
              item: 3,
              slideMove: 3
            }
          },
          {
            breakpoint: 1300,
            settings: {
              item: 2,
              slideMove: 2
            }
          },
          {
            breakpoint: 768,
            settings: {
              item: 1,
              slideMove: 1
            }
          }
        ]
      });

      let sliderJs = document.querySelectorAll('[data-lightSlider]')[0];
      let xDown = null;
      let yDown = null;
      let lSNext = false;
      let runClick = false;
      sliderJs.addEventListener('touchstart', e => {
        runClick = false;
        lSNext = false;
        const firstTouch = getTouches(e)[0];
        xDown = firstTouch.clientX;
        yDown = firstTouch.clientY;
      }, false);
      sliderJs.addEventListener('touchmove', e => {
        if (!xDown || !yDown) {
          return;
        }

        var xUp = e.touches[0].clientX;
        var yUp = e.touches[0].clientY;

        var xDiff = xDown - xUp;
        var yDiff = yDown - yUp;

        if (Math.abs(xDiff) > Math.abs(yDiff)) {
          console.log(xDiff, runClick);
          runClick = true;
          e.preventDefault();
          if (xDiff > 0) {
            lSNext = true;
          }
        } else {
          // runClick = false;

          if (yDiff > 0) {
            return false;
          } else {
            /* down swipe */
            return false;
          }
        }
        /* reset values */
        xDown = null;
        yDown = null;
      }, false);
      sliderJs.addEventListener('touchend', e => {
        if (runClick === true) {
          if (lSNext === true) {
            $('.lSNext').trigger('click');
          } else {
            $('.lSPrev').trigger('click');
          }
        }
      });

      function getTouches(e) {
        return e.touches ||             // browser API
          e.originalEvent.touches; // jQuery
      }

    }


    $('.target-blank > a').each(function () {
      $(this).attr('target', '_blank');
    });

    $('.is-datetimepicker').datetimepicker({
      autoclose: true,
      format: 'yyyy-mm-dd hh:ii',
      todayHighlight: true,
      language: 'no'
    });

    $('.is-datepicker').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd',
      todayHighlight: true
    });

    $('.is-logs-type').change(function () {
      let option = $('.is-logs-type option:selected');
      let favorite = $('.favorite-checkbox');
      let message = $('#lead-log-message');

      if (favorite.length > 0) {
        let favoriteBlock = favorite.parents('.form-group');

        favorite.prop('checked', true);

        switch (option.val()) {
          case '1014':
            favoriteBlock.hide();
            break;
          case '1020':
          case '1008':
          case '1018':
            favorite.prop('checked', false);
            favoriteBlock.hide();
            break;
          case '1011':
            message.prop('required', true);
            favoriteBlock.show();
            break;
          default:
            message.prop('required', false);
            favoriteBlock.show();
        }
      }

      if (!option.val().includes('1014')) {
        $('.is-for-notify').fadeOut();
      } else {
        $('.is-for-notify').fadeIn();
      }
    });

    let leadLogModal = $('#m_modal_loggforing');

    $('.js-lead-log-edit').click(function (e) {
      e.preventDefault();

      leadLogModal.modal('show', $(this));
    });

    leadLogModal.on('shown.bs.modal', function (e) {
      let button = $(e.relatedTarget);

      if (button && button.hasClass('js-lead-log-edit')) {
        let form = $('#add_log-form');
        let id = button.data('id');
        let log = $(`#log-${id}`);

        form
          .data('action-original', form.prop('action'))
          .prop('action', `${window.Schala.baseUrl}/logs/update/${id}`);

        form
          .find('#leadlog-message')
          .val($.trim(log.find('.log-message').html()));

        let notifyAt = moment.unix(log.find('.log-notify_at').data('moment')).utc()
          .format('YYYY-MM-DD hh:mm');

        form
          .find('#leadlog-notify_at')
          .val(notifyAt);

        form.on('submit', function (e) {
          e.preventDefault();

          form.find('button[type="submit"]').prop('disabled', true);

          $.post($(this).prop('action'), $(this).serialize(), function (response) {
            location.reload();
          });
        });
      }
    });

    leadLogModal.on('hidden.bs.modal', function (e) {
      let form = $('#add_log-form');
      let action = form.data('action-original');

      form.off('submit');

      form.find('#leadlog-message').val('');

      if (action) {
        form.prop('action', action);
      }
    });

    $('.js-lead-log-destroy').click(function (e) {
      e.preventDefault();

      let self = $(this);

      Swal({
        title: 'Er du sikker?',
        text: "Du vil ikke kunne tilbakestille dette!",
        showCancelButton: true,
        cancelButtonClass: 'btn btn-danger',
        confirmButtonText: 'Ja, slett',
        cancelButtonText: 'Nei',
      }).then(function (result) {
        if (result.value) {
          let id = self.data('id');

          $.post(`${window.Schala.baseUrl}/logs/destroy/${id}`, function (response) {
            Swal('Slettet!', 'Loggen din er slettet.');

            self.closest('tr').remove();
          });
        }
      });
    });

    let contentEditable = $('[contenteditable="true"]');

    contentEditable.focusin(function () {
      let form = $(this).parents('.editable');

      if (form.length < 1 || form.data('action') === undefined) {
        return;
      }

      let element = $(this);

      element.data('original-value', element.text().trim());

      if (element.parent().find('.is-save').length < 1) {
        let saveButton = $('<a href="#" class="btn btn-xs btn-outline-success ml-2 is-save"><i class="fa fa-check" aria-hidden="true"></i></a>');
        let data = {};
        let field = element.data('field');

        saveButton.click(function (e) {
          e.preventDefault();

          data[field] = element.text().trim();

          $.post(form.data('action'), data).done(function () {
            saveButton.remove();
          });
        });

        element.parent().append(saveButton);
      }
    });

    contentEditable.focusout(function () {
      if ($(this).data('original-value') === $(this).text().trim()) {
        $(this)
          .parent()
          .find('.is-save')
          .remove();
      }
    });

    $('input.lead-favorite').change(function () {
      let id = $(this).data('id');

      $.post(`${window.Schala.baseUrl}/leads/favorite`, {id: id});
    });
  };

  $('.log-message a').prop('target', '_blank');

  var searchParams = new URLSearchParams(location.search.slice(1));

  $('.js-range-slider').ionRangeSlider({
    skin: 'round',
    hide_min_max: true,
    onStart: function (data) {
      if (!searchParams.has(data.input.prop('name'))) {
        setTimeout(function () {
          data.input.val('')
        }, 100)
      }

      ionRangeSliderPlusPostfix(data);
    },
    onChange: ionRangeSliderPlusPostfix,
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

  function ionRangeSliderPlusPostfix(data) {
    if (data.to >= data.max) {
      setTimeout(function () {
        data.input.prev().find('.irs-to').text(data.to_pretty + '+');
      }, 100);
    }
  }

  $('#boligvarsling-edit :input').change(function () {
    if ($(this).is(':checkbox')) {
      var container = $('.' + $(this).prop('id'));
      var checked = $(this).is(':checked');

      if (container.length) {
        container.find(':input').each(function () {
          $(this).prop('checked', false);
        });

        container.toggle(checked);
      }
    }
  });

  $(document).on('submit', '.js-ajax-update', function (event) {
    event.preventDefault();

    $.post($(this).prop('action'), $(this).serializeArray(), function (response) {
      Swal('Oppdatert!', response.message);
    })
  });

  initPage();

  $(document).on('pjax:success', initPage);
});