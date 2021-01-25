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
				searchDelay: 200
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


var daterangepickerLead = function() {
	var daterangepickerInit = function() {
		if ($('#m_dashboard_daterangepicker').length == 0) {
			return;
		}

		var picker = $('#m_dashboard_daterangepicker');
		var start = moment();
		var end = moment();

		function cb(start, end, label) {
			var title = '';
			var range = '';

			if ((end - start) < 100 || label == 'Today') {
				title = 'Today:';
				range = start.format('MMM D');
			} else if (label == 'Yesterday') {
				title = 'Yesterday:';
				range = start.format('MMM D');
			} else {
				range = start.format('MMM D') + ' - ' + end.format('MMM D');
			}

			picker.find('.m-subheader__daterange-date').html(range);
			picker.find('.m-subheader__daterange-title').html(title);
		}

		picker.daterangepicker({
			direction: mUtil.isRTL(),
			startDate: start,
			endDate: end,
			opens: 'left',
			ranges: {
				'Today': [moment(), moment()],
				'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
				'Last 7 Days': [moment().subtract(6, 'days'), moment()],
				'Last 30 Days': [moment().subtract(29, 'days'), moment()],
				'This Month': [moment().startOf('month'), moment().endOf('month')],
				'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
			}
		}, cb);

		cb(start, end, '');
	}
    return {
        //== Init demos
        init: function() {
            daterangepickerInit();
        }
    };
}();
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
	daterangepickerLead.init();
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