var companyInfo = null;
var text = 'https://www.linkedin.com/company/';

/**
 * Hides elements upon the page loading
 */
$(document).ready(function() {
  $('#linkedin-url')
    .val(text)
    .keydown(function() {
      $('label').css('color', '');
      $('#linkedin-url').attr('label', "Enter your company's LinkedIn URL");
      $('#linkedin-submit-button')
        .text('Submit')
        .attr('onclick', 'processLinkedIn()');
    });
  $('#linkedin-submit-button').text('Submit');
  $('#linkedin-progress').hide();
  cleanUploads('refresh');
});

/**
 * Opens the LinkedIn scraper modal
 */
function initLinkedIn() {
  $('#linkedin-dialog')[0].open();
  $('#linkedin-submit-button')
    .text('Submit')
    .attr('onclick', 'processLinkedIn()');
}

/**
 * Clears unused LinkedIn images in the uploads directory
 * that were generated from a previous scrape
 */
function cleanUploads(key) {
  $.ajax({
    type: 'POST',
    dataType: 'json',
    data: {'clear': key},
    url: '/ajax/linkedin-scraper',
    error: function(xhr, status, error) {
      console.error(error);
    }
  });
}

/**
 * Processes information from the input and changes
 * input label colors based on the request status
 */
function processLinkedIn() {
  var $input = $('#linkedin-url');
  var link = $input.val();
  if (link.length === 0) {
    $('label').css('color', 'red');
    $input.attr('label', "Enter your company's LinkedIn URL");
  } else {
    // handle progress bar
    $('#linkedin-progress').show();
    // call function
    openLinkedIn(link);
  }
}

/**
 * Sends an AJAX request to retrieve company information
 * from the Python web scraper
 *
 * @param {String} companyLink LinkedIn company URL
 */
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
        companyInfo = JSON.parse(data['data']);
      } catch (error) {
        console.error(error);
      }

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
        $('#linkedin-submit-button')
          .text('Select')
          .attr('onclick', 'addData()');
      }
    },
    error: function(xhr, status, error) {
      console.error(error);
    }
  });
}

/**
 * Resets the LinkedIn modal window
 */
function cancelLinkedIn() {
  $('label').css('color', '');
  $('#linkedin-url').attr('label', "Enter your company's LinkedIn URL");
  $('#linkedin-progress').hide();
  $('#linkedin-url').val(text);
  $('#linkedin-submit-button')
    .text('Select')
    .attr('onclick', 'processLinkedIn()');
  try {
    var key = companyInfo['key'];
    cleanUploads(key);
  } catch (e) {}
}

/**
 * Resets the LinkedIn modal window without removing
 * data that was previously scraped
 */
function resetLinkedIn() {
  $('#linkedin-dialog')[0].close();
  $('label').css('color', '');
  $('#linkedin-url').attr('label', "Enter your company's LinkedIn URL");
  $('#linkedin-progress').hide();
  $('#linkedin-url').val(text);
  $('#linkedin-submit-button')
    .text('Select')
    .attr('onclick', 'processLinkedIn()');
}

/**
 * Populates the token with information - assumes
 * the AJAX request was successful
 */
function addData() {
  var alert = false;
  var fields = ['#company', '#company-description', '#company-linkedin'];
  for (var i = 0; i < fields.length; i++) {
    if ($(fields[i]).val().length > 0) {
      alert = true;
      break;
    }
  }
  if ($('#company-image-container').children().length !== 0) alert = true;
  if (alert) {
    var message = 'Warning: "Select" will replace data already in the form';
    if (!confirm(message)) return;
  }
  addName();
  addDescription();
  clearExistingImages();
  addImages();
  addURL();
  resetLinkedIn();
}

/**
 * Adds the company name to its respective field
 */
function addName() {
  $('#company').val(companyInfo['name']);
}

/**
 * Adds the company description to its respective field
 */
function addDescription() {
  $('#company-description').val(companyInfo['description']);
}

function clearExistingImages() {
  var parent = '#company-image-container';
  var container = '.photo-thumbnail';
  var images = $(container);
  for (var i = 0; i < images.length; i++) {
    var id = $(images[i]).attr('id');
    var key = id.slice(-10);
    cleanUploads(key);
  }
  $(parent).children().length > 0 ? $(parent).empty() : null;
}

/**
 * Adds the default LinkedIn images to the images section
 */
function addImages() {
  var images = ['heroImage', 'legacyLogo'];
  var img = null;
  for (var i = 0; i < images.length; i++) {
    var key = companyInfo['key'];
    if (companyInfo[images[i]].length > 0) {
      var url = 'https://media.licdn.com/media' + companyInfo[images[i]];
      img = $('<img class="recruiting-token-image" id="' + images[i] + '-' + key + '">');
      $(img).attr('src', url);
      img.data('file', null);
      img.data('name', images[i] + '-' + key);
      img.data('saved', false);
      img.data('scraped', true);
      createThumbnail(img, 'company-image-container');
    }
  }
}

/**
 * Adds the LinkedIn URL to the social media section
 */
function addURL() {
  var url = companyInfo['url'];
  var shortURL = url.replace('https://www.linkedin.com/', '');
  $('#company-linkedin').val(shortURL);
}

/**
 * Changes the names of the images for inclusion in the
 * Sizzle database through AJAX
 *
 * @param {Object} image scraped image
 * @param {String} oldName default name of image
 * @param {String} newName unique identifier of image
 */
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
    },
    error: function(xhr, status, error) {
      console.error(error);
    }
  });
}

/**
 * Saves images to the database
 *
 * @param {Object} image scraped image
 * @param {String} imageName unique identifier of image
 */
function saveScrapedImage(image, imageName) {
  image.data('name', imageName);
  var url = 'ajax/recruiting_company_image/save';
  var params = {
    recruiting_company_id: image.data('recruiting_company_id'),
    file_name: imageName
  };
  postSave(image, url, params);
}
