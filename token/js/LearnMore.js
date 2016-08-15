Sizzle.LearnMore = {

  /**
   * Closes the learn more dialog
   */
  'close': function (event) {
    $('#learn-more-dialog')[0].close();
    learnMoreOpen = false;
    $('.interest-fab').removeClass('mdl-button--disabled');
  },

  /**
   * Submits learn more info
   */
  'submit': function(event) {
    event.preventDefault();
    if ($('#learn-more-email')[0].validate()) {
      $('.learn-more-button').addClass('disable-clicks');
      var response = 'Yes';
      url = '/ajax/recruiting_token_response/create' + path[4];
      url += '/' + encodeURIComponent($('#learn-more-email')[0].value);
      url += '/' + response;
      $.post(url, '', function(data) {
        if (data.data.id !== undefined & data.data.id > 0) {
          $('.learn-more-form').html("<h2>Thanks for your interest!<br />We'll be in touch</h2>");
          $('.learn-more-button').remove();
          $('.dismiss-learn-more-button').text('DISMISS');
          $('.interest-fab').remove();
        } else {
          $('.learn-more-button').removeClass('disable-clicks');
        }
      },'json');
    }
  },
};
