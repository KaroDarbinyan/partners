var DatatablesBasicBasic = {
    init: function () {
        var e = $("[data-table = 'oppdrag-details']");
        e.DataTable({
            scrollY: "55vh",
            scrollX: !0,
            responsive: !0,
            dom: "<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 '>>",
            pageLength: 100,
            "initComplete": function (settings, json) {
                $('body').find('.dataTables_scrollBody').addClass("scrollbar");
            },
            order: [
                [0, "asc"]
            ]
        }),
            e.on("change", ".m-group-checkable", function () {
                var e = $(this).closest("table").find("td:first-child .m-checkable"),
                    a = $(this).is(":checked");
                $(e).each(function () {
                    a ? ($(this).prop("checked", !0), $(this).closest("tr").addClass("active")) : ($(this).prop("checked", !1), $(this).closest("tr").removeClass("active"))
                })
            }),
            e.on("change", "tbody tr .m-checkbox", function () {
                $(this).parents("tr").toggleClass("active")
            });
    }
};
jQuery(document).ready(function () {

    let forventet_salgspris = $('.forventet_salgspris');
    let saveButton = forventet_salgspris.find('a');

    forventet_salgspris.find('input').keyup(function () {
        if ($(this).val()) {
            $(this).val(parseInt($(this).val().replace(/\D/g, '')).toLocaleString('fi-FI'))
        }
    })
        .focusin(function () {
            saveButton.click((e) => {
                e.preventDefault();
                saveButton.find('i').removeClass('fa-check').addClass('fa-spinner fa-pulse')
                $.post(forventet_salgspris.data('action'), {forventet_salgspris: $(this).val().replace(/\s+/g, '')}).done(function () {
                    saveButton.find('i').removeClass('fa-spinner fa-pulse').addClass('fa-check')
                });
            });
        })
        .keypress(function (e) {
            return (e.which !== 13) && $.isNumeric(e.key);
        });

    DatatablesBasicBasic.init();

});