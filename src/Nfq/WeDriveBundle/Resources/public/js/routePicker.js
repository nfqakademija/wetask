/**
 * Created by Ray on 14.5.6.
 */
$(".routeRow").each(function () {
    $(this).mouseover(function () {
        var routeId = $(this).attr('id');
        var coords = routePoints[routeId];
        clearMarkers();
        coordMarkers(coords);
        plotRoute(arrayLatLng(coords));
    })
});
