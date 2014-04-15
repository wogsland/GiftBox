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

function hideControls(bento) {
	var sliderId = bento.id + '-slider';
	var closeId = bento.id + '-close';
	var css = '.bento:hover #' + sliderId + '{display: none;} .bento:hover #' + closeId + '{display: none;}';
	var style = document.createElement('style');
	if (style.styleSheet)
		style.styleSheet.cssText = css;
	else 
		style.appendChild(document.createTextNode(css));
	document.getElementsByTagName('head')[0].appendChild(style);
	
	// put the slider on top
	document.getElementById(sliderId).style.zIndex = -9999;
	document.getElementById(closeId).style.zIndex = -9999;
}

function showControls(bento) {
	var sliderId = bento.id + '-slider';
	var closeId = bento.id + '-close';
	var css = '.bento:hover #' + sliderId + '{display: block;} .bento:hover #' + closeId + '{display: block;}';
	var style = document.createElement('style');
	if (style.styleSheet)
		style.styleSheet.cssText = css;
	else 
		style.appendChild(document.createTextNode(css));
	document.getElementsByTagName('head')[0].appendChild(style);
	
	// put the slider on top
	document.getElementById(sliderId).style.zIndex = 9999;
	document.getElementById(closeId).style.zIndex = 9999;
}

function removeChild(parent, childId) {
	var child = document.getElementById(childId);
	if (child) {
		parent.removeChild(child);
	}
}

function removeImage(bento) {
	removeChild(bento, bento.id + '-image-container');
	hideControls(bento);
}

function resizeContainer(bento, img, div) {
	// resize the DIV so that the image covers the bento with no white space
	var widthDiff = img.width - bento.offsetWidth;
	var heightDiff = img.height - bento.offsetHeight;
	var divWidth = bento.offsetWidth + (widthDiff * 2);
	var divHeight = bento.offsetHeight + (heightDiff * 2);
	div.style.width = divWidth + 'px';
	div.style.height = divHeight + 'px';
	div.style.left = (0 - ((divWidth - bento.offsetWidth) / 2)) + 'px';
	div.style.top = (0 - ((divHeight - bento.offsetHeight) / 2)) + 'px';
	img.style.left = ((divWidth / 2) - (img.width / 2)) + 'px';
	img.style.top = ((divHeight / 2) - (img.height / 2)) + 'px';
}

function resizeImage(img, bento) {
	var imgAspectRatio = img.height / img.width;
	var bentoAspectRatio = bento.offsetHeight / bento.offsetWidth;
	if (bentoAspectRatio < imgAspectRatio) {
//		img.width = bento.offsetWidth;
		img.style.height = "auto";
		img.style.width = bento.offsetWidth + "px";
	} else {
//		img.height = bento.offsetHeight;
		img.style.width = "auto";
		img.style.height = bento.offsetHeight + "px";
	}
	img.style.top = 0;
	img.style.left = 0;
	
	// set values for slider scaling
	img.originalWidth = img.width;
	img.originalHeight = img.height;
}

function resizeContents(bento, img, div) {
	resizeImage(img, bento);
	resizeContainer(bento, img, div);
}

function handleDrop(e) {
	if (e.preventDefault) {
		e.preventDefault(); // Necessary. Allows us to drop.
	}
	this.classList.remove('over');
	
	// remove any previously dropped image
	removeImage(this);
	
	// get the drop data
	var src = e.dataTransfer.getData('text');
	
	// create an IMG element
	var img = document.createElement('img');
	
	// create a DIV element
	var div = document.createElement('div');
	
	// set the IMG attributes
	img.setAttribute('src', src);
	var imageId = this.id + '-image';
	img.id = imageId
	
	// set the DIV attributes
	var divId = this.id + '-image-container';
	div.id = divId;
	div.style.position = 'absolute';
	
	// add the IMG to the DIV, add the DIV to the bento
	div.appendChild(img);
	this.appendChild(div);

	// make the IMG draggable inside the DIV
	$('#'+ img.id).draggable({ containment: "#" + div.id});
	
	// now resize the image so that it covers the bento
	resizeImage(img, this);
	
	// resize the image container so that the image has scroll containment
	resizeContainer(this, img, div);	
	
	// change the hover for the bento to show the slider
	showControls(this);
	
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

function handleSliderEvent(event, ui) {
	var bento = event.target.parentNode;
	var nameRoot = bento.id;
	var image = document.getElementById(nameRoot + "-image");
	var container = document.getElementById(nameRoot + "-image-container");
	
	// change the value into a float (e.g. 1.5);
	var value = ui.value / 100;

	// scale the image
	image.style.width = (image.originalWidth * value) + "px";
	image.style.height = (image.originalHeight * value) + "px";
	
	// now resize the container so the image can be moved around
	resizeContainer(bento, image, container);
}

$(function() {
	$(".image-slider").slider({
		orientation: "vertical",
		min: 100,
		max: 400,
		slide: function(event, ui) {
			handleSliderEvent(event, ui);
		}
	});
});

function handleHorizontalDrag(target, movement) {
	var index;

	for (index = 0; index < target.leftBentos.length; ++index) {
		var leftBento = target.leftBentos[index];
		leftBento.style.width = (parseInt(getComputedStyle(leftBento).width, 10) + movement) + "px";
		var leftImage = document.getElementById(leftBento.id + "-image");
		if (leftImage) {
			var leftContainer = document.getElementById(leftBento.id + "-image-container");
			resizeContents(leftBento, leftImage, leftContainer);
		}
	}	

	for (index = 0; index < target.rightBentos.length; ++index) {
		var rightBento = target.rightBentos[index];
		rightBento.style.left = (parseInt(getComputedStyle(rightBento, null).left, 10) + movement) + "px";
		rightBento.style.width = (parseInt(getComputedStyle(rightBento).width, 10) - movement) + "px";
		var rightImage = document.getElementById(rightBento.id + "-image");
		if (rightImage) {
			var rightContainer = document.getElementById(rightBento.id + "-image-container");
			resizeContents(rightBento, rightImage, rightContainer);
		}
	}
}

function handleVerticalDrag(target, movement) {
	var index;

	for (index = 0; index < target.topBentos.length; ++index) {
		var topBento = target.topBentos[index];
		var newHeight = (parseInt(getComputedStyle(topBento).height, 10) + movement);
		topBento.style.height = newHeight + "px";
		var topSlider = document.getElementById(topBento.id + "-slider");
		topSlider.style.height = (newHeight - 45) + "px";
		var topImage = document.getElementById(topBento.id + "-image");
		if (topImage) {
			var topContainer = document.getElementById(topBento.id + "-image-container");
			resizeContents(topBento, topImage, topContainer);
		}
	}	

	for (index = 0; index < target.bottomBentos.length; ++index) {
		var bottomBento = target.bottomBentos[index];
		bottomBento.style.top = (parseInt(getComputedStyle(bottomBento, null).top, 10) + movement) + "px";
		bottomBento.style.height = (parseInt(getComputedStyle(bottomBento).height, 10) - movement) + "px";
		var bottomImage = document.getElementById(bottomBento.id + "-image");
		if (bottomImage) {
			var bottomContainer = document.getElementById(bottomBento.id + "-image-container");
			resizeContents(bottomBento, bottomImage, bottomContainer);
		}
	}
}

$(function() {
	var divider;
	
	divider = document.getElementById("divider-1-1");
	divider.leftBentos = [document.getElementById("bento-1-1")]
	divider.rightBentos = [document.getElementById("bento-1-2")]

	divider = document.getElementById("divider-1-2");
	divider.leftBentos = [document.getElementById("bento-1-2")];
	divider.rightBentos = [document.getElementById("bento-1-3"), document.getElementById("bento-1-4"), document.getElementById("divider-1-3")];

	divider = document.getElementById("divider-1-3");
	divider.topBentos = [document.getElementById("bento-1-3")];
	divider.bottomBentos = [document.getElementById("bento-1-4")];


	$("#divider-1-1").draggable({
		axis: "x",
		drag: function(event, ui) {
			handleHorizontalDrag(event.target, ui.position.left - ui.originalPosition.left);
			ui.originalPosition.left = ui.position.left;
		}
	});
	
	$("#divider-1-2").draggable({
		axis: "x",
		drag: function(event, ui) {
			handleHorizontalDrag(event.target, ui.position.left - ui.originalPosition.left);
			ui.originalPosition.left = ui.position.left;
		}
	});

	$("#divider-1-3").draggable({
		axis: "y",
		drag: function(event, ui) {
			handleVerticalDrag(event.target, ui.position.top - ui.originalPosition.top);
			ui.originalPosition.top = ui.position.top;
		}
	});

/*	
	Draggable.create("#divider-1-2", {
        type:"x",
        onDrag: function() {
			handleHorizontalDrag(this.target, this.pointerEvent.mozMovementX);
			console.log("this.x: "+this.x + " this.pointerEvent.mozMovementX: "+this.pointerEvent.mozMovementX);
		}
    });
*/
});

function stack(top, middle, bottom) {
	$(top).css('z-index', "3");
	$(middle).css('z-index', "2");
	$(bottom).css('z-index', "1");
}
