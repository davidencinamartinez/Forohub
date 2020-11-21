function threadEmptyTitle() {
	$('.error').remove();
	var status = 0;
	if ($('input[name="thread_title"]').val().replace(/\s/g, "").length <= 0 ) {
		errorDisplay($('#replyButton'),'Debes ponerle un nombre al tema antes de crearlo.');
		status = false;
	} else {
		status = true;
	}
	return status;
}