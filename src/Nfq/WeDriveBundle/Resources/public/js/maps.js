/**
 * Created by Ray on 14.3.27.
 */
var currentLocation = new google.maps.LatLng(54.696164, 25.277769);
var idleCenter = new google.maps.LatLng(54.68901487769897, 25.227699279785);
var map;
var waypoints = new Array();
var waypointlim = 8;

var routeWaypoints = new Array();

var elemAvailableTrips = $("");
var elemRoutePlanner = $("");

function Initialise() {
    directionsService = new google.maps.DirectionsService();
    directionsDisplay = new google.maps.DirectionsRenderer({
        'draggable':true,
        'suppressMarkers':true,
//        'markerOptions':{
//            animation: google.maps.Animation.DROP,
//            flat:false,
//            raiseOnDrag:true
//        },
        'polylineOptions':{
            editable:false,
            draggable:false,
            clickable:false,
            strokeColor:'#736AFF',
            strokeWeight:5,
            strokeOpacity:0.9
        },
        'preserveViewport': true,
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
        addWaypoint(event);
        plotRoute();
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

function plotRoute(){
    var routeOrigin = currentLocation;
    var routeDestinationWaypoint = waypoints[waypoints.length-1];

    var routeDestination = routeDestinationWaypoint.getPosition();

    var routeWaypoints =[];

    if (waypoints.length > 1){
        for (var i = 0,n = waypoints.length;i<n;i++){
            routeWaypoints[i] = {location:waypoints[i].getPosition(),
                stopover:true}
        }
        routeWaypoints.pop();
    }
    console.log(routeWaypoints);

    var request = {
        origin: routeOrigin,
        destination: routeDestination,
        travelMode: google.maps.TravelMode.DRIVING,
        waypoints:routeWaypoints,
        //provideRouteAlternatives: Boolean,
        region: 'lt'
    };

    directionsService.route(request, function (response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
        }
    });
};

function addWaypoint(event) {
    if (!(waypoints.length > waypointlim)) {

        var waypoint = new google.maps.Marker({
            animation: google.maps.Animation.DROP,
            position: event.latLng,
            map: map,
            draggable:true
        });

        waypoints.push(waypoint);

        google.maps.event.addListener(waypoint,'dragend',function() {
            plotRoute();
        });
    } else {
    }
};

function hideAvailableTrips() {
}
function showAvailableTrips() {
}
function showRoutePlanner() {
    //Add event listeners like added marker or something
    //Initialise variables
    //Initialise form
}
function hideRoutePlanner() {
    //Remove event listeners
    //Clear form variables
    //Hide form
    //recenter the map
}
google.maps.event.addDomListener(window, 'load', Initialise);
