$(document).ready(function () {
    $( document ).on( "click", ".sidebar-menu li.treeview", function() {
        if (this.classList.contains("active")) {
            unActiveChild(this.parentNode);
        } else {
            unActiveChild(this.parentNode);
            this.classList.add("active");
        }
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
    if (childNodes.length) {
        childNodes[0].classList.remove("active");
        unActiveChild(parent);
    }
}