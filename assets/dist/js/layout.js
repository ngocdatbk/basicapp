$(document).ready(function () {
    $( document ).on( "click", ".sidebar-menu li.treeview", function(e) {
        if (this.classList.contains("active")) {
            unActiveChild(this.parentNode);
        } else {
            unActiveChild(this.parentNode);
            this.classList.add("active");
        }
        e.stopPropagation();
    });

    $( document ).on( "click", "a.show-menu", function() {
        if ($(".content_menu").css("display") == 'table-cell') {
            $(".content_menu").css("display",'none');
        } else {
            $(".content_menu").css("display",'table-cell');
        }
    });
});

function unActiveChild(parent) {
    var childNodes = parent.getElementsByClassName("active");
    for (var i = 0; i < childNodes.length; i++) {
        childNodes[i].classList.remove("active");
    }
}