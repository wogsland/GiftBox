var imageType = /image.*/;
var videoType = /video.*/;
var audioType = /audio.*/;

$(document).ready(function() {
	$('.open-popup-link').magnificPopup({
		type: 'inline',
		midClick: true
	});
});

function addText(text, container) {
	var p = document.createElement("p");
	p.innerHTML = text;
	p.classList.add("file-name");
	container.appendChild(p);
}

function isYouTube(url) {
	retVal = false;
	if (url.indexOf("youtube.com") > -1 || url.indexOf("youtu.be") > -1) {
		retVal = true;
	}
	return retVal;
}

function isSoundCloud(url) {
	retVal = false;
	if (url.indexOf("soundcloud.com") > -1) {
		retVal = true;
	}
	return retVal;
}

function isSpotify(url) {
	retVal = false;
	if (url.indexOf("spotify.com") > -1 || url.indexOf("spotify:track:") > -1) {
		retVal = true;
	}
	return retVal;
}

function youTubeID(url) {
	var result = url.match(/(youtu(?:\.be|be\.com)\/(?:.*v(?:\/|=)|(?:.*\/)?)([\w'-]+))/i);
	if (result) {
		return result[result.length - 1];
	} else {
		return null;
	}
}

function spotifyTrackId(url) {
	var delimiter = "/";
	if (url.indexOf("spotify:track:") > -1) {
		delimiter = ":";
	}
	var parts = url.split(delimiter);
	var trackId = parts[parts.length - 1];
	
	return trackId;
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
		setStatus("Uploading " + fileName);
		xhr.upload.onprogress = function(e) {
			if (e.lengthComputable) {
				setStatus("Uploading " + fileName + " " + (Math.round((e.loaded / e.total) * 100))+"%");
				console.log("Uploading " + fileName + " " + (Math.round((e.loaded / e.total) * 100))+"%");
			}
		};
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

function addAudio (bento, audioSrc, audioFile, savedBento) {
	// Create the audio element
	var audio = document.createElement('audio');
	audio.setAttribute('controls', true);
	audio.src = audioSrc;
	audio.id = bento.id + '-audio';
	audio.classList.add("audio-player");
	audio.style.zIndex = 10;
	bento.appendChild(audio);
	bento.file = audioFile;
	bento.audio = audio;

	// add close button
	var closeButton = document.createElement('div');
	closeButton.id = audio.id + "-close";
	closeButton.classList.add("audio-close-button");
	closeButton.style.zIndex = 11;
	closeButton.onclick = function(){closeClicked(closeButton);};
	bento.appendChild(closeButton);
	showControl(closeButton.id, audio);
}

function addVideo (bento, videoSrc, videoFile, savedBento) {
	var video = document.createElement('video');
	video.setAttribute('controls', true);
	video.setAttribute('preload', "auto");
	if (videoFile) {
		video.src = window.URL.createObjectURL(videoFile);
		bento.file = videoFile;
	} else {
		video.src = videoSrc;
	}
	video.id = bento.id + '-video';
	video.width =  parseInt(getComputedStyle(bento).width, 10);
	video.height = parseInt(getComputedStyle(bento).height, 10);
	bento.video = video;
	video.classList.add("video-js");
	video.classList.add("vjs-default-skin");
	video.classList.add("video-player");
	bento.appendChild(video);
	showControl(bento.id + "-close", video);
}

function addImage(bento, imageSrc, imageFile, savedBento) {
		// Remove any previously dropped image or video
	if (bento.imageContainer) {
		bento.removeChild(bento.imageContainer);
		bento.imageContainer = null;
	} else if (bento.video) {
		bento.removeChild(bento.video);
		bento.video = null;
	}

	// Create the image scroll container
	var imageContainer = document.createElement('div');
	imageContainer.id =  bento.id + '-image-container';
	imageContainer.style.position = 'absolute';

	// Create the IMG
	var img = new Image();
	img.id = bento.id + '-image';
	img.file = imageFile;
	img.parentBento = bento;
	img.imageContainer = imageContainer;
	img.crossOrigin = "Anonymous";
	img.savedBento = savedBento;
	img.onload = function() {
		resizeImage(this, this.parentBento);
		if (this.savedBento) {
			this.style.width = this.savedBento.image_width;
			this.style.height = this.savedBento.image_height;
			this.saved = true;
			$("#"+bento.id+"-slider").slider("value", this.savedBento.slider_value);
		} else {
		}
		// resize the image container so that the image has scroll containment
		resizeContainer(this.parentBento, this, this.imageContainer);
		if (this.savedBento) {
			this.style.top = this.savedBento.image_top_in_container;
			this.style.left = this.savedBento.image_left_in_container;
		}
	}

	// add the img to the container, add the container to the bento
	imageContainer.appendChild(img);
	bento.appendChild(imageContainer);
	bento.imageContainer = imageContainer;

	// make the IMG draggable inside the DIV
	$('#'+ img.id).draggable({ containment: "#" + imageContainer.id});

	img.src = imageSrc;
	
	// change the hover for the bento to show the slider and close button
	showControl(bento.id + "-close", imageContainer);
	showControl(bento.id + "-slider", img);
}

function handleDrop(e) {
	if (e.preventDefault) {
		e.preventDefault(); // Necessary. Allows us to drop.
	}
	this.classList.remove('over');
	var srcId = e.dataTransfer.getData('src_id');
	if (srcId.length > 0) {
		var source = document.getElementById(srcId);
		if (source.file) {
			var file = source.file;
			var imageSrc = null;
			if (file.type.match(imageType)) {
				imageSrc = e.dataTransfer.getData('text/uri-list');
				addImage(this, imageSrc, file, null);
				this.image_file_name = file.name;
			} else if (file.type.match(audioType)) {
				// Remove any existing audio
				if (this.audio) {
					this.removeChild(this.audio);
					this.audio = null;
				}

				// Check for album art
				imageSrc = e.dataTransfer.getData('text/uri-list');
				if (imageSrc) {
					addImage(this, imageSrc, null, null);
					this.image_file_name = file.name.replace(".", "_") + ".jpg";
				}
				addAudio(this, window.URL.createObjectURL(file), file, null);
				this.download_file_name = file.name;
				this.download_mime_type = file.type;
			} else if (file.type.match(videoType)) {
				if (this.imageContainer) {
					this.removeChild(this.imageContainer);
					this.imageContainer = null;
					hideControl(this.id + "-slider");
				} else if (this.video) {
					this.removeChild(this.video);
					this.video = null;
				}
				this.download_file_name = file.name;
				this.download_mime_type = file.type;
				addVideo(this, null, file, null);
			}
		} else if (source.youTubeURL) {
			dropYouTube(this, source.youTubeURL);
		} else if (source.spotifyTrackId) {
			dropSpotify(this, source.spotifyTrackId)
		} else if (source.soundCloudURL) {
			dropSoundCloud(this, source.soundCloudURL);
		}
	}
	return false;
}

function dropSpotify(bento, trackId) {
	var iframe = document.createElement('iframe');
	var contentURI = "https://embed.spotify.com/?url=spotify:track:"+trackId;
	iframe.src = contentURI;
	var width = bento.offsetWidth;
	var height = bento.offsetHeight;
	iframe.width = width;
	iframe.height = height;
	iframe.style.border = 0;
	bento.appendChild(iframe);
	bento.iframe = iframe;
	bento.contentURI = contentURI;
}

function dropSoundCloud(bento, url) {
	var iframe = document.createElement('iframe');
	iframe.src = "https://w.soundcloud.com/player/?url="+encodeURIComponent(url);
	var width = bento.offsetWidth;
	var height = bento.offsetHeight;
	iframe.width = width;
	iframe.height = height;
	iframe.style.border = 0;
	bento.appendChild(iframe);
	bento.iframe = iframe;
	bento.contentURI = url;
}

function dropYouTube(bento, url) {
	var iframe = document.createElement('iframe');
	var videoId =  youTubeID(url);
	iframe.src = "//www.youtube.com/embed/"+videoId;
	var width = bento.offsetWidth;
	var height = bento.offsetHeight;
	iframe.width = width;
	iframe.height = height;
	iframe.style.border = 0;
	bento.appendChild(iframe);
	bento.iframe = iframe;
	bento.contentURI = url;
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
	
	if (e.dataTransfer) {
		if (e.dataTransfer.files) {
			if (e.dataTransfer.files.length > 0) {
				handleMediaFiles(e.dataTransfer.files);
			} else {
				handleURIDrop(e);
			}
		}
	}
}

function handleAddImageDragEnd(e) {
	this.classList.remove('over');
}

function handleURIDrop(e) {
	var textURIList = e.dataTransfer.getData('text/uri-list');
    var tabs = document.getElementById("media-tab");

	if (isYouTube(textURIList)) {
		addYouTube(textURIList);
	} else if (isSoundCloud(textURIList)) {
		addSoundCloud(textURIList);
	} else if (isSpotify(textURIList)) {
		addSpotify(textURIList);
	} else {
		var error = "The dropped item is not one of the accepted types.\n\n"+textURIList;
		console.log(error);
		alert(error);
	}
}

function addYouTube(url) {
	var videoId = youTubeID(url);
	var error = null;
	if (videoId) {
		var dataURL = "https://gdata.youtube.com/feeds/api/videos/"+videoId+"?v=2&alt=json";
		$.getJSON(dataURL,
			function(data){
			var title = data.entry.title.$t;
			var mediaList = document.getElementById("media-tab");
			var img = document.createElement("img");
			img.classList.add("photo-thumbnail");
			img.src = "https://img.youtube.com/vi/"+videoId+"/0.jpg";
			img.id = videoId;
			img.addEventListener('dragstart', handleDragStart, false);
			img.youTubeURL = url;
			mediaList.appendChild(img);
			addText(title, mediaList);
		}).fail(function() {
			error = "Youtube API call failed.\n\n" + dataURL;
			console.log(error);
			alert(error);
		});	
	} else {
		error = "Unable to extract a Youtube video ID from the URL.\n\n"+url;
		console.log(error);
		alert(error);
	}
}

function addSoundCloud(url) {
    var mediaList = document.getElementById("media-tab");
	$.getJSON("https://api.soundcloud.com/resolve.json?url="+url+"&client_id=YOUR_CLIENT_ID", function(data){
		var img = document.createElement("img");
		img.classList.add("photo-thumbnail");
		if (data.artwork_url) {
			img.src = data.artwork_url.replace("large", "t500x500");
		} else {
			img.src = "images/soundcloud_icon.jpg";
		}
		img.id = data.id;
		img.addEventListener('dragstart', handleDragStart, false);
		img.soundCloudURL = data.uri;
		mediaList.appendChild(img);
		addText(data.title, mediaList);
	}).fail(function(){
		var error = "The URL specified is not a valid SoundCloud track or playlist URL.\n\n"+url;
		console.log(error);
		alert(error);
	});
}

function addSpotify(url) {
    var mediaList = document.getElementById("media-tab");
	var trackId = spotifyTrackId(url);
	$.getJSON("https://api.spotify.com/v1/tracks/"+trackId, function(data){
		var img = document.createElement("img");
		img.classList.add("photo-thumbnail");
		img.src = data.album.images[1].url;
		img.id = trackId;
		img.addEventListener('dragstart', handleDragStart, false);
		img.spotifyTrackId = trackId;
		mediaList.appendChild(img);
		addText(data.name, mediaList);
	}).fail(function() {
		var error = "The URL specified is not a valid Spotify track URL.\n\n"+url;
		console.log(error);
		alert(error);
	});
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
		addText(file.name, tabs);
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
			element = document.createElement("video");
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
		addText(file.name, tabs);
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
	// resize the container so that the image covers the bento with no white space
	var widthDiff = img.width - bento.offsetWidth;
	var heightDiff = img.height - bento.offsetHeight;
	var newContainerWidth = bento.offsetWidth + (widthDiff * 2);
	var newContainerHeight = bento.offsetHeight + (heightDiff * 2);
	div.style.width = newContainerWidth + 'px';
	div.style.height = newContainerHeight + 'px';
	div.style.left = Math.round(0 - ((newContainerWidth - bento.offsetWidth) / 2)) + 'px';
	div.style.top = Math.round(0 - ((newContainerHeight - bento.offsetHeight) / 2)) + 'px';
	img.style.left = Math.round((newContainerWidth / 2) - (img.width / 2)) + 'px';
	img.style.top = Math.round((newContainerHeight / 2) - (img.height / 2)) + 'px';
}

function resizeImage(img, bento) {
	var imgAspectRatio = img.height / img.width;
	var bentoAspectRatio = bento.offsetHeight / bento.offsetWidth;
	if (bentoAspectRatio < imgAspectRatio) {
		img.style.width = bento.offsetWidth + "px";
		img.style.height = "auto";
	} else {
		img.style.height = bento.offsetHeight + "px";
		img.style.width = "auto";
	}
	img.style.top = 0;
	img.style.left = 0;
	
	// set values for slider scaling
	img.originalWidth = img.width;
	img.originalHeight = img.height;
}

function resizeBento(bento) {
	var image = document.getElementById(bento.id + "-image");
	if (image) {
		resizeImage(image, bento);
		var container = document.getElementById(bento.id + "-image-container");
		resizeContainer(bento, image, container);
	}
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
	image.style.width = Math.round(image.originalWidth * value) + "px";
	image.style.height = Math.round(image.originalHeight * value) + "px";
	
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
	var width;
	var newWidth;
	var newLeft;
	if (movement !== 0) {
		for (index = 0; index < target.leftDependents.length; ++index) {
			var leftDependent = target.leftDependents[index];
			width = parseFloat(getComputedStyle(leftDependent).width);
console.log("movement: "+movement+", left: "+leftDependent.id+", width: "+width);
			newWidth = width + movement;
			leftDependent.style.width = newWidth + "px";
			
			var bentos = leftDependent.getElementsByClassName("bento");
			for (var i = 0; i < bentos.length; ++i) {
				resizeBento(bentos[i]);
			}
		}

		for (index = 0; index < target.rightDependents.length; ++index) {
			var rightDependent = target.rightDependents[index];
			width = parseFloat(getComputedStyle(rightDependent).width);
console.log("movement: "+movement+", right: "+rightDependent.id+", width: "+width);
			newWidth = width - movement;
			newLeft = parseFloat(getComputedStyle(rightDependent).left, 10) + movement;
			rightDependent.style.left = newLeft + "px";
			rightDependent.style.width = newWidth + "px";
			
			var bentos = rightDependent.getElementsByClassName("bento");
			for (var i = 0; i < bentos.length; ++i) {
				resizeBento(bentos[i]);
			}
		}
	}	
}

function handleVerticalDrag(target, movement) {
	var index;

	if (movement !== 0) {
		for (index = 0; index < target.topDependents.length; ++index) {
			var topDependent = target.topDependents[index];
			var newHeight = parseFloat(getComputedStyle(topDependent).height, 10) + movement;
			topDependent.style.height = newHeight + "px";
			
			var bentos = topDependent.getElementsByClassName("bento");
			for (var i = 0; i < bentos.length; ++i) {
				resizeBento(bentos[i]);
			}
		}	

		for (index = 0; index < target.bottomDependents.length; ++index) {
			var bottomDependent = target.bottomDependents[index];
			bottomDependent.style.top = (parseFloat(getComputedStyle(bottomDependent, null).top, 10) + movement) + "px";
			var newHeight = parseFloat(getComputedStyle(bottomDependent).height, 10) - movement;
			bottomDependent.style.height = newHeight + "px";
			
			var bentos = bottomDependent.getElementsByClassName("bento");
			for (var i = 0; i < bentos.length; ++i) {
				resizeBento(bentos[i]);
			}
		}
	}
}

$(function() {
	var divider;

	// Template #1
	divider = document.getElementById("divider-1-1");
	divider.leftDependents = [document.getElementById("column-1-1")];
	divider.rightDependents = [
		document.getElementById("column-1-2"), 
		document.getElementById("divider-container-1-2")];

	divider = document.getElementById("divider-1-2");
	divider.leftDependents = [
		document.getElementById("column-1-2"), 
		document.getElementById("divider-container-1-1")];
	divider.rightDependents = [
		document.getElementById("column-1-3"), 
		document.getElementById("divider-1-3"), 
		document.getElementById("divider-container-1-3")];

	divider = document.getElementById("divider-1-3");
	divider.topDependents = [document.getElementById("column-1-4")];
	divider.bottomDependents = [document.getElementById("column-1-5")];

	$("#divider-1-1").draggable({
		axis: "x",
		containment: "#divider-container-1-1",
		drag: function(event, ui) {
			handleHorizontalDrag(event.target, ui.position.left - ui.originalPosition.left);
			ui.originalPosition.left = ui.position.left;
		},
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
	divider.leftDependents = [
		document.getElementById("column-2-1"), 
		document.getElementById("divider-2-2"), 
		document.getElementById("divider-container-2-2")];
	divider.rightDependents = [
		document.getElementById("column-2-2"), 
		document.getElementById("divider-2-3"), 
		document.getElementById("divider-2-4"), 
		document.getElementById("divider-container-2-3"), 
		document.getElementById("divider-container-2-4")];

	divider = document.getElementById("divider-2-2");
	divider.topDependents = [document.getElementById("column-2-3")];
	divider.bottomDependents = [document.getElementById("column-2-4")];

	divider = document.getElementById("divider-2-3");
	divider.topDependents = [document.getElementById("column-2-5")];
	divider.bottomDependents = [
		document.getElementById("column-2-6"), 
		document.getElementById("divider-container-2-4")];

	divider = document.getElementById("divider-2-4");
	divider.topDependents = [
		document.getElementById("column-2-6"), 
		document.getElementById("divider-container-2-3")];
	divider.bottomDependents = [document.getElementById("column-2-7")];

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
	divider.leftDependents = [
		document.getElementById("column-3-1"), 
		document.getElementById("divider-3-3"), 
		document.getElementById("divider-container-3-3")];
	divider.rightDependents = [
		document.getElementById("column-3-2"), 
		document.getElementById("divider-3-4"), 
		document.getElementById("divider-container-3-4")];

	divider = document.getElementById("divider-3-2");
	divider.leftDependents = [
		document.getElementById("column-3-2"), 
		document.getElementById("divider-3-4"), 
		document.getElementById("divider-container-3-4"), 
		document.getElementById("divider-container-3-1")];
	divider.rightDependents = [
		document.getElementById("column-3-3"), 
		document.getElementById("divider-3-5"), 
		document.getElementById("divider-container-3-5")];

	divider = document.getElementById("divider-3-3");
	divider.topDependents = [document.getElementById("column-3-4")];
	divider.bottomDependents = [document.getElementById("column-3-5")];

	divider = document.getElementById("divider-3-4");
	divider.topDependents = [document.getElementById("column-3-6")];
	divider.bottomDependents = [document.getElementById("column-3-7")];

	divider = document.getElementById("divider-3-5");
	divider.topDependents = [document.getElementById("column-3-8")];
	divider.bottomDependents = [document.getElementById("column-3-9")];

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

function setPreviewLink (template) {
	var linkText;
	if (template.wrapperType) {
		linkText = "second-harvest.php?ut=" + template.wrapperType + "&uc=" + template.unloadCount + "&tid=" + template.giftboxId;
	} else {
		linkText = "preview.php?id=" + template.giftboxId;
	}
	$("#preview-link").val(template.appURL + linkText);
}

function stack(top, middle, bottom) {
	var top_template = document.getElementById(top);
	var middle_template = document.getElementById(middle);
	var bottom_template = document.getElementById(bottom);
	window.top_template = top_template;
	setPreviewLink(top_template);
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

function saveButton() {
	if (!window.top_template.giftboxId) {
		$('#save-name').val(window.top_template.giftboxName); 
		$('#save-dialog').dialog('open');	
	} else {
		save();
	}
	
}
function save() {
	if ($("#save-dialog" ).dialog("isOpen")) {
		// Get the name
		var giftboxName = $("#save-name").val();
		$("#save-dialog" ).dialog("close");
		window.top_template.giftboxName = giftboxName;
	}
	var giftboxName = window.top_template.giftboxName;
	
	openStatus("Save", "Saving " + giftboxName + "...");
	var template = window.top_template;
	var giftboxId = template.giftboxId;
	var cssId = template.id;
	var letterText = template.letterText;
	var wrapperType = template.wrapperType;
	var unloadCount = template.unloadCount;
	var userAgent = navigator.userAgent;
	var giftbox = {
		id: giftboxId,
		css_id: cssId,
		css_width: template.clientWidth,
		css_height: template.clientHeight,
		name: giftboxName,
		letter_text: letterText,
		wrapper_type: wrapperType,
		unload_count: unloadCount,
		user_agent: userAgent,
		bentos: new Array(),
		dividers: new Array(),
		columns: new Array()
	};
	
	$("#"+template.id+" div.bento").each(function(i) { 
		var bento = new Object();
		bento.giftbox_id = giftboxId;
		bento.css_id = $(this).attr("id");
		bento.css_width = $(this).css("width");
		bento.css_height = $(this).css("height");
		bento.css_top = $(this).css("top");
		bento.css_left = $(this).css("left");
		bento.image_file_name = null;
		bento.download_file_name = null;
		bento.download_mime_type = null;
		bento.content_uri = null;
		bento.slider_value = null;
		bento.image_width = null;
		bento.image_height = null;
		bento.image_top = null;
		bento.image_left = null;
		bento.image_left_in_container = null;
		bento.image_top_in_container = null;

		giftbox.bentos[i] = bento;
		var image = document.getElementById(bento.css_id + "-image");
		if (image) {
			bento.image_file_name = this.image_file_name;
			bento.slider_value = $("#"+bento.css_id+"-slider").slider("value");
			var container = document.getElementById(bento.css_id + '-image-container');
			bento.image_width = image.style.width;
			bento.image_height = image.style.height;
			bento.image_top = calcTop(bento, image, container);
			bento.image_left = calcLeft(bento, image, container);
			bento.image_left_in_container = image.style.left;
			bento.image_top_in_container = image.style.top;
			var croppedImage = createCroppedImage(bento, image, container);
			uploadFileData(croppedImage.src, bento.css_id+"-cropped_"+this.image_file_name);
			if (!image.saved) {
				if (image.file) {
					uploadFile(image.file);
				} else {
					uploadFileData(image.src, this.image_file_name);
				}
				image.saved = true;
			}
		}
		if (this.video || this.audio) {
			bento.download_file_name = this.download_file_name;
			bento.download_mime_type = this.download_mime_type;
			if (this.file) {
				uploadFile(this.file);
				this.file = null;
			}
		}
		if (this.contentURI) {
			bento.content_uri = this.contentURI;
		}
	});

	$("#"+template.id+" div.divider").each(function(i) { 
		var divider = new Object();
		divider.giftbox_id = giftboxId;
		divider.css_id = $(this).attr("id");
		divider.css_width = $(this).css("width");
		divider.css_height = $(this).css("height");
		divider.css_top = $(this).css("top");
		divider.css_left = $(this).css("left");
		giftbox.dividers[i] = divider;
	});

	$("#"+template.id+" div.divider-container").each(function(i) { 
		var container = new Object();
		container.giftbox_id = giftboxId;
		container.css_id = $(this).attr("id");
		container.css_width = $(this).css("width");
		container.css_height = $(this).css("height");
		container.css_top = $(this).css("top");
		container.css_left = $(this).css("left");
		giftbox.dividers[giftbox.dividers.length] = container;
	});

	$("#"+template.id+" div.column").each(function(i) { 
		var column = new Object();
		column.giftbox_id = giftboxId;
		column.css_id = $(this).attr("id");
		column.css_width = $(this).css("width");
		column.css_height = $(this).css("height");
		column.css_top = $(this).css("top");
		column.css_left = $(this).css("left");
		column.parent_css_id = $(this).parent().attr("id");
		giftbox.columns[giftbox.columns.length] = column;
	});

	// Save the template first
	$.post("save_token_ajax.php", giftbox, function(result) { 
		closeStatus();
		if (result.status === "SUCCESS") {
			template.giftboxId = result.giftbox_id;
			template.appURL = result.app_url;
			setPreviewLink(template);
		} else if (result.status === "ERROR") {
			openMessage("Save", "Save failed with the following error:  "+result.message);
		} else {
			openMessage("Save", "Save failed!");
		}
	}).fail(function() {
		openMessage("Save", "Save failed!");
	});
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

function saveLetter() {
	var letterText = document.getElementById("letter-text");
	window.top_template.letterText = letterText.value;
	$("#letter-dialog" ).dialog("close");
}

function wrapper() {
	$('#wrapper-type').val(window.top_template.wrapperType);
	$('#unload-count').spinner("value", window.top_template.unloadCount);
	$('#wrapper-dialog').dialog('open');
}

function save_wrapper() {
	var wrapperType = document.getElementById;
	var unloadCount = document.getElementById("unload-count");
	window.top_template.wrapperType = $("#wrapper-type").val();
	window.top_template.unloadCount = $("#unload-count").spinner("value");
	$("#wrapper-dialog" ).dialog("close");
}

function inputURL(site) {
	$('#url').val("");
	$('#url-dialog').dialog({title: site});	
	$('#url-dialog').dialog('open');	
}

function addURL() {
	// Get the url
	var url = document.getElementById("url").value;
	var title = $("#url-dialog").dialog("option", "title");
	$("#url-dialog").dialog("close");
	if (isYouTube(url)) {
		addYouTube(url);
	} else if (isSoundCloud(url)) {
		addSoundCloud(url);
	} else if (isSpotify(url)) {
		addSpotify(url);
	} else {
		var error = "The URL specified is not a valid "+title+" URL.\n\n"+url;
		console.log(error);
		alert(error);
	}
}

function selectSaved() {
	openStatus("Open", "Retrieving saved Tokens...");
	$.get("get_user_tokens_ajax.php", function(data) {
		var output = [];
		$.each(data, function(key, value)
		{
		  output.push('<option value="'+ value['id'] + '"' + ((key === 0) ? " selected" : "") +'>' + value['name'] + '</option>');
		});
		$('#token-list').html(output.join(''));
		closeStatus();
		$('#open-dialog').dialog('open');
	});
}

function loadSaved() {
	var tokenId = $('#token-list').find(":selected").val();
	if (tokenId) {
		$('#open-dialog').dialog('close');
		openStatus("Loading", "Loading saved Token...");
		$.get("get_token_ajax.php", {id: tokenId}, function(data) {
			var token = data;
			closeStatus();
			
			// Bring the correct template to the top
			if (token.css_id === 'template-1') {
				stack('template-1', 'template-2', 'template-3');
			} else if (token.css_id === 'template-2') {
				stack('template-2', 'template-3', 'template-1')				
			} else {
				stack('template-3', 'template-1', 'template-2')				
			}
			
			// Populate the top template properties
			window.top_template.giftboxId = token.id;
			window.top_template.giftboxName = token.name;
			window.top_template.appURL = token.app_url;
			window.top_template.letterText = token.letter_text;
			window.top_template.wrapperType = token.wrapper_type;
			window.top_template.unloadCount = token.unload_count;
			setPreviewLink(window.top_template);
			
			// Bento properties
			var index;
			var bento;
			for (index = 0; index < token.bentos.length; ++index) {
				bento = document.getElementById(token.bentos[index].css_id);
				bento.style.width = "100%";
				bento.style.height = "100%";
				bento.style.top = "0px";
				bento.style.left = "0px";
				clearBento(bento);
				loadBento(bento, token.bentos[index]);
			}
			
			// Divider properties
			var divider;
			for (index = 0; index < token.dividers.length; ++index) {
				divider = document.getElementById(token.dividers[index].css_id);
				if (token.dividers[index].parent_css_id.indexOf("column") > -1) {
					divider.style.width = "100%";
				} else {
					divider.style.width = token.dividers[index].css_width;
				}
				divider.style.height = token.dividers[index].css_height;
				divider.style.top = token.dividers[index].css_top;
				divider.style.left = token.dividers[index].css_left;
			}
		});
	}
}

function clearBento(bento) {
	hideControl(bento.id+"-close");
	hideControl(bento.id+"-slider");
	if (bento.imageContainer) {
		bento.removeChild(bento.imageContainer);
		bento.imageContainer = null;
	}
	if (bento.video) {
		bento.removeChild(bento.video);
		bento.video = null;
	}
	if (bento.audio) {
		var closeButton = document.getElementById(bento.audio.id+"-close");
		bento.removeChild(closeButton);
		bento.removeChild(bento.audio);
		bento.audio = null;
	}
	if (bento.iframe) {
		bento.removeChild(bento.iframe);
		bento.iframe = null;
		bento.contentURI = null;
	}
	bento.file = null;
}

function loadBento(bento, savedBento) {
	if (savedBento.content_uri) {
		if (isYouTube(savedBento.content_uri)) {
			dropYouTube(bento, savedBento.content_uri);
		} else if (isSoundCloud(savedBento.content_uri)) {
			dropSoundCloud(bento, savedBento.content_uri);
		} else if (isSpotify(savedBento.content_uri)) {
			var trackId = spotifyTrackId(savedBento.content_uri);
			dropSpotify(bento, trackId);
		}
	}
	if (savedBento.image_file_name) {
		addImage(bento, savedBento.image_file_path, null, savedBento);
		bento.image_file_name = savedBento.image_file_name;
	}
	if (savedBento.download_file_name) {
		bento.download_file_name = savedBento.download_file_name;
		bento.download_mime_type = savedBento.download_mime_type;
		if (bento.download_mime_type.match(videoType)) {
			addVideo(bento, savedBento.download_file_path, null, savedBento);
		}
		if (bento.download_mime_type.match(audioType)) {
			addAudio(bento, savedBento.download_file_path, null, savedBento);
		}
	}
}
	
function createCroppedImage (bento, image, container) {
	// draw the original image to a scaled canvas
	var canvas = document.createElement('canvas');
	var imageStyle = getComputedStyle(image);
	var width = parseInt(imageStyle.width, 10);
	var height = parseInt(imageStyle.height, 10);
	canvas.width = width;
	canvas.height = height;
	var context = canvas.getContext('2d');
	context.drawImage(image, 0, 0, width, height);
	
	// now crop the canvas
	var containerStyle = getComputedStyle(container);
	var containerLeft = parseInt(containerStyle.left, 10);
	var imageLeft = parseInt(imageStyle.left, 10);
	var sourceX = (containerLeft * -1) - imageLeft;
	var containerTop = parseInt(containerStyle.top, 10);
	var imageTop = parseInt(imageStyle.top, 10);
	var sourceY = (containerTop * -1) - imageTop;
	var croppedCanvas = document.createElement('canvas');
	croppedCanvas.width = parseInt(bento.css_width, 10);
	croppedCanvas.height = parseInt(bento.css_height, 10);
	var croppedContext = croppedCanvas.getContext('2d');
	var cropWidth = parseInt(bento.css_width, 10);
	var cropHeight = parseInt(bento.css_height, 10);
	croppedContext.drawImage(canvas, sourceX, sourceY, cropWidth, cropHeight, 0, 0,cropWidth, cropHeight);
	var croppedImage = new Image();
	croppedImage.src = croppedCanvas.toDataURL();
	return croppedImage;
}