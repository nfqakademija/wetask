var routeDrawer = {
    init: function init() {
        var drawer = $('<div></div>');
        $(drawer).attr('id', 'routeDrawerPanel');
        var list = $('<ul class="btn-group-vertical"></ul>');
        $(drawer).append(list);
        $("#contentHolder").append(drawer);
        $(list).sortable({
            cancel: ".no-sort"
        }).disableSelection();
    },
    Add: function Add(event) {
        if (!(waypoints.length > waypointLimit)) {
            var cell = $('<div></div>');
            $(cell).addClass('cell').addClass('btn').addClass('btn-default');
            $(cell).attr('type', 'button');
            $(cell).append($('<span class="glyphicon glyphicon-map-marker"></span>'));
            $("#routeDrawerPanel").find('ul').append(cell);
            addWaypoint(event.latLng, true);
        }
    },
    Remove: function Remove() {

    },
    FetchJSON: function FetchJSON() {
        var latlngs = markerLatLng(waypoints);
        if (latlngs.length > 0) {
            var json = JSON.stringify(latlngs);
            console.log(json);
        }
        return json;
    }
};
