$(window).scroll(function() {
	if ($(window).scrollTop() > 150) {
		$('#back-top').addClass('show');
	} 
	else {
		$('#back-top').removeClass('show');
	}
});

function backToTop() {
	document.body.scrollTop = 0;
	document.documentElement.scrollTop = 0;
}