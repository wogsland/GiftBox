function login() {
	var loginLink = $("#login-link");
	loginLink.text("My Account");
	loginLink.attr('href', 'myaccount.html');
	
	$("#settings-link").attr('href', 'settings.html');
	
	$("#create-link").attr('href', 'create.html');

	$.magnificPopup.close();
	document.location.href = 'create.html';
};

function send() {
	$.magnificPopup.close();
};

function unselectWrapper(container) {
	for (var i = 0; i < container.children.length; i++) {
		container.children[i].style.backgroundColor = "white";
	}
}

function selectWrapper(selectedWrapper) {
	var listContainer = document.getElementById("standard-wrappers");
	unselectWrapper(listContainer);
	listContainer = document.getElementById("premium-wrappers");
	unselectWrapper(listContainer);
	selectedWrapper.style.backgroundColor = "gray";
};

function showPremium() {
	var container = $("#multiple-list-container");
	var button = document.getElementById('show-premium');
	if (container.height() == 280) {
		TweenLite.to("#multiple-list-container", 1, {height:580});
		button.innerHTML = "Hide Specialty Wrappers";
	} else {
		TweenLite.to("#multiple-list-container", 1, {height:280});
		button.innerHTML = "Show Specialty Wrappers";
	}
};

$(document).ready(function(){
	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
		$('body,html').animate({scrollTop: 2000}, 10000); 
	}
});

$(document).ready(function() {

	var carousel = $("#carousel").featureCarousel({
		// include options like this:
		// (use quotes only for string values, and no trailing comma after last option)
		// option: value,
		// option: value
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
	.to("#blank-template-over", .3, {opacity: 1}, "-=.15")
	.to("#blank-template-over", 2, {top: 800})
	.to("#blank-template", 2, {top: 800}, "-=2")
	.to("#rhcp-logo", 2, {top: 836}, "-=2")
	.to("#search-box", 2, {top: 800}, "-=2")
	;
		
	var t2 = new TimelineLite();
	t2
	.from("#search-box-2", 2, {opacity:0}, "+=.5")
	.from("#blank-template-2", 2, {opacity:0}, "-=1.5")
	.to("#text-reveal-2", 1, {left:265})
	.to("#text-reveal-2", 1, {width:20}, "-=1")
	.from("#download", 1, {scale:0}, "-=1")
	.to("#download", 1, {left: 355, top: 20})
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

function handleDragStart(e) {
	e.dataTransfer.effectAllowed = 'move';
	e.dataTransfer.setData('text', this.src);
}

function handleDragOver(e) {
	if (e.preventDefault) {
		e.preventDefault(); // Necessary. Allows us to drop.
	}
	e.dataTransfer.dropEffect = 'move';

	return false;
}

function handleDragEnter(e) {
	this.classList.add('over');
}

function handleDragLeave(e) {
	this.classList.remove('over');  // this / e.target is previous target element.
}

function handleDrop(e) {
	if (e.preventDefault) {
		e.preventDefault(); // Necessary. Allows us to drop.
	}
	this.classList.remove('over');
	var src = e.dataTransfer.getData('text');
	var img = e.dataTransfer.getData('application/x-moz-nativeimage');
	
	this.style.backgroundImage = "url('"+src+"')";
	this.style.backgroundRepeat = "no-repeat";
	this.style.backgroundSize = "contain";
	this.style.backgroundPosition = "center";

	return false;
}

function handleDragEnd(e) {
	this.classList.remove('over');
}

function handleSearch(field) {
	var textLength = field.value.length;
	var index = 1;
	
	var images = document.querySelectorAll('.result-image');
	[].forEach.call(images, function(image) {
		if (index <= textLength) {
			image.style.display = "inline";
		} else {
			image.style.display = "none";
		}
		index += 1;
	});
}


//Parallax Effect
$(document).ready(function(){
	var $window = $(window); 

    $('section[data-type="background"]').each(function(){
        var $bgobj = $(this); // assigning the object
     
        $(window).scroll(function() {
			var yPos = -( ($window.scrollTop() - $bgobj.offset().top) / $bgobj.data('speed'));


             
            // Put together our final background position
            var coords = '50% '+ yPos + 'px';
 
            // Move the background
            $bgobj.css({ backgroundPosition: coords });
        }); 
    });    
});
