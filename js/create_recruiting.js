var imageType = /image.*/;

function clearImage(id) {
	$("#"+id).val(null);
	var img = $("#"+id+"-img");
	img.attr("src", null);
	img.data("file", null);
	img.data("saved", true);
}

function handleImageFileSelect(evt) {
	for (var i = 0; i < evt.target.files.length; i++) {
		var file = evt.target.files[i];
		if (!file.type.match(imageType)) {
			alert(file.name+" is not an image file (.jpg, .png, etc.).");
			continue;
		}
		var baseId = this.id.replace("-input", "");
		var img = $("#"+baseId+"-img");
		
		// Set the value of the hidden field to the file name
		$("#"+baseId).val(file.name);
		
		// Set the src of the img element
		img.attr("src", window.URL.createObjectURL(file));
		
		// Save a reference to the file Object for later saving
		img.data("file", file);
		
		// Set the dirty flag so the file gets saved
		img.data("saved", false);
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

function saveRecruitingToken() {
	var tokenId = null;
	var userId = null;
	$("#save-button").html("Saving...");
	
	// Save the token first so we can use the ID in the file path:  userId/tokenId/fileName
	$.post("save_recruiting_token_ajax.php", $("#recruiting-token-form").serialize(), function(data, textStatus){
		if(data.status === "SUCCESS") {
			$("#id").val(data.token_id);
			tokenId = data.token_id;
			userId = data.user_id;
			backdropfileName = data.backdrop_picture;
			companyfileName = data.company_picture;

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
			$("#save-button").html("Save");
		} else if (data.status === "ERROR") {
			alert(data.message);
		}  else {
			alert(textStatus);
		}
	}).fail(function() {
		alert("Save failed");
	});
	
}