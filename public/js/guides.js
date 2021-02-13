$(document).ready(function() {
	$('.community-date').each(function(index, el) {
		$(this).text(moment($(this).text()).format('LL'));
	});
});