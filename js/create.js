var imageType = /image.*/;
var videoType = /video.*/;
var audioType = /audio.*/;

$(document).ready(function() {
	$('.open-popup-link').magnificPopup({
		type: 'inline',
		midClick: true
	});
});

function readCookie(name){
	var c = document.cookie.split('; ');
	var cookies = {};
	for(var i = c.length-1; i >= 0; i--){
	   var C = c[i].split('=');
	   cookies[C[0]] = C[1];
	}
	return cookies[name];
}

function sendGiftbox() {
	if (!document.getElementById('email').value) {
		document.getElementById('send-message').innerHTML = "Please enter a valid email address.";
	} else {
		var posting = $.post("send_preview.php", $("#send-form").serialize());
		posting.done(function(data) {
			$.magnificPopup.close();
		});
	}
}

function uploadFileData(fileData, fileName) {
    var xhr = new XMLHttpRequest();
    if (xhr.upload) {
        xhr.open("POST", "upload.php", true);
        xhr.setRequestHeader("X-FILENAME", fileName);
        xhr.send(fileData);
    }
}

function uploadFile(file) {
	var reader  = new FileReader();
	reader.onloadend = function () {
		uploadFileData(reader.result, reader.fileName);
	};
	reader.fileName = file.name;
	reader.readAsDataURL(file);
}

/************** BENTO DRAG/DROP HANDLERS *****************/

function handleDragEnter(e) {
	this.classList.add('over');
}

function handleDragOver(e) {
	if (e.preventDefault) {
		e.preventDefault();
	}
	e.dataTransfer.dropEffect = 'move';

	return false;
}

function handleDragLeave(e) {
	this.classList.remove('over');
}

function addImage(bento, imageSrc, imageFile) {
		// Remove any previously dropped image or video
	if (bento.imageContainer) {
		bento.removeChild(bento.imageContainer);
		bento.imageContainer = null;
	} else if (bento.video) {
		bento.removeChild(bento.video);
		bento.video = null;
	}

	// Create the DIV
	var div = document.createElement('div');
	div.id =  bento.id + '-image-container';
	div.style.position = 'absolute';

	// Create the IMG
	var img = document.createElement('img');
	img.src = imageSrc;
	img.id = bento.id + '-image';
	img.file = imageFile;

	// Add the IMG to the DIV, add the DIV to the bento
	div.appendChild(img);
	bento.appendChild(div);
	bento.imageContainer = div;

	// make the IMG draggable inside the DIV
	$('#'+ img.id).draggable({ containment: "#" + div.id});

	// now resize the image so that it covers the bento
	resizeImage(img, bento);

	// resize the image container so that the image has scroll containment
	resizeContainer(bento, img, div);	

	// change the hover for the bento to show the slider
	showControl(bento.id + "-close", div);
	showControl(bento.id + "-slider", img);
}

function handleDrop(e) {
	if (e.preventDefault) {
		e.preventDefault(); // Necessary. Allows us to drop.
	}
	this.classList.remove('over');
	var srcId = e.dataTransfer.getData('src_id');
	if (srcId.length > 0) {
		var file = document.getElementById(srcId).file;
		var imageSrc = null;
		if (file.type.match(imageType)) {
			imageSrc = e.dataTransfer.getData('text/uri-list');
			addImage(this, imageSrc, file);
		} else if (file.type.match(audioType)) {
			// Remove any existing audio
			if (this.audio) {
				this.removeChild(this.audio);
				this.audio = null;
			}
			
			// Check for album art
			imageSrc = e.dataTransfer.getData('text/uri-list');
			if (imageSrc) {
				addImage(this, imageSrc, null);
				this.image_file_name = file.name.replace(".", "_") + ".jpg";
			}
			
			// Create the audio element
			var audio = document.createElement('audio');
			audio.setAttribute('controls', true);
			audio.src = window.URL.createObjectURL(file);
			audio.id = this.id + '-audio';
			audio.classList.add("audio-player");
			audio.style.zIndex = 10;
			this.appendChild(audio);
			var closeButton = document.createElement('div');
			closeButton.id = audio.id + "-close";
			closeButton.classList.add("audio-close-button");
			closeButton.style.zIndex = 11;
			closeButton.onclick = function(){closeClicked(closeButton);};
			this.appendChild(closeButton);
			showControl(closeButton.id, audio);
			this.file = file;
			this.audio = audio;
		} else if (file.type.match(videoType)) {
			if (this.imageContainer) {
				this.removeChild(this.imageContainer);
				this.imageContainer = null;
				hideControl(this.id + "-slider");
			} else if (this.video) {
				this.removeChild(this.video);
				this.video = null;
			}
			var video = document.createElement('video');
			video.setAttribute('controls', true);
			video.setAttribute('preload', "auto");
			video.src = window.URL.createObjectURL(file);
			video.id = this.id + '-video';
			video.width =  parseInt(getComputedStyle(this).width, 10);
			this.file = file;
			this.video = video;
			video.classList.add("video-js");
			video.classList.add("vjs-default-skin");
			video.classList.add("video-player");
			this.appendChild(video);
			showControl(this.id + "-close", video);
		}
	}
	return false;
}

function handleDragEnd(e) {
	this.classList.remove('over');
}

function handleDragStart(e) {
	e.dataTransfer.setData("src_id", this.id);

}

//******* SIDEBAR DRAG/DROP HANDLERS *****************

function handleAddImageDragEnter(e) {
	
	this.classList.add('over');
}

function handleAddImageDragOver(e) {
	if (e.preventDefault) {
		e.preventDefault();
	}
	e.dataTransfer.dropEffect = 'move';

	return false;
}
function handleAddImageDragLeave(e) {
	this.classList.remove('over');
}

function handleAddImageDrop(e) {
	if (e.preventDefault) {
		e.preventDefault(); // Necessary. Allows us to drop.
	}
	this.classList.remove('over');
	handleImageFiles(e.dataTransfer.files);
}

function handleAddMediaDrop(e) {
	if (e.preventDefault) {
		e.preventDefault(); // Necessary. Allows us to drop.
	}
	this.classList.remove('over');
	handleMediaFiles(e.dataTransfer.files);
}

function handleAddImageDragEnd(e) {
	this.classList.remove('over');
}

function handleImageFiles(files) {
	var tabs = document.getElementById("images-tab");
	for (var i = 0; i < files.length; i++) {
		var file = files[i];

		// if not an image go on to next file
		if (!file.type.match(imageType)) {
			alert("This drop zone only accepts image files (.jpg, .png, etc.).");
			continue;
		}

		var img = document.createElement("img");
		img.classList.add("photo-thumbnail");
		img.src = window.URL.createObjectURL(file);
		img.file = file;
		img.id = file.name;
		img.addEventListener('dragstart', handleDragStart, false);
		tabs.appendChild(img);
		var text = document.createElement("p");
		text.innerHTML = file.name;
		text.classList.add("file-name");
		tabs.appendChild(text);
	}
}

function handleMediaFiles(files) {
    var tabs = document.getElementById("media-tab");
    for (var i = 0; i < files.length; i++) {
		var file = files[i];

		// if not video or audio go on to next file
		if (!file.type.match(videoType) && !file.type.match(audioType)) {
			alert("This drop zone only accepts music and video files (.mp3, .mp4, etc.).");
			continue;
		}

		var element;
		if (file.type.match(videoType)) {
			element = document.createElement("video")
			element.src = window.URL.createObjectURL(file);
			element.setAttribute('draggable', true);
		}
		if (file.type.match(audioType)) {
			element = document.createElement("img");
			
			// Get the album artwork from an MP3
			if (file.type.indexOf("mp3") >= 0 || file.type.indexOf("mpeg") >= 0) {
				var url = file.urn || file.name;
				ID3.loadTags(
					url, 
					function() {showAlbumArt(url, file, tabs);},
					{tags: ["title","artist","album","picture"], dataReader: FileAPIReader(file)}
				);
			} else {
				element.src = "images/audio.jpg";
			}
		}
		element.classList.add("photo-thumbnail");
		element.file = file;
		element.id = file.name;
		element.addEventListener('dragstart', handleDragStart, false);
		tabs.appendChild(element);
		var text = document.createElement("p");
		text.innerHTML = file.name;
		text.classList.add("file-name");
		tabs.appendChild(text);
    }

}

function showAlbumArt(url, file) {
	var tags = ID3.getAllTags(url);
	var image = tags.picture;
	var img = document.getElementById(file.name);
	if (image) {
		var base64String = "";
		for (var i = 0; i < image.data.length; i++) {
			base64String += String.fromCharCode(image.data[i]);
		}
		var base64 = "data:" + image.format + ";base64," + window.btoa(base64String);
		img.setAttribute('src', base64);
	} else {
		img.src = "images/audio.jpg";
	}
}

function handleImageFileSelect(evt) {
	handleImageFiles(evt.target.files);
}

function handleMediaFileSelect(evt) {
    handleMediaFiles(evt.target.files);
}


//******************************************************
function hideControl(controlId) {
	var control = document.getElementById(controlId);
	var css = '.bento:hover #' + controlId + '{display: none;}';
	var style = document.createElement('style');
	if (style.styleSheet)
		style.styleSheet.cssText = css;
	else 
		style.appendChild(document.createTextNode(css));
	document.getElementsByTagName('head')[0].appendChild(style);
	control.style.zIndex = -9999;
	control.target = null;
}

function showControl(controlId, target) {
	var control = document.getElementById(controlId);
	var css = '.bento:hover #' + controlId + '{display: block;}';
	var style = document.createElement('style');
	if (style.styleSheet)
		style.styleSheet.cssText = css;
	else 
		style.appendChild(document.createTextNode(css));
	document.getElementsByTagName('head')[0].appendChild(style);
	
	// put the control on top
	control.style.zIndex = 9999;
	control.target = target;
}

function closeClicked(closeButton) {
	if (closeButton.target) {
		if (closeButton.target.nodeName === "VIDEO") {
			closeButton.parentNode.video = null;
		} else if (closeButton.target.nodeName === "AUDIO") {
			closeButton.parentNode.audio = null;
		} else if (closeButton.target.nodeName === "DIV") {
			closeButton.parentNode.imageContainer = null;
		}
		closeButton.parentNode.removeChild(closeButton.target);
	}
	if (closeButton.target.nodeName === "AUDIO") {
		closeButton.parentNode.removeChild(closeButton);
	} else {
		hideControl(closeButton.id);
		hideControl(closeButton.parentNode.id + "-slider");
	}
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
	var newWidth;
	var newLeft;

	for (index = 0; index < target.leftDependents.length; ++index) {
		var leftDependent = target.leftDependents[index];
		newWidth = parseInt(getComputedStyle(leftDependent).width, 10) + movement;
		leftDependent.style.width = newWidth + "px";
		var leftImage = document.getElementById(leftDependent.id + "-image");
		if (leftImage) {
			var leftContainer = document.getElementById(leftDependent.id + "-image-container");
			resizeContents(leftDependent, leftImage, leftContainer);
		}
	}	

	for (index = 0; index < target.rightDependents.length; ++index) {
		var rightDependent = target.rightDependents[index];
		newWidth = parseInt(getComputedStyle(rightDependent).width, 10) - movement;
		newLeft = parseInt(getComputedStyle(rightDependent, null).left, 10) + movement;
		rightDependent.style.left = newLeft + "px";
		rightDependent.style.width = newWidth + "px";
		var rightImage = document.getElementById(rightDependent.id + "-image");
		if (rightImage) {
			var rightContainer = document.getElementById(rightDependent.id + "-image-container");
			resizeContents(rightDependent, rightImage, rightContainer);
		}
	}
}

function handleVerticalDrag(target, movement) {
	var index;

	for (index = 0; index < target.topDependents.length; ++index) {
		var topDependent = target.topDependents[index];
		var newHeight = parseInt(getComputedStyle(topDependent).height, 10) + movement;
		topDependent.style.height = newHeight + "px";
		var topSlider = document.getElementById(topDependent.id + "-slider");
		if (topSlider) {
			topSlider.style.height = (newHeight - 45) + "px";
		}
		var topImage = document.getElementById(topDependent.id + "-image");
		if (topImage) {
			var topContainer = document.getElementById(topDependent.id + "-image-container");
			resizeContents(topDependent, topImage, topContainer);
		}
	}	

	for (index = 0; index < target.bottomDependents.length; ++index) {
		var bottomDependent = target.bottomDependents[index];
		bottomDependent.style.top = (parseInt(getComputedStyle(bottomDependent, null).top, 10) + movement) + "px";
		var newHeight = parseInt(getComputedStyle(bottomDependent).height, 10) - movement;
		bottomDependent.style.height = newHeight + "px";
		var bottomSlider = document.getElementById(bottomDependent.id + "-slider");
		if (bottomSlider) {
			bottomSlider.style.height = (newHeight - 45) + "px";
		}
		var bottomImage = document.getElementById(bottomDependent.id + "-image");
		if (bottomImage) {
			var bottomContainer = document.getElementById(bottomDependent.id + "-image-container");
			resizeContents(bottomDependent, bottomImage, bottomContainer);
		}
	}
}

$(function() {
	var divider;

	// Template #1
	divider = document.getElementById("divider-1-1");
	divider.leftDependents = [document.getElementById("bento-1-1")];
	divider.rightDependents = [document.getElementById("bento-1-2"), document.getElementById("divider-container-1-2")];

	divider = document.getElementById("divider-1-2");
	divider.leftDependents = [document.getElementById("bento-1-2"), document.getElementById("divider-container-1-1")];
	divider.rightDependents = [document.getElementById("bento-1-3"), document.getElementById("bento-1-4"), document.getElementById("divider-1-3"), document.getElementById("divider-container-1-3")];

	divider = document.getElementById("divider-1-3");
	divider.topDependents = [document.getElementById("bento-1-3")];
	divider.bottomDependents = [document.getElementById("bento-1-4")];

	$("#divider-1-1").draggable({
		axis: "x",
		containment: "#divider-container-1-1",
		drag: function(event, ui) {
			handleHorizontalDrag(event.target, ui.position.left - ui.originalPosition.left);
			ui.originalPosition.left = ui.position.left;
		}
	});
	
	$("#divider-1-2").draggable({
		axis: "x",
		containment: "#divider-container-1-2",
		drag: function(event, ui) {
			handleHorizontalDrag(event.target, ui.position.left - ui.originalPosition.left);
			ui.originalPosition.left = ui.position.left;
		}
	});

	$("#divider-1-3").draggable({
		axis: "y",
		containment: "#divider-container-1-3",
		drag: function(event, ui) {
			handleVerticalDrag(event.target, ui.position.top - ui.originalPosition.top);
			ui.originalPosition.top = ui.position.top;
		}
	});
	
	// Template #2
	divider = document.getElementById("divider-2-1");
	divider.leftDependents = [document.getElementById("bento-2-1"), document.getElementById("bento-2-2"), document.getElementById("divider-2-2"), document.getElementById("divider-container-2-2")];
	divider.rightDependents = [document.getElementById("bento-2-3"), document.getElementById("bento-2-4"), document.getElementById("bento-2-5"), document.getElementById("divider-2-3"), document.getElementById("divider-2-4"), document.getElementById("divider-container-2-3"), document.getElementById("divider-container-2-4")];

	divider = document.getElementById("divider-2-2");
	divider.topDependents = [document.getElementById("bento-2-1")];
	divider.bottomDependents = [document.getElementById("bento-2-2")];

	divider = document.getElementById("divider-2-3");
	divider.topDependents = [document.getElementById("bento-2-3")];
	divider.bottomDependents = [document.getElementById("bento-2-4"), document.getElementById("divider-container-2-4")];

	divider = document.getElementById("divider-2-4");
	divider.topDependents = [document.getElementById("bento-2-4"), document.getElementById("divider-container-2-3")];
	divider.bottomDependents = [document.getElementById("bento-2-5")];

	$("#divider-2-1").draggable({
		axis: "x",
		containment: "#divider-container-2-1",
		drag: function(event, ui) {
			handleHorizontalDrag(event.target, ui.position.left - ui.originalPosition.left);
			ui.originalPosition.left = ui.position.left;
		}
	});
	
	$("#divider-2-2").draggable({
		axis: "y",
		containment: "#divider-container-2-2",
		drag: function(event, ui) {
			handleVerticalDrag(event.target, ui.position.top - ui.originalPosition.top);
			ui.originalPosition.top = ui.position.top;
		}
	});
	
	$("#divider-2-3").draggable({
		axis: "y",
		containment: "#divider-container-2-3",
		drag: function(event, ui) {
			handleVerticalDrag(event.target, ui.position.top - ui.originalPosition.top);
			ui.originalPosition.top = ui.position.top;
		}
	});
	
	$("#divider-2-4").draggable({
		axis: "y",
		containment: "#divider-container-2-4",
		drag: function(event, ui) {
			handleVerticalDrag(event.target, ui.position.top - ui.originalPosition.top);
			ui.originalPosition.top = ui.position.top;
		}
	});
	
	// Template #3
	divider = document.getElementById("divider-3-1");
	divider.leftDependents = [document.getElementById("bento-3-1"), document.getElementById("bento-3-2"), document.getElementById("divider-3-3"), document.getElementById("divider-container-3-3")];
	divider.rightDependents = [document.getElementById("bento-3-3"), document.getElementById("bento-3-4"), document.getElementById("divider-3-4"), document.getElementById("divider-container-3-2")];

	divider = document.getElementById("divider-3-2");
	divider.leftDependents = [document.getElementById("bento-3-3"), document.getElementById("bento-3-4"), document.getElementById("divider-3-4"), document.getElementById("divider-container-3-1"), document.getElementById("divider-container-3-4")];
	divider.rightDependents = [document.getElementById("bento-3-5"), document.getElementById("bento-3-6"), document.getElementById("divider-3-5"), document.getElementById("divider-container-3-5")];

	divider = document.getElementById("divider-3-3");
	divider.topDependents = [document.getElementById("bento-3-1")];
	divider.bottomDependents = [document.getElementById("bento-3-2")];

	divider = document.getElementById("divider-3-4");
	divider.topDependents = [document.getElementById("bento-3-3")];
	divider.bottomDependents = [document.getElementById("bento-3-4")];

	divider = document.getElementById("divider-3-5");
	divider.topDependents = [document.getElementById("bento-3-5")];
	divider.bottomDependents = [document.getElementById("bento-3-6")];

	$("#divider-3-1").draggable({
		axis: "x",
		containment: "#divider-container-3-1",
		drag: function(event, ui) {
			handleHorizontalDrag(event.target, ui.position.left - ui.originalPosition.left);
			ui.originalPosition.left = ui.position.left;
		}
	});
	
	$("#divider-3-2").draggable({
		axis: "x",
		containment: "#divider-container-3-2",
		drag: function(event, ui) {
			handleHorizontalDrag(event.target, ui.position.left - ui.originalPosition.left);
			ui.originalPosition.left = ui.position.left;
		}
	});

	$("#divider-3-3").draggable({
		axis: "y",
		containment: "#divider-container-3-3",
		drag: function(event, ui) {
			handleVerticalDrag(event.target, ui.position.top - ui.originalPosition.top);
			ui.originalPosition.top = ui.position.top;
		}
	});
	
	$("#divider-3-4").draggable({
		axis: "y",
		containment: "#divider-container-3-4",
		drag: function(event, ui) {
			handleVerticalDrag(event.target, ui.position.top - ui.originalPosition.top);
			ui.originalPosition.top = ui.position.top;
		}
	});
	
	$("#divider-3-5").draggable({
		axis: "y",
		containment: "#divider-container-3-5",
		drag: function(event, ui) {
			handleVerticalDrag(event.target, ui.position.top - ui.originalPosition.top);
			ui.originalPosition.top = ui.position.top;
		}
	});

});

function openMessage(title, text) {
	$("#confirm-dialog").dialog( "option", "title", title);
	$("#confirm-text").text(text);
	$("#confirm-dialog").dialog("open");
}

function openStatus(title, text) {
	$("#status-dialog").dialog( "option", "title", title);
	$("#status-text").text(text);
	$("#status-dialog").dialog("open");
}

function closeStatus() {
	$("#status-dialog" ).dialog("close");
}

function setPreviewLink (giftboxId) {
	$("#preview-link").val(readCookie("app_url") + "preview.php?id=" + giftboxId);
}
function stack(top, middle, bottom) {
	var top_template = document.getElementById(top);
	var middle_template = document.getElementById(middle);
	var bottom_template = document.getElementById(bottom);
	window.top_template = top_template;
	setPreviewLink(top_template.giftboxId);
	top_template.style.zIndex = 3;
	middle_template.style.zIndex = 2;
	bottom_template.style.zIndex = 1;
}

function calcTop(bento, image, container) {
	var top = null;
	var imageTop = parseInt(image.style.top, 10);
	var bentoHeight = parseInt(bento.height, 10);
	var containerHeight = parseInt(container.style.height, 10);
	top = imageTop - ((containerHeight - bentoHeight)/2);
	return top + "px";
}

function calcLeft(bento, image, container) {
	var left = null;
	var imageLeft = parseInt(image.style.left, 10);
	var bentoWidth = parseInt(bento.width, 10);
	var containerWidth = parseInt(container.style.width, 10);
	left = imageLeft - ((containerWidth - bentoWidth)/2);
	return left + "px";
}

function save() {
	// Prompt for giftbox name
	var saveName = document.getElementById("save-name").value;
	$("#save-dialog" ).dialog("close");
	window.top_template.giftboxName = saveName;
	
	openStatus("Save", "Saving your giftbox...");
	var template = window.top_template;
	var giftboxName = saveName;
	var giftboxId = template.giftboxId;
	var letterText = template.letterText;
	var wrapperType = template.wrapperType;
	var unloadCount = template.unloadCount;
	var userId = readCookie('user_id');
	var giftbox = {
		giftbox_id: giftboxId,
		user_id: userId,
		name: giftboxName,
		letter_text: letterText,
		wrapper_type: wrapperType,
		unload_count: unloadCount,
		bentos: new Array()
	};
	$("#"+template.id+" div.bento").each(function(i) { 
		var bento = new Object();
		bento.name = $(this).attr("id");
		bento.width = $(this).css("width");
		bento.height = $(this).css("height");
		bento.top = $(this).css("top");
		bento.left = $(this).css("left");
		bento.image_file_name = null;
		bento.image_width = null;
		bento.image_height = null;
		bento.image_top = null;
		bento.image_left = null;
		bento.download_file_name = null;
		bento.download_mime_type = null;

		giftbox.bentos[i] = bento;
		var image = document.getElementById(bento.name + "-image");
		if (image) {
			var container = document.getElementById(bento.name + '-image-container');
			bento.image_width = image.style.width;
			bento.image_height = image.style.height;
			bento.image_top = calcTop(bento, image, container);
			bento.image_left = calcLeft(bento, image, container);
			if (image.file) {
				bento.image_file_name = image.file.name;
				uploadFile(image.file);
			} else {
				bento.image_file_name = this.image_file_name;
				uploadFileData(image.src, this.image_file_name);
			}
		}
		if (this.file) {
			bento.download_file_name = this.file.name;
			bento.download_mime_type = this.file.type;
			uploadFile(this.file);
		}
	});

	// Save the template first
	$.post("save_giftbox_ajax.php", 
		giftbox, 
		function(result) { 
			template.giftboxId = result.giftbox_id;
			setPreviewLink(template.giftboxId);
			closeStatus();
		}, 
		"json").fail(function() {alert("Save failed!"); closeStatus();});
}

function send() {
	var giftboxId = window.top_template.giftboxId;
	if (!giftboxId) {
		openMessage("Send", "The giftbox must be saved before it can be sent.");
	} else {
		$.magnificPopup.open({
		  items: {
			src: '#send-form',
			type: 'inline'
		  }
		});
	}
}

function preview() {
	var giftboxId = window.top_template.giftboxId;
	var unloadType = window.top_template.wrapperType;
	var unloadCount = window.top_template.unloadCount
	if (!giftboxId) {
		openMessage("Preview", "The giftbox must be saved before it can be previewed.");
	} else {
		if (window.top_template.wrapperType) {
			window.open("second-harvest.php?ut=" + unloadType + "&uc=" + unloadCount + "&tid=" + giftboxId, "_blank");
		} else {
			window.open("preview.php?id=" + giftboxId, "_blank");
		}
	}
}

function save_letter() {
	var letterText = document.getElementById("letter-text");
	window.top_template.letterText = letterText.value;
	$("#letter-dialog" ).dialog("close");
}

function wrapper() {
	$('#wrapper-type').val(window.top_template.wrapperType);
	$('#unload-count').val(window.top_template.unloadCount);
	$('#wrapper-dialog').dialog('open');
}

function save_wrapper() {
	var wrapperType = document.getElementById("wrapper-type");
	var unloadCount = document.getElementById("unload-count");
	window.top_template.wrapperType = wrapperType.value;
	window.top_template.unloadCount = unloadCount.value;
	$("#wrapper-dialog" ).dialog("close");
}