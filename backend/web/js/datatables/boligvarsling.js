window.addEventListener('load', function () {
  let collapsedGroups = {}

  function getLatestDate(dates) {
    if (dates.length) {
      return dates.reduce(function (m, i) {
        return (i > m) && i || m;
      }, '');
    }
  }

  $('#boligvarsling-datatable').DataTable({
    responsive: true,
    processing: true,
    serverSide: true,
    stateSave: false,
    pageLength: 25,
    // dom: "<'row'<'col-sm-12 col-md-6'f>>" +
    //   "<'row'<'col-sm-12'tr>>" +
    //   "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-6'p>>",
    ajax: {
      url: window.DATA_TABLE.action,
      type: 'POST'
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
      {data: 'name', name: 'name', title: 'Navn'}, // 0
      {data: 'phone', name: 'phone', visible: false}, // 1
      {data: 'email', name: 'email', visible: false}, // 2
      {data: 'created_at', name: 'created_at', title: 'Siste'}, // 3
      {data: 'totalSubscriptions', name: 'totalSubscriptions', title: 'Abonnementer', searchable: false}, // 4
      {data: null, searchable: false}
    ],
    columnDefs: [
      {
        targets: 0,
        render: function (data, type, row, meta) {
          if (type !== 'display') {
            return data
          }

          return `<a href="#" class="d-block">${data}</a><small class="text-muted">${row.email}</small>`
        }
      },
      {
        targets: 3,
        render: function (data, type, row, meta) {
          if (type !== 'display') {
            return data
          }

          return moment(data).format('ll')
        }
      },
      {
        targets: -1,
        title: 'Handlinger',
        orderable: false,
        render: function (data, type, row, meta) {
          return `<a href="#" class="btn btn-default btn-sm js-boligvarsling-detail" data-email="${row.email}">Detaljer</a>`
        }
      }
    ],
    initComplete: function () {
      let api = this.api();

      $('#boligvarsling-datatable').on('click', '.js-boligvarsling-detail', function (event) {
        event.preventDefault();

        let row = $(this).parents('tr');

        $('.boligvarsling-detail').remove();

        $.post(window.DATA_TABLE.url_to_show, {email: $(this).data('email')}, function (response) {
          row.after(`<tr class="boligvarsling-detail"><td colspan="4">${response}</td></tr>`)
        });
      });
    }
  });
});
