var DatatablesSearchOptionsColumnSearch = function() {
	$.fn.dataTable.Api.register("column().title()", function() {
		return $(this.header()).text().trim()
	});
	return {
		init: function() {
			var t;
			t = $("#m_table_1").DataTable({
				responsive: !0,
				dom: "<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
				lengthMenu: [10, 25, 50, 100, 200],
				pageLength: 25,
				language: {
					lengthMenu: "Display _MENU_"
				},
				searchDelay: 500,
				processing: !0,
				serverSide: !0,
				ajax: {
					url: "https://00001.su/INVOLVE/leads/demo-solgte.php",
					type: "POST",
					data: {
						columnsDef: ["Adresse", "Akseptdato", "Country", "ShipCity", "CompanyAgent", "ShipDate", "Status"]
					}
				},
				columns: [{
					data: "Adresse"
				}, {
					data: "Akseptdato"
				}, {
					data: "Country"
				}, {
					data: "ShipCity"
				}, {
					data: "CompanyAgent"
				}, {
					data: "ShipDate"
				}, {
					data: "Status"
				}],
				initComplete: function() {
					var a = $('<tr class="filter"></tr>').appendTo($(t.table().header()));
					this.api().columns().every(function() {
						var e;
						switch (this.title()) {
							case "Adresse":
								e = $('<div class="input-group"><input type="text" class="form-control form-control-sm form-filter m-input" data-col-index="' + this.index() + '"/></div><div class="input-group"><input type="text" class="form-control form-control-sm form-filter m-input" data-col-index="' + this.index() + '"/></div>');
								break;
							case "Akseptdato":
								e = $('\n\t\t\t\t\t\t\t<div class="input-group date">\n\t\t\t\t\t\t\t\t<input type="text" class="form-control form-control-sm m-input" readonly placeholder="From" id="m_datepicker_1"\n\t\t\t\t\t\t\t\t data-col-index="' + this.index() + '"/>\n\t\t\t\t\t\t\t\t<div class="input-group-append">\n\t\t\t\t\t\t\t\t\t<span class="input-group-text"><i class="la la-calendar-o glyphicon-th"></i></span>\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t<div class="input-group date">\n\t\t\t\t\t\t\t\t<input type="text" class="form-control form-control-sm m-input" readonly placeholder="To" id="m_datepicker_2"\n\t\t\t\t\t\t\t\t data-col-index="' + this.index() + '"/>\n\t\t\t\t\t\t\t\t<div class="input-group-append">\n\t\t\t\t\t\t\t\t\t<span class="input-group-text"><i class="la la-calendar-o glyphicon-th"></i></span>\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t</div>');
								break;
							case "Primærrom":
								e = $('<div class="input-group"><input type="text" class="form-control form-control-sm form-filter m-input" data-col-index="' + this.index() + '"/></div><div class="input-group"><input type="text" class="form-control form-control-sm form-filter m-input" data-col-index="' + this.index() + '"/></div>');
								break;
							case "Prisantydning":
								e = $('<div class="input-group"><input type="text" class="form-control form-control-sm form-filter m-input" data-col-index="' + this.index() + '"/></div><div class="input-group"><input type="text" class="form-control form-control-sm form-filter m-input" data-col-index="' + this.index() + '"/></div>');
								break;
							case "Salgssum":
								e = $('<div class="input-group"><input type="text" class="form-control form-control-sm form-filter m-input" data-col-index="' + this.index() + '"/></div><div class="input-group"><input type="text" class="form-control form-control-sm form-filter m-input" data-col-index="' + this.index() + '"/></div>');
								break;
							case "Salgstid":
								e = $('<div class="input-group"><input type="text" class="form-control form-control-sm form-filter m-input" data-col-index="' + this.index() + '"/></div><div class="input-group"><input type="text" class="form-control form-control-sm form-filter m-input" data-col-index="' + this.index() + '"/></div>');
								break;
						}
						$(e).appendTo($("<th>").appendTo(a))
					}), $("#m_datepicker_1,#m_datepicker_2").datepicker()
				},
				columnDefs: [{
					targets: 6,
					render: function(t, a, e, n) {
						var i = {
							1: {
								title: "Solgt",
								class: " schala-status-red"
							},
							2: {
								title: "Solgt",
								class: " schala-status-red"
							},
							3: {
								title: "Solgt",
								class: " schala-status-red"
							},
							4: {
								title: "Solgt",
								class: " schala-status-red"
							},
							5: {
								title: "Solgt",
								class: " schala-status-red"
							},
							6: {
								title: "Solgt",
								class: " schala-status-red"
							},
							7: {
								title: "Solgt",
								class: " schala-status-red"
							}
						};
						return void 0 === i[t] ? t : '<span class="m-badge ' + i[t].class + ' m-badge--wide">' + i[t].title + "</span>"
					}
				}]
			})
		}
	}
}();
jQuery(document).ready(function() {
	DatatablesSearchOptionsColumnSearch.init()
});