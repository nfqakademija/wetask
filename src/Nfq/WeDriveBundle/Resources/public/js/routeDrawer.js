var routeDrawer = {
    init: function init() {
        var drawer = $('<div></div>');
//        var cell = $('<div></div>');
//        $(drawer).addClass('btn-group');
        $(drawer).attr('id', 'routeDrawerPanel');
//        $(cell).addClass('cell').addClass('btn').addClass('btn-primary').addClass('no-sort');
//        $(cell).attr('type', 'button');
//        $(cell).append($('<span class="glyphicon glyphicon-home"></span> '))
//        $(drawer).append(cell);
        var list = $('<ul class="btn-group-vertical"></ul>');
        $(drawer).append(list);
        $("#contentHolder").append(drawer);
        $(list).sortable({
            cancel: ".no-sort"
        }).disableSelection();
    },
    Add: function Add(event) {
        if (!(waypoints.length > waypointlim)) {
            var cell = $('<div></div>');
            $(cell).addClass('cell').addClass('btn').addClass('btn-default');
            $(cell).attr('type', 'button');
            $(cell).append($('<span class="glyphicon glyphicon-map-marker"></span>'));
            $("#routeDrawerPanel").find('ul').append(cell);
            addWaypoint(event.latLng, true);
        }
    }
};
