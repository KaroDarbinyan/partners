window.addEventListener('load', function () {
    $('#data-table').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        stateSave: false,
        pageLength: 25,
        /*dom: "<'row'<'col-sm-12 col-md-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-6'p>>",*/
        ajax: {
            url: window.DATA_TABLE.action,
            type: 'POST',
            data: function (data) {

            }
        },
        drawCallback: function (settings) {

        },
        order: [[3, 'desc']],
        language: {
            decimal: ',',
            emptyTable: 'Ingen elementer ble funnet',
            info: 'Viser _START_ til _END_ av _TOTAL_ totalt',
            infoEmpty: 'Ingen elementer',
            infoFiltered: '(filtrert fra _MAX_ totalt)',
            infoPostFix: '',
            thousands: '.',
            lengthMenu: 'Vis _MENU_ rader',
            loadingRecords: 'Laster...',
            processing: 'Laster...',
            search: 'Søk:',
            zeroRecords: 'Ingen treff ble funnet',
            paginate: {
                first: 'Første',
                last: 'Siste'
            },
            aria: {
                sortAscending: ': sorter stigende',
                sortDescending: ': sorter synkende'
            }
        },
        columns: [
            {data: 'id'}, // 0
            {data: 'type', title: 'Type'}, // 1
            {data: 'name', title: 'Navn'}, // 2
            {data: 'created_at', title: 'Registrert'}, // 3
            {data: 'updated_at', title: 'Sist endret'}, // 4
            {data: 'status'}, // 5
            {data: 'belongsType', name: 'belongs', title: 'Hvilken'}, // 6
            {data: 'department_id'}, // 7
            {data: 'broker_id'}, // 8
            {data: 'departmentName'}, // 9
            {data: null}
        ],
        columnDefs: [
            {targets: [0, 4, 5, 7, 8, 9], visible: false},
            {targets: [0], searchable: false},
            {
                targets: 1,
                render: function (data, type, row, meta) {
                    return `<span class="schala-status">
                                <span class="m-badge m-badge--dot schala-type-selger"></span>
                                <em>${data}</em>
                            </span>`;
                }
            },
            {
                targets: 2,
                render: function (data, type, row, meta) {
                    return `<a class="table-schala-name d-block contact-phone" href="#" data-lead-id="${row['id']}">${data}</a>
                            <p class="lead-phone"></p>`;
                }
            },
            {
                targets: 3,
                render: function (data, type, row, meta) {
                    let date = moment.unix(data);

                    return `<span class="schala-status">
                        <span class="m-badge m-badge--dot schala-status-registrert"></span>
                        <em>registrert</em>
                    </span><span class="table-schala-time">${date.format('lll')}</span><span class="table-schala-time-ago">${date.fromNow()}</span>`;
                }
            },
            {
                targets: 4,
                render: function (data, type, row, meta) {
                    let date = moment.unix(data);

                    return `<span class="schala-status">
                        <span class="m-badge m-badge--dot schala-status-${row['status']}"></span>
                        <em>${row['status']}</em>
                    </span><span class="table-schala-time">${date.format('lll')}</span><span class="table-schala-time-ago">${date.fromNow()}</span>`;
                }
            },
            /*{
                targets: 6,
                render: function (data, type, row, meta) {
                    let belongs = 'Felles';

                    if (row['broker_id']) {
                        belongs = row['broker_id'] == window.DATA_TABLE.user_id
                            ? 'Min'
                            : 'Kontor';
                    }

                    if (row['department_id'] && !row['broker_id']) {
                        belongs = row['departmentName'];
                    }

                    return belongs;
                }
            },*/
            {
                targets: -1,
                title: 'Handlinger',
                orderable: false,
                render: function (data, type, row, meta) {
                    return `<div class="btn-group btn-group-sm" role="group" aria-label="Handlinger">
                      <button type="button" class="btn btn-success interested" data-actions data-lead-id="${row['id']}" title="Loggføring" disabled>
                        <i class="fa fa-plus"></i>
                      </button>
                      <button type="button" class="btn btn-danger not-interested" data-actions data-lead-id="${row['id']}" title="Ønsker ikke kontakt" disabled>
                        <i class="fa fa-times"></i>
                      </button>
                      <a href="#" class="btn btn-warning disabled hot" target="_blank" data-actions data-lead-id="${row['id']}" title="To Hot">
                        <i class="fa fa-fire text-white"></i>
                      </a>
                    </div>`;
                }
            }
        ],
        
        initComplete: function () {
            let api = this.api();
            let table = api.table();
            let state = api.state.loaded();

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

            let interestedModal = $('#interested_modal');
            let interestedForm = $('#interested-form');

            let countdown = null;

            $(document).on('click', '.contact-phone', function (e) {
                e.preventDefault();

                let button = $(this);
                let row = button.parents('tr');
                let id = button.data('lead-id');

                let actions = row.find('[data-actions]');
                let hot = row.find('.hot');

                clearInterval(countdown);

                $.ajax({
                    url: window.Schala.baseUrl + '/leads/contact-phone',
                    type: 'POST',
                    data: {id: id},
                    dataType: 'json'
                }).done(function (response) {
                    $('.lead-phone').empty();

                    $('[data-actions]')
                        .prop('disabled', true)
                        .addClass('disabled');

                    let phoneBlock = row.find('.lead-phone');

                    phoneBlock.append(response.phone);

                    let incrementButton = $('<a href="#" class="is-increment btn btn-sm btn-default" style="display:none">+2min</a>');
                    let countdownBlock = phoneBlock.find('.countdown');
                    let countdownDate = response.countdown * 1000;

                    incrementButton.click(function (e) {
                        e.preventDefault();

                        $.ajax({
                            url: window.Schala.baseUrl + '/leads/contact-phone-prolong',
                            type: 'POST',
                            data: {id: id},
                            dataType: 'json'
                        }).done(function (data) {
                            countdownDate = data.countdown * 1000;

                            incrementButton.fadeOut();
                        });
                    });

                    if (response.success) {
                        countdownBlock.after(incrementButton);
                        actions
                            .prop('disabled', false)
                            .removeClass('disabled');

                        hot.prop('href', window.DATA_TABLE.url_to_create + '/' + id);

                        table.columns.adjust();
                    }

                    countdown = setInterval(function () {
                        let nowDate = new Date().getTime();
                        let distance = countdownDate - nowDate;

                        let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        let seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        if (countdownBlock.length) {
                            let m = minutes < 10 ? '0' + minutes : minutes;
                            let s = seconds < 10 ? '0' + seconds : seconds;

                            countdownBlock.text(m + ':' + s);
                        }

                        if (minutes < 1) {
                            incrementButton.fadeIn();
                        }

                        if (distance <= 1) {
                            clearInterval(countdown);

                            countdownBlock.remove();
                            phoneBlock.empty();
                            incrementButton.fadeOut();
                            actions
                                .prop('disabled', true)
                                .addClass('disabled');
                        }

                    }, 1000);
                });
            });

            $(document).on('click', '.interested', function () {
                $('#lead-id').val($(this).data('lead-id'));

                interestedModal.modal('show');
            });

            interestedModal.on('hidden.bs.modal', function (e) {
                interestedForm.resetForm();
            });

            interestedForm.submit(function (e) {
                e.preventDefault();

                let row = $('[data-lead-id="' + $('#lead-id').val() + '"]').parents('tr');

                $.ajax({
                    url: window.Schala.baseUrl + '/leads/interested',
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json'
                }).done(function (response) {
                    interestedModal.modal('hide');

                    table.row(row).remove();

                    row.fadeOut();

                    if (table.rows().count() < 1) {
                        table.draw();
                    }
                });
            });

            $(document).on('click', '.not-interested', function () {
                let button = $(this);
                let row = button.parents('tr');
                let id = button.data('lead-id');

                Swal({
                    html: 'Vil du sette status <strong>Ønsker ikke kontakt</strong> på denne leaden?',
                    showCancelButton: true,
                    cancelButtonClass: 'btn btn-danger',
                    confirmButtonText: 'Ja',
                    cancelButtonText: 'Nei',
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            url: window.Schala.baseUrl + '/leads/not-interested',
                            type: 'POST',
                            data: {id: id},
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
    });
});
