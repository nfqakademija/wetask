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
    Add: function Add(event) {
        if (!(waypoints.length > waypointLimit)) {
            var cell = $('<div></div>');
            $(cell).addClass('cell').addClass('btn').addClass('btn-default');
            $(cell).attr('type', 'button').attr('id','markerCell');
            $(cell).append($('<span class="glyphicon glyphicon-map-marker"></span>'));
            var delBtn = $('<span id="routedel" class="glyphicon glyphicon-remove"></span>');
            $(delBtn).click(function() {
                routeDrawer.Remove($(this).parent().index());
                $(this).parent().remove();
                plotRoute(markerLatLng(waypoints));
            });
            $(cell).append(delBtn);
            $(cell).hover(function () {
                var index = $(this).index();
                waypoints[index].setAnimation(google.maps.Animation.BOUNCE);
            });
            $(cell).mouseleave(function () {
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
    Remove: function Remove(index) {
        waypoints[index].setMap(null);
        waypoints.splice(index, 1);
    },
    FetchJSON: function FetchJSON() {
        var latlngs = markerLatLng(waypoints);
        if (latlngs.length > 0) {
            var json = JSON.stringify(latlngs);
        }
        return json;
    }
};
$(document).mouseup(function(event){
    var popocontainer = jQuery(".popover");
    if (popocontainer.has(event.target).length === 0){
        jQuery('.popover').toggleClass('in').remove();
    }
});
