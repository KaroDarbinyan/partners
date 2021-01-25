var WizardDemo = function() {
	$("#m_wizard");
	var e, r, i = $("#m_form");
	return {
		init: function() {
			var n;
			$("#m_wizard"), i = $("#m_form"), (r = new mWizard("m_wizard", {
				startStep: 1
			})).on("beforeNext", function(r) {
				!0 !== e.form() && r.stop()
			}), r.on("change", function(e) {
				mUtil.scrollTop()
			}), r.on("change", function(e) {
				1 === e.getStep() && alert(1)
			}), e = i.validate({
				ignore: ":hidden",
				rules: {
					name: {
						required: !0
					},
					email: {
						required: !0,
						email: !0
					},
					phone: {
						required: !0,
						phoneUS: !0
					},
					postnummer: {
						required: !0
					}
				},
				messages: {
					"account_communication[]": {
						required: "You must select at least one communication option"
					},
					accept: {
						required: "You must accept the Terms and Conditions agreement!"
					}
				},
				invalidHandler: function(e, r) {
					mUtil.scrollTop(), swal({
						title: "",
						text: "There are some errors in your submission. Please correct them.",
						type: "error",
						confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
					})
				},
				submitHandler: function(e) {}
			}), (n = i.find('[data-wizard-action="submit"]')).on("click", function(r) {
				r.preventDefault(), e.form() && (mApp.progress(n), i.ajaxSubmit({
					success: function() {
						mApp.unprogress(n), swal({
							title: "",
							text: "The application has been successfully submitted!",
							type: "success",
							confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
						})
					}
				}))
			})
		}
	}
}();





/* begin:: RANGE SLIDERS FOR TABLE */

var IONRangeSlider = {
	init: function() {
		$("#m_slider_kvm").ionRangeSlider({
			type: "double",
			grid: !0,
			min: 0,
			max: 1000,
			from: 50,
			to:70,
			step: 5,
			postfix: "m<sup>2</sup>"
		}), $("#m_slider_pris").ionRangeSlider({
			type: "double",
			grid: !0,
			min: 0,
			max: 40000000,
			step: 100000,
			from: 2000000,
			to:3500000
		})
	}
};

/* end:: RANGE SLIDERS FOR TABLE */



/* begin:: SELECT2 FOR TABLE */

/* W E    M U S T    U S E    A J A X.   T H E R E   I S    A N    E X A M P L E */


var Select2 = {
	init: function() {
		$("#m_solgte_eindomstype, #m_solgte_eindomstype_validate").select2({
			placeholder: "Velg eindomstype"
		})
	}
};

/* end:: SELECT2 FOR TABLE */

jQuery(document).ready(function() {
	WizardDemo.init();
	IONRangeSlider.init();
	Select2.init();
});