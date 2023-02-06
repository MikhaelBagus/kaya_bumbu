$(document).ready(function () {

    //Do action when size large less than 769px
    if ($(window).width() <= 768) {
        $(".content-sidebar").removeClass("d-flex flex-row");

    }
    else {
        $(".content-sidebar").addClass("d-flex flex-row");
    }
    $(window).resize(function () {
        if ($(window).width() <= 768) {
            $(".content-sidebar").removeClass("d-flex flex-row");

        }
        else {
            $(".content-sidebar").addClass("d-flex flex-row");
        }
    });
});