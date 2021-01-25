window.addEventListener('load', function () {
    $('#data-table').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        stateSave: false,
        pageLength: 10,
        dom: "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-12'p>>",
        ajax: {
            url: window.DATA_TABLE.action,
            type: 'POST',
            data: function (data) {
                let priceRange = $('#forms-price_range');
                let areaRange = $('#forms-area_range');
                let created_at = $('#forms-created_at');

                data.columns[3].search.value = created_at.data('from') + '-' + created_at.data('to');
                data.columns[7].search.value = priceRange.data('from') + '-' + priceRange.data('to');
                data.columns[8].search.value = areaRange.data('from') + '-' + areaRange.data('to');
                data.columns[10].search.value = $('#filter_map_coordinates').val();
            }
        },
        drawCallback: function(settings) {
            let pageInfo = this.api().table().page.info();

            $('.potential-clients-count').text(pageInfo.recordsDisplay);
        },
        order: [[2, 'desc']],
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
                last: 'Siste',
                next: 'Neste',
                previous: 'Tidligere'
            },
            aria: {
                sortAscending: ': sorter stigende',
                sortDescending: ': sorter synkende'
            }
        },
        columns: [
            {data: 'id'}, // 0
            {data: 'type'}, // 1
            {title: 'Navn', data: 'name'}, // 2
            {title: 'Registrert', data: 'created_at'}, // 3
            {data: 'latestLogType'}, // 4
            {data: 'phone'}, // 5
            {data: null, name: 'property_type'}, // 6
            {data: null, name: 'price_range'}, // 7
            {data: null, name: 'area_range'}, // 8
            {data: 'post_number'}, // 9
            {data: null, name: 'map_coordinates'}, // 10
        ],
        columnDefs: [
            {
                targets: [0, 1, 4, 5, 6, 7, 8, 9, 10],
                visible: false
            },
            {
                targets: 2,
                render: function(data, type, row, meta) {
                    return `<strong class="table-schala-name text-blur noselect">${data}</strong>
                            <p class="text-blur noselect">${row['phone']}</p>`;
                }
            },
            {
                targets: 3,
                render: function (data, type, row, meta) {
                    let date = moment.unix(data);

                    return `<span class="schala-status">
                        <span class="m-badge m-badge--dot schala-status-registrert"></span>
                        <em>registrert</em>
                    </span><span class="table-schala-time">${date.format('lll')}</span>`;
                }
            }
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
                skin: 'flat'
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
