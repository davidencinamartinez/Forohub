$(document).ready(function() {
	$(document).on('input click', '.thread-community input:first', function(event) {
		NT_getCommunity(this);
	});
	$(document).on('click', '.community-div', function(event) {
		$('.thread-community input:first').val($(this).attr('data-tag'));
		$('.thread-community-container').remove();
	});
	$(document).on('click', 'body:not(.community-div)', function(event) {
		$('.thread-community-container').remove();
	});
	$('.thread-type-option').click(function(event) {
		$('.thread-content').empty();
		$('.thread-type-option').removeClass('active');
		$('#type').val($(this).attr('data-type'));
		$(this).addClass('active');
		NT_pickType($(this).attr('data-type'));
	});
	$(document).on('click', '.append-option', function(event) {
		event.preventDefault();
		NT_appendPollOption();
	});
	$(document).on('click', '.poll-option > button', function(event) {
		event.preventDefault();
		NT_removePollOption(this);
	});
});