function login() {
	var loginLink = $("#login-link");
	loginLink.text("My Account");
	loginLink.attr('href', 'myaccount.html');
	
	$("#settings-link").attr('href', 'settings.html');
	
	$("#create-link").attr('href', 'create.html');

	$.magnificPopup.close();
	document.location.href = 'create.html';
	//blah
};

function send() {
	$.magnificPopup.close();
};

$(document).ready(function(){
	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
		$('body,html').animate({scrollTop: 2000}, 10000); 
	}
});

$(document).ready(function() {

	var carousel = $("#carousel").featureCarousel({
	});

	$("#but_prev").click(function () {
		carousel.prev();
	});
	
	$("#but_next").click(function () {
		carousel.next();
	});
});

$(document).ready(function() {
	$('.open-popup-link').magnificPopup({
		type: 'inline',
		midClick: true
	});
});

$(document).ready(function() {
	var controller = $.superscrollorama();
	var t1 = new TimelineLite();
	
	t1
	.to("#text-reveal", .5, {left:210}, "+=1")
	.to("#text-reveal", .5, {width:80}, "-=.5")
	.from("#rhcp-logo", .5, {scale:0}, "-=.5")
	.to("#rhcp-logo", .5, {left: 368, top: 36})
	.to("#rhcp-logo", .25, {scale:1.4})
	.to("#blank-template", 2, {top: 800})
	.to("#rhcp-logo", 2, {top: 836}, "-=2")
	.to("#search-box", 2, {top: 800}, "-=2")
	;
		
	var t2 = new TimelineLite();
	t2
	.from("#search-box-2", 1.5, {opacity:0}, "+=.5")
	.from("#blank-template-2", 1.5, {opacity:0}, "-=1.5")
	.to("#text-reveal-2", 1, {left:265})
	.to("#text-reveal-2", 1, {width:20}, "-=1")
	.from("#download", 1, {scale:0}, "-=1")
	.to("#download", 1, {left: 335, top: 0})
	.to("#download", .5, {opacity:.5})
	.to("#download", 0, {opacity:0})
	.to("#blank-template-2", 0, {opacity:0})
	.to("#blank-template-3", 0, {opacity:1})
	.to("#blank-template-3", 2, {top:600})
	.to("#blank-template-3", 2, {left:150}, "-=2")
	.to("#blank-template-3", 2, {scale:0.1}, "-=2")
	.to("#box-top", .5, {left:550}, "-=2")
	.to("#box-top", .5, {rotation:90}, "-=2")
	.to("#box-top", .25, {top:520}, "-=2")
	.to("#box-top", .5, {left:380})
	.to("#box-top", .5, {rotation:-0}, "-=.5")
	.to("#box-top", .5, {top:600}, "-=.4")
	;

	controller.addTween('#add-images-section', t1, 1700, -300);
	controller.addTween('#add-downloads-section', t2, 1400, -200);
});

