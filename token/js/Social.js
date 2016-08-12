Sizzle.Social = {

  /**
   * Applies a social media link if it exists or deletes that section from the
   * token
   *
   * @param {string} the type of social media
   */
  'applyLinkOrRemove': function(data, socialMedia) {
    cssClass = ('google_plus' == socialMedia ? '.gt-info-gplus' : '.gt-info-'+socialMedia);
    linkURL = ('google_plus' == socialMedia ? 'http://plus.google.com/' : 'http://'+socialMedia+'.com/');
    if (Sizzle.Util.dataExists(data['company_'+socialMedia])) {
      $(cssClass).attr('href', linkURL+data['company_'+socialMedia]);
      return 1;
    } else {
      $(cssClass).remove();
      return 0;
    }
  },

  /**
   * Resizes social media buttons as needed
   *
   * @param {int} the count of social media buttons
   */
  'resizeButtons': function(socialCount) {
    if (socialCount < 6) {
      switch (socialCount) {
        case 5:
        $('.frontpage-social-button').css('width','20%');
        break;
        case 4:
        $('.frontpage-social-button').removeClass('mdl-cell--2-col');
        $('.frontpage-social-button').addClass('mdl-cell--3-col');
        break;
        case 3:
        $('.frontpage-social-button').removeClass('mdl-cell--2-col');
        $('.frontpage-social-button').removeClass('mdl-cell--2-col-phone');
        $('.frontpage-social-button').addClass('mdl-cell--4-col');
        break;
        case 2:
        $('.frontpage-social-button').removeClass('mdl-cell--2-col');
        $('.frontpage-social-button').addClass('mdl-cell--6-col');
        break;
        case 1:
        $('.frontpage-social-button').removeClass('mdl-cell--2-col');
        $('.frontpage-social-button').removeClass('mdl-cell--2-col-phone');
        $('.frontpage-social-button').addClass('mdl-cell--12-col');
        break;
      }
    }
  },
};
