function initMap() {
	var styledMapType = new google.maps.StyledMapType(
	[
	  {
		"elementType": "geometry",
		"stylers": [
		  {
			"color": "#212121"
		  }
		]
	  },
	  {
		"elementType": "geometry.fill",
		"stylers": [
		  {
			"color": "#0e0e0e"
		  }
		]
	  },
	  {
		"elementType": "labels.icon",
		"stylers": [
		  {
			"visibility": "off"
		  }
		]
	  },
	  {
		"elementType": "labels.text.fill",
		"stylers": [
		  {
			"color": "#757575"
		  }
		]
	  },
	  {
		"elementType": "labels.text.stroke",
		"stylers": [
		  {
			"color": "#212121"
		  }
		]
	  },
	  {
		"featureType": "administrative",
		"elementType": "geometry",
		"stylers": [
		  {
			"color": "#757575"
		  },
		  {
			"visibility": "off"
		  }
		]
	  },
	  {
		"featureType": "administrative.country",
		"elementType": "labels.text.fill",
		"stylers": [
		  {
			"color": "#9e9e9e"
		  }
		]
	  },
	  {
		"featureType": "administrative.land_parcel",
		"stylers": [
		  {
			"visibility": "off"
		  }
		]
	  },
	  {
		"featureType": "administrative.locality",
		"elementType": "labels.text.fill",
		"stylers": [
		  {
			"color": "#bdbdbd"
		  }
		]
	  },
	  {
		"featureType": "administrative.neighborhood",
		"stylers": [
		  {
			"visibility": "off"
		  }
		]
	  },
	  {
		"featureType": "poi",
		"stylers": [
		  {
			"visibility": "off"
		  }
		]
	  },
	  {
		"featureType": "poi",
		"elementType": "labels.text",
		"stylers": [
		  {
			"visibility": "off"
		  }
		]
	  },
	  {
		"featureType": "poi",
		"elementType": "labels.text.fill",
		"stylers": [
		  {
			"color": "#757575"
		  }
		]
	  },
	  {
		"featureType": "poi.park",
		"elementType": "geometry",
		"stylers": [
		  {
			"color": "#181818"
		  }
		]
	  },
	  {
		"featureType": "poi.park",
		"elementType": "labels.text.fill",
		"stylers": [
		  {
			"color": "#616161"
		  }
		]
	  },
	  {
		"featureType": "poi.park",
		"elementType": "labels.text.stroke",
		"stylers": [
		  {
			"color": "#1b1b1b"
		  }
		]
	  },
	  {
		"featureType": "road",
		"elementType": "geometry.fill",
		"stylers": [
		  {
			"color": "#2c2c2c"
		  }
		]
	  },
	  {
		"featureType": "road",
		"elementType": "labels",
		"stylers": [
		  {
			"visibility": "off"
		  }
		]
	  },
	  {
		"featureType": "road",
		"elementType": "labels.icon",
		"stylers": [
		  {
			"visibility": "off"
		  }
		]
	  },
	  {
		"featureType": "road",
		"elementType": "labels.text.fill",
		"stylers": [
		  {
			"color": "#8a8a8a"
		  }
		]
	  },
	  {
		"featureType": "road.arterial",
		"elementType": "geometry",
		"stylers": [
		  {
			"color": "#373737"
		  }
		]
	  },
	  {
		"featureType": "road.arterial",
		"elementType": "geometry.fill",
		"stylers": [
		  {
			"color": "#055046"
		  }
		]
	  },
	  {
		"featureType": "road.highway",
		"elementType": "geometry",
		"stylers": [
		  {
			"color": "#3c3c3c"
		  }
		]
	  },
	  {
		"featureType": "road.highway",
		"elementType": "geometry.fill",
		"stylers": [
		  {
			"color": "#055046"
		  }
		]
	  },
	  {
		"featureType": "road.highway.controlled_access",
		"elementType": "geometry",
		"stylers": [
		  {
			"color": "#4e4e4e"
		  }
		]
	  },
	  {
		"featureType": "road.local",
		"elementType": "geometry.fill",
		"stylers": [
		  {
			"color": "#055046"
		  }
		]
	  },
	  {
		"featureType": "road.local",
		"elementType": "labels.text.fill",
		"stylers": [
		  {
			"color": "#616161"
		  }
		]
	  },
	  {
		"featureType": "transit",
		"stylers": [
		  {
			"visibility": "off"
		  }
		]
	  },
	  {
		"featureType": "transit",
		"elementType": "labels.text.fill",
		"stylers": [
		  {
			"color": "#757575"
		  }
		]
	  },
	  {
		"featureType": "water",
		"elementType": "geometry",
		"stylers": [
		  {
			"color": "#01173d"
		  }
		]
	  },
	  {
		"featureType": "water",
		"elementType": "geometry.fill",
		"stylers": [
		  {
			"color": "#112c2e"
		  }
		]
	  },
	  {
		"featureType": "water",
		"elementType": "labels.text",
		"stylers": [
		  {
			"visibility": "off"
		  }
		]
	  },
	  {
		"featureType": "water",
		"elementType": "labels.text.fill",
		"stylers": [
		  {
			"color": "#112c2e"
		  }
		]
	  }
	],
	{name: 'Mørk'});

	var styledMapType2 = new google.maps.StyledMapType(
	[
	  {
		"elementType": "geometry",
		"stylers": [
		  {
			"color": "#e1e1e1"
		  }
		]
	  },
	  {
		"elementType": "labels.icon",
		"stylers": [
		  {
			"visibility": "off"
		  }
		]
	  },
	  {
		"elementType": "labels.text.fill",
		"stylers": [
		  {
			"color": "#616161"
		  }
		]
	  },
	  {
		"featureType": "administrative.land_parcel",
		"elementType": "labels.text.fill",
		"stylers": [
		  {
			"color": "#bdbdbd"
		  }
		]
	  },
	  {
		"featureType": "landscape",
		"stylers": [
		  {
			"hue": "#FFBB00"
		  },
		  {
			"saturation": 43.400000000000006
		  },
		  {
			"lightness": 37.599999999999994
		  },
		  {
			"gamma": 1
		  }
		]
	  },
	  {
		"featureType": "poi",
		"stylers": [
		  {
			"hue": "#00FF6A"
		  },
		  {
			"saturation": -1.0989010989011234
		  },
		  {
			"lightness": 11.200000000000017
		  },
		  {
			"gamma": 1
		  }
		]
	  },
	  {
		"featureType": "poi",
		"elementType": "geometry",
		"stylers": [
		  {
			"color": "#eeeeee"
		  }
		]
	  },
	  {
		"featureType": "poi",
		"elementType": "labels.text.fill",
		"stylers": [
		  {
			"color": "#757575"
		  }
		]
	  },
	  {
		"featureType": "poi.park",
		"elementType": "geometry",
		"stylers": [
		  {
			"color": "#cdfee3"
		  }
		]
	  },
	  {
		"featureType": "poi.park",
		"elementType": "labels.text.fill",
		"stylers": [
		  {
			"color": "#9e9e9e"
		  }
		]
	  },
	  {
		"featureType": "road",
		"elementType": "geometry",
		"stylers": [
		  {
			"color": "#ffffff"
		  }
		]
	  },
	  {
		"featureType": "road",
		"elementType": "geometry.stroke",
		"stylers": [
		  {
			"color": "#dedede"
		  }
		]
	  },
	  {
		"featureType": "road.arterial",
		"stylers": [
		  {
			"hue": "#FF0300"
		  },
		  {
			"saturation": -100
		  },
		  {
			"lightness": 51.19999999999999
		  },
		  {
			"gamma": 1
		  }
		]
	  },
	  {
		"featureType": "road.arterial",
		"elementType": "labels.text.fill",
		"stylers": [
		  {
			"color": "#757575"
		  }
		]
	  },
	  {
		"featureType": "road.highway",
		"stylers": [
		  {
			"saturation": -60
		  },
		  {
			"lightness": 45
		  }
		]
	  },
	  {
		"featureType": "road.highway",
		"elementType": "geometry",
		"stylers": [
		  {
			"color": "#dadada"
		  }
		]
	  },
	  {
		"featureType": "road.highway",
		"elementType": "labels.text.fill",
		"stylers": [
		  {
			"color": "#616161"
		  }
		]
	  },
	  {
		"featureType": "road.local",
		"stylers": [
		  {
			"hue": "#FF0300"
		  },
		  {
			"saturation": -100
		  },
		  {
			"lightness": 52
		  },
		  {
			"gamma": 1
		  }
		]
	  },
	  {
		"featureType": "road.local",
		"elementType": "labels.text.fill",
		"stylers": [
		  {
			"color": "#9e9e9e"
		  }
		]
	  },
	  {
		"featureType": "transit.line",
		"elementType": "geometry",
		"stylers": [
		  {
			"color": "#e5e5e5"
		  }
		]
	  },
	  {
		"featureType": "transit.station",
		"elementType": "geometry",
		"stylers": [
		  {
			"color": "#eeeeee"
		  }
		]
	  },
	  {
		"featureType": "water",
		"stylers": [
		  {
			"saturation": -15
		  }
		]
	  },
	  {
		"featureType": "water",
		"elementType": "geometry.fill",
		"stylers": [
		  {
			"color": "#d6e7fe"
		  }
		]
	  },
	  {
		"featureType": "water",
		"elementType": "labels.text.fill",
		"stylers": [
		  {
			"color": "#9e9e9e"
		  }
		]
	  }
	],
	{name: 'Lys'});		

	var map = new google.maps.Map(document.getElementById('map'), {
	  center: {lat: 59.9250926, lng: 10.7280271},
	  controlSize: 26,
	  zoom: 12,
	  mapTypeControlOptions: {
		mapTypeIds: ['roadmap', 'satellite', 'hybrid', 'terrain', 'styled_map_2', 'styled_map']
	  }
	});

	//Associate the styled map with the MapTypeId and set it to display.
	map.mapTypes.set('styled_map_2', styledMapType2);
	map.setMapTypeId('styled_map_2');
	map.mapTypes.set('styled_map', styledMapType);
	map.setMapTypeId('styled_map');

}




var GoogleMapsDemo = {
	init: function() {
		var t;
		new GMaps({
				div: "#m_gmap_1",
				lat: 59.9250926,
				lng: 10.7280271
			}), new GMaps({
				div: "#m_gmap_2",
				zoom: 16,
				lat: -12.043333,
				lng: -77.028333,
				click: function(t) {
					alert("click")
				},
				dragend: function(t) {
					alert("dragend")
				}
			}), (t = new GMaps({
				div: "#m_gmap_3",
				lat: -51.38739,
				lng: -6.187181
			})).addMarker({
				lat: -51.38739,
				lng: -6.187181,
				title: "Lima",
				details: {
					database_id: 42,
					author: "HPNeo"
				},
				click: function(t) {
					console.log && console.log(t), alert("You clicked in this marker")
				}
			}), t.addMarker({
				lat: -12.042,
				lng: -77.028333,
				title: "Marker with InfoWindow",
				infoWindow: {
					content: '<span style="color:#000">HTML Content!</span>'
				}
			}), t.setZoom(5),
			function() {
				var t = new GMaps({
					div: "#m_gmap_4",
					lat: -12.043333,
					lng: -77.028333
				});
				GMaps.geolocate({
					success: function(e) {
						t.setCenter(e.coords.latitude, e.coords.longitude)
					},
					error: function(t) {
						alert("Geolocation failed: " + t.message)
					},
					not_supported: function() {
						alert("Your browser does not support geolocation")
					},
					always: function() {}
				})
			}(),
			function() {
				var t = new GMaps({
					div: "#m_gmap_5",
					lat: -12.043333,
					lng: -77.028333,
					click: function(t) {
						console.log(t)
					}
				});
				path = [
					[-12.044012922866312, -77.02470665341184],
					[-12.05449279282314, -77.03024273281858],
					[-12.055122327623378, -77.03039293652341],
					[-12.075917129727586, -77.02764635449216],
					[-12.07635776902266, -77.02792530422971],
					[-12.076819390363665, -77.02893381481931],
					[-12.088527520066453, -77.0241058385925],
					[-12.090814532191756, -77.02271108990476]
				], t.drawPolyline({
					path: path,
					strokeColor: "#131540",
					strokeOpacity: .6,
					strokeWeight: 6
				})
			}(), new GMaps({
				div: "#m_gmap_6",
				lat: -12.043333,
				lng: -77.028333
			}).drawPolygon({
				paths: [
					[-12.040397656836609, -77.03373871559225],
					[-12.040248585302038, -77.03993927003302],
					[-12.050047116528843, -77.02448169303511],
					[-12.044804866577001, -77.02154422636042]
				],
				strokeColor: "#BBD8E9",
				strokeOpacity: 1,
				strokeWeight: 3,
				fillColor: "#BBD8E9",
				fillOpacity: .6
			}),
			function() {
				var t = new GMaps({
					div: "#m_gmap_7",
					lat: -12.043333,
					lng: -77.028333
				});
				$("#m_gmap_7_btn").click(function(e) {
					e.preventDefault(), mUtil.scrollTo("m_gmap_7_btn", 400), t.travelRoute({
						origin: [-12.044012922866312, -77.02470665341184],
						destination: [-12.090814532191756, -77.02271108990476],
						travelMode: "driving",
						step: function(e) {
							$("#m_gmap_7_routes").append("<li>" + e.instructions + "</li>"), $("#m_gmap_7_routes li:eq(" + e.step_number + ")").delay(800 * e.step_number).fadeIn(500, function() {
								t.setCenter(e.end_location.lat(), e.end_location.lng()), t.drawPolyline({
									path: e.path,
									strokeColor: "#131540",
									strokeOpacity: .6,
									strokeWeight: 6
								})
							})
						}
					})
				})
			}(),
			function() {
				var t = new GMaps({
						div: "#m_gmap_8",
						lat: -12.043333,
						lng: -77.028333
					}),
					e = function() {
						var e = $.trim($("#m_gmap_8_address").val());
						GMaps.geocode({
							address: e,
							callback: function(e, o) {
								if ("OK" == o) {
									var n = e[0].geometry.location;
									t.setCenter(n.lat(), n.lng()), t.addMarker({
										lat: n.lat(),
										lng: n.lng()
									}), mUtil.scrollTo("m_gmap_8")
								}
							}
						})
					};
				$("#m_gmap_8_btn").click(function(t) {
					t.preventDefault(), e()
				}), $("#m_gmap_8_address").keypress(function(t) {
					"13" == (t.keyCode ? t.keyCode : t.which) && (t.preventDefault(), e())
				})
			}()
	}
};
jQuery(document).ready(function() {
	GoogleMapsDemo.init()
});