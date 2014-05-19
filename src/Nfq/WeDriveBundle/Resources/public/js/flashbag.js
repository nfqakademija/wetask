$(document).ready(function() {

//    function showFlashBagMessage() {
    if ($('#flash_container').html().length > 0) {
        setTimeout(function() {
            $("#flash_container").fadeOut(500,function() {
                $("#flash_container").hide();
            })
        }, 3000)
    }
//    }
})
