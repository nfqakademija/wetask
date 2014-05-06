/**
 * Created by Ray on 14.3.27.
 */
var currentLocation = new google.maps.LatLng(54.696164, 25.277769);
var idleCenter = new google.maps.LatLng(54.68901487769897, 25.227699279785);
var map;
var waypoints = new Array();
var waypointlim = 8;

function Initialise() {
    directionsService = new google.maps.DirectionsService();
    directionsDisplay = new google.maps.DirectionsRenderer({
        'draggable': true,
        'suppressMarkers': true,
//        'markerOptions':{
//            animation: google.maps.Animation.DROP,
//            flat:false,
//            raiseOnDrag:true
//        },
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

    google.maps.event.addListener(map, 'click', function (event) {
        if (waypoints.length == 0) {
            startRoutePlan();
        }
        addWaypoint(event.latLng);
        var coords = markerLatLng(waypoints)
        plotRoute(coords);
    });

    function startRoutePlan() {
    }
}

function markerLatLng(markers) {
    var coords = new Array();
    for (var i = 0, n = markers.length; i < n; i++) {
//        coords[i] = new google.maps.LatLng(
//            markers[i].getPosition().lat(),
//            markers[i].getPosition().lng()
//        )
        coords[i] = markers[i].getPosition();
    }
    return coords;
}

function plotRoute(coords) {
    var routeOrigin = currentLocation;
    var routeDestination = coords[coords.length - 1];

    var routeWaypoints = Array();

    coords.pop();

    var fixedcoords = new Array();

    for (var i = 0, n = coords.length; i < n; i++) {
        fixedcoords[i] = {
            location: coords[i],
            stopover: true
        }
    }

    console.log(coords);
    console.log(routeDestination);

    var request = {
        origin: routeOrigin,
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
};

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
            var coords = markerLatLng(waypoints)
            plotRoute(coords);
        });
    } else {
    }
};

google.maps.event.addDomListener(window, 'load', Initialise);
