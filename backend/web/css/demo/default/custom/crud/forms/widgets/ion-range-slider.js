var IONRangeSlider = {
	init: function() {
		$("#m_slider_1").ionRangeSlider(), $("#m_slider_2").ionRangeSlider({
			min: 100,
			max: 1e3,
			from: 550
		}), $("#m_slider_3").ionRangeSlider({
			type: "double",
			grid: !0,
			min: 0,
			max: 1e3,
			from: 200,
			to: 800,
			prefix: "$"
		}), $("#m_slider_4").ionRangeSlider({
			type: "double",
			grid: !0,
			min: -1e3,
			max: 1e3,
			from: -500,
			to: 500
		}), $("#m_slider_5").ionRangeSlider({
			type: "double",
			grid: !0,
			min: -12.8,
			max: 12.8,
			from: -3.2,
			to: 3.2,
			step: .1
		}), $("#m_slider_6").ionRangeSlider({
			type: "double",
			grid: !0,
			min: 0,
			max: 1000,
			from: 0,
			postfix: "m<sup>2</sup>"
		}), $("#m_slider_7").ionRangeSlider({
			type: "double",
			min: 100,
			max: 200,
			from: 145,
			to: 155,
			prefix: "Weight: ",
			postfix: " million pounds",
			decorate_both: !0
		}), $("#m_slider_8").ionRangeSlider({
			type: "double",
			grid: !0,
			min: 0,
			max: 500000000,
			from: 0,
		}), $("#m_slider_9").ionRangeSlider({
			type: "double",
			grid: !0,
			min: 0,
			max: 500000000,
			from: 0,
		})
	}
};
jQuery(document).ready(function() {
	IONRangeSlider.init()
});