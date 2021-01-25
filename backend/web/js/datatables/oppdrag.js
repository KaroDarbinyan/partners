window.addEventListener('load', function () {
    $('#data-table').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        stateSave: false,
        pageLength: 25,
        ajax: window.DATA_TABLE.action,
        order: [[7, 'desc']],
        language: {
            'lengthMenu': 'Vise _MENU_',
        },
        columns: [
            {data: 'id'}, // 0
            {title: 'Status', data: 'solgt'}, // 1
            {title: 'Adresse', data: 'adresse'}, // 2
            {title: 'Oppdrag №', data: 'oppdragsnummer'}, // 3
            {title: 'Prisantydning', data: 'prisantydning'}, // 4
            {title: 'Prom', data: 'prom'}, // 5
            {data: 'byggeaar'}, // 6
            {title: 'Registrert', data: 'oppdragsdato'}, // 7
            {title: 'Sist endret', data: 'endretdato'}, // 8
            {title: 'Markedsforingsdato', data: 'markedsforingsdato'}, // 9
            {title: 'Salgsdato', data: 'akseptdato'}, // 10
            {title: 'Leads', data: 'leadsCount'}, // 11
            {title: 'Megler', data: 'user.navn'}, // 12
            {data: 'brokerDepartmentShortName'}, // 13
            {data: 'brokerAvatar'}, // 14
            {data: null}
        ],
        columnDefs: [
            {targets: [0, 4, 5, 6, 8, 11, 13, 14, 15], searchable: false, visible: false},
            {
                targets: 1,
                render: function (data, type, row, meta) {
                    let badge = row['solgt'] === -1
                        ? `<span class="m-badge m-badge--dot schala-type-solgt"></span><em>Solgt</em>`
                        : row['markedsforingsdato'] > 0
                            ? `<span class="m-badge m-badge--dot schala-type-selger"></span><em>Til salgs</em>`
                            : `<span class="m-badge m-badge--dot schala-type-signert"></span><em>Signert</em>`;

                    return `<span class="schala-status">${badge}</span>`;
                }
            },
            {
                targets: 2,
                render: function (data, type, row, meta) {
                    let price = row['prisantydning'] || '';

                    if (price) {
                        price = new Intl.NumberFormat('nb-no').format(price);
                    }

                    let prom = row['prom'] || '';

                    if (prom) {
                        prom += ' m<sup>2</sup>'
                    }

                    let year = row['byggeaar'] || '';

                    return `<a class="table-schala-street d-block" href="${window.DATA_TABLE.url_to_show}/${row['id']}">${data}</a>`
                    + `<div><span class="mr-3">${price}</span>
                            <span class="mr-3">${prom}</span>
                            <span>${year}</span>
                       </div>`;
                }
            },
            {
                targets: 3,
                render: function (data, type, row, meta) {
                    return `<span class="table-schala-time">${data}</span>`;
                }
            },
            {
                targets: 4,
                render: function (data, type, row, meta) {
                    if (!data) {
                        return data;
                    }

                    return new Intl.NumberFormat('nb-no').format(data);
                }
            },
            {
                targets: 5,
                render: function (data, type, row, meta) {
                    if (!data) {
                        return data;
                    }

                    return `${data} m<sup>2</sup>`
                }
            },
            {
                targets: 7,
                render: function (data, type, row, meta) {
                    let date = moment.unix(data);

                    return `<span class="table-schala-time">${date.format('ll')}</span><span class="table-schala-time-ago">${date.fromNow()}</span>`;
                }
            },
            {
                targets: [8, 9],
                render: function (data, type, row, meta) {
                    if (data < 1) {
                        return '';
                    }

                    let date = moment.unix(data);

                    return `<span class="table-schala-time">${date.format('lll')}</span><span class="table-schala-time-ago">${date.fromNow()}</span>`;
                }
            },
            {
                targets: 10,
                render: function (data, type, row, meta) {
                    if (!data) {
                        return '';
                    }

                    let date = moment(data, 'DD.MM.YYYY');

                    return `<span class="table-schala-time">${date.format('ll')}</span><span class="table-schala-time-ago">${date.fromNow()}</span>`;
                }
            },
            {
                targets: 12,
                render: function (data, type, row, meta) {
                    if (data === null) {
                        return ' ';
                    }

                    return `<img src="${row['brokerAvatar']}" class="m--img-rounded m--marginless table-schala-img" alt="">
								<span class="table-schala-time">${data}</span>
								<span class="table-schala-time-ago">${row['brokerDepartmentShortName'] || '/img/users/default.jpg'}</span>`;
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
