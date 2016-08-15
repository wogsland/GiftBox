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
   * Handles the data return from /ajax/recruiting_token/get
   *
   * @param {object} the return
   */
  'handleAjaxRecruitingTokenGet': function (data) {
    if (data.success == 'false') {
      window.location.href = 'https://www.gosizzle.io';
    }
    var tokenTitle;
    if (Sizzle.Util.dataExists(data.data.company)) {
      $('.gt-info-company').text(data.data.company);
      if (data.data.company.length > 36 && $(window).width() > 800) {
        $('#supporting-company').css('height','100px');
        $('#supporting-company').css('margin-top','217px');
      } else if (data.data.company.length > 18 && $(window).width() <= 800) {
        if (data.data.company.length > 36) {
          $('#supporting-company').css('height','150px');
          $('#supporting-company').css('margin-top','167px');
        } else {
          $('#supporting-company').css('height','100px');
          $('#supporting-company').css('margin-top','217px');
        }
      }
      tokenTitle = data.data.company+' - '+data.data.job_title;
    } else {
      tokenTitle = data.data.job_title;
    }
    $('title').text(tokenTitle);
    Sizzle.JobDescription.populateData(data.data);

    if (Sizzle.Util.dataExists(data.data.company_description)) {
      $('#company-description-text').html(data.data.company_description);
    } else {
      $('#company-description').hide();
    }

    if(Sizzle.Util.dataExists(data.data.long_id)) {
      url = '/ajax/recruiting_token/get_cities/' + data.data.long_id;
      $.post(url, '', Sizzle.Location.handleAjaxGetCities);
    } else {
      $('#location-section').remove();
    }
    var socialCount = 0;
    socialCount += Sizzle.Social.applyLinkOrRemove(data.data, 'twitter');
    socialCount += Sizzle.Social.applyLinkOrRemove(data.data, 'facebook');
    socialCount += Sizzle.Social.applyLinkOrRemove(data.data, 'linkedin');
    socialCount += Sizzle.Social.applyLinkOrRemove(data.data, 'youtube');
    socialCount += Sizzle.Social.applyLinkOrRemove(data.data, 'google_plus');
    socialCount += Sizzle.Social.applyLinkOrRemove(data.data, 'pinterest');
    Sizzle.Social.resizeButtons(socialCount);

    if (Sizzle.Util.dataExists(data.data.recruiter_profile) && 'Y' == data.data.recruiter_profile) {
      $('#bio-button').remove();
      $('#contact-button').remove();
      $('#schedule-button').remove();
      url = '/ajax/user/get_recruiter_profile/' + data.data.user_id;
      $.post(url, '', Sizzle.Recruiter.handleAjaxUserGetRecruiterProfile, 'json');
    } else {
      $('#recruiter-section').remove();
    }
    setTimeout(Sizzle.Token.updateSectionPositions, 500);//for slow ajax responses
    setTimeout(Sizzle.Token.updateSectionPositions, 1000);//for slow ajax responses
    setTimeout(Sizzle.Token.updateSectionPositions, 5000);//for slow ajax responses
  },

  /**
   * Handles the data return from /ajax/recruiting_token/get_responses_allowed
   *
   * @param {object} the return
   */
  'handleAjaxRecruitingTokenGetResponsedAllowed': function (data) {
    if (data.data !== undefined && data.data.allowed !== undefined) {
      if ('false' == data.data.allowed) {
        $('.interest-fab').hide();
      } else {
        if (!addedName && 'true' == data.data.collectName) {
          var nameInput = '<paper-input';
          nameInput += '  class="name-paper-input"';
          nameInput += '  label="name"';
          nameInput += '  autofocus';
          nameInput += '  error-message="Please input your name"';
          nameInput += '  required>';
          nameInput += '</paper-input>';
          $('.email-paper-input').after(nameInput);
          addedName = true;
        }
        if ('true' == data.data.autoPop) {
          // display the response form once after 10 seconds
          if (!presentedInterestPopup) {
            setTimeout(function(){
              if (!presentedInterestPopup && !presentedLearnMore) {
                $('.interest-dialog').each(function (i, dialog){
                  Sizzle.Token.disableBackButton();
                  dialog.open();
                  openedInterestPopup = true;
                });
                presentedInterestPopup = true;
              }
            },
            (data.data.autoPopDelay !== undefined ? data.data.autoPopDelay*1000 : 10000));
          }
        }
      }
    }
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
