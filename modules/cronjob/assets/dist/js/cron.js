$(document).ready(function () {
    if ($("#cb_day_of_week").is(":checked")) {
        $("#dayOfWeek").css('display', 'block');
    } else {
        $("#dayOfWeek").css('display', 'none');
    }
    if ($("#cb_day_of_month").is(":checked")) {
        $("#dayOfMonth").css('display', 'block');
    } else {
        $("#dayOfMonth").css('display', 'none');
    }

    $("#cb_day_of_week").click(function () {
        if ($("#cb_day_of_week").is(":checked")) {
            $("#cb_day_of_month").prop('checked', false).parent().attr('class', '');

            $("#dayOfWeek").fadeIn(500, function () {
                $(this).css({"display": "block"});
            });

            $("#dayOfMonth").fadeOut(500, function () {
                $(this).css({"display": "none"});
            });
        } else {
            $("#dayOfWeek").fadeOut(500, function () {
                $(this).css({"display": "none"});
            });
        }
    });

    $("#cb_day_of_month").click(function () {
        if ($("#cb_day_of_month").is(":checked")) {
            $("#cb_day_of_week").prop('checked', false).parent().attr('class', '');
            $("#dayOfMonth").fadeIn(500, function () {
                $(this).css({"display": "block"});
            });

            $("#dayOfWeek").fadeOut(500, function () {
                $(this).css({"display": "none"});
            });
        } else {
            $("#dayOfMonth").fadeOut(500, function () {
                $(this).css({"display": "none"});
            });
        }
    });
});