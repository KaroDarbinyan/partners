<?php

/* @var $this yii\web\View */

?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Oppdrag Print</title>
  <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.21/af-2.3.5/b-1.6.2/b-colvis-1.6.2/b-flash-1.6.2/b-html5-1.6.2/b-print-1.6.2/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.2/r-2.2.5/rg-1.1.2/rr-1.2.7/sc-2.0.2/sp-1.1.1/sl-1.3.1/datatables.min.css"/>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
  <style>
      body {
          font-family: 'Lato', sans-serif;
      }

      .badge {
          padding: 0.3em .4em;
      }

      .status {
          display: inline-block;
          padding: 0.25rem;
          line-height: 1;
          white-space: nowrap;
          vertical-align: middle;
          border-radius: 50%;
      }

      .status-0 {
          background-color: #007bff;
      }

      .status--1 {
          background-color: #ff002f;
      }

      .badge-success a,
      .badge-dark a {
          color: #fff !important;
      }

      table.dataTable tbody > tr.selected.odd,
      table.dataTable tbody > tr > .selected.odd {
          background-color: #adc4de;
      }

      table.dataTable tbody > tr.selected.even,
      table.dataTable tbody > tr > .selected.even {
          background-color: #96a9bf;
      }

      table.dataTable tbody > tr.selected .text-muted,
      table.dataTable tbody > tr > .selected .text-muted {
          color: #fff !important;
      }

      table.dataTable tbody tr.selected a,
      table.dataTable tbody th.selected a,
      table.dataTable tbody td.selected a {
          color: #4f6671;
      }
  </style>
  <script>
    window.Schala = <?= json_encode([
        'baseUrl' => Yii::getAlias('@web')
    ]) ?>;
  </script>
</head>
<body>

<div class="container-fluid">
  <div>
    <form id="properties-print-filters" class="form-inline my-4">
      <div class="form-group mr-3">
        <select class="form-control form-control-sm" data-col-index="29">
          <option value="">Alle Partnere</option>
          <option value="partners">Partners</option>
          <option value="schala">Schala & Partners</option>
        </select>
      </div>
      <div class="form-group mr-3">
        <input type="text" class="form-control form-control-sm daterange-picker"
               data-col-index="12"
               placeholder="Markedsforingsdato">
      </div>
      <div class="form-group mr-3">
        <input type="text" class="form-control form-control-sm daterange-picker"
               data-col-index="13"
               placeholder="Salgsdato">
      </div>
      <div class="form-group mr-3">
        <label class="form-check-label">
          <input type="checkbox" class="form-check-input" data-col-index="30" checked> Ikke vis nybygg
        </label>
      </div>
      <div class="form-group mr-3">
        <label class="form-check-label">
          <input type="checkbox" class="form-check-input" data-col-index="31" checked> Ikke vis Grimsoen
        </label>
      </div>
      <button type="submit" class="btn btn-primary btn-sm mr-2">Søk</button>
      <button type="reset" class="btn btn-dark btn-sm">Nullstille</button>
    </form>
    <table id="properties-print-table" class="table table-striped table-bordered table-sm">
    </table>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment-with-locales.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript"
        src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.21/af-2.3.5/b-1.6.2/b-colvis-1.6.2/b-flash-1.6.2/b-html5-1.6.2/b-print-1.6.2/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.2/r-2.2.5/rg-1.1.2/rr-1.2.7/sc-2.0.2/sp-1.1.1/sl-1.3.1/datatables.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.15/lodash.min.js"></script>

<script>
  function getArea(property) {
    const columns = {
      'Boligtomt': 'tomteareal',
      'Hyttetomt': 'tomteareal',
      'Næringstomt': 'tomteareal',
      'Parkeringsplass': 'bruksareal',
      'Næringsbygg': 'bruksareal',
      'Forretning': 'bruksareal',
      'Landbrukseiendom': 'bruksareal',
      'Lager': 'bruksareal'
    }

    let column = columns[property.type_eiendomstyper] || 'prom'

    return property[column]
  }

  function bindToolTip() {
    $('[data-toggle="tooltip"]').tooltip()
  }

  $(function () {
    moment.locale('nb')

    bindToolTip()

    $('#properties-print-table').DataTable({
      fixedHeader: true,
      select: {
        style: 'multi'
      },
      processing: true,
      serverSide: true,
      //searching: false,
      pageLength: 100,
      ajax: {
        url: "<?= Yii::getAlias('@web') ?>/oppdrag/print-next-table",
        type: 'POST',
        data: function (data) {
          $('[data-col-index]').each(function () {
            let col = $(this).data('col-index')

            if ($(this).attr('type') === 'checkbox') {
              $(this).val($(this).is(':checked'))
            }

            data.columns[col].search.value = $(this).val()
          })
        }
      },
      order: [[10, 'desc']],
      columns: [
        {title: 'Oppdrag', data: 'oppdragsnummer', name: 'oppdragsnummer'}, // 0
        {title: 'Solgt', data: 'solgt'}, // 1
        {title: 'Adresse', data: 'adresse', name: 'adresse'}, // 2
        {title: 'Postnummer', data: 'postnummer', name: 'property_details.postnummer'}, // 3
        {title: 'Boligtype', data: 'type_eiendomstyper', name: 'type_eiendomstyper'}, // 4
        {title: 'Primærrom', data: 'prom'}, // 5
        {title: 'Tomt', data: 'tomteareal'}, // 6
        {title: 'Bruksareal', data: 'bruksareal'}, // 7
        {title: 'Byggeår', data: 'byggeaar'}, // 8
        {title: 'Soverom', data: 'soverom'}, // 9
        {title: 'Reg. / Marked', data: null, name: 'markedsforingsdato'}, // 10
        {title: 'Registrert', data: 'oppdragsdato'}, // 11
        {title: 'Markedsforingsdato', data: 'markedsforingsdato', name: 'markedsforingsdato'}, // 12
        {title: 'Salgsdato', data: 'akseptdato', name: 'akseptdato'}, // 13
        {title: 'Pris / Total', data: null, name: 'prisantydning'}, // 14
        {title: 'Prisantydning', data: 'prisantydning'}, // 15
        {title: 'Totalpris', data: 'totalkostnadsomtall'}, // 16
        {title: 'Salgssum', data: 'salgssum'}, // 17
        {title: 'Visning', data: 'propertyVisits'}, // 18
        {title: 'FINN', data: 'propertyAds.finn_adid', name: 'property_ads.finn_adid'}, // 19
        {title: 'Vispåfinn', data: 'vispaafinn'}, // 20
        {title: 'Megler', data: 'user.navn', name: 'department.navn'}, // 21
        {data: 'user.url'}, // 22
        {title: 'Kontor', data: 'user.department'}, // 23
        {title: 'Leads', data: 'leadsCount'}, // 24
        {data: 'id'}, // 25
        {title: 'Trafikk', data: null, name: 'property_ads.eiendom_viewings'}, // 26
        {title: 'Besøk på partners.no', data: 'propertyAds.eiendom_viewings'}, // 27
        {title: 'Har besøkt annonsen', data: 'propertyAds.finn_viewings'}, // 28
        {data: null, name: 'partner'}, // 29
        {data: null, name: 'do_not_show_nybygg'}, // 30
        {data: null, name: 'do_not_show_grimsoen'}, // 31
        {title: 'Kommentar', data: 'propertyPrint.comment', name: 'comment'}, // 32
        {title: 'ADV', data: null, name: 'adv_at'}, // 33
        {data: 'propertyPrint.fb_ab_at', name: 'fb_ab_at'}, // 34
        {data: 'propertyPrint.fb_video_at', name: 'fb_video_at'}, // 35
        {data: 'propertyPrint.delta_at', name: 'delta_at'}, // 36
        {data: 'propertyPrint.instagram_at', name: 'instagram_at'}, // 37
        {data: 'propertyPrint.sold_at', name: 'sold_at'}, // 38
        {title: 'FB Video Url', data: 'propertyPrint.fb_video_url', name: 'fb_video_url'} // 39
      ],
      columnDefs: [
        {
          targets: [
            1, 2, 3, 4, 5, 6, 7, 8, 9, 25, // For property
            11, 12, 13, // For dates
            15, 16, 17, // For Prices
            19, 20, 27, 28, // For FINN
            22, 23, // For broker
            29,
            30, 31,
            // For ADV Dates
            34, 35, 36, 37, 38
          ], searchable: false, visible: false
        },
        {
          // Property
          targets: 0,
          render: function (row, type, val, meta) {
            if (type !== 'display') {
              return row
            }

            let zip = val.postnummer.toString().padStart(4, '0')

            let area = getArea(val) || ''

            if (area) {
              area += ' m&sup2;, '
            }

            let rooms = val.soverom || ''

            if (rooms) {
              rooms = `, ${rooms} rom`
            }

            let finnUrl = ''
            let finnLink = 'FINN'

            if (val.propertyAds.finn_adid) {
              finnUrl = `https://www.finn.no/realestate/homes/ad.html?finnkode=${val.propertyAds.finn_adid}`
              finnLink = `<a href="${finnUrl}" target="_blank">FINN</a>`
            }

            if (val.vispaafinn === -1) {
              finnLink = `<span class="badge badge-success">${finnLink}</span>`
            } else {
              finnLink = `<span class="badge badge-dark">${finnLink}</span>`
            }

            return `<a href="/eiendommer/${val.oppdragsnummer}" target="_blank">${val.oppdragsnummer}</a>`
              + ` <span class="status status-${val.solgt}"></span> ${finnLink}<br>`
              + `<small class="text-muted">${val.adresse}, ${zip}</small><br>`
              + `<small class="text-muted">${val.type_eiendomstyper}, ${area}${val.byggeaar}${rooms}</small>`
          }
        },
        {
          targets: 3,
          render: function (row, type, val, meta) {
            if (type === 'export') {
              return row.toString().padStart(4, '0')
            }

            return row
          }
        },
        {
          targets: 10,
          searchable: false,
          render: function (row, type, val, meta) {
            if (type !== 'display') {
              return row
            }

            let sold = val.akseptdato || ''

            if (sold) {
              sold = `<small class="d-block text-success" title="Salgsdato"><span class="badge badge-success mr-1" style="width: 17px">S</span> ${val.akseptdato}</small>`
            }

            let register = moment.unix(val.oppdragsdato)
            let marked = moment.unix(val.markedsforingsdato)

            return sold
              + `<small class="d-block text-dark" title="Markedsforingsdato"> <span class="badge badge-dark mr-1" style="width: 17px">M</span> ${marked.format('DD.MM.YYYY')}</small>`
              + `<small class="d-block text-muted" title="Registrert"><span class="badge badge-secondary mr-1" style="width: 17px">R</span> ${register.format('DD.MM.YYYY')}</small>`
          }
        },
        {
          // Dates
          targets: [11, 12],
          searchable: false,
          render: function (row, type, val, meta) {
            if (type === 'export') {
              return moment.unix(row).format('DD.MM.YYYY')
            }

            return row
          }
        },
        {
          targets: 14,
          searchable: false,
          render: function (row, type, val, meta) {
            let formatter = new Intl.NumberFormat('nb-NB')

            let soldSum = ''

            if (val.salgssum) {
              soldSum = `<small class="d-block text-success">${formatter.format(val.salgssum)}</small>`
            }

            return soldSum
              + `<small class="d-block">${formatter.format(val.prisantydning)}</small>`
              + `<small class="d-block">${formatter.format(val.totalkostnadsomtall)}</small>`
          }
        },
        {
          targets: [15, 16, 17],
          searchable: false,
          render: function (row, type, val, meta) {
            if (type === 'export') {
              let formatter = new Intl.NumberFormat('nb-NB')
              let sum = row || 0

              return formatter.format(sum)
            }

            return row
          }
        },
        {
          // Visning
          targets: 18,
          orderable: false,
          searchable: false,
          render: function (row, type, val, meta) {
            let visits = ''

            for (let key in row) {
              if (row.hasOwnProperty(key)) {
                let visit = row[key]

                let start = moment.unix(visit.fra)
                let end = moment.unix(visit.til)

                visits += `<small class="d-block">${start.format('DD.MM.YYYY [kl.] HH:mm')}-${end.format('HH:mm')}</small>\r\n`
              }
            }

            return visits
          }
        },
        {
          // FINN
          targets: 19,
          render: function (row, type, val, meta) {
            let id = row || ''
            let url = ''
            let link = ''

            if (id) {
              url = `https://www.finn.no/realestate/homes/ad.html?finnkode=${id}`
              link = `<a href="${url}" target="_blank">${id}</a>`
            }

            if (type === 'export') {
              return url
            }

            if (type !== 'display') {
              return row
            }

            if (val.vispaafinn === -1) {
              return `<small class="d-block"><span class="badge badge-success">ON</span></small><small>${link}</small>`
            }

            return `<small class="d-block"><span class="badge badge-dark">OFF</span></small><small>${link}</small>`
          }
        },
        {
          // Broker
          targets: 21,
          render: function (row, type, val, meta) {
            if (type !== 'display') {
              return row
            }

            if (!val.user || !val.user.department) {
              return ''
            }

            return `<small><a href="/kontor/${val.user.department.url}" target="_blank">${val.user.department.navn}</a><br>
                      <a href="/ansatte/${val.user.url}" target="_blank">${val.user.navn}</a>
                    </small>`
          }
        },
        {
          targets: 23,
          render: function (row, type, val, meta) {
            if (type === 'export' && val.user && val.user.department) {
              return val.user.department.navn
            }

            return row
          }
        },
        {
          // Leads
          targets: 24,
          searchable: false,
          render: function (row, type, val, meta) {
            if (type !== 'display') {
              return row
            }

            return `<small><a href="${window.Schala.baseUrl}/oppdrag/interessenter/${val.id}" target="_blank">${row}</a></small>`
          }
        },
        {
          // Trafikk
          targets: 26,
          searchable: false,
          render: function (row, type, val, meta) {
            let views = val.propertyAds.eiendom_viewings || 0

            if (type !== 'display') {
              return views
            }

            return `<small><a href="${window.Schala.baseUrl}/oppdrag/statistikk/${val.id}" target="_blank">
                      ${views}
                    </a></small>`
          }
        },
        {
          // Comment
          targets: 32,
          searchable: false,
          render: function (row, type, val, meta) {
            if (type !== 'display') {
              return row
            }

            return `<div class="form-group">
              <textarea class="form-control form-control-sm js-editable"
                data-id="${val.id}" name="comment" placeholder="En kommentar">${row || ''}</textarea>
            </div>`
          }
        },
        // {
        //   // Dates
        //   targets: [33, 34, 36, 37, 38],
        //   searchable: false,
        //   render: function (row, type, val, meta) {
        //     if (type !== 'display') {
        //       return row
        //     }
        //
        //     let column = meta.settings.aoColumns[meta.col]
        //     let date = ''
        //
        //     if (row) {
        //       date = moment(row).format('MM/DD/YYYY')
        //     }
        //
        //     return `<div class="form-group">
        //       <input class="form-control form-control-sm date-picker js-editable" data-id="${val.id}"
        //         placeholder="Dato" name="${column.name}" type="text" value="${date}" />
        //     </div>`
        //   }
        // },
        {
          targets: 33,
          searchable: false,
          render: function (row, type, val, meta) {
            if (type !== 'display') {
              return row
            }

            let columns = {
              'fb_ab_at': 'FB A/B',
              'fb_video_at': 'FB Video',
              'delta_at': 'Delta',
              'instagram_at': 'Insta',
              'sold_at': 'Solgt'
            }

            let responseHtml = ''

            Object.entries(columns).forEach(function (entry) {
              const [column, label] = entry

              let value = val['propertyPrint'][column] ?? ''

              if (value) {
                value = moment(value).format('MM/DD/YYYY')
              }

              responseHtml += `<div class="form-group row m-0">
                    <label for="${column}" class="col-sm-4 col-form-label">${label}</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control form-control-sm date-picker js-editable"
                        data-id="${val.id}" id="${column}" name="${column}" value="${value}">
                    </div>
                  </div>`
            })

            return responseHtml
          }
        },
        {
          // FB Video URL
          targets: [39],
          searchable: false,
          render: function (row, type, val, meta) {
            if (type !== 'display') {
              return row
            }

            return `<div class="form-group">
              <input class="form-control form-control-sm js-editable" data-id="${val.id}"
                placeholder="Lenke" name="fb_video_url" type="text" value="${row || ''}" />
            </div>`
          }
        }
      ],
      dom: 'Brftip',
      lengthMenu: [
        [20, 50, 100, -1],
        ['20', '50', '100', 'Alle']
      ],
      buttons: [
        {
          extend: 'pageLength',
          text: 'Vise',
          className: 'btn-sm btn-light',
        },
        {
          extend: 'excel',
          text: 'Export',
          className: 'btn-sm btn-success',
          exportOptions: {
            orthogonal: 'export',
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 11, 12, 13, 15, 16, 17, 18, 19, 20, 21, 23, 24, 27, 28],
            modifier: {
              page: 'current'
            }
          }
        }
      ],
      drawCallback: function (settings) {
        let singleDatePickers = $('.date-picker')

        singleDatePickers.daterangepicker({
          autoUpdateInput: false,
          singleDatePicker: true,
          locale: {
            format: 'MM/DD/YYYY'
          }
        })

        singleDatePickers.on('apply.daterangepicker', function (ev, picker) {
          $(this).val(picker.startDate.format('MM/DD/YYYY')).change()
        });
      },

      initComplete: function () {
        let api = this.api()

        bindToolTip()

        let pickers = $('.daterange-picker')

        pickers.daterangepicker({
          autoUpdateInput: false
        })

        pickers.on('apply.daterangepicker', function (ev, picker) {
          $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'))
        });

        let filtersForm = $('#properties-print-filters')

        filtersForm.submit(function (event) {
          event.preventDefault()

          let filters = {}

          $('[data-col-index]').each(function () {
            let col = $(this).data('col-index')

            if ($(this).attr('type') === 'checkbox') {
              $(this).val($(this).is(':checked'))
            }

            if (filters[col]) {
              filters[col] += `|${$(this).val()}`
            } else {
              filters[col] = $(this).val()
            }
          })

          $.each(filters, function (col, val) {
            api.columns(col).search(val ? val : '', false, false)
          })

          api.table().draw()
        })

        filtersForm.bind('reset', function () {
          setTimeout(function () {
            $('[data-col-index]').each(function () {
              $(this).val('');

              api
                .column($(this).data('col-index'))
                .search('', false, false);
            });

            api.state.clear();

            api.table().draw();
          }, 1);
        });

        $(document).on('keyup change', '.js-editable', _.debounce(storeInputValue, 500))
      }
    });
  });

  function storeInputValue() {
    let url = `${window.Schala.baseUrl}/oppdrag/print-store`
    let formData = new FormData()

    formData.append('property_id', $(this).data('id'))

    let value = $(this).val()

    if ($(this).is('.date-picker')) {
      value = moment(value, 'MM/DD/YYYY')
        .format('YYYY-MM-DD HH:mm:ss')
    }

    formData.append($(this).prop('name'), value)

    $.ajax({
      url: url,
      data: formData,
      processData: false,
      contentType: false,
      type: 'POST',
    })
  }
</script>
</body>
</html>