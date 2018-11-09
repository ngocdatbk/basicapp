$(document).ready(function () {
    $( document ).on( "click", "label.tree-toggler", function() {
        $(this).parent().children('ul.tree').toggle(300, showDetailMenu(this));
    });

    $( document ).on( "click", "a.show-menu", function() {
        if($(".content_menu").css("display") == 'table-cell')
        {
            $(".content_menu").css("display",'none');
        }
        else
        {
            $(".content_menu").css("display",'table-cell');
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