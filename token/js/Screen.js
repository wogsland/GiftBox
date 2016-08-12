Sizzle.Screen = {
  'small': function() {
    if ( $(window).width() < 739) {
      // small screens adjustments
      $('.back-button-lower').addClass('back-button-lower-right');
      $('.back-button-lower-right').removeClass('back-button-lower');
    }
  },
};
