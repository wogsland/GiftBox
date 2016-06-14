$(document).ready(function() {
  // hide and disable progress bar
  $('#linkedin-progress').hide();
});

function initLinkedIn() {
  $('#linkedin-dialog')[0].open();
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
      var companyInfo = null;
      try {
        companyInfo = JSON.parse(data['data']);
      } catch (error) {
        console.error(error);
      }

      var companyInfo = JSON.parse(data['data']);
      console.log(companyInfo);

      /*
      TODO statuses:
      - company found, information found
      - company found, no information found
      - no company found
      */

      $('#toast').attr('text', 'LinkedIn company found!');
      $('#linkedin-progress').hide();
      // TODO enable add button, disable other two buttons

      // TODO add button handler - calls the addDescription
      // and the addImages functions


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
}

function addDescription() {
  // TODO grab id of company description and
  // populate it with the description
}

function addImages() {
  // TODO ajax call to add images?
}

function resetToast() {
  $('#toast').attr('text', 'Searching for LinkedIn company');
}
