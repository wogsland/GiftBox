var companyInfo = null;
var text = 'https://www.linkedin.com/company/';

/**
 * Hides elements upon the page loading
 */
$(document).ready(function() {
  // placeholder text
  $('#linkedin-url').val(text);
  // hide the add button
  $('#linkedin-add-button').hide();
  // hide and disable progress bar
  $('#linkedin-progress').hide();
});

/**
 * Opens the LinkedIn scraper modal
 */
function initLinkedIn() {
  $('#linkedin-dialog')[0].open();
  $('#linkedin-add-button').hide();
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
    // hide the add button temporarily
    $('#linkedin-add-button').hide();
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
        console.log(data);
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
        $('#linkedin-add-button').show();
      }
    },
    error: function(xhr, status, error) {
      console.log(error);
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
  $('#linkedin-add-button').hide();
  $('#linkedin-url').val(text);
}

/**
 * Populates the token with information - assumes
 * the AJAX request was successful
 */
function addData() {
  $('#linkedin-cancel-button').trigger('click');
  addName();
  addDescription();
  addImages();
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

/**
 * Adds the default LinkedIn images to the images section
 */
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
      console.log(error);
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
