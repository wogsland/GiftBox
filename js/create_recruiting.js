var imageType = /image.*/;

/**
 * Creates an HTML image
 *
 * @param {String} id The source id of the video
 * @param {String} src Whether it's YouTube or Vimeo
 * @param {String} url The URL of the video
 * @return {Oject} The HTML image
 */
function createVideoImage(id, src, url, source) {
  var img = $('<img class="recruiting-token-video" id="'+id+'">');
  img.attr('src', src);
  img.data('url', url);
  img.data('source', source);
  img.data('saved', false);

  return img;
}

/**
 * Opens a Vimeo URL to a thumbnail if it's valid
 *
 * @param {String} url The URL of a Vimeo video
 * @return {Boolean} The validity of the URL
 */
function openVimeo(vimeoUrl){
  var videoId = vimeoId(vimeoUrl);
  var fileFound = false;
  if (videoId) {
    var dataURL = "https://vimeo.com/api/v2/video/"+ videoId +".json";
    $.ajax({
      type: 'POST',
      dataType: 'json',
      async: false,
      url: '/ajax/url-valid',
      data: {
        url: dataURL
      },
      success: function(data){
        $.getJSON(
          dataURL,
          function(data){
            var img = createVideoImage(videoId, data[0].thumbnail_medium, vimeoUrl, 'vimeo');
            createThumbnail(img, 'company-video-container');
          }
        );
        fileFound = true;
      },
      error: function() {
        $('label').css('color', 'red');
        $('#video-dialog-url').attr('label', 'Please choose a valid Vimeo URL.');
      }
    });
  } else {
    $('label').css('color', 'red');
    $('#video-dialog-url').attr('label', 'Unable to extract a Vimeo video ID from the URL.');
  }
  return fileFound;
}

/**
 * Opens a YouTube URL to a thumbnail if it's valid
 *
 * @param {String} url The URL of a YouTube video
 * @return {Boolean} The validity of the URL
 */
function openYouTube(url) {
  var videoId = youTubeID(url);
  if (videoId) {
    var imageUrl = "https://img.youtube.com/vi/"+videoId+"/0.jpg";
    var fileFound = false;
    $.ajax({
      type: 'POST',
      dataType: 'json',
      async: false,
      url: '/ajax/url-valid',
      data: {
        url: imageUrl
      },
      success: function(data) {
        if (data.data.httpCode == '200') {
          var img = createVideoImage(videoId, imageUrl, url, 'youtube');
          createThumbnail(img, 'company-video-container');
          fileFound = true;
        } else {
          $('label').css('color', 'red');
          $('#video-dialog-url').attr('label', 'Please choose a valid Youtube URL.');
        }
      }
    });
    return fileFound;
  } else {
    $('label').css('color', 'red');
    $('#video-dialog-url').attr('label', 'Unable to extract a Youtube video ID from the URL.');
    return false;
  }
}

/**
 * Adds a video URL after validating it or displays an error message
 */
function processVideoURL() {
  var url = $('#video-dialog-url').val();
  var valid = false;
  var isYouTubeVid = isYouTube(url);
  var isVimeoVid = isVimeo(url);
  if(isYouTubeVid){
    valid = openYouTube(url);
  } else if (isVimeoVid){
    valid = openVimeo(url);
  }
  if (valid) {
    $('#video-dialog')[0].close();
    $('label').css('color', '');
    $('#video-dialog-url').attr('label', 'Please choose a Youtube or Vimeo video.');
  } else if (!isYouTubeVid && !isVimeoVid) {
    $('label').css('color', 'red');
    $('#video-dialog-url').attr('label', 'Please choose a Youtube or Vimeo video.');
  }
}

/**
 * Cancels input of a video URL which may have included errors
 */
function cancelVideoURL() {
  $('label').css('color', '');
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

/**
 * Remove an image or video from view and queue it to be removed from the
 * database if needed when the token is saved
 *
 * @param {Object} img The image or video object
 */
function removeImage(img) {
  var saved = img.data('saved');
  if (saved === true) {
    var id = img.data('id');
    if (img.hasClass("recruiting-token-image")) {
      addDeleted('image', id);
    } else if (img.hasClass("recruiting-token-video")) {
      addDeleted('video', id);
    }
  }
  img.parent().parent().remove();
}

/**
 * Remove an image or video from view and queue it to be removed from the
 * database if needed when the token is saved
 *
 * @param {String} imageId The HTML id of the image or video object
 */
function removeImageById(imageId) {
  removeImage($('#'+imageId));
}

/**
 * Create thumbnail of an image and a remove button and display them
 *
 * @param {Object} object The image HTML object
 * @param {String} parentId The HTML id of the tag to plave the thumbnail in
 */
function createThumbnail(object, parentId) {
  var container = $('<div>');
  var inner = $('<div>');
  var button = $('<paper-button raised class="remove-button">REMOVE</paper-button>').click(function(){
    removeImage(object);
  });
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
        xhr.open("POST", "/upload", true);
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
  var params = {
    recruiting_token_id: img.data('token_id'),
    url: img.data('url'),
    source: img.data('source'),
    source_id: img.attr('id')
  };
  postSave(img, url, params);
}

function isValid(id) {
  var valid = false;
  var field = $('#'+id);
  var value = field[0].value;
  if (typeof value == 'undefined' || !value) {
    var fieldName = field[0].label;
    $('#validation-message').html(fieldName+" is a required field.");
    $('#validation-dialog')[0].open();
  } else {
    valid = true;
  }

  return valid;
}

function linkifyText() {
  $("#job-title")[0].updateValueAndPreserveCaret(Autolinker.link($("#job-title").val()));
  $("#job-description")[0].updateValueAndPreserveCaret(Autolinker.link($("#job-description").val()));
  $("#skills-required")[0].updateValueAndPreserveCaret(Autolinker.link($("#skills-required").val()));
  $("#responsibilities")[0].updateValueAndPreserveCaret(Autolinker.link($("#responsibilities").val()));
  $("#perks")[0].updateValueAndPreserveCaret(Autolinker.link($("#perks").val()));
  $("#company")[0].updateValueAndPreserveCaret(Autolinker.link($("#company").val()));
  //$("#company-tagline")[0].updateValueAndPreserveCaret(Autolinker.link($("#company-tagline").val()));
  //$("#company-website")[0].updateValueAndPreserveCaret(Autolinker.link($("#company-website").val()));
  $("#company-values")[0].updateValueAndPreserveCaret(Autolinker.link($("#company-values").val()));
}

function saveRecruitingToken(preview) {
  var tokenId = null;
  var userId = null;
  var serializedForm = null;
  if ($('#recruiting-token-form')[0].validate()) {
    linkifyText();
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
  $('#status-dialog').css('height', '170px');
  $('#status-dialog')[0].open();
}
function closeStatus() {
  $('#status-dialog').css('height', '0px');
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
