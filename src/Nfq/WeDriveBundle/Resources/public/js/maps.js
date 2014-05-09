/**
 * Created by Ray on 14.3.27.
 */
var currentLocation = new google.maps.LatLng(54.696164, 25.277769);
var idleCenter = new google.maps.LatLng(54.68901487769897, 25.227699279785);
var map;
var waypoints = [];
var waypointlim = 8;
var overlay;

function Initialise() {
    directionsService = new google.maps.DirectionsService();
    directionsDisplay = new google.maps.DirectionsRenderer({
        'draggable': true,
        'suppressMarkers': true,
        'polylineOptions': {
            editable: false,
            draggable: false,
            clickable: false,
            strokeColor: '#736AFF',
            strokeWeight: 5,
            strokeOpacity: 0.9
        },
        'preserveViewport': true
    });

    var mapElement = document.getElementById("map-canvas");

    var mapOptions = {
        center: idleCenter,
        zoom: 13,
        mapTypeControl: true,
        mapTypeControlOptions: {
            style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
            position: google.maps.ControlPosition.BOTTOM_CENTER
        },
        pancontrol: true,
        panControlOptions: {
            position: google.maps.ControlPosition.RIGHT_BOTTOM
        },
        zoomControl: true,
        zoomControlOptions: {
            style: google.maps.ZoomControlStyle.LARGE,
            position: google.maps.ControlPosition.RIGHT_BOTTOM
        },
        scaleControl: true,
        scaleControlOptions: {
            position: google.maps.ControlPosition.RIGHT_BOTTOM
        },
        streetViewControl: true,
        streetViewControlOptions: {
            position: google.maps.ControlPosition.RIGHT_CONTROL
        }
    };

    map = new google.maps.Map(mapElement, mapOptions);
    directionsDisplay.setMap(map);

    overlay = new google.maps.OverlayView();
    overlay.draw = function () {
    };
    overlay.setMap(map);

//    google.maps.event.addListener(map, 'click', function (event) {
//        if (waypoints.length == 0) {
//            startRoutePlan();
//        }
//        addWaypoint(event.latLng);
//        var coords = markerLatLng(waypoints)
//        plotRoute(coords);
//    });
}

function clearMarkers() {
    if (waypoints.length > 0) {
        for (var i = 0; i < waypoints.length; i++) {
            waypoints[i].setMap(null);
        }
        waypoints = [];
    }
}
function arrayLatLng(array) {
    var coords = [];
    for (var i = 0, n = array.length; i < n; i++) {
        coords[i] = new google.maps.LatLng(
            array[i]['lat'],
            array[i]['lng']
        )
    }
    return coords;
}

function coordMarkers(coords) {
    clearMarkers();

    for (var i = 0, n = coords.length; i < n; i++) {
        var coord = new google.maps.LatLng(coords[i]['lat'], coords[i]['lng']);
        addWaypoint(coord);
    }
}

function markerLatLng(markers) {
    var coords = [];
    for (var i = 0, n = markers.length; i < n; i++) {
        coords[i] = markers[i].getPosition();
    }
    return coords;
}

function plotRoute(coords) {
    var routeDestination = coords[coords.length - 1];

    coords.pop();

    var fixedcoords = [];

    for (var i = 0, n = coords.length; i < n; i++) {
        fixedcoords[i] = {
            location: coords[i],
            stopover: true
        }
    }

    var request = {
        origin: currentLocation,
        destination: routeDestination,
        travelMode: google.maps.TravelMode.DRIVING,
        waypoints: fixedcoords,
        //provideRouteAlternatives: Boolean,
        region: 'lt'
    };

    directionsService.route(request, function (response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
        }
    });
}

function addWaypoint(latlng) {
    if (!(waypoints.length > waypointlim)) {

        var waypoint = new google.maps.Marker({
            animation: google.maps.Animation.DROP,
            position: latlng,
            map: map,
            draggable: true
        });

        waypoints.push(waypoint);

        google.maps.event.addListener(waypoint, 'dragend', function () {
            var coords = markerLatLng(waypoints);
            plotRoute(coords);
        });
    } else {
    }
}


function refitMap(points) {
    function marginExtend(point) {
        var marginPoint = overlay.getProjection().fromLatLngToContainerPixel(point);
        var margin1 = new google.maps.Point(marginPoint.x - 300, marginPoint.y - 120);
        var adjCoord1 = overlay.getProjection().fromContainerPixelToLatLng(margin1);
        bounds.extend(adjCoord1);
        var margin2 = new google.maps.Point(marginPoint.x + 50, marginPoint.y + 50);
        var adjCoord2 = overlay.getProjection().fromContainerPixelToLatLng(margin2);
        bounds.extend(adjCoord2);
    }

    var bounds = new google.maps.LatLngBounds();
    marginExtend(currentLocation);
    points.forEach(function (point) {
        marginExtend(point);
    })

    map.fitBounds(bounds);
}

google.maps.event.addDomListener(window, 'load', Initialise);
