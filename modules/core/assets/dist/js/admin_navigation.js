/**
 * Author: KETNV
 * Date: 16-06-2017 11:15:30
 */

function changeType() {
	var type = $('#adminnavigation-permission_type').val();
	var $callback = $('#callback_permission');
	var $permission = $('#adminnavigation-permission');

	switch (type) {
		case 'permission' :
			$permission.removeAttr('disabled');
			$callback.attr('disabled', 'disabled');
			break;
		case 'callback' :
			$permission.attr('disabled', 'disabled');
			$callback.removeAttr('disabled');
			break;
		case 'admin' :
			$callback.attr('disabled', 'disabled');
			$permission.attr('disabled', 'disabled');
			break;
		default :
			$callback.attr('disabled', 'disabled');
			$permission.attr('disabled', 'disabled');
	}
}

function showChild(elem) {
	$(elem).parent().find('.children').slideToggle();
	$(elem).parent().find('.has-child>.fa').toggleClass('fa-angle-down');
}

$('.checkAll').change(function() {
    var checkboxes = $(':checkbox');
    if($(this).is(':checked')) {
        checkboxes.prop('checked', true);
    } else {
        checkboxes.prop('checked', false);
    }
});

if ($('#highlight').length && $('#highlight').parents('div.children').length != 0) {
    $('#highlight').parents('td').children('a').click();
}

$(document).ready(function() {
	if ($('#highlight').length) {
        $('#highlight').effect('highlight', {}, 15000);

        $('html, body').animate({
            scrollTop: $('#highlight').offset().top
        }, 2000);
	}

	changeType();
});