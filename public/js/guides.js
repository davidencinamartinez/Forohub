$(document).ready(function() {
	$('.element-date-community, .element-date-users').each(function(index, el) {
		$(this).text(moment($(this).text()).format('LL'));
	});
	$('.element-date-threads').each(function(index, el) {
		$(this).text("Hace "+(moment($(this).text(), 'YYYY-MM-DD HH:mm:ss').fromNow(true)));
	});
});