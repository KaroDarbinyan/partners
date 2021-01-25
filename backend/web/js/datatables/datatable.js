function initCompleteDataTable() {
    let api = this.api();
    let table = api.table();

    const header = $('#data-table_length')
        .addClass('d-flex justify-content-center justify-content-sm-start align-items-start');

    header.append('<div class="dropdown ml-3">' +
        '<button class="btn btn-sm btn-outline-light dropdown-toggle" ' +
        'type="button" ' +
        'id="dropdownViewButton" ' +
        'data-toggle="dropdown" ' +
        'aria-haspopup="true" ' +
        'aria-expanded="false">Stolper</button>' +
        '<div class="view-columns dropdown-menu px-2 stop" aria-labelledby="dropdownViewButton"></div>' +
        '</div>');

    api.columns().every(function () {
        if (!this.title() || this.title() === '') {
            return;
        }

        $('.view-columns').append('<div class="dropdown-item-text form-check">' +
            '<input class="form-check-input view-column" ' +
            'id="view-column-' + this.index() + '" ' +
            'type="checkbox" value="' + this.index() + '" ' + (this.visible() ? 'checked' : '') + '>' +
            '<label class="form-check-label text-black" ' +
            'for="view-column-' + this.index() + '">' + this.title() + '</label>' +
            '</div>');
    });

    header.append('<button class="btn btn-outline-light btn-sm ml-3 show-filter-form">' +
        '<i class="fa fa-cogs"></i> Filter ' +
        '<span class="badge badge-info filters-count"></span>' +
        '</button>');

    $('.dropdown-menu.stop').click(function (event) {
        event.stopPropagation()
    });

    $('.view-column').change(function () {
        let index = $(this).val();
        let column = api.column(index);

        column.visible(!column.visible());

        api.columns.adjust().draw();
    });

    let state = api.state.loaded();

    if (state && state.columns) {
        let filtersCount = 0;

        $.each(state.columns, function (i, val) {
            let input = $('[data-col-index="' + i + '"]');

            if (input.attr('type') !== 'checkbox') {
                input.val(val.search.search);
            } else {
                input.prop('checked', val.search.search === 'true');
            }

            if (val.search.search && val.search.search !== '') {
                filtersCount++;
            }
        });

        if (filtersCount) {
            $('.filters-count').text(filtersCount);
        }
    }

    const filterForm = $('#data-table-filter');

    $('.show-filter-form').click(function (e) {
        e.preventDefault();

        // if(filterForm.is(':visible')) {
        //    filterForm.trigger('reset');
        // }

        filterForm.fadeToggle();
    });

    filterForm.submit(function (e) {
        e.preventDefault();

        let params = {};

        let filtersCount = 0;

        $('[data-col-index]').each(function () {
            let i = $(this).data('col-index');

            if ($(this).attr('type') === 'checkbox') {
                $(this).val($(this).is(':checked'));
            }

            if (params[i]) {
                params[i] += '|' + $(this).val();
            } else {
                params[i] = $(this).val();
            }

            if (params[i] && params[i] !== '') {
                filtersCount++;
            }
        });

        if (filtersCount) {
            $('.filters-count').text(filtersCount);
        }

        $.each(params, function (i, val) {
            api
                .column(i)
                .search(val ? val : '', false, false);
        });

        api.table().draw();
    });

    filterForm.bind('reset', function () {
        setTimeout(function () {
            $('[data-col-index]').each(function () {
                $(this).val('');

                api
                    .column($(this).data('col-index'))
                    .search('', false, false);
            });

            $('.filters-count').text('');

            api.state.clear();

            api.table().draw();
        }, 1);
    });

    let pickers = $('.daterange-picker');

    pickers.daterangepicker({
        autoUpdateInput: false
    });

    pickers.on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
    });

    if (window.DATA_TABLE.route && window.DATA_TABLE.route.includes('paminnelser')) {
        $('#clientsLogType option:selected')
            .attr('selected', false);

        $('#clientsLogType option[value="Ubehandlede"]')
            .attr('selected', true);

        setTimeout(function () {
            filterForm.fadeToggle();
            filterForm.submit();
        }, 1);
    }

    $(document).on('click', '.js-lead-short-info', function (e) {
        e.preventDefault();

        let self = $(this);

        $.ajax({
            url: window.Schala.baseUrl + '/leads/short-info',
            type: 'POST',
            data: {id: self.data('id')},
            dataType: 'json'
        }).done(function (response) {
            $('.lead-short-info').empty();

            self.siblings('.lead-short-info').html(response.html);

            table.columns.adjust();
        });

    });

    let interestedModal = $('#interested_modal');
    let interestedForm = $('#interested-form');

    $(document).on('click', '.js-lead-interested', function (e) {
        e.preventDefault();

        $('#lead-id').val($(this).data('id'));

        interestedModal.modal('show');
    });

    if (interestedForm.length) {
        interestedModal.on('hidden.bs.modal', function (e) {
            interestedForm.resetForm();
        });

        interestedForm.submit(function (e) {
            e.preventDefault();

            $.ajax({
                url: window.Schala.baseUrl + '/leads/common-interested',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json'
            }).done(function (response) {
                interestedModal.modal('hide');
            });
        });
    }

    $(document).on('click', '.js-lead-not-interested', function (e) {
        e.preventDefault();

        let button = $(this);
        let row = button.parents('tr');

        Swal({
            html: 'Vil du sette status <strong>Ønsker ikke kontakt</strong> på denne leaden?',
            showCancelButton: true,
            cancelButtonClass: 'btn btn-danger',
            confirmButtonText: 'Ja',
            cancelButtonText: 'Nei',
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    url: window.Schala.baseUrl + '/leads/common-not-interested',
                    type: 'POST',
                    data: {id: button.data('id')},
                    dataType: 'json'
                }).done(function () {
                    table.row(row).remove();

                    row.fadeOut();

                    if (table.rows().count() < 1) {
                        table.draw();
                    }
                });
            }
        });
    });
}
