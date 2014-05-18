/**
 * Created by Ray on 14.3.27.
 */
var currentLocation = new google.maps.LatLng(54.696164, 25.277769);
var idleCenter = new google.maps.LatLng(54.68901487769897, 25.227699279785);
var map;
var waypoints = [];
var waypointLimit = 8;
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

    google.maps.event.addListener(map, 'click', function (event) {
        if (routeDraw) {
            if (waypoints.length == 0) {
                routeDrawer.init();
            }
            routeDrawer.Add(event.latLng);
            var coords = markerLatLng(waypoints);
            plotRoute(coords);
        }
    });
    google.maps.event.addListenerOnce(map, 'idle', function () {
        if (typeof singleRoutePoints != 'undefined') {
            routeDrawer.Load(singleRoutePoints);
        }
    })
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
        (function (n) {
            setTimeout(function () {
                addWaypoint(n, false);
            }, i * 80);
        }(coord));
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

function addWaypoint(latlng, draggable) {
    if (!(waypoints.length > waypointLimit)) {

        var waypoint = new google.maps.Marker({
            animation: google.maps.Animation.DROP,
            position: latlng,
            map: map,
            draggable: draggable
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
    var bounds = new google.maps.LatLngBounds();

    bounds.extend(currentLocation);

    points.forEach(function (point) {
        bounds.extend(point);
    });

    map.fitBounds(bounds);

    var topRight = bounds.getNorthEast();
    var botLeft = bounds.getSouthWest();

    var topMarginx = overlay.getProjection().fromLatLngToContainerPixel(topRight);
    var topMarginPoint = new google.maps.Point(topMarginx.x, topMarginx.y - 50);
    var topMargin = overlay.getProjection().fromContainerPixelToLatLng(topMarginPoint);

    var botMarginx = overlay.getProjection().fromLatLngToContainerPixel(botLeft);
    var botMarginPoint = new google.maps.Point(botMarginx.x - 420, botMarginx.y);
    var botMargin = overlay.getProjection().fromContainerPixelToLatLng(botMarginPoint);

    var marginBounds = new google.maps.LatLngBounds();

    marginBounds.extend(topMargin);
    marginBounds.extend(botMargin);

    map.fitBounds(marginBounds);
}

google.maps.event.addDomListener(window, 'load', Initialise);
