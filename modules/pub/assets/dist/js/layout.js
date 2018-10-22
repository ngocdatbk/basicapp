$(document).ready(function () {
    $( document ).on( "click", "label.tree-toggler", function() {
        $(this).parent().children('ul.tree').toggle(300, showDetailMenu(this));
    });

    $( document ).on( "click", "img.show-menu", function() {
        var position = $(".menu_left").position();
        if(position.left < 0)
        {
            $(".menu_left").css({'transform': 'translateX(0)'});
            if($(document).width() >= 768)
                $(".content").animate({'margin-left': '230px'});
        }
        else
        {
            $(".menu_left").css({'transform': 'translateX(-230px)'});
            if($(document).width() >= 768)
                $(".content").animate({'margin-left': '0'});
        }
    });
});

function showDetailMenu(label) {
    return function(e) {
        if($(this).parent().children('ul.tree').css("display") == 'none')
            $(label).children('span').attr('class','glyphicon glyphicon-plus');
        else
            $(label).children('span').attr('class','glyphicon glyphicon-minus');
    };
}