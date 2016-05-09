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
    $('.video-dialog-button').addClass("disable-clicks");
    var dataURL = "https://vimeo.com/api/v2/video/"+ videoId +".json";
    $.ajax({
      type: 'POST',
      async: false,
      dataType: 'json',
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
      },
      complete: function() {
        $('.video-dialog-button').removeClass("disable-clicks");
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
  var videoId = youTubeId(url);
  if (videoId) {
    $('.video-dialog-button').addClass("disable-clicks");
    var imageUrl = "https://img.youtube.com/vi/"+videoId+"/0.jpg";
    var fileFound = false;
    $.ajax({
      type: 'POST',
      async: false,
      dataType: 'json',
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
      },
      complete: function() {
        $('.video-dialog-button').removeClass("disable-clicks");
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
  $('#'+parentId).removeAttr('hidden');
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
  // avoid trying to save before files are finished being added
  $('#save-continue-button').addClass("disable-clicks");

  // process files
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
  $('#save-continue-button').removeClass("disable-clicks");

  // empty selector so next change will be noted (see #862)
  $('#select-image-file:file').val('');
}

function uploadFileData(fileData, fileName, img) {
    var xhr = new XMLHttpRequest();
    if (xhr.upload) {
      xhr.upload.onprogress = function(e) {
        if (e.lengthComputable) {
          // progress indicator goes here
        }
      };
      xhr.open("POST", "/upload", false);
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
    var url = '/ajax/recruiting_company_'+type+'/delete/';
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
  $.ajax({
    type: 'POST',
    datatype: 'json',
    async: false,
    url: url,
    data: params,
    success: function(data, textStatus){
      if(data.status === "SUCCESS") {
        img.data('id', data.id);
        img.data("saved", true);
      } else if (data.status === "ERROR") {
        alert('Save failed: '+data.message);
      }  else {
        alert('Save failed: '+textStatus);
      }
    }
  }).fail(function() {
    alert('Save failed.');
  });
}

function saveTokenImage(img, fileName) {
  img.data('file').name = fileName;
  var url = '/ajax/recruiting_company_image/save/';
  var params = {recruiting_company_id: img.data('recruiting_company_id'), file_name: fileName};
  postSave(img, url, params);
}

function saveTokenVideo(img) {
  var url = '/ajax/recruiting_company_video/save/';
  var params = {
    recruiting_company_id: img.data('recruiting_company_id'),
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
  $("#job-title")[0].updateValueAndPreserveCaret(excludedLinkify($("#job-title").val()));
  $("#job-description")[0].updateValueAndPreserveCaret(excludedLinkify($("#job-description").val()));
  $("#skills-required")[0].updateValueAndPreserveCaret(excludedLinkify($("#skills-required").val()));
  $("#responsibilities")[0].updateValueAndPreserveCaret(excludedLinkify($("#responsibilities").val()));
  $("#perks")[0].updateValueAndPreserveCaret(excludedLinkify($("#perks").val()));
  if($("#company").length) {
    linkifyCompanyText();
  }
}

function linkifyCompanyText() {
  $("#company-description")[0].updateValueAndPreserveCaret(excludedLinkify($("#company-description").val()));
  $("#company-values")[0].updateValueAndPreserveCaret(excludedLinkify($("#company-values").val()));
}

/**
 * Linkify text excluding a black list
 *
 * @param {String} inputText The text to linkify
 * @return {String} The linkified text
 */
function excludedLinkify (inputText) {
  var exclusions = [
    {url:'asp.net', temp:'84gt43qg8ci4bci4'},
    {url:'ASP.NET', temp:'87c84c8n3cgnn7c4'},
    {url:'avc.net', temp:'v5y5s4v5by5b55vb'},
    {url:'AVC.NET', temp:'b7j7fjn6n7n7b6b6'},
    {url:'apc.net', temp:'m87t8r6kbjv6j65b'},
    {url:'APC.NET', temp:'23b46un6unndubyb'},
    {url:'Salesforce.com', temp:'i3cc5si75cm5cik7c5'},
    {url:'salesforce.com', temp:'29jftwkgpgmetfueeg'},
    {url:'Force.com', temp:'chuiueri7n34ininwcf'},
    {url:'force.com', temp:'lncgw82jfnwuchfu3'}
  ];
  exclusions.forEach(function (e) {
    inputText = inputText.replace(e.url, e.temp);
  });
  inputText = Autolinker.link(inputText);
  exclusions.forEach(function (e) {
    inputText = inputText.replace(e.temp, e.url);
  });
  return inputText;
}

function saveRecruitingToken(preview) {
  var tokenId = null;
  var userId = null;
  var serializedForm = null;
  if ($('#recruiting-token-form')[0].validate()) {
    linkifyText();
    //setStatus("Saving token...");
    serializedForm = document.getElementById("recruiting-token-form").serialize();
    if ('true' == $('#recruiter-profile').attr('aria-checked')) {
      serializedForm.recruiter_profile = 'Y';
    } else {
      serializedForm.recruiter_profile = 'N';
    }
    $('#save-continue-button').addClass("disable-clicks");
    $.ajax({
      type: "POST",
      url: "/ajax/recruiting_token/save/",
      data: serializedForm,
      dataType: 'json',
      async: false,
      success: function(data, textStatus){
        if(data.status === "SUCCESS") {
          $("#id").val(data.id);
          $("#long-id").val(data.long_id);
          var userId = data.user_id;
          var tokenId = data.id;
          var companyId = data.recruiting_company_id;
          if (! $('#recruiting-company-id').length) {
            companyInput = '<input type="hidden" id="recruiting-company-id" name="recruiting_company_id" value="'+companyId+'">';
            $('#recruiting-token-form').prepend(companyInput);
          }
          closeStatus();
          if (preview) {
            $('#token-preview').attr('href', '/token/recruiting/'+data.long_id);
            $('#token-preview')[0].click();
          }
          window.location = '/create_company?id='+companyId+'&referrer='+data.long_id;
        } else if (data.status === "ERROR") {
          $('#validation-message').html(data.message);
          $('#validation-dialog')[0].open();
        }  else {
          alert(textStatus);
        }
        $("#save-button").html("Save");
      }
    }).fail(function() {
      alert("Save failed");
    }).always(function() {
      $('#save-continue-button').removeClass("disable-clicks");
    });
  }
}

/**
 * Saves the company information
 */
function saveCompany() {
  var userId = null;
  var serializedForm = null;
  if ($('#recruiting-company-form')[0].validate()) {
    linkifyCompanyText();
    setStatus("Saving company...");
    serializedForm = document.getElementById("recruiting-company-form").serialize();
    $('#save-continue-button').addClass("disable-clicks");
    $.ajax({
      type: 'POST',
      async: false,
      datatype: 'json',
      url: "/ajax/recruiting_company/save/",
      data: serializedForm,
      success: function(data, textStatus){
        if(data.status === "SUCCESS") {
          $("#id").val(data.id);
          var userId = data.user_id;
          var companyId = data.id;
          if (companyId && userId) {
            if ($('#company-images').length) {
              // Upload and save the image files
              $('.recruiting-token-image').each(function() {
                var img = $(this);
                img.data('recruiting_company_id', companyId);
                if (!img.data('saved')) {
                  var file = img.data("file");
                  var fileName = userId+'_'+companyId+'_'+Date.now()+'_'+file.name;
                  img.data('file_name', fileName);
                  uploadFile(file, fileName, img);
                }
              });

              // Delete any removed images
              deleteChildren('image');
            }

            if ($('#company-videos').length) {
              // Save the video urls
              $('.recruiting-token-video').each(function() {
                var img = $(this);
                img.data('recruiting_company_id', companyId);
                if (!img.data('saved')) {
                  saveTokenVideo(img);
                }
              });

              // Delete any removed videos
              deleteChildren('video');
            }
          }

          closeStatus();
          setTimeout(function(){
            window.location = '/send_recruiting?referrer='+companyId+'&id='+$('#recruiting-token-id').val();
          },1000);
        } else if (data.status === "ERROR") {
          alert(data.message);
        }  else {
          alert(textStatus);
        }
        $("#save-button").html("Save");
      }
    }).fail(function() {
      alert("Save failed");
    }).always(function() {
      $('#save-continue-button').removeClass("disable-clicks");
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
    window.location = "/create_recruiting?id="+long_id;
  }
}

/**
 * Open dropdown to choose existing company
 */
function chooseCompany() {
  var dropdown = $("#company-to-use");
  var menu = $("#company-to-use")[0].contentElement;
  menu.selected = null;
  $('#use-existing-company-dialog')[0].open();
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


/**
 * Redirects user back to token edit page from company edit page
 *
 * @param {String} longId The long_id of the token to go back to
 */
function backToToken(longId) {
  window.location = '/create_recruiting?id='+longId;
}
