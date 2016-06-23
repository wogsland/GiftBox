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
  var link = $input.val();
  if (link.length === 0) {
    $('label').css('color', 'red');
    $input.attr('label', "Enter your company's LinkedIn URL");
  } else {
    // handle progress bar
    $('#linkedin-progress').show();
    // hide the add button temporarily
    $('#linkedin-add-button').hide();
    // call function
    openLinkedIn(link);
  }
}

function openLinkedIn(companyLink) {
  $.ajax({
    type: 'POST',
    dataType: 'json',
    data: {
      link: companyLink
    },
    url: '/ajax/linkedin-scraper',
    success: function(data) {
      try {
        console.log(data);
        companyInfo = JSON.parse(data['data']);
      } catch (error) {
        console.error(error);
      }

      //console.log(companyInfo);
      $('#linkedin-progress').hide();

      if (companyInfo === null ||
        (companyInfo['name'].length === 0 &&
        companyInfo['description'].length === 0 &&
        companyInfo['legacyLogo'].length === 0 &&
        companyInfo['heroImage'].length === 0)
      ) {
        $('label').css('color', 'red');
        $('#linkedin-url').attr('label', 'LinkedIn company not found');
      } else {

        $('label').css('color', 'green');
        $('#linkedin-url').attr('label', 'LinkedIn company and information found');
        $('#linkedin-add-button').show();
      }
    },
    error: function(xhr, status, error) {
      console.log(error);
    }
  });
}

function cancelLinkedIn() {
  $('label').css('color', '');
  $('#linkedin-url').attr('label', "Enter your company's LinkedIn URL");
  $('#linkedin-progress').hide();
  $('#linkedin-url').val("");
  $('#linkedin-add-button').hide();
}

function addData() {
  $('#linkedin-cancel-button').trigger('click');
  addName();
  addDescription();
  addImages();
}

function addName() {
  $('#company').val(companyInfo['name']);
}

function addDescription() {
  $('#company-description').val(companyInfo['description']);
}

function addImages() {
  var images = ["heroImage", "legacyLogo"];
  var img = null;
  for (var i = 0; i < images.length; i++) {
    if (companyInfo[images[i]].length > 0) {
      var url = 'https://media.licdn.com/media' + companyInfo[images[i]];
      img = $('<img class="recruiting-token-image" id="' + images[i] + '">');
      $(img).attr('src', url);
      img.data('file', null);
      img.data('name', images[i]);
      img.data('saved', false);
      img.data('scraped', true);
      createThumbnail(img, "company-image-container");
    }
  }
}

function uploadScrapedImage(image, oldName, newName) {
  $.ajax({
    type: 'POST',
    dataType: 'json',
    url: 'ajax/linkedin-scraper',
    data: {'oldName': oldName, 'newName': newName},
    success: function(data, status) {
      if (data['success']) {
        saveScrapedImage(image, newName);
      }
    }
  });
}

function saveScrapedImage(image, imageName) {
  image.data('name', imageName);
  var url = 'ajax/recruiting_company_image/save';
  var params = {
    recruiting_company_id: image.data('recruiting_company_id'),
    file_name: imageName
  };
  postSave(image, url, params);
}
