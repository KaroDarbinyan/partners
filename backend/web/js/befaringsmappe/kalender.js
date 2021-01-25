var CalendarBasic = {
	init: function() {
		var e = moment().startOf("day"),
			t = e.format("YYYY-MM"),
			i = e.clone().subtract(1, "day").format("YYYY-MM-DD"),
			n = e.format("YYYY-MM-DD"),
			r = e.clone().add(1, "day").format("YYYY-MM-DD");
		$("#m_calendar").fullCalendar({
			isRTL: mUtil.isRTL(),
			header: {
				left: "prev,next",
				center: "title",
				right: "month,listWeek"
			},
			editable: !0,
			eventLimit: !0,
			navLinks: !0,
			events: [{
				title: "Befaring",
				start: t + "-01",
				description: "",
				className: "m-fc-event--solid-visning"
			}, {
				title: "Visning",
				start: r + "T07:00:00",
				description: "Lorem ipsum dolor sit amet, scing",
				className: "m-fc-event--solid-visning"
			}, {
				title: "Click for Google",
				url: "http://google.com/",
				start: t + "-28",
				className: "m-fc-event--solid-info m-fc-event--light",
				description: "Lorem ipsum dolor sit amet, labore"
			}],
			eventRender: function(e, t) {
				t.hasClass("fc-day-grid-event") ? (t.data("content", e.description), t.data("placement", "top"), mApp.initPopover(t)) : t.hasClass("fc-time-grid-event") ? t.find(".fc-title").append('<div class="fc-description">' + e.description + "</div>") : 0 !== t.find(".fc-list-item-title").lenght && t.find(".fc-list-item-title").append('<div class="fc-description">' + e.description + "</div>")
			}
		})
	}
};
jQuery(document).ready(function() {
	CalendarBasic.init()
});