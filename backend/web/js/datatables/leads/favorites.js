window.addEventListener('load', function () {
    $('#data-table').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        stateSave: false,
        pageLength: 25,
        ajax: window.DATA_TABLE.action,
        drawCallback: function (settings) {
            $('.notify-expired').each(function () {
                $(this).parents('tr').addClass('notify-expired');
            });

            let showChar = 50;
            let ellipsesText = '...';
            let moreText = 'Show more';
            let lessText = 'Show less';

            $(document).on('click', '.morelink', function () {
                if ($(this).hasClass('less')) {
                    $(this).removeClass('less');
                    $(this).html(moreText);
                } else {
                    $(this).addClass('less');
                    $(this).html(lessText);
                }
                $(this).parent().prev().toggle();
                $(this).prev().toggle();
                return false;
            });

            $('[data-moretext]').each(function () {
                let content = $(this).html();

                if (content.length > showChar) {
                    let c = content.substr(0, showChar);
                    let h = content.substr(showChar, content.length - showChar);

                    let html = c + '<span class="moreellipses">' + ellipsesText
                        + '&nbsp;</span><span class="morecontent"><span>' + h
                        + '</span><a href="" class="morelink">' + moreText
                        + '</a></span>';

                    $(this).html(html);
                }
            });
        },
        order: [[4, 'asc']],
        language: {
            "decimal": ",",
            "emptyTable": "Ingen elementer ble funnet",
            "info": "Viser _START_ til _END_ av _TOTAL_ totalt",
            "infoEmpty": "Ingen elementer",
            "infoFiltered": "(filtrert fra _MAX_ totalt)",
            "infoPostFix": "",
            "thousands": ".",
            "lengthMenu": "Vis _MENU_ rader",
            "loadingRecords": "Laster...",
            "processing": "Laster...",
            "search": "Søk:",
            "zeroRecords": "Ingen treff ble funnet",
            "paginate": {
                "first": "Første",
                "last": "Siste"
            },
            "aria": {
                "sortAscending": ": sorter stigende",
                "sortDescending": ": sorter synkende"
            }
        },
        columns: [
            {data: 'id'}, // 0
            {title: 'Type', data: 'type'}, // 1
            {title: 'Navn', data: 'name'}, // 2
            {title: 'Adrese', data: 'address'}, // 3
            {title: 'Påminnelse', name: 'reminder', data: 'reminder.notify_at'}, // 4
            {title: 'Registrert', data: 'created_at'}, // 5
            {title: 'Sist endret', data: 'updated_at'}, // 6
            {data: 'status'}, // 7
            {title: 'Megler', data: 'brokerName'}, // 8
            {data: 'brokerAvatar'}, // 9
            {data: 'delegatedBrokerName'}, // 10
            {data: 'delegatedBrokerAvatar'}, // 11
            {data: 'phone'}, // 12
            {data: 'latestLogMessage'}, // 13
            {data: 'reminder.message'}, // 14
            {data: null}
        ],
        columnDefs: [
            {targets: [0, 7, 8, 9, 10, 11, 12, 13, 14], visible: false},
            {targets: [0, 9, 10, 11], searchable: false},
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
                    let path = `${window.DATA_TABLE.url_to_detail}/${row['id']}`;
                    return `<a class="table-schala-name d-block js-lead-short-info" href="${path}" data-id="${row['id']}">${data}</a>
                            <p>${row['phone']}</p><div class="lead-short-info"></div>`;
                }
            },
            {
                targets: 4,
                render: function (data, type, row, meta) {
                    let dateTemplate = '';
                    if (data) {
                        let date = moment.unix(data);
                        let expired = date.isBefore(moment());

                        dateTemplate = `<span class="table-schala-time ${expired ? 'notify-expired' : ''}">${date.format('ll')}</span>`;
                    }

                    if (!row['reminder']['message']) {
                        row['reminder']['message'] = '';
                    }

                    return `<span class="schala-status">
                        ${dateTemplate}
                        <div class="schala-status-message" data-moretext data-limit="50" style="max-width: 250px; white-space: pre-wrap;">${row['reminder']['message']}</div>
                    </span>`;
                }
            },
            {
                targets: 5,
                render: function (data, type, row, meta) {
                    let date = moment.unix(data);

                    return `<span class="schala-status">
                        <span class="m-badge m-badge--dot schala-status-registrert"></span>
                        <em>registrert</em>
                    </span><span class="table-schala-time">${date.format('lll')}</span><span class="table-schala-time-ago">${date.fromNow()}</span>`;
                }
            },
            {
                targets: 6,
                render: function (data, type, row, meta) {
                    let date = moment.unix(data);
                    let message = row['latestLogMessage'];

                    if (row['status'] === 'Påminnelse') {
                        message = '';
                    }

                    return `<span class="schala-status">
                        <span class="m-badge m-badge--dot schala-status-${row['status']}"></span>
                        <em>${row['status']}</em>
                        <div class="schala-status-message" style="max-width: 250px; white-space: pre-wrap;">${message}</div>
                    </span><span class="table-schala-time">${date.format('lll')}</span><span class="table-schala-time-ago">${date.fromNow()}</span>`;
                }
            },
            {
                targets: 8,
                orderable: false,
                render: function (data, type, row, meta) {
                    let brokers = '';

                    if (row['delegatedBrokerName'] && !row['delegatedBrokerName'].includes(row['brokerName'])) {
                        brokers += '<img src="' + row['delegatedBrokerAvatar'] + '" ' +
                            'class="m--img-rounded m--marginless table-schala-img" ' +
                            'alt="' + row['delegatedBrokerName'] + '" ' +
                            'title="' + row['delegatedBrokerName'] + '">';
                    }

                    if (row['brokerName']) {
                        if (row['delegatedBrokerName'] && !row['delegatedBrokerName'].includes(row['brokerName'])) {
                            brokers += '<i class="fa fa-arrow-right mr-2"></i>';
                        }

                        brokers += '<img src="' + row['brokerAvatar'] + '" ' +
                            'class="m--img-rounded m--marginless table-schala-img" ' +
                            'alt="' + row['brokerName'] + '" ' +
                            'title="' + row['brokerName'] + '">';
                    }

                    return '<div class="d-flex align-items-center">' + brokers + '</div>'
                }
            },
            {
                targets: -1,
                title: 'Handlinger',
                orderable: false,
                render: function (data, type, row, meta) {
                    return `<div class="btn-group btn-group-sm" role="group" aria-label="Handlinger">
                      <button type="button" class="btn btn-success interested" data-actions data-lead-id="${row['id']}" title="Loggføring">
                        <i class="fa fa-plus"></i>
                      </button>
                      <button type="button" class="btn btn-danger not-interested" data-actions data-lead-id="${row['id']}" title="Ønsker ikke kontakt">
                        <i class="fa fa-times"></i>
                      </button>
                      <a href="${window.DATA_TABLE.url_to_create}/${row['id']}" class="btn btn-warning hot" target="_blank" data-actions data-lead-id="${row['id']}" title="To Hot">
                        <i class="fa fa-fire text-white"></i>
                      </a>
                      <a href="${window.DATA_TABLE.url_to_detail}/${row['id']}" class="btn btn-default btn-sm">Detaljer</a>
                    </div>`;
                }
            }
        ],

        // leadsTableActions
        initComplete: function () {
            let api = this.api();
            let table = api.table();
            let state = api.state.loaded();

            let interestedModal = $('#interested_modal');
            let interestedForm = $('#interested-form');

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
                });
            });

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
