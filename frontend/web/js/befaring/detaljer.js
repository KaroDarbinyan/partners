let property_details = $('#pd-info').data('json'), map, markers = [];
property_details.prom = property_details.prom === null ? 0 : property_details.prom,
    property_details.prisantydning = property_details.prisantydning === null ? 0 : property_details.prisantydning,
    property_details.byggeaar = property_details.byggeaar === null ? 0 : property_details.byggeaar;
let marker_status = {
    current: '/img/befaring/detaljer/oppdrag/markers/current.svg',
    clicked: '/img/befaring/detaljer/oppdrag/markers/clicked.svg',
    rest: '/img/befaring/detaljer/oppdrag/markers/rest.svg'
};


function initMap() {

    const newStyle = new google.maps.StyledMapType(
        [
            {
                "featureType": "administrative",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "color": "#ffffff"
                    },
                    {
                        "weight": "0.35"
                    }
                ]
            },
            {
                "featureType": "landscape.man_made",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "landscape.man_made",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "color": "#808080"
                    },
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "landscape.natural",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "simplified"
                    },
                    {
                        "saturation": -60
                    },
                    {
                        "lightness": 60
                    },
                    {
                        "color": "#a7a7a7"
                    }
                ]
            },
            {
                "featureType": "landscape.natural.landcover",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#a7a7a7"
                    }
                ]
            },
            {
                "featureType": "landscape.natural.terrain",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#777777"
                    },
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "saturation": -100
                    },
                    {
                        "lightness": 40
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "labels.text",
                "stylers": [
                    {
                        "color": "#ffffff"
                    },
                    {
                        "weight": "0.01"
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
                "featureType": "road.highway",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#9e846e"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#9e846e"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "road.local",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#9e846e"
                    },
                    {
                        "weight": "1.00"
                    }
                ]
            },
            {
                "featureType": "road.local",
                "elementType": "labels.text",
                "stylers": [
                    {
                        "color": "#ffffff"
                    },
                    {
                        "weight": "0.01"
                    }
                ]
            },
            {
                "featureType": "transit",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    },
                    {
                        "saturation": -100
                    },
                    {
                        "lightness": 60
                    }
                ]
            },
            {
                "featureType": "transit.line",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "color": "#6b6b6b"
                    }
                ]
            },
            {
                "featureType": "transit.line",
                "elementType": "geometry",
                "stylers": [
                    {
                        "weight": "1.50"
                    }
                ]
            },
            {
                "featureType": "transit.line",
                "elementType": "labels.text",
                "stylers": [
                    {
                        "color": "#ffffff"
                    },
                    {
                        "weight": "0.01"
                    }
                ]
            },
            {
                "featureType": "transit.station",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "weight": "0.01"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "saturation": -10
                    },
                    {
                        "lightness": 30
                    },
                    {
                        "color": "#3d546d"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "color": "#c7d9fe"
                    },
                    {
                        "weight": "2"
                    }
                ]
            }
        ],
        {name: 'Ny'});

    const darkStyle = new google.maps.StyledMapType(
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
                        "color": "#ababab"
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

    const lightStyle = new google.maps.StyledMapType(
        [
            {
                'elementType': 'geometry',
                'stylers': [
                    {
                        'color': '#e1e1e1'
                    }
                ]
            },
            {
                'elementType': 'labels.icon',
                'stylers': [
                    {
                        'visibility': 'off'
                    }
                ]
            },
            {
                'elementType': 'labels.text.fill',
                'stylers': [
                    {
                        'color': '#616161'
                    }
                ]
            },
            {
                'featureType': 'administrative.land_parcel',
                'elementType': 'labels.text.fill',
                'stylers': [
                    {
                        'color': '#bdbdbd'
                    }
                ]
            },
            {
                'featureType': 'landscape',
                'stylers': [
                    {
                        'hue': '#FFBB00'
                    },
                    {
                        'saturation': 43.400000000000006
                    },
                    {
                        'lightness': 37.599999999999994
                    },
                    {
                        'gamma': 1
                    }
                ]
            },
            {
                'featureType': 'poi',
                'stylers': [
                    {
                        'hue': '#00FF6A'
                    },
                    {
                        'saturation': -1.0989010989011234
                    },
                    {
                        'lightness': 11.200000000000017
                    },
                    {
                        'gamma': 1
                    }
                ]
            },
            {
                'featureType': 'poi',
                'elementType': 'geometry',
                'stylers': [
                    {
                        'color': '#eeeeee'
                    }
                ]
            },
            {
                'featureType': 'poi',
                'elementType': 'labels.text.fill',
                'stylers': [
                    {
                        'color': '#757575'
                    }
                ]
            },
            {
                'featureType': 'poi.park',
                'elementType': 'geometry',
                'stylers': [
                    {
                        'color': '#cdfee3'
                    }
                ]
            },
            {
                'featureType': 'poi.park',
                'elementType': 'labels.text.fill',
                'stylers': [
                    {
                        'color': '#9e9e9e'
                    }
                ]
            },
            {
                'featureType': 'road',
                'elementType': 'geometry',
                'stylers': [
                    {
                        'color': '#ffffff'
                    }
                ]
            },
            {
                'featureType': 'road',
                'elementType': 'geometry.stroke',
                'stylers': [
                    {
                        'color': '#dedede'
                    }
                ]
            },
            {
                'featureType': 'road.arterial',
                'stylers': [
                    {
                        'hue': '#FF0300'
                    },
                    {
                        'saturation': -100
                    },
                    {
                        'lightness': 51.19999999999999
                    },
                    {
                        'gamma': 1
                    }
                ]
            },
            {
                'featureType': 'road.arterial',
                'elementType': 'labels.text.fill',
                'stylers': [
                    {
                        'color': '#757575'
                    }
                ]
            },
            {
                'featureType': 'road.highway',
                'stylers': [
                    {
                        'saturation': -60
                    },
                    {
                        'lightness': 45
                    }
                ]
            },
            {
                'featureType': 'road.highway',
                'elementType': 'geometry',
                'stylers': [
                    {
                        'color': '#dadada'
                    }
                ]
            },
            {
                'featureType': 'road.highway',
                'elementType': 'labels.text.fill',
                'stylers': [
                    {
                        'color': '#616161'
                    }
                ]
            },
            {
                'featureType': 'road.local',
                'stylers': [
                    {
                        'hue': '#FF0300'
                    },
                    {
                        'saturation': -100
                    },
                    {
                        'lightness': 52
                    },
                    {
                        'gamma': 1
                    }
                ]
            },
            {
                'featureType': 'road.local',
                'elementType': 'labels.text.fill',
                'stylers': [
                    {
                        'color': '#9e9e9e'
                    }
                ]
            },
            {
                'featureType': 'transit.line',
                'elementType': 'geometry',
                'stylers': [
                    {
                        'color': '#e5e5e5'
                    }
                ]
            },
            {
                'featureType': 'transit.station',
                'elementType': 'geometry',
                'stylers': [
                    {
                        'color': '#eeeeee'
                    }
                ]
            },
            {
                'featureType': 'water',
                'stylers': [
                    {
                        'saturation': -15
                    }
                ]
            },
            {
                'featureType': 'water',
                'elementType': 'geometry.fill',
                'stylers': [
                    {
                        'color': '#d6e7fe'
                    }
                ]
            },
            {
                'featureType': 'water',
                'elementType': 'labels.text.fill',
                'stylers': [
                    {
                        'color': '#9e9e9e'
                    }
                ]
            }
        ],
        {name: 'Lys'});

    map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 59.9250926, lng: 10.7280271},
        controlSize: 26,
        zoom: 15,
        mapTypeControlOptions: {
            mapTypeIds:['new', 'light', 'dark', 'roadmap']
        }
    });

    map.mapTypes.set('new', newStyle);
    map.mapTypes.set('light', lightStyle);
    map.mapTypes.set('dark', darkStyle);

    // Default style
    map.setMapTypeId('new');


    addMarkers(getProperties({
        meter: property_details.prom,
        price: property_details.prisantydning,
        year: property_details.byggeaar
    }));

}


function addMarkers(locations) {
    if (locations) {
        deleteMarkers();
        let marker, current_marker, temp_marker;
        locations.forEach(function (element) {

            marker = new google.maps.Marker({
                position: new google.maps.LatLng(element.lat, element.lng),
                map: map,
                id: element.id,
                icon: marker_status.rest,
                zIndex: 1,
                info: element.address ? new google.maps.InfoWindow({content: '<span class="text-info bold">' + element.address + '</span>'}) : false,
            });

            if (+element.id === +property_details.id) {
                map.setCenter({lat: +element.lat, lng: +element.lng});
                marker.setIcon(marker_status.current);
                marker.zIndex = 5;
                marker.info.open(map, marker);
                current_marker = marker;
            }

            //events
            google.maps.event.addListener(marker, 'click', (function (marker) {
                return function () {
                    if (marker.id !== property_details.id) {
                        if (temp_marker !== undefined) {
                            temp_marker.setIcon(marker_status.rest);
                            temp_marker.zIndex = 1;
                            temp_marker.info.close();
                        }
                        marker.setIcon(marker_status.clicked);
                        marker.zIndex = 2;
                        marker.info.open(map, marker);
                        temp_marker = marker;
                    }
                    // map.setZoom(15);
                    // map.panTo(this.getPosition());
                    getSingleProperty(marker.id);
                }
            })(marker));

            markers.push(marker);

        });
    }
}

function getProperties(filter) {

    return $.ajax({
        url: '/befaring/oppdrag/all/' + property_details.id,
        dataType: 'json',
        async: false,
        type: 'GET',
        data: {
            filter: filter,
        }
    }).responseJSON;
}

function getSingleProperty(id) {
    $.ajax({
        url: '/befaring/oppdrag/single/' + id,
        async: false,
        success: function (result) {
            if (result) {
                $('#pd-info').html(result);
            }
        }
    });
}

function deleteMarkers() {
    for (let i = 0; i < markers.length; i++) {
        markers[i].setMap(null);
    }
    markers = [];

}

$(function () {

    $('body').on('click', '.about-tabs .about-tabs_item', function (e) {
        e.preventDefault();
        $('.about-tabs .about-tabs_item.tab-active').removeClass('tab-active');
        $(this).addClass('tab-active');
        let href = $(this).attr('href');
        $('.tab-content').hide();
        $(href).show();
    });


    $(document).delegate('#marker-filter', 'click', function () {
        let checkbox = $('#filter-checked');
        if (checkbox.children().hasClass('checked')) {
            checkbox.removeClass('checked').children().removeClass('checked');
            addMarkers(getProperties({}));
        } else {
            checkbox.addClass('checked').children().addClass('checked');
            addMarkers(getProperties({
                meter: property_details.prom,
                price: property_details.prisantydning,
                year: property_details.byggeaar
            }));
        }
    });


    $('body').delegate('#bilder #pd-image', 'click', (function () {
        $.ajax({
            url: '/befaring/oppdrag/images/' + $(this).data('id'),
            async: false,
            success: function (result) {
                if (result) {
                    $('#bilder-slider').html(result);
                    $("#gallery").unitegallery().enterFullscreen();
                    $("#gallery").on("fullscreenchange", function () {
                        if (!document.fullscreenElement) $('#bilder-slider').empty();
                    });
                }
            }
        });
    }));

});
