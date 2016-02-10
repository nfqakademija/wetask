/**
 * Created by Edvinas on 14.5.12.
 */

$(".joinButton").click(function (event) {
    event.preventDefault();

//    $(".joinButton100").each.html('opaopaopaa');
    console.log($('#'+this.id).attr('action'));
    var buttonId = this.id;
    $.ajax({
        type: "POST",
        url: $('#'+this.id).attr('action'),
        data: {},
        dataType: 'json',
        success: function(data) {
            console.log('asdasd');
            $('#'+ buttonId).html(data.buttonName);
        }
    });
});
