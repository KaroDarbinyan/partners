/* begin:: TABLE */

var DatatablesSearchOptionsColumnSearch = function() {
	$.fn.dataTable.Api.register("column().title()", function() {
		return $(this.header()).text().trim()
	});
	return {
		init: function() {
			var t;
			t = $("#m_table_1").DataTable({
				responsive: !0,
				lengthMenu: [25, 50, 100, 250],
				
				pageLength: 25,
				language: {
					lengthMenu: "Display _MENU_"
				},
				searchDelay: 200,
				processing: !0,
				serverSide: !0,
				ajax: {
					url: "https://keenthemes.com/metronic/themes/themes/metronic/dist/preview/inc/api/datatables/demos/server.php",
					type: "POST",
					data: {
						columnsDef: ["RecordID", "OrderID", "Country", "ShipCity", "CompanyAgent", "Status", "Type"]
					}
				},
				columns: [{
					data: "RecordID"
				}, {
					data: "OrderID"
				}, {
					data: "Country"
				}, {
					data: "ShipCity"
				}, {
					data: "CompanyAgent"
				}, {
					data: "Status"
				}, {
					data: "Type"
				}],
				columnDefs: [{
					targets: 5,
					render: function(t, a, e, n) {
						var i = {
							1: {
								title: "Solgt",
								class: "m-badge--danger"
							},
							2: {
								title: "Solgt",
								class: " m-badge--danger"
							},
							3: {
								title: "Solgt",
								class: " m-badge--danger"
							},
							4: {
								title: "Solgt",
								class: " m-badge--danger"
							},
							5: {
								title: "Solgt",
								class: " m-badge--danger"
							},
							6: {
								title: "Solgt",
								class: " m-badge--danger"
							},
							7: {
								title: "Solgt",
								class: " m-badge--danger"
							}
						};
						return void 0 === i[t] ? t : '<span class="m-badge ' + i[t].class + ' m-badge--wide">' + i[t].title + "</span>"
					}
				}, {
					targets: 6,
					render: function(t, a, e, n) {
						var i = {
							1: {
								title: "Online",
								state: "danger"
							},
							2: {
								title: "Retail",
								state: "primary"
							},
							3: {
								title: "Direct",
								state: "accent"
							}
						};
						return void 0 === i[t] ? t : '<span class="m-badge m-badge--' + i[t].state + ' m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-' + i[t].state + '">' + i[t].title + "</span>"
					}
				}]
			})
		}
	}
}();

/* end:: TABLE */





/* begin:: RANGE SLIDERS FOR TABLE */

var IONRangeSlider = {
	init: function() {
		$("#m_slider_primaerrom").ionRangeSlider({
			skin: "round",
			type: "double",
			grid: !0,
			min: 0,
			max: 1000,
			from: 0,
			step: 5,
			postfix: "m<sup>2</sup>",
		}), $("#m_slider_prisantydning").ionRangeSlider({
			skin: "round",
			type: "double",
			grid: !0,
			min: 0,
			max: 40000000,
			step: 100000,
			from: 0,
		}), $("#m_slider_salgssum").ionRangeSlider({
			skin: "round",
			type: "double",
			grid: !0,
			min: 0,
			max: 40000000,
			step: 100000,
			from: 0,
		}), $("#m_slider_adresse").ionRangeSlider({
			skin: "round",
			type: "double",
			grid: !0,
			min: 0,
			max: 200,
			step: 1,
			from: 0,
			postfix: " km",
			prefix: "< "
		})
	}
};

/* end:: RANGE SLIDERS FOR TABLE */



/* begin:: DATERANGE PICKER FOR TABLE */

var BootstrapDaterangepicker = {
	init: function() {
		! function() {
			var a = moment().subtract(29, "days"),
				t = moment();
			$("#m_daterangepicker_6").daterangepicker({
				buttonClasses: "m-btn btn",
				applyClass: "btn-primary",
				cancelClass: "btn-secondary",
				startDate: a,
				endDate: t,
				ranges: {
					Today: [moment(), moment()],
					Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
					"Last 7 Days": [moment().subtract(6, "days"), moment()],
					"Last 30 Days": [moment().subtract(29, "days"), moment()],
					"This Month": [moment().startOf("month"), moment().endOf("month")],
					"Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
				}
			}, function(a, t, n) {
				$("#m_daterangepicker_6 .form-control").val(a.format("MM/DD/YYYY") + " / " + t.format("MM/DD/YYYY"))
			})
		}()
	}
};

/* end:: DATERANGE PICKER FOR TABLE */




/* begin:: SELECT2 FOR TABLE */

/* W E    M U S T    U S E    A J A X.   T H E R E   I S    A N    E X A M P L E */


var Select2 = {
	init: function() {
		$("#m_solgte_postnummer, #m_solgte_postnummer_validate").select2({
			placeholder: "Velg postnummer"
		}), $("#m_solgte_megler, #m_solgte_megler_validate").select2({
			placeholder: "Velg megler"
		}), $("#m_solgte_kontorer, #m_solgte_kontorer_validate").select2({
			placeholder: "Velg kontor"
		}), $("#m_solgte_byggear, #m_solgte_byggear_validate").select2({
			placeholder: "Velg byggeår"
		}), $("#m_solgte_medlem, #m_solgte_medlem_validate").select2({
			placeholder: "Velg medlem"
		}), $("#m_solgte_eindomstype, #m_solgte_eindomstype_validate").select2({
			placeholder: "Velg eindomstype"
		}), $("#_________AJAX_______").select2({
			placeholder: "Search for git repositories",
			allowClear: !0,
			ajax: {
				url: "https://api.github.com/search/repositories",
				dataType: "json",
				delay: 250,
				data: function(e) {
					return {
						q: e.term,
						page: e.page
					}
				},
				processResults: function(e, t) {
					return t.page = t.page || 1, {
						results: e.items,
						pagination: {
							more: 30 * t.page < e.total_count
						}
					}
				},
				cache: !0
			},
			escapeMarkup: function(e) {
				return e
			},
			minimumInputLength: 1,
			templateResult: function(e) {
				if (e.loading) return e.text;
				var t = "<div class='select2-result-repository clearfix'><div class='select2-result-repository__meta'><div class='select2-result-repository__title'>" + e.full_name + "</div>";
				return e.description && (t += "<div class='select2-result-repository__description'>" + e.description + "</div>"), t += "<div class='select2-result-repository__statistics'><div class='select2-result-repository__forks'><i class='fa fa-flash'></i> " + e.forks_count + " Forks</div><div class='select2-result-repository__stargazers'><i class='fa fa-star'></i> " + e.stargazers_count + " Stars</div><div class='select2-result-repository__watchers'><i class='fa fa-eye'></i> " + e.watchers_count + " Watchers</div></div></div></div>"
			},
			templateSelection: function(e) {
				return e.full_name || e.text
			}
		})
	}
};

/* end:: SELECT2 FOR TABLE */





jQuery(document).ready(function() {
	IONRangeSlider.init();	
	DatatablesSearchOptionsColumnSearch.init()
	BootstrapDaterangepicker.init();
	Select2.init();
	
	
	$('#collapseFilter1').on('click', function () {
		var text=$('#collapseFilter1').html();
		if(text === '<i class="la la-filter"></i> Vis filter'){
			$(this).html('<i class="la la-filter"></i> Tom filter');
		} else{
			$(this).html('<i class="la la-filter"></i> Vis filter');
		}
	});


});