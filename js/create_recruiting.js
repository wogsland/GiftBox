var imageType = /image.*/;

function createVideoThumbnail(id, src, url) {
	var img = $('<img class="recruiting-token-video" id="'+id+'">');
	img.attr('src', src);
	img.data('url', url);
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
				var img = createVideoThumbnail(videoId, data[0].thumbnail_medium, url);
				createThumbnailContainer(img, 'company-video-container');
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
		var img = createVideoThumbnail(videoId, "https://img.youtube.com/vi/"+videoId+"/0.jpg", url);
		createThumbnailContainer(img, 'company-video-container');
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
	$('#company-'+type+'-container').data('deleted').push(id);
}

function removeDeleted(type, id) {
	var deleted = getDeleted(type);
	var start = deleted.indexOf(id);
	deleted.splice(start, 1);
}

function remove(img) {
	if (img.data('saved') == true) {
		var id = img.data('id');
		if (img.hasClass("recruiting-token-image")) {
			addDeleted('image', id);
		} else if (img.hasClass("recruiting-token-video")) {
			addDeleted('video', id);
		}
	}
	img.parent().parent().remove();
}

function createThumbnailContainer(object, parentId) {
	var container = $('<div>');
	var inner = $('<div>');
	var button = $('<paper-button raised class="remove-button">REMOVE</paper-button>').click(function(){remove(object);});
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
		
		var img = $('<img class="recruiting-token-image" id="'+file.name+'">');
		img.attr('src', window.URL.createObjectURL(file));
		img.data('file', file);
		img.data('saved', false);
		createThumbnailContainer(img, "company-image-container");
	}
}

function uploadFileData(fileData, fileName, img) {
    var xhr = new XMLHttpRequest();
    if (xhr.upload) {
		console.log("Uploading " + fileName);
		xhr.upload.onprogress = function(e) {
			if (e.lengthComputable) {
				console.log("Uploading " + fileName + " " + (Math.round((e.loaded / e.total) * 100))+"%");
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
	var params = {recruiting_token_id: img.data('token_id'), image_file_name: fileName};
	postSave(img, url, params);
}

function saveTokenVideo(img) {
	var url = '/ajax/recruiting_token_video/save/';
	var params = {recruiting_token_id: img.data('token_id'), video_url: img.data('url')};
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
//	if (isValid('job-title') && isValid('job-description') && isValid('city-id')) {
		// Save the token first so we can use the ID in the file path:  userId/tokenId/fileName
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
