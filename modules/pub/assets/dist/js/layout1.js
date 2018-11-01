$(document).ready(function () {
    $(".menu-ver > .ver-container > .ver-header > div:first-child > button").on('click',function() {
        $(".menu-ver .ver-container").animate({left: -$(".menu-ver .ver-container").width()},function() {
            $(".menu-ver").css("display",'none');
        });
    });
    $(".menu-ver").on('click',function(e) {
        if (e.target === e.currentTarget) {
            $(".menu-ver .ver-container").animate({left: -$(".menu-ver .ver-container").width()},function() {
                $(".menu-ver").css("display",'none');
            });
        }
    });

    $(".header > .container-fluid> .header-button button").on('click',function() {
        $(".menu-ver").css("display",'block');
        $(".menu-ver .ver-container").animate({left: 0});
    });
});