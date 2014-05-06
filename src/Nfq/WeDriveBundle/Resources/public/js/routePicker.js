/**
* Created by Ray on 14.5.6.
*/
$(".routeRow").each(function (){
    $(this).hover(function (){
        var routeId = $(this).attr('id');
        var coords = routePoints[routeId];
        plotRoute(coords);
    })
})
