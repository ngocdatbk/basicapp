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

$('.export-selected').on('click', function(event) {
    event.preventDefault();

    var checkedVals = $('.check_value:checkbox:checked').map(function() {
        return this.value;
    }).get();

    var ids = checkedVals.join(',');
    var url = $(this).attr('href');

    if (ids.length > 0) {
        var urlExport = url + '?ids='+ids;
        window.open(urlExport, '_blank');
    } else {
        alert('Vui lòng chọn ít nhất 1 trường dữ liệu');
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