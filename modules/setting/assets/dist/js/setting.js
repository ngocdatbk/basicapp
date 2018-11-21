$(document).ready(function () {
    $( document ).on( "click", ".input_edit", function() {
        var input_id = $(this).attr('input_id');
        //$("#"+input_id).attr('disabled',false).focus();
        if($('[name="SettingModel['+input_id+']"]'))
            $('[name="SettingModel['+input_id+']"]').attr('disabled',false).focus();
        if($('[name="SettingModelPassword['+input_id+']"]'))
            $('[name="SettingModelPassword['+input_id+']"]').attr('disabled',false).focus();
    });

    $( document ).on( "click", ".btn-collapse", function() {
        var content_id = $(this).attr('content_id');
        if(document.getElementById(content_id).classList.contains("active"))
            return;

        var contents = document.getElementsByClassName("tab-pane");
        for (var i = 0; i < contents.length; ++i) {
            var content = contents[i];
            if(content.classList.contains("active"))
                content.classList.remove("active");
        }

        document.getElementById(content_id).classList.toggle("active");
    });
});