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
    openLinkedIn();
  }
}

function openLinkedIn() {
  var url = "https://linkedin.com/company/sizzle";
  $.get(url, function(data) {
    console.log(data);
  });
}

function cancelLinkedIn() {
  $('label').css('color', '');
}
