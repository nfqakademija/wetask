/**
 * Created by Ray on 14.3.27.
 */
var currentLocation = new google.maps.LatLng(54.696164, 25.277769);
var idleCenter = new google.maps.LatLng(54.68901487769897, 25.227699279785);
var initialisedCenter = idleCenter;          //TODO Set initialised to a new coordinate location
var map;
var waypoints = new Array();
var waypointlim = 8;
var waypointlinreached = false;
var elemAvailableTrips = $("");
var elemRoutePlanner = $("");

function Initialise() {
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

    google.maps.event.addListener(map, 'rightclick', function (event) {
        console.log('Current waypoints elements:' + waypoints.length);
        if (waypoints.length == 0) {
            startRoutePlan();
        }
        addWaypoint(event);
    });
    function startRoutePlan() {
        hideAvailableTrips();
        showRoutePlanner();
    }

    function finishRoutePlan() {
        hideRoutePlanner();
        showAvailableTrips();
        waypoints.length = 0;
    }
}
function addWaypoint(event) {
    if (!(waypoints.length > waypointlim)) {
        var waypoint = new google.maps.Marker({
            animation: google.maps.Animation.DROP,
            position: event.latLng,
            map: map
        });
        waypoints.push(waypoint);
    } else {
    }
};
function hideAvailableTrips() {
    console.log('trying to hide available trips');
}
function showAvailableTrips() {
    console.log('trying to show available trips');
}
function showRoutePlanner() {
    console.log('trying to show routePlanner');
    //Add event listeners like added marker or something
    //Initialise variables
    //Initialise form
    map.panTo(initialisedCenter);
}
function hideRoutePlanner() {
    console.log('trying to hide route planner');
    //Remove event listeners
    //Clear form variables
    //Hide form
    //recenter the map
    map.panTo(idleCenter);
}
google.maps.event.addDomListener(window, 'load', Initialise);
