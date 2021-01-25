let GoogleMap = {
    init: function () {
        let mapEnableCheckbox = $('#filter_map_enable');
        let radiusInput = $('#filter_map_circle_radius');
        let latInput = $('#filter_map_latitude');
        let lngInput = $('#filter_map_longitude');

        let center = new google.maps.LatLng(
            latInput.val() ? parseFloat(latInput.val()) : 59.9139,
            lngInput.val() ? parseFloat(lngInput.val()) : 10.7522,
        );

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

        const map = new google.maps.Map(document.getElementById('map'), {
            center: center,
            zoom: 10,
            // minZoom: 9,
            controlSize: 24,
            mapTypeControlOptions: {
                mapTypeIds: ['new', 'roadmap']
            },
            //disableDefaultUI: true
        });

        map.mapTypes.set('new', newStyle);
        // map.mapTypes.set('light', lightStyle);
        // map.mapTypes.set('dark', darkStyle);

        // Default style
        map.setMapTypeId('new');

        let mapCircle = new google.maps.Circle({
            center: center,
            radius: radiusInput.val() || 1000,
            map: map,
            strokeColor: 'orange',
            strokeOpacity: .9,
            fillColor: 'orange',
            fillOpacity: .1,
            strokeWeight: 2,
            zIndex: 1,
            draggable: true,
            // editable: true
        });

        map.fitBounds(mapCircle.getBounds());

        let self = this;

        google.maps.event.addListener(mapCircle, 'center_changed', function () {
            self.circleWasChanged(this)
        });

        google.maps.event.addListener(mapCircle, 'radius_changed', function () {
            //self.circleWasChanged(this)
        });

        let timer;

        radiusInput.change(function () {
            let $self = $(this);

            clearTimeout(timer);

            timer = setTimeout(function () {
                mapCircle.setRadius($self.val() * 1);

                let bounds = new google.maps.LatLngBounds();
                bounds.union(mapCircle.getBounds());

                map.fitBounds(bounds);
                map.panToBounds(bounds);
                
                // 1-4 000 000
                // 20-7
            }, 200);

        });

        mapEnableCheckbox.change(function () {
            let isChecked = $(this).is(':checked');

            if (!isChecked) {
                radiusInput.val('').change();
                latInput.val('').change();
                lngInput.val('').change();
            }

            $('#filterCollapseAreas').find('.input_check').prop('disabled', isChecked);

            radiusInput.data('ionRangeSlider').update({
                block: !isChecked
            })

            let lat = parseFloat(latInput.val() || 59.9139);
            let lng = parseFloat(lngInput.val() || 10.7522);

            mapCircle.setCenter({lat: lat, lng: lng});
        });
    },

    circleWasChanged: function (circle) {
        clearTimeout(this.timer);

        const {radius, center} = circle;

        this.timer = setTimeout(function () {
            $('#filter_map_circle_radius').val(radius).change();
            $('#filter_map_latitude').val(center.lat()).change();
            $('#filter_map_longitude').val(center.lng()).change();
        }, 200);

    },

    /**
     * Convert radiance to degree.
     *
     * @param angle
     *
     * @returns {number}
     */
    deg2rad: function (angle) {
        return (angle / 180) * Math.PI;
    }
};

function initMap() {
    GoogleMap.init();
}
