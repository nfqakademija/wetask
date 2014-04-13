/**
 * Created by Ray on 14.3.27.
 */
var currentLocation = new google.maps.LatLng(54.696164, 25.277769);
var mapCenter = new google.maps.LatLng(54.682167934292465,25.224266052246094);
var map;
var waypoints = new Array();
var waypointlim = 8;

function Initialise() {
    var mapElement = document.getElementById("map-canvas");

    var mapOptions = {
        center: mapCenter,
        zoom: 13,
        mapTypeControl: true,
        mapTypeControlOptions: {
            style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
            position: google.maps.ControlPosition.BOTTOM_CENTER
        },
        panControl: true,
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
        addWaypoint(event);
    });
}
function addWaypoint(event) {
    if (!(waypoints.length > waypointlim)) {
        var waypoint = new google.maps.Marker({
            animation: google.maps.Animation.DROP,
            position: event.latLng,
            map: map
        });
        waypoints.push(waypoint);

//        var entry = createWaypointItem();
//        entry.text(event.latLng.toString());
//        $("#waypointdisplay").append(entry);
    }else{
//        var entry = createWaypointItem();
//        entry.text("waypoint limit reached");
//        $("#waypointdisplay").append(entry);
    }
};
//function createWaypointItem(){
//    var item = $(document.createElement('div'));
//    item.addClass('panel');
//    item.addClass('panel-default');
//    var a = $(document.createElement('a'));
//    a.addClass('none');
//    item.append(item);
//    return item;
//}
google.maps.event.addDomListener(window, 'load', Initialise);
