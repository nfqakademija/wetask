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
            start: function(event, ui) {
                originalIndex = ui.placeholder.index()-1;
            },
            update: function (event, ui) {
                var currentIndex = ui.item.index();
                routeDrawer.Switch(originalIndex, currentIndex);
            }
        }).disableSelection();
    },
    Add: function Add(event) {
        if (!(waypoints.length > waypointLimit)) {
            var cell = $('<div></div>');
            $(cell).addClass('cell').addClass('btn').addClass('btn-default');
            $(cell).attr('type', 'button');
            $(cell).append($('<span class="glyphicon glyphicon-map-marker"></span>'));
            $(cell).mouseover(function(){
                var index = $(this).index();
                waypoints[index].setAnimation(google.maps.Animation.BOUNCE);
            });
            $(cell).mouseout(function(){
                var index = $(this).index();
                waypoints[index].setAnimation(null);
            });
            $("#routeDrawerPanel").find('ul').append(cell);
            addWaypoint(event.latLng, true);
        }
    },
    Switch: function Switch(original, current) {
        var tmp = waypoints[original];
        waypoints.splice(original, 1);
        waypoints.splice(current, 0, tmp);
        plotRoute(markerLatLng(waypoints));
    },
    Remove: function Remove() {

    },
    FetchJSON: function FetchJSON() {
        var latlngs = markerLatLng(waypoints);
        if (latlngs.length > 0) {
            var json = JSON.stringify(latlngs);
        }
        return json;
    }
};
