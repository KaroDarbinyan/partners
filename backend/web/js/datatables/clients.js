window.addEventListener('load', function () {
    $('#data-table').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        stateSave: false,
        pageLength: 25,
        ajax: window.DATA_TABLE.action,
        order: [[4, 'desc']],
        language: {
            "decimal":        ",",
            "emptyTable":     "Ingen elementer ble funnet",
            "info":           "Viser _START_ til _END_ av _TOTAL_ totalt",
            "infoEmpty":      "Ingen elementer",
            "infoFiltered":   "(filtrert fra _MAX_ totalt)",
            "infoPostFix":    "",
            "thousands":      ".",
            "lengthMenu":     "Vis _MENU_ rader",
            "loadingRecords": "Laster...",
            "processing":     "Laster...",
            "search":         "Søk:",
            "zeroRecords":    "Ingen treff ble funnet",
            "paginate": {
                "first":      "Første",
                "last":       "Siste"
            },
            "aria": {
                "sortAscending":  ": sorter stigende",
                "sortDescending": ": sorter synkende"
            }
        },
        columns: [
            {data: 'id'}, // 0
            {title: 'Type', data: 'type'}, // 1
            {title: 'Navn', data: 'name'}, // 2
            {title: 'Sist endret', data: 'updated_at'}, // 7 => 6 => 3
            {title: 'Registrert', data: 'created_at'}, // 4 => 3 => 4
            {title: 'Megler', data: 'brokerName'}, // 5 => 4 => 5
            {data: 'status'}, // 6 => 5 => 6
            {title: 'Source', data: 'referer_source'}, // 3 => 7
            {data: 'brokerAvatar'}, // 8
            {data: 'delegatedBrokerName'}, // 9
            {data: 'delegatedBrokerAvatar'}, // 10
            {data: 'phone'}, // 11
            {data: null}
        ],
        columnDefs: [
            {targets: [0, 1, 6, 8, 9, 10, 11], visible: false},
            {targets: [0, 8, 9, 10], searchable: false},
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
                render: function(data, type, row, meta) {
                    let path = `${window.DATA_TABLE.url_to_show}/${row['id']}`;

                    return `<span class="schala-status">
                                <span class="m-badge m-badge--dot schala-type-selger"></span>
                                <em>${row['type']}</em>
                            </span>
                            <a class="table-schala-name d-block js-lead-short-info" href="${path}" data-id="${row['id']}">${data}</a>
                            <p>${row['phone']}</p><div class="lead-short-info"></div>`;
                }
            },
            {
                targets: 4,
                render: function (data, type, row, meta) {
                    let date = moment.unix(data);

                    return `<span class="schala-status">
                        <span class="m-badge m-badge--dot schala-status-registrert"></span>
                        <em>registrert</em>
                    </span><span class="table-schala-time">${date.format('Do MMM [kl.] HH:mm')}</span><span class="table-schala-time-ago">${date.fromNow()}</span>`;
                }
            },
            {
                targets: 3,
                render: function (data, type, row, meta) {
                    let date = moment.unix(data);

                    return `<span class="schala-status">
                        <span class="m-badge m-badge--dot schala-status-${row['status']}"></span>
                        <em>${row['status']}</em>
                    </span><span class="table-schala-time">${date.format('Do MMM [kl.] HH:mm')}</span><span class="table-schala-time-ago">${date.fromNow()}</span>`;
                }
            },
            {
                targets: 5,
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
                targets: 7,
                render: function(data, type, row, meta) {
                    let url = new URL(data, location);
                    let host = url ? url.host : 'n/a';

                    return `<span class="badge badge-pill badge-dark font-weight-normal m--regular-font-size-sm2 p-2">${host}</span>`;
                }
            },
            {
                targets: -1,
                title: 'Handlinger',
                orderable: false,
                render: function (data, type, row, meta) {
                    return `<div class="btn-group btn-group-sm" role="group" aria-label="Handlinger">
                      <button type="button" class="btn btn-success js-lead-interested" data-id="${row['id']}" title="Loggføring">
                        <i class="fa fa-plus"></i>
                      </button>
                      <button type="button" class="btn btn-danger js-lead-not-interested" data-id="${row['id']}" title="Ønsker ikke kontakt">
                        <i class="fa fa-times"></i>
                      </button>
                      <a href="${window.DATA_TABLE.url_to_show}/${row['id']}" class="btn btn-default btn-sm">Detaljer</a>
                    </div>`;
                }
            }
        ],
        initComplete: initCompleteDataTable
    });
});
