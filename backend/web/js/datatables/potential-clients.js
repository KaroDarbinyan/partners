window.addEventListener('load', function () {
    $('#data-table').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        stateSave: false,
        pageLength: 10,
        dom: "<'row'<'col-sm-12 col-md-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-6'p>>",
        ajax: {
            url: window.DATA_TABLE.action,
            type: 'POST',
            data: function (data) {
                let priceRange = $('#forms-price_range');
                let areaRange = $('#forms-area_range');
                let created_at = $('#forms-created_at');

                data.columns[4].search.value = created_at.data('from') + '-' + created_at.data('to');
                data.columns[13].search.value = priceRange.data('from') + '-' + priceRange.data('to');
                data.columns[14].search.value = areaRange.data('from') + '-' + areaRange.data('to');
                data.columns[16].search.value = $('#filter_map_coordinates').val();
            }
        },
        drawCallback: function(settings) {
            let pageInfo = this.api().table().page.info();

            $('[data-gmap-count]').html(pageInfo.recordsDisplay);
        },
        order: [[4, 'desc']],
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
            {data: null, name: 'property_type'}, // 12
            {data: null, name: 'price_range'}, // 13
            {data: null, name: 'area_range'}, // 14
            {data: 'post_number'}, // 15
            {data: null, name: 'map_coordinates'}, // 16
        ],
        columnDefs: [
            {targets: [0, 1, 3, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 16], visible: false},
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
                    return `<a class="table-schala-name d-block text-blur--" href="${window.DATA_TABLE.url_to_show}/${row['id']}" target="_blank">${data}</a>
                            <p class="text-blur--">${row['phone']}</p>`;
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
                        <span class="m-badge m-badge--dot schala-status-${row['statys']}"></span>
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
            }/*,
            {
                targets: -1,
                title: 'Handlinger',
                orderable: false,
                render: function (data, type, row, meta) {
                    return `<a href="${window.DATA_TABLE.url_to_show}/${row['id']}" class="btn btn-default btn-sm">Detaljer</a>`
                }
            }*/
        ],
        initComplete: function () {
            let api = this.api();
            let state = api.state.loaded();

            if (state && state.columns) {
                $.each(state.columns, function (i, val) {
                    let input = $('[data-col-index="' + i + '"]');

                    if (input.attr('type') !== 'checkbox') {
                        input.val(val.search.search);
                    } else {
                        input.prop('checked', val.search.search === 'true');
                    }
                });
            }

            const filterForm = $('#data-table-filter');

            filterForm.submit(function (e) {
                e.preventDefault();
                let params = {};

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
                });

                $.each(params, function (i, val) {
                    api
                        .column(i)
                        .search(val ? val : '', false, false);
                });

                api.table().draw();
            });

            $('.js-toggle-data-table').click(function (event) {
                event.preventDefault();

                $('#data-table').fadeToggle(function() {
                    $(this)
                        .closest('.data-table')
                        .toggleClass('invisible');
                });
            });

            $('.js-range-slider').ionRangeSlider({
                skin: 'flat',
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

            $('[data-col-index]').change(function () {
                let self = $(this);

                clearTimeout(self.data('timer'));

                self.data('timer', setTimeout(function () {
                    self.removeData('timer');
                    filterForm.submit();
                }, 500));
            });
        }
    });
});
