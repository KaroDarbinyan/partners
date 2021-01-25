/*-----------------------------------------------------------------------------------

	Theme Name: 
	Theme URI: http://
	Description: 
	Author: Roelnie
	Author URI: http://themeforest.net/user/roelnie
	Version: 1.0

-----------------------------------------------------------------------------------*/

$.blockUI.defaults.message = null;
$.blockUI.defaults.overlayCSS = {};

var clientOnline = window.navigator.onLine;

var flashConnectionError = function () {
  Swal.fire({
    title: 'INGEN INTERNETT!',
    text: 'PRØV IGJEN',
    confirmButtonText: 'OK'
  });
};

var lazyLoadInstance = new LazyLoad({
  elements_selector: '.lazy'
});

$(function () {
  'use strict'

  window.addEventListener('online', function (event) {
    clientOnline = true;
  }, false);

  window.addEventListener('offline', function (event) {
    clientOnline = false;
  }, false);

  //  PageScroll  start
  $('a.order, a.link').mPageScroll2id();
  //  PageScroll end

  // Wow start
  new WOW().init();
  // Wow end

  $('#city').easyAutocomplete({
    cssClasses: 'properties-filter',
    adjustWidth: false,
    requestDelay: 250,

    url: function (text) {
      return '/properties/locations?q=' + text;
    },

    listLocation: 'locations',
    getValue: 'name',

    list: {
      onChooseEvent: function () {
        const {latitude, longitude} = $('#city').getSelectedItemData();

        $('#filter_map_latitude').val(latitude);
        $('#filter_map_longitude').val(longitude);

        $('#filter_map_enable')
          .prop('checked', true)
          .trigger('change');
      }
    }
  });


  // animation mobile menu start
  (function () {
    jQuery('.mob_button').on('click', function () {
      jQuery('.mob_button').toggleClass('active');
      jQuery('.menu').toggleClass('menu_vissible');
      jQuery('body').toggleClass('hidden');
      jQuery('.nav_bar').toggleClass('nav_bar_mob');
    });
    jQuery('.menu li a').on('click', function () {
      jQuery('.mob_button').toggleClass('active');
      jQuery('.menu').toggleClass('menu_vissible');
      jQuery('body').toggleClass('hidden');
      jQuery('.nav_bar').toggleClass('nav_bar_mob');
    });
  })();
  // animation mobile menu end


  // animation search popup start
  (function () {
    jQuery('.box_search .icon').on('click', function () {
      jQuery('.box_search').toggleClass('active');
      jQuery('.box_search_popup').toggleClass('active');
      setTimeout(function () {
        jQuery('.box_search_popup input').focus();
      }, 500);
    });
  })();
  // animation search popup end


  // sections background image from data background start
  $('.bg_img, section').each(function () {
    if ($(this).attr('data-background')) {
      $(this).css('background-image', 'url(' + $(this).data('background') + ')');
    }
  });
  // sections background image from data background end


  // SVG load start
  $('.icon').each(function () {
    if ($(this).attr('data-svg')) {
      $(this).load($(this).data('svg'));
    }
  });

  // SVG load end

  function autocompleteClientDataWhenExists() {
    if ($.trim($(this).val()).length < 8) {
      return;
    }

    var typeInput = $(this)
      .parents('form')
      .find('#forms-type');

    $.post('/forms/client-data', {phone: $(this).val(), type: typeInput.val()}, function (response) {
      if (response.success) {
        for (var prop in response.client) {
          if (response.client.hasOwnProperty(prop)) {
            $('#forms-' + prop).val(response.client[prop]);
          }
        }
      }
    });
  }

  $('#forms-phone').keyup(_.debounce(autocompleteClientDataWhenExists, 500));

  function sendLeadForm(form) {
    var button = form.find('button[type="submit"]')
      .prop('disabled', true);

    form.find('.help-block').empty();

    var modal = form.parents('.modal');

    $.blockUI();

    form.block();

    $.ajax({
      url: '/forms/contact',
      type: 'POST',
      data: form.serialize(),
      dataType: 'json'
    })
      .done(function (response) {
        if (response.success) {
          if (modal.length) {
            modal.modal('hide');
          }

          var downloadLink = $('a.download-pdf');
          var needDownload = $('#forms-download_sales_report').is(':checked')
            || $('#forms-type').val() === 'salgsoppgave';

          if (needDownload && downloadLink.length) {
            downloadLink.get(0).click();
          }

          Swal.fire({
            title: response.title || 'Takk!',
            text: response.message || 'Du vil bli kontaktet av megler for nærmere avtale.',
            confirmButtonText: 'OK'
          });

          form[0].reset();
        } else {
          showFormErrors('forms', response)
        }
      })
      .fail(function(jqXHR, textStatus, errorThrown) {
        flashConnectionError();
      })
      .always(_.debounce(function () {
        button.prop('disabled', false);
        $.unblockUI();
        form.unblock();
      }, 500));
  }

  $(document).on('submit', '.lead-form', function (e) {
    e.preventDefault();

    var form = $(this);

    if (form.find('.forms-send_sms').is(':visible') && !form.find('#forms-send_sms').is(':checked')) {
      Swal.fire({
        title: 'Ønsker du å motta budvarsel på sms?',
        showCancelButton: true,
        confirmButtonText: 'Ja',
        cancelButtonText: 'Nei'
      }).then(function (result) {
        if (result.value) {
          form.find('#forms-send_sms').prop('checked', result.value);
        }

        sendLeadForm(form);
      })
    } else {
      sendLeadForm(form);
    }
  });

  function showFormErrors(model, response) {
    for (var name in response) {
      if (response.hasOwnProperty(name)) {
        var el = $('#' + model + '-' + name);

        if (el.is(':checkbox')) {
          el = el.next()
        }

        el.next('.help-block')
          .html(response[name].join('<br>'))

      }
    }
  }

  var formAction = $('a[href="' + location.hash + '"]');

  if (formAction) {
    setTimeout(function () {
      formAction.click();
    }, 1);
  }

  $('[data-dynamic-form]').on('show.bs.modal', function (event) {
    var $button = $(event.relatedTarget);
    var title = $button.data('title');
    if (title) {
      $(this).find('.modal-title').html(title);
    }

    var url = $button.prop('hash');
    var hash = url ? url.substring(url.indexOf('#')) : '';
    if (hash.length > 1) {
      location.hash = hash;
    }

    ['type', 'target_id', 'department_id', 'broker_id'].forEach(function (val) {
      var prop = $button.data(val);

      if (prop) {
        $('#forms-' + val).val(prop);

        if (val === 'type' && prop === 'budvarsel') {
          $('label[for="forms-i_agree"]').find('.default-hidden').show();
        }
      }
    });

    var includes = $button.data('includes');

    if (includes) {
      includes.split(',').forEach(function (val) {
        $('.forms-' + $.trim(val)).show();
      })
    }
  }).on('hidden.bs.modal', function (e) {
    history.pushState('', document.title, location.pathname + location.search);

    $(this).find('.default-hidden').hide();
    $(this).find('.help-block').empty();
    $(this).find('form')[0].reset();
  });

  $('#offices-modal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var title = button.data('title');
    if (title) {
      $(this).find('.modal-title').html(title);
    }

    var offices = button.data('offices');

    if (offices.length) {
      var body = $(this)
        .find('.modal-body')
        .empty();

      var content = '';

      offices.forEach(function (office) {
        content += '<h3><a class="d-block" href="/kontor/' + office.url + '">' + office.short_name + '</a></h3>'
      });

      body.append(content);
    }
  });

  $('#offices-selector').change(function () {
    location.href = $(this).val();
  });

  $('#office-search-form').submit(function (e) {
    e.preventDefault();

    var helpBlock = $(this).find('.help-block');

    $.ajax({
      url: '/company/office-search',
      type: 'GET',
      data: $(this).serialize(),
      dataType: 'json',
    })
      .done(function (response) {
        if (response.success) {
          location.href = encodeURI('/kontor/' + response.department.url);
        } else {
          helpBlock.html('Ikke funnet.');

          setTimeout(function () {
            helpBlock.empty()
          }, 3000)
        }
      })
  });

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

  var propertiesFiltersForm = $('#properties-filters-form');

  $('#properties-notify-form :input, #properties-filters-form :input').change(function () {
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

  $(document).on('change', '.js-properties-sort', function () {
    var sortInput = $('#filter_sort');
    var val = $(this).val();

    if (sortInput.length) {
      sortInput.val(val).change();
    }
  });

  propertiesFiltersForm.on('keypress', ':input', function (e) {
    if (e.keyIdentifier === 'U+000A' || e.keyIdentifier === 'Enter' || e.keyCode === 13) {
      e.preventDefault();
    }
  });

  propertiesFiltersForm.on('change keydown', ':input', _.debounce(searchPropertiesByFilters, 500));

  function searchPropertiesByFilters() {
    // if ($(this).prop('name') === 'text' && $.trim($(this).val()).length < 3) {
    //     return;
    // }

    var query = new URLSearchParams();
    var request = propertiesFiltersForm.serializeArray();

    request.forEach(function (input) {
      if ($.trim(input.value) !== '') {
        query.append(input.name, input.value);
      }
    });

    var emptyFilters = query.toString() === '';
    var url = location.pathname + (emptyFilters ? '' : '?' + query);

    propertiesFiltersResetButton.toggle(!emptyFilters);

    history.pushState({
      url: url,
      title: document.title
    }, document.title, url);

    getPropertiesList(url);
  }

  function getPropertiesList(url) {
    $.ajax({
      url: url,
      cache: false,
      dataType: 'json'
    }).done(function (response) {
      $('#properties-count').text(response.count);
      $('#properties-list').html(response.html);

      lazyLoadInstance.update();
    });
  }

  var propertiesFiltersResetButton = $('#properties-filters-reset');

  if (propertiesFiltersResetButton.length) {
    var emptySearchParams = searchParams.toString() === '';

    propertiesFiltersResetButton.toggle(!emptySearchParams);

    propertiesFiltersResetButton.click(function (e) {
      e.preventDefault();

      resetForm(propertiesFiltersForm);
    });
  }

  function resetForm(form) {
    form.find(':input')
      .each(function () {
        if ($(this).is(':checkbox')) {
          $(this).prop('checked', false)
        } else {
          var slider = $(this).data('ionRangeSlider');

          if (slider) {
            slider.update({
              from: slider.options.min,
              to: slider.options.max
            });
          }

          $(this).val('')
        }

        $(this).change();
      });

    $('.filter-dropdown').hide();
  }

  $(window).on('popstate', function (e) {
    var state = e.originalEvent.state;

    if (state !== null) {
      getPropertiesList(state.url);
    } else {
      getPropertiesList(location.pathname);
    }
  });

  var propertiesNotifyFormTimer = null;

  $('#properties-notify-form').submit(function (e) {
    e.preventDefault();

    clearTimeout(propertiesNotifyFormTimer);

    $(this).find('.help-block').empty();

    var form = $(this);
    var request = form.serialize();

    propertiesNotifyFormTimer = setTimeout(function () {
      $.ajax({
        url: '/dwelling/form',
        type: 'POST',
        data: request,
        dataType: 'json'
      }).done(function (response) {
        if (response.success) {
          form[0].reset();
          resetForm(form);

          Swal.fire({
            title: response.title || 'TAKK!',
            text: response.message || 'Du blir varslet på e-post, i appen på mobil og her på Schala.',
            confirmButtonText: 'Ja'
          })
        } else {
          showFormErrors('boligvarsling', response);
        }
        console.log(response);
      }).fail(function(jqXHR, textStatus, errorThrown) {
        flashConnectionError();
      })
    }, 500);
  });

  $("#office_search input[type=text]").on("input", function () {
    var search = $(this).val();
    var isOk = false;
    if (search.length === 0) isOk = true;
    else if ((Number.isInteger(+search) && search.length === 4)) isOk = true;
    else if ((!Number.isInteger(+search) && search.length > 1)) isOk = true;

    if (isOk) office_search(search);
  });

  $('.search-button').click(function (e) {
    e.preventDefault();
    $(this).hide();

    $('.search-wrap').addClass('search-overlay');
    $('.search-main').addClass('open').find('input').focus();
  });

  $(document).on('click keyup', function (e) {
    if ($('.search-overlay').is(e.target) || e.keyCode === 27) {
      $('.search-button').show();
      $('.search-wrap').removeClass('search-overlay');
      $('.search-main').removeClass('open')
    }
  });

  function office_search(search) {
    $.ajax({
      url: window.location.pathname,
      type: "GET",
      data: {
        "search": search
      },
      success: function (response) {
        $("ul.list_office").html(response);
      }
    });
  }

  $('.carousel-item').click(function () {
    var fullImage = $(this).find('a.full-image');

    if (fullImage.length) {
      fullImage.get(0).click();
    }
  })

  $("div[data-click=book_visning]").click(function () {
    $(`a[data-type=${$(this).data("click")}]`).click();
  });

});
