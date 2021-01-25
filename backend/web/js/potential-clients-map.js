let GoogleMap = {
    map: false,
    markers: [],
    marker_status: {
        current: '/admin/images/markers/current.svg',
        rest: '/admin/images/markers/rest.svg'
    },
    init: function () {
        this.markers = [];
        let input = $('input[data-gmap-search]');
        let button = $('button[data-gmap-search]');
        this.center = new google.maps.LatLng(59.9139, 10.7522);

        const darkStyle = new google.maps.StyledMapType(
            [
                {
                    'elementType': 'geometry',
                    'stylers': [
                        {
                            'color': '#212121'
                        }
                    ]
                },
                {
                    'elementType': 'geometry.fill',
                    'stylers': [
                        {
                            'color': '#0e0e0e'
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
                            'color': '#757575'
                        }
                    ]
                },
                {
                    'elementType': 'labels.text.stroke',
                    'stylers': [
                        {
                            'color': '#212121'
                        }
                    ]
                },
                {
                    'featureType': 'administrative',
                    'elementType': 'geometry',
                    'stylers': [
                        {
                            'color': '#757575'
                        },
                        {
                            'visibility': 'off'
                        }
                    ]
                },
                {
                    'featureType': 'administrative.country',
                    'elementType': 'labels.text.fill',
                    'stylers': [
                        {
                            'color': '#9e9e9e'
                        }
                    ]
                },
                {
                    'featureType': 'administrative.land_parcel',
                    'stylers': [
                        {
                            'visibility': 'off'
                        }
                    ]
                },
                {
                    'featureType': 'administrative.locality',
                    'elementType': 'labels.text.fill',
                    'stylers': [
                        {
                            'color': '#bdbdbd'
                        }
                    ]
                },
                {
                    'featureType': 'administrative.neighborhood',
                    'stylers': [
                        {
                            'visibility': 'off'
                        }
                    ]
                },
                {
                    'featureType': 'poi',
                    'stylers': [
                        {
                            'visibility': 'off'
                        }
                    ]
                },
                {
                    'featureType': 'poi',
                    'elementType': 'labels.text',
                    'stylers': [
                        {
                            'visibility': 'off'
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
                            'color': '#181818'
                        }
                    ]
                },
                {
                    'featureType': 'poi.park',
                    'elementType': 'labels.text.fill',
                    'stylers': [
                        {
                            'color': '#616161'
                        }
                    ]
                },
                {
                    'featureType': 'poi.park',
                    'elementType': 'labels.text.stroke',
                    'stylers': [
                        {
                            'color': '#1b1b1b'
                        }
                    ]
                },
                {
                    'featureType': 'road',
                    'elementType': 'geometry.fill',
                    'stylers': [
                        {
                            'color': '#2c2c2c'
                        }
                    ]
                },
                {
                    'featureType': 'road',
                    'elementType': 'labels',
                    'stylers': [
                        {
                            'visibility': 'off'
                        }
                    ]
                },
                {
                    'featureType': 'road',
                    'elementType': 'labels.icon',
                    'stylers': [
                        {
                            'visibility': 'off'
                        }
                    ]
                },
                {
                    'featureType': 'road',
                    'elementType': 'labels.text.fill',
                    'stylers': [
                        {
                            'color': '#8a8a8a'
                        }
                    ]
                },
                {
                    'featureType': 'road.arterial',
                    'elementType': 'geometry',
                    'stylers': [
                        {
                            'color': '#373737'
                        }
                    ]
                },
                {
                    'featureType': 'road.arterial',
                    'elementType': 'geometry.fill',
                    'stylers': [
                        {
                            'color': '#055046'
                        }
                    ]
                },
                {
                    'featureType': 'road.highway',
                    'elementType': 'geometry',
                    'stylers': [
                        {
                            'color': '#3c3c3c'
                        }
                    ]
                },
                {
                    'featureType': 'road.highway',
                    'elementType': 'geometry.fill',
                    'stylers': [
                        {
                            'color': '#055046'
                        }
                    ]
                },
                {
                    'featureType': 'road.highway.controlled_access',
                    'elementType': 'geometry',
                    'stylers': [
                        {
                            'color': '#4e4e4e'
                        }
                    ]
                },
                {
                    'featureType': 'road.local',
                    'elementType': 'geometry.fill',
                    'stylers': [
                        {
                            'color': '#055046'
                        }
                    ]
                },
                {
                    'featureType': 'road.local',
                    'elementType': 'labels.text.fill',
                    'stylers': [
                        {
                            'color': '#616161'
                        }
                    ]
                },
                {
                    'featureType': 'transit',
                    'stylers': [
                        {
                            'visibility': 'off'
                        }
                    ]
                },
                {
                    'featureType': 'transit',
                    'elementType': 'labels.text.fill',
                    'stylers': [
                        {
                            'color': '#757575'
                        }
                    ]
                },
                {
                    'featureType': 'water',
                    'elementType': 'geometry',
                    'stylers': [
                        {
                            'color': '#01173d'
                        }
                    ]
                },
                {
                    'featureType': 'water',
                    'elementType': 'geometry.fill',
                    'stylers': [
                        {
                            'color': '#112c2e'
                        }
                    ]
                },
                {
                    'featureType': 'water',
                    'elementType': 'labels.text',
                    'stylers': [
                        {
                            'visibility': 'off'
                        }
                    ]
                },
                {
                    'featureType': 'water',
                    'elementType': 'labels.text.fill',
                    'stylers': [
                        {
                            'color': '#112c2e'
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

        this.map = new google.maps.Map(document.getElementById('map'), {
            center: this.center,
            zoom: 10,
            controlSize: 24,
            mapTypeControlOptions: {
                mapTypeIds: ['dark', 'light']
            }
        });

        this.map.mapTypes.set('dark', darkStyle);
        this.map.mapTypes.set('light', lightStyle);

        // Default style
        this.map.setMapTypeId('dark');

        this.circle = new google.maps.Circle({
            center: this.center,
            map: this.map,
            strokeColor: 'orange',
            strokeOpacity: .9,
            fillColor: 'orange',
            fillOpacity: .1,
            strokeWeight: 2,
            zIndex: 1,
            radius: 10000,
            draggable: true,
            editable: true
        });

        let self = this;

        google.maps.event.addListener(this.circle, 'center_changed', function () {
            self.circleWasChanged(this)
        });

        google.maps.event.addListener(this.circle, 'radius_changed', function () {
            self.circleWasChanged(this)
        });

        button.click(function () {
            if (input.val()) self.addMarkers(input.val());
        });

        input.keydown(function (e) {
            if (e.keyCode === 13 && input.val()) self.addMarkers(input.val());
        });

        this.fetchCoords();
    },

    fetchCoords: function () {
        let self = this;

        $.ajax({
            type: 'POST',
            url: window.Schala.baseUrl + '/clients/get-coord-map',
            data: $('#data-table-filter').serializeArray(),
            dataType: 'json',
            success: function (result) {
                console.log('result',result);
                self.coords = result;
                self.circleWasChanged(self.circle);
            }
        });
    },

    circleWasChanged: function (circle) {
        let self = this;

        clearTimeout(this.timer);

        this.timer = setTimeout(function () {
            console.log('circleWasChanged', self, circle);

            let f1 = self.deg2rad(circle.center.lat());
            let d1 = self.deg2rad(circle.center.lng());
            let postNumbers = [];

            self.coords.forEach(function (val) {
                let f2 = self.deg2rad(val.lat);
                let d2 = self.deg2rad(val.lng);

                let df = Math.sin((f1 - f2) / 2);
                let dd = Math.sin((d1 - d2) / 2);

                // sin²(Δφ/2)
                df *= df;
                // sin²(Δλ/2)
                dd *= dd;

                // sin²(Δφ/2) + cos φ1 ⋅ cos φ2 ⋅ sin²(Δλ/2)
                let a = df + Math.cos(f1) * Math.cos(f2) * dd;

                // 2 ⋅ atan2(√a, √(1−a))
                let c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

                // R ⋅ c
                let L = 6371000 * c;

                postNumbers = L < circle.radius
                    ? postNumbers.concat(val.postNumbers)
                    : postNumbers;
            });

            postNumbers = [...new Set(postNumbers)];

            if (postNumbers.length < 1) {
                postNumbers[0] = -1;
            }

            $('#forms-post_number')
                .val(postNumbers)
                .change();

        }, 200);
    },

    addMarkers: function (address) {
        for (let i = 0; i < this.markers.length; i++) {
            this.markers[i].setMap(null);
        }
        this.markers = [];
        $.ajax({
            url: window.location.href + '?address=' + address,
            dataType: 'json',
            async: false,
            type: 'GET',
            success: (result) => {
                $('span[data-gmap-count]').html(`ANTALL : ${result ? result.length : 0}`);
                if (result) {
                    let infoWindow, marker, temp_marker;
                    result.forEach((element) => {

                        infoWindow = new google.maps.InfoWindow({content: '<span class="text-info bold">' + element.address + '</span>'});

                        marker = new google.maps.Marker({
                            position: new google.maps.LatLng(element.lat, element.lng),
                            map: this.map,
                            id: element.id,
                            zIndex: 1,
                            info: infoWindow,
                            icon: this.marker_status.rest
                        });

                        //events
                        google.maps.event.addListener(marker, 'click', ((marker) => {
                            return () => {
                                if (temp_marker !== undefined) {
                                    temp_marker.info.close();
                                    temp_marker.setIcon(this.marker_status.rest);
                                    temp_marker.zIndex = 1;
                                }
                                marker.setIcon(this.marker_status.current);
                                marker.zIndex = 20;
                                marker.info.open(this.map, marker);
                                temp_marker = marker;
                            }
                        })(marker));

                        this.markers.push(marker);

                    });
                }
            }
        });


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

function initPotentialClientsMap() {
    GoogleMap.init();
}
