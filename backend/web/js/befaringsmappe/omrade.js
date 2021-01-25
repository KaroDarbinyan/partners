var DatatablesBasicBasic = {
	init: function() {
		var e;
		(e = $("#m_table_1")).DataTable({
			scrollY: "55vh",
			scrollX: !0,
			responsive: !0,
			dom: "<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 '>>",
			pageLength: 100,
			"initComplete": function(settings, json) {
				$('body').find('.dataTables_scrollBody').addClass("scrollbar");
			},
			order: [
				[2, "asc"]
			]
		}), e.on("change", ".m-group-checkable", function() {
			var e = $(this).closest("table").find("td:first-child .m-checkable"),
				a = $(this).is(":checked");
			$(e).each(function() {
				a ? ($(this).prop("checked", !0), $(this).closest("tr").addClass("active")) : ($(this).prop("checked", !1), $(this).closest("tr").removeClass("active"))
			})
		}), e.on("change", "tbody tr .m-checkbox", function() {
			$(this).parents("tr").toggleClass("active")
		})
	}
};
jQuery(document).ready(function() {
	DatatablesBasicBasic.init()
});