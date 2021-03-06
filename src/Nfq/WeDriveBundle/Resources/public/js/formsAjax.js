/**
 * Created by Ray on 14.5.13.
 */
$("#routeForm").submit(function (event) {
    event.preventDefault();
    if (waypoints.length != 0) {
        var url = $(this).attr("action");

        $(this).children("#route_routePoints").val(routeDrawer.FetchJSON());
        var formData = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            error: function (XMLHttpRequest) {
            },
            success: function (data) {
                window.location = data;
            }
        });
    } else {
        alert("No actual route specified");
    }
})
;

$("#tripForm").submit(function (event) {
    event.preventDefault();
    if (waypoints.length != 0) {
        var url = $(this).attr("action");

        $("#trip_route_routePoints").val(routeDrawer.FetchJSON());
        $("#trip_routePoints").val(routeDrawer.FetchJSON());
        var formData = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            error: function (XMLHttpRequest) {
            },
            success: function (data) {
                window.location = data;
            }
        });
    } else {
        alert("No actual route specified");
    }

});
