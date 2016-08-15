Sizzle.Token = {

  /**
   * Handles click on the back button
   */
  'backClick': function(event) {
    if (openedInterestPopup) {
      // removes functionality of back button when
      // the interest dialog is opened
      return;
    }
    $('.gt-info-video').remove();
    this.$.pages.selected = 0;
    Sizzle.Image.removePreview();
  },

  /**
   * Closes the interest dialog
   */
  'closeInterestDialog': function (event) {
    $('.interest-dialog').each(function (i, dialog){
      dialog.close();
      openedInterestPopup = false;
      Sizzle.Token.enableBackButton();
    });
  },

  /**
   * Disables BACK button
   */
  'disableBackButton': function() {
    $('.back-button').addClass('mdl-button--disabled');
    $('.back-button-lower').addClass('mdl-button--disabled');
    $('.back-button-lower-right').addClass('mdl-button--disabled');
  },

  /**
   * Enables BACK button
   */
  'enableBackButton': function() {
    $('.back-button').removeClass('mdl-button--disabled');
    $('.back-button-lower').removeClass('mdl-button--disabled');
    $('.back-button-lower-right').removeClass('mdl-button--disabled');
  },

  /**
   * Handles click on an interest fab
   */
  'interestClick': function (event) {
    index = event.target.getAttribute('data-fab-index');
    if (learnMoreOpen === false) {
      $('.interest-dialog')[index].open();
      presentedInterestPopup = true;
      openedInterestPopup = true;
      Sizzle.Token.disableBackButton();
    }
  },

  /**
   * Responsible for ordering the page sections after populating the token.
   */
  'updateSectionPositions': function() {
    var wrapper = document.getElementById('ordered-sections'),
        ordered = [],
      /*
       * sectionPriority
       *
       * Each member of this semi-ordered array is either an id or an object with an id and a position.
       * If the member is an id, or if position === false, then the section will appear in order.
       * If the member has an explicit position, then the section will be placed in that position, and the rest of
       * the sections will flow around it.
       *
       */
      sectionPriority =
      [
        'company-section',
        'recruiter-section',
        'location-section',
        'doublet-location-section',
        'triplet-location-section',
        'image-video-section'
      ];
      if ($('#learn-more-section').length) {
        sectionPriority.push({
          id: 'learn-more-section',
          position: 1
        });
      } else if ($('#full-apply-now-section').length) {
        sectionPriority.push({
          id: 'full-apply-now-section',
          position: 1
        });
      }
      sectionPriority.push({
        id: 'job-description-section',
        position: (($('#learn-more-section').length || $('#full-apply-now-section').length) ? 2 : 1)
      });
      sectionPriority.push({
        id: 'social-section',
        position: (($('#learn-more-section').length || $('#full-apply-now-section').length) ? 3 : 2)
      });
      if ($('#request-interview-section').length) {
        sectionPriority.push({
          id: 'request-interview-section',
          position: (($('#learn-more-section').length || $('#full-apply-now-section').length) ? 4 : 3)
        });
      }

    sectionPriority.forEach(function(section) {
      var position = typeof section === 'string' ? false : section.position,
          section_id = typeof section === 'string' ? section : section.id,
          section_el = document.getElementById(section_id);

      if (Sizzle.Util.elementIsPresent(section_el) === false) return;

      if (position === false) {
        ordered.push(section_el);
      } else {
        ordered = ordered.slice(0, position).concat(section_el).concat(ordered.slice(position));
      }
    });

    ordered.forEach(wrapper.appendChild.bind(wrapper));
  },
};
