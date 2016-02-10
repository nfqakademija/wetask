$(document).ready(function () {
    setTimeout(function () {
        $("#flash_container").fadeOut(500, function () {
            $("#flash_container").remove();
        })
    }, 3000);
})
