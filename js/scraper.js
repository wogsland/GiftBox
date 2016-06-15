var companyInfo = null;

$(document).ready(function() {
  // hide the add button
  $('#linkedin-add-button').hide();
  // hide and disable progress bar
  $('#linkedin-progress').hide();
});

function initLinkedIn() {
  $('#linkedin-dialog')[0].open();
  $('#linkedin-add-button').hide();
}

function processLinkedIn() {
  var $input = $('#linkedin-url');
  var name = $input.val();
  if (name.length === 0) {
    $('label').css('color', 'red');
    $input.attr('label', "Enter your company's LinkedIn username");
  } else {
    // handle progress bar
    $('#linkedin-progress').show();
    // hide the add button temporarily
    $('#linkedin-add-button').hide();
    // call function
    openLinkedIn(name);
  }
}

function openLinkedIn(companyName) {
  $.ajax({
    type: 'POST',
    dataType: 'json',
    data: {
      name: companyName
    },
    url: '/ajax/linkedin-scraper',
    success: function(data) {
      try {
        companyInfo = JSON.parse(data['data']);
      } catch (error) {
        console.error(error);
      }

      if (companyInfo == null) {
        handleToast(2);
      } else if (
          companyInfo['name'].length === 0 &&
          companyInfo['description'].length === 0 &&
          companyInfo['legacyLogo'].length === 0 &&
          companyInfo['heroImage'].length === 0
      ) {
        handleToast(1);
      } else {
        handleToast(0);
      }
    },
    error: function(xhr, status, error) {
      console.log(error);
    }
  });
}

function cancelLinkedIn() {
  $('label').css('color', '');
  $('#linkedin-progress').hide();
  $('#linkedin-url').val("");
  $('#linkedin-add-button').hide();
}

function addData() {
  $('#linkedin-cancel-button').trigger('click');
  $('#toast').hide();
  addName();
  addDescription();
  addImages();
}

function addName() {
  var container = $('#company').children()[0];
  var label = $(container).children()[2];
  var labelContainer = $(label).children()[0];
  var input = $(labelContainer).children()[1];
  $(label).addClass('label-is-floating');
  $(input).val(companyInfo['name']);
  $(input).click(function() {
    $(label).addClass('label-is-floating');
  });
}

function addDescription() {
  var parent = $('paper-textarea')[0];
  var textareaContainer = $(parent).children()[0];
  var descripLabel = $(textareaContainer).children()[2];
  var text = $('#textarea')[0];
  $(descripLabel).addClass('label-is-floating');
  $(text).val(companyInfo['description']);
  $(text).click(function() {
    $(descripLabel).addClass('label-is-floating');
  });
  $(document).click(function() {
    if ($(text).val().length !== 0) {
      $(descripLabel).addClass('label-is-floating');
    }
  });
}

function addImages() {
  var images = ["legacyLogo", "heroImage"];
  var img = null;
  for (var i = 0; i < images.length; i++) {
    if (companyInfo[images[i]].length > 0) {
      var url = 'https://media.licdn.com/media' + companyInfo[images[i]];
      img = $('<img class="recruiting-token-image" id="' + images[i] + '">');
      $(img).attr('src', url);
      img.data('file', url);
      img.data('file').name = images[i];
      img.data('saved', false);
      createThumbnail(img, "company-image-container");
    }
  }
}

function handleToast(status) {
  var toastText = "";
  switch(status) {
    case 0:
      toastText = "LinkedIn company and information found";
      $('#linkedin-add-button').show();
      break;
    case 1:
      toastText = "LinkedIn company found but no information found";
      break;
    case 2:
      toastText = "LinkedIn company not found";
      break;
    default: break;
  }
  $('#toast').attr('text', toastText);

  // hide progress when toast is set
  $('#linkedin-progress').hide();
}

function resetToast() {
  $('#toast').attr('text', 'Searching for LinkedIn company');
}
