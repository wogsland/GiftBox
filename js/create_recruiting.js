var imageType = /image.*/;

function clearImage(id) {
	$("#"+id).val(null);
	var img = $("#"+id+"-img");
	img.attr("src", null);
	img.data("file", null);
	img.data("saved", true);
}

function removeImage() {
	alert("removeImage()");
}

function createThumbnailContainer(object, titleText, parentId) {
	var container = document.createElement("div");
	var inner = document.createElement("div");
	var button = $('<button type="button" class="image-remove-button">REMOVE</buton>').click(function(){removeImage();});
	inner.classList.add("inner-thumbnail-container");
	object.classList.add("photo-thumbnail");
	container.classList.add("thumbnail-container");
	container.id = "thumbnail-container-"+($(".thumbnail-container").size()+1);
	inner.appendChild(object);
	inner.appendChild(button[0]);
	container.appendChild(inner);
	document.getElementById(parentId).appendChild(container);
}

function handleImageFileSelect(evt) {
	for (var i = 0; i < evt.target.files.length; i++) {
		var file = evt.target.files[i];
		if (!file.type.match(imageType)) {
			alert(file.name+" is not an image file (.jpg, .png, etc.).");
			continue;
		}

		// Create an image element to show the thumbnail
		var img = document.createElement("img");
		img.src = window.URL.createObjectURL(file);
		img.file = file;
		img.id = file.name;
		createThumbnailContainer(img, file.name, "company-images-container");
		
	}
}

function uploadFileData(fileData, fileName) {
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
    }
}

function uploadFile(file, fileName) {
	fileName = typeof fileName !== 'undefined' ? fileName : file.name;
	var reader  = new FileReader();
	reader.fileName = fileName;
	reader.onloadend = function () {
		uploadFileData(reader.result, reader.fileName);
	};
	reader.readAsDataURL(file);
}

function saveRecruitingToken(preview) {
	var tokenId = null;
	var userId = null;
	var serializedForm = null;
	$("#save-button").html("Saving...");

	// Save the token first so we can use the ID in the file path:  userId/tokenId/fileName
	// serializedForm = $("#recruiting-token-form").serialize();
	serializedForm = document.getElementById("recruiting-token-form").serialize();
	$.post("/ajax/recruiting_token/save/", serializedForm, function(data, textStatus){
		if(data.status === "SUCCESS") {
			$("#id").val(data.id);
			$("#long-id").val(data.long_id);
/*			
			// Save the files
			if (tokenId && userId) {

				// Backdrop picutre
				var img = $("#backdrop-picture-img");
				if (!img.data("saved")) {
					var file = img.data("file");
					uploadFile(file, backdropfileName);
					// Mark it as saved
					img.data("saved", true);
					$("#backdrop-picture").val(backdropfileName);
				}
				// Company
				img = $("#company-picture-img");
				if (!img.data("saved")) {
					var file = img.data("file");
					uploadFile(file, companyfileName);
					// Mark it as saved
					img.data("saved", true);
					$("#company-picture").val(companyfileName);
				}
			}
*/			if (preview) {
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
