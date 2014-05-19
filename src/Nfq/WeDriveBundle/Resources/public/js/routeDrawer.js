var routeDrawer = {
    init: function init() {
        var drawer = $('<div></div>');
        $(drawer).attr('id', 'routeDrawerPanel');
        var list = $('<ul class="btn-group-vertical"></ul>');
        $(drawer).append(list);
        $("#contentHolder").append(drawer);
        var originalIndex;
        $(list).sortable({
            cancel: ".no-sort",
            start: function (event, ui) {
                originalIndex = ui.placeholder.index() - 1;
            },
            update: function (event, ui) {
                var currentIndex = ui.item.index();
                routeDrawer.Switch(originalIndex, currentIndex);
            }
        }).disableSelection();
    },
    Add: function Add(latLng) {
        if (!(waypoints.length > waypointLimit)) {
            var cell = $('<div></div>');
            $(cell).addClass('cell').addClass('btn').addClass('btn-default');
            $(cell).attr('type', 'button').attr('id', 'markerCell');
            $(cell).append($('<span class="glyphicon glyphicon-map-marker"></span>'));
            $(cell).click(function () {
                routeDrawer.Remove($(this).index());
                $(this).remove();
                plotRoute(markerLatLng(waypoints));
            });
            $(cell).hover(function () {
                var index = $(this).index();
                waypoints[index].setAnimation(google.maps.Animation.BOUNCE);
            });
            $(cell).mouseleave(function () {
                var index = $(this).index();
                waypoints[index].setAnimation(null);
            });
            $("#routeDrawerPanel").find('ul').append(cell);
            addWaypoint(latLng, true);
        }
    },
    Switch: function Switch(original, current) {
        var tmp = waypoints[original];
        waypoints.splice(original, 1);
        waypoints.splice(current, 0, tmp);
        plotRoute(markerLatLng(waypoints));
    },
    Remove: function Remove(index) {
        waypoints[index].setMap(null);
        waypoints.splice(index, 1);
    },
    Load: function Load(routepoints) {
        for (var i = 0; i < routepoints.length; i++) {
            latlng = new google.maps.LatLng(routepoints[i].lat, routepoints[i].lng);
            routeDrawer.Add(latlng);
            console.log("yes");
        }
        plotRoute(markerLatLng(waypoints));
    },
    FetchJSON: function FetchJSON() {
        var latlngs = markerLatLng(waypoints);
        if (latlngs.length > 0) {
            var json = JSON.stringify(latlngs);
        }
        return json;
    }
};
