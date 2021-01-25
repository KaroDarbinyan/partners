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
            'lengthMenu': 'Vise _MENU_',
        },
        columns: [
            {data: 'id'}, // 0
            {title: 'Type', data: 'type'}, // 1
            {title: 'Navn', data: 'name'}, // 2
            {title: 'Source', data: 'referer_source'}, // 3
            {title: 'Registrert', data: 'created_at'}, // 4
            {title: 'Sist endret', data: 'updated_at'}, // 5
            {data: 'status'}, // 6
            {title: 'Megler', data: 'brokerName'}, // 7
            {data: 'brokerAvatar'}, // 8
            {data: 'delegatedBrokerName'}, // 9
            {data: 'delegatedBrokerAvatar'}, // 10
            {data: 'phone'}, // 11
            {data: null}
        ],
        columnDefs: [
            {targets: [0, 6, 8, 9, 10, 11], visible: false},
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
                    return `<a class="table-schala-name d-block" href="${window.DATA_TABLE.url_to_show}/${row['id']}">${data}</a>
                            <p>${row['phone']}</p>`;
                }
            },
            {
                targets: 3,
                render: function(data, type, row, meta) {
                    let url = new URL(data, location);
                    let host = url ? url.host : 'n/a';

                    return `<span class="badge badge-pill badge-dark font-weight-normal m--regular-font-size-sm2 p-2">${host}</span>`;
                }
            },
            {
                targets: 4,
                render: function (data, type, row, meta) {
                    let date = moment.unix(data);

                    return `<span class="schala-status">
                        <span class="m-badge m-badge--dot schala-status-registrert"></span>
                        <em>registrert</em>
                    </span><span class="table-schala-time">${date.format('lll')}</span><span class="table-schala-time-ago">${date.fromNow()}</span>`;
                }
            },
            {
                targets: 5,
                render: function (data, type, row, meta) {
                    let date = moment.unix(data);

                    return `<span class="schala-status">
                        <span class="m-badge m-badge--dot schala-status-${row['status']}"></span>
                        <em>${row['status']}</em>
                    </span><span class="table-schala-time">${date.format('lll')}</span><span class="table-schala-time-ago">${date.fromNow()}</span>`;
                }
            },
            {
                targets: 7,
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
                    return `<a href="${window.DATA_TABLE.url_to_show}/${row['id']}" class="btn btn-default btn-sm">Detaljer</a>`
                }
            }
        ],
        initComplete: initCompleteDataTable
    });
});
