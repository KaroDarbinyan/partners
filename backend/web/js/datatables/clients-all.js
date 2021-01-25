window.addEventListener('load', function () {
  $('#data-table').DataTable({
    responsive: true,
    processing: true,
    serverSide: true,
    stateSave: false,
    pageLength: 25,
    dom: "<'row'<'col-sm-12 col-md-6'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-6'p>>",
    ajax: {
      url: window.DATA_TABLE.action,
      type: 'POST',
      data: function (data) {

      }
    },
    drawCallback: function (settings) {

    },
    order: [[6, 'desc']],
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
      {data: 'name', title: 'Navn'}, // 1
      {data: 'phone'}, // 2
      {data: 'hotCount', title: 'Hot'}, // 3
      {data: 'coldCount', title: 'Cold'}, // 4
      {data: 'created_at', title: 'Registrert'}, // 5
      {data: 'last_contact', title: 'Siste kontakt'}, // 6
      {data: 'status'}, // 7
      {data: null}
    ],
    columnDefs: [
      {targets: [0, 2, 7], visible: false},
      {targets: [0], searchable: false},
      {
        targets: 1,
        render: function (data, type, row, meta) {
          return `<a class="table-schala-name d-block text-blur--" href="${window.DATA_TABLE.url_to_show}/${row['id']}" target="_blank">${data}</a>
                            <p class="text-blur--">${row['phone']}</p>`;
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

          if (!row['status']) {
            row['status'] = 'Ukjent status';
          }

          return `<span class="schala-status">
                        <span class="m-badge m-badge--dot schala-status-${row['status']}"></span>
                        <em>${row['status']}</em>
                    </span><span class="table-schala-time">${date.format('lll')}</span><span class="table-schala-time-ago">${date.fromNow()}</span>`;
        }
      },
      {
        targets: -1,
        title: 'Handlinger',
        orderable: false,
        render: function (data, type, row, meta) {
          return `<a href="${window.DATA_TABLE.url_to_show}/${row['id']}" class="btn btn-default btn-sm">Detaljer</a>`;
        }
      }
    ],
    initComplete: function () {
      let api = this.api();
      let state = api.state.loaded();

    }
  });
});
