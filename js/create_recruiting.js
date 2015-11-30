var imageType = /image.*/;

function createVideoImage(id, src, url) {
	var img = $('<img class="recruiting-token-video" id="'+id+'">');
	img.attr('src', src);
	img.data('url', url);
	img.data('thumbnail_src', src);
	img.data('saved', false);

	return img;
}

function openVimeo(url){
	var videoId = vimeoId(url);
	var error = null;
	if (videoId) {
		var dataURL = "https://vimeo.com/api/v2/video/"+ videoId +".json";
		$.getJSON(dataURL,
			function(data){
				var title = data[0].title;
				var img = createVideoImage(videoId, data[0].thumbnail_medium, url);
				createThumbnail(img, 'company-video-container');
			}).fail(function() {
				error = "Vimeo API call failed. Please verify that the URL you entered is correct.\n\n" + dataURL;
				alert(error);
			});
	} else {
		error = "Unable to extract a Vimeo video ID from the URL.\n\n"+url;
		alert(error);
	}
}

function openYouTube(url) {
	var videoId = youTubeID(url);
	var error = null;
	if (videoId) {
		var img = createVideoImage(videoId, "https://img.youtube.com/vi/"+videoId+"/0.jpg", url);
		createThumbnail(img, 'company-video-container');
	} else {
		error = "Unable to extract a Youtube video ID from the URL.\n\n"+url;
		alert(error);
	}
}

function processVideoURL() {
	var url = $('#video-dialog-url').val();
	var valid = false;
	if(isYouTube(url)){
		openYouTube(url);
		valid = true;
	} else if (isVimeo(url)){
		openVimeo(url);
		valid = true;
	}
	if (valid) {
		$('#video-dialog')[0].close();
	} else {
		$('#video-dialog-url')[0].validate();
	}
}

function openVideoDialog() {
	$('#video-dialog-url').val(null);
	$('#video-dialog')[0].open();
}

function getDeleted(type) {
	return $('#company-'+type+'-container').data('deleted');
}

function addDeleted(type, id) {
	var container = $('#company-'+type+'-container');
	var deleted = container.data('deleted');
	deleted.push(id);
}

function removeDeleted(type, id) {
	var deleted = getDeleted(type);
	var start = deleted.indexOf(id);
	deleted.splice(start, 1);
}

function removeImage(img) {
	var saved = img.data('saved');
	if (saved == true) {
		var id = img.data('id');
		if (img.hasClass("recruiting-token-image")) {
			addDeleted('image', id);
		} else if (img.hasClass("recruiting-token-video")) {
			addDeleted('video', id);
		}
	}
	img.parent().parent().remove();
}

function removeImageById(imageId) {
	removeImage($('#'+imageId));
}

function createThumbnail(object, parentId) {
	var container = $('<div>');
	var inner = $('<div>');
	var button = $('<paper-button raised class="remove-button">REMOVE</paper-button>').click(function(){removeImage(object);});
	inner.addClass("inner-thumbnail-container");
	object.addClass("photo-thumbnail");
	container.addClass("thumbnail-container");
	container.attr('id', 'thumbnail-container-'+($('.thumbnail-container').size()+1));
	inner.append(object);
	inner.append(button);
	container.append(inner);
	$('#'+parentId).append(container);
}

function handleImageFileSelect(evt) {
	for (var i = 0; i < evt.target.files.length; i++) {
		var file = evt.target.files[i];
		if (!file.type.match(imageType)) {
			alert(file.name+" is not an image file (.jpg, .png, etc.).");
			continue;
		}

		// Create an image element to show the thumbnail

		var img = $('<img class="recruiting-token-image" id="'+file.name.replace('.', '_')+'">');
		img.attr('src', window.URL.createObjectURL(file));
		img.data('file', file);
		img.data('saved', false);
		createThumbnail(img, "company-image-container");
	}
}

function uploadFileData(fileData, fileName, img) {
    var xhr = new XMLHttpRequest();
    if (xhr.upload) {
		xhr.upload.onprogress = function(e) {
			if (e.lengthComputable) {
				// progress indicator goes here
			}
		};
        xhr.open("POST", "upload.php", true);
        xhr.setRequestHeader("X-FILENAME", fileName);
        xhr.send(fileData);
		saveTokenImage(img, fileName);
    }
}

function uploadFile(file, fileName, img) {
	fileName = typeof fileName !== 'undefined' ? fileName : file.name;
	var reader  = new FileReader();
	reader.fileName = fileName;
	reader.onloadend = function () {
		uploadFileData(reader.result, reader.fileName, img);
	};
	reader.readAsDataURL(file);
}

function deleteChildren(type) {
	var ids = getDeleted(type);
	ids.forEach(function(id){
		var url = '/ajax/recruiting_token_'+type+'/delete/';
		var params = {id: id};
		$.post(url, params, function(data, textStatus){
			if(data.status === "SUCCESS") {
				removeDeleted(type, id);
			} else if (data.status === "ERROR") {
				alert('Recruiting token '+type+' delete failed: '+data.message);
			}  else {
				alert('Recruiting token '+type+' delete failed: '+textStatus);
			}
		},'json').fail(function() {
			alert('Recruiting token '+type+' delete failed.');
		});
	});
}

function postSave(img, url, params) {
	$.post(url, params, function(data, textStatus){
		if(data.status === "SUCCESS") {
			img.data('id', data.id);
			img.data("saved", true);
		} else if (data.status === "ERROR") {
			alert('Save failed: '+data.message);
		}  else {
			alert('Save failed: '+textStatus);
		}
	},'json').fail(function() {
		alert('Save failed.');
	});
}

function saveTokenImage(img, fileName) {
	img.data('file').name = fileName;
	var url = '/ajax/recruiting_token_image/save/';
	var params = {recruiting_token_id: img.data('token_id'), file_name: fileName};
	postSave(img, url, params);
}

function saveTokenVideo(img) {
	var url = '/ajax/recruiting_token_video/save/';
	var params = {recruiting_token_id: img.data('token_id'), url: img.data('url'), thumbnail_src: img.data('thumbnail_src')};
	postSave(img, url, params);
}

function isValid(id) {
	var valid = false;
	var field = $('#'+id);
	var value = field[0].value
	if (typeof value == 'undefined' || !value) {
		var fieldName = field[0].label;
		$('#validation-message').html(fieldName+" is a required field.");
		$('#validation-dialog')[0].open();
	} else {
		valid = true;
	}

	return valid;
}
function saveRecruitingToken(preview) {
	var tokenId = null;
	var userId = null;
	var serializedForm = null;
	if ($('#recruiting-token-form')[0].validate()) {
		setStatus("Saving token...");
		serializedForm = document.getElementById("recruiting-token-form").serialize();
		$.post("/ajax/recruiting_token/save/", serializedForm, function(data, textStatus){
			if(data.status === "SUCCESS") {
				$("#id").val(data.id);
				$("#long-id").val(data.long_id);
				var userId = data.user_id;
				var tokenId = data.id;

				if (tokenId && userId) {
					// Upload and save the image files
					$('.recruiting-token-image').each(function() {
						var img = $(this);
						img.data('token_id', tokenId);
						if (!img.data('saved')) {
							var file = img.data("file");
							var fileName = userId+'_'+tokenId+'_'+Date.now()+'_'+file.name;
							img.data('file_name', fileName);
							uploadFile(file, fileName, img);
						}
					});

					// Save the video urls
					$('.recruiting-token-video').each(function() {
						var img = $(this);
						img.data('token_id', tokenId);
						if (!img.data('saved')) {
							saveTokenVideo(img);
						}
					});

					// Delete any removed images
					deleteChildren('image');

					// Delete any removed videos
					deleteChildren('video');

				}

				closeStatus();
				if (preview) {
					window.open('/token/recruiting/'+data.long_id , '_blank');
				}
			} else if (data.status === "ERROR") {
				alert(data.message);
			}  else {
				alert(textStatus);
			}
			$("#save-button").html("Save");
		},'json').fail(function() {
			alert("Save failed");
		});
	}
}

function openToken() {
	var dropdown = $("#token-to-open");
	var menu = $("#token-to-open")[0].contentElement;
	menu.selected = null;
	$('#open-dialog')[0].open();
}

function processOpen() {
	if ($("#open-token-form")[0].validate()) {
		setStatus("Opening token...");
		var menu = $("#token-to-open")[0].contentElement;
		var long_id = menu.selectedItem.id;
		$('#open-dialog')[0].close();
		window.location = "/create_recruiting.php?id="+long_id;
	}
}

function setStatus(message) {
	$('#status-message').html(message);
	$('#status-dialog')[0].open();
}
function closeStatus() {
	$('#status-dialog')[0].close();
}

function shrink(item) {
	item.animate(
		{
		height: "toggle"
		}, 1000, function() {});
}

function fadeIn(item) {
	item.animate(
		{
		opacity: 1
		}, 1000, function() {});
}

function finish() {
	shrink($("#company-social-media"));
	shrink($("#company-videos"));
	shrink($("#company-images"));
	shrink($("#company-info"));
	shrink($("#basic-info"));
	shrink($("#required-info"));
	$(".bottom-button").each(function() {
		shrink($(this));
	});
	fadeIn($("#send-token-via"));
}
