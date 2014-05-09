/**
 * Created by Ray on 14.5.6.
 */

var lastPickedRoute;

$(".routeRow").each(function () {
    $(this).mouseover(function () {
        var routeId = $(this).attr('id');
        if (routeId != lastPickedRoute) {
            var coords = routePoints[routeId];
            displayRoute(coords);
            lastPickedRoute = routeId;
        }
    })
});

$(".tripRow").each(function () {
    $(this).mouseover(function () {
        var tripId = $(this).attr('id');
        if (tripId != lastPickedRoute) {
            var coords = tripPoints[tripId];
            displayRoute(coords);
            lastPickedRoute = tripId;
        }
    })
});

function displayRoute(coords) {
    var latLngPoints = arrayLatLng(coords);
    for (var i = 0; i < 4; i++) {
        refitMap(latLngPoints);
    }
    clearMarkers();
    coordMarkers(coords);
    plotRoute(latLngPoints);
}
