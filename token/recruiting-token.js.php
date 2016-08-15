<?php
// js namespace
require __DIR__.'/js/Sizzle.js';

// js classes
foreach (scandir(__DIR__.'/js') as $jsFile) {
    if (!in_array($jsFile, ['.', '..', 'Sizzle.js'])) {
        require __DIR__.'/js/'.$jsFile;
    }
}

echo <<<'EOT'
var scope = document.querySelector('template[is="dom-bind"]');
var presentedInterestPopup = false;
var openedInterestPopup = false;
var cities = [];
var learnMoreChecked = false;
var learnMoreOpen = false;
var presentedLearnMore = false;
var setLocationButtons = false;

scope._onTrack = function(event) {
  // do nothing, get no error
};

// assign click handlers
scope._onOverviewClick = Sizzle.JobDescription.overviewClick;
scope._onSkillsClick = Sizzle.JobDescription.skillsClick;
scope._onValuesClick = Sizzle.JobDescription.valuesClick;
scope._onResponsibilitiesClick = Sizzle.JobDescription.responsibilitiesClick;
scope._onPerksClick = Sizzle.JobDescription.perksClick;
scope._onLocationClick = Sizzle.Location.click;
scope._onImagesClick = Sizzle.Image.sectionClick;
scope._onVideosClick = Sizzle.Video.sectionClick;
scope._onInterestClick = Sizzle.Token.interestClick;

/**
 * Submits interest info
 */
scope._submitInterest = submitInterest;
function submitInterest(event) {
  event.preventDefault();
  var formIndex = 0;
  var eventPath = [];
  openedInterestPopup = false;
  if (event.path !== undefined) {
    // Chrome
    eventPath = event.path;
    eventPath.forEach(function(eventPathVal){
      if ($(eventPathVal).is('location-x-card')) {
        formIndex = 1;
      } else if ($(eventPathVal).is('image-x-card')) {
        formIndex = 2;
      } else if ($(eventPathVal).is('video-x-card')) {
        formIndex = 3;
      } else if ($(eventPathVal).is('description-x-card')) {
        formIndex = 4;
      }
    });
  } else {
    // Firefox & Safari
    var currentElem = event.target;
    while (currentElem) {
      eventPath.push(currentElem);
      currentElem = currentElem.parentElement;
    }
    if (eventPath.indexOf(window) === -1 && eventPath.indexOf(document) === -1) {
      eventPath.push(document);
    }
    if (eventPath.indexOf(window) === -1) {
      eventPath.push(window);
    }
    if (eventPath[9].localName == 'location-x-card' || eventPath[8].localName == 'location-x-card') {
      formIndex = 1;
    } else if (eventPath[5].localName == 'image-x-card') {
      formIndex = 2;
    } else if (eventPath[5].localName == 'video-x-card') {
      formIndex = 3;
    } else if (eventPath[5].localName == 'description-x-card') {
      formIndex = 4;
    }
  }
  if ($('.email-paper-input')[formIndex].validate()) {
    $('.submit-interest-button').addClass('disable-clicks');
    var response = $('#interest-response')[0].selectedItem.value;
    url = '/ajax/recruiting_token_response/create' + path[4];
    url += '/' + encodeURIComponent($('.email-paper-input')[formIndex].value);
    url += '/' + response;
    if ($('.name-paper-input').length) {
      url += '/' + encodeURIComponent($('.name-paper-input')[formIndex].value);
    }
    $.post(url, '', function(data) {
      if (data.data.id !== undefined & data.data.id > 0) {
        if (response == 'yes' || response == 'maybe') {
EOT;
if ('1A' == $argv[1]) {
    echo <<<'EOT'

          // look for application link
          $.post(
            '/ajax/recruiting_token/get_apply_link' + path[4],
            '',
            function(data) {
              if (data.data !== undefined) {
                applicationLink = data.data;
              }
              if ('' !== applicationLink) {
                $('.interest-form').text('Would you like to submit an application?');
                $('.interest-form').css('margin-bottom','30px');
                $('.submit-interest-button').remove();
                $('.apply-button').removeAttr('hidden');
              } else {
                $('.interest-form').text('Thanks for you interest!');
                $('.submit-interest-button').remove();
                $('.dismiss-interest-button').text('DISMISS');
              }
            },
            'json'
          );
EOT;
} else {
    echo <<<'EOT'

          if ('' !== applicationLink) {
            window.location.href = applicationLink;
          } else {
            $('.interest-form').text('Thanks for you interest!');
            $('.submit-interest-button').remove();
            $('.dismiss-interest-button').text('DISMISS');
          }
EOT;
}
echo <<<'EOT'

        } else {
          $('.interest-form').text('Thanks for telling us!');
          $('.submit-interest-button').remove();
          $('.dismiss-interest-button').text('DISMISS');
        }
        $('.interest-fab').remove();
      } else {
        $('.submit-interest-button').removeClass('disable-clicks');
      }
    },'json');
  }
}

/**
 * Submits learn more info
 */
scope._submitLearnMore = function(event) {
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
};

/**
 * Forwards the user to the application page
 */
var applicationLink = '';
scope._applyNow = function (event) {
  if ('' !== applicationLink) {
EOT;
if ('1A' == $argv[1]) {
    echo <<<'EOT'

    window.location.href = applicationLink;
EOT;
} else {
    echo <<<'EOT'

    if ($('.email-paper-input').length) {
      submitInterest(event);
    } else {
      window.location.href = applicationLink;
    }
EOT;
}
echo <<<'EOT'

  } else {
    $('.apply-button').remove();
    $('.interest-form').text('An error has occured forwarding you to the application.');
    $('.dismiss-interest-button').text('DISMISS');
  }
};

/**
 * Closes the interest dialog
 */
scope._closeInterestDialog = Sizzle.Token.closeInterestDialog;

/**
 * Closes the learn more dialog
 */
scope._closeLearnMoreDialog = function (event) {
  $('#learn-more-dialog')[0].close();
  learnMoreOpen = false;
  $('.interest-fab').removeClass('mdl-button--disabled');
};

/**
 * Closes the apply dialog
 */
scope._closeApplyDialog = function (event) {
  $('.apply-dialog').each(function (i, dialog){
    dialog.close();
  });
};

/**
 * Navigates back to the main page
 */
scope._onBackClick = Sizzle.Token.backClick;

$(document).ready(function(){
  // initial token load (doesn't work if in background tab)
  loadDataAndPopulateToken();

  // reload the token data whenever the page comes into focus
  window.onfocus = loadDataAndPopulateToken;

  // escape should work the same as clicking cancel
  $(document).keyup(function(e){
    if(e.keyCode === 27) {
      $('.interest-dialog').each(function (i, dialog){
        dialog.close();
      });
      openedInterestPopup = false;
      Sizzle.Token.enableBackButton();
    }
  });

  // enable BACK button if dialog box isn't open
  var first = true;
  $(document).click(function() {
    if ($('.iron-overlay-backdrop-0').length === 0 && first) {
      Sizzle.Token.enableBackButton();
      first = !first;
    }
  });

  // BACK button support for iOS devices
  $('.dismiss-interest-button, .submit-interest-button').click(function() {
    Sizzle.Token.enableBackButton();
  });

  // fixes background modal on location page
  setTimeout(function() {
    var $parent = $('#location-content');
    var elements = $parent.children().children();
    var $div1 = $(elements[1]);
    var $div2 = $(elements[2]);
    $(elements[1]).remove();
    $(elements[2]).remove();
    var $superparent = $($parent.parent());
    $superparent.append($div1);
    $superparent.append($div2);
  }, 2500);

  // background sniffer to close interest dialog
  var elapsed = 0;
  closeInterestDialog();
  setInterval(function() {
    if (elapsed <= 50) {
      if ($('.iron-overlay-backdrop-0').length === 0) {
        $('.interest-dialog').each(function(i, dialog) {
          dialog.close();
        });
        openedInterestPopup = false;
        Sizzle.Token.enableBackButton();
      }
      elapsed++;
    } else {
      clearInterval(this);
    }
  }, 1000);

});

/**
 * Closes dialog box on click (iOS patch)
 */
function closeInterestDialog() {
  $(document).not('.interest-fab').click(function() {
    $('.interest-dialog').each(function(i, dialog) {
      dialog.close();
      $(this).remove();
    });
  });
}

/**
 * Handle loading the token data and putting it where it should go
 */
function loadDataAndPopulateToken() {
  path = Sizzle.Util.getUrlPath();
  if (path[2] === '/token' & path[3] == '/recruiting' & typeof path[4] !== 'undefined') {
    url = '/ajax/recruiting_token/get' + path[4];
    $.post(url, '', handleAjaxRecruitingTokenGet,'json');
    url = '/ajax/recruiting_token/get_images' + path[4];
    $.post(url, '', function(data) {
      if (data.data !== undefined && data.data.length > 0) {
        assetHost = Sizzle.Util.getAssetHost();
        if (data.data.length > 0) {
          $('#images-frontpage').hide();
          $('#company-image-grid').css('width','100%');
          $('#company-main-image').css('background',"url('"+assetHost+"/"+data.data[0].file_name+"') center / cover");
          if ( $(window).width() < 739 || data.data.length < 4) {
            $('#company-secondary-images').remove();
            $('#company-main-image').css('width','100%');
            data.data.forEach(function(companyImageValue) {
              if ('Y' == companyImageValue.mobile && $(window).width() < 739) {
                $('#company-main-image').css('background',"url('"+assetHost+"/"+companyImageValue.file_name+"') center / cover");
              }
            });
          } else {
            $('#company-secondary-image-1').attr('src',assetHost+"/"+data.data[1].file_name);
            $('#company-secondary-image-1').parent().css('width','100%');
            $('#company-secondary-image-2').attr('src',assetHost+"/"+data.data[2].file_name);
            $('#company-secondary-image-2').parent().css('width','100%');
            $('#company-secondary-image-3').attr('src',assetHost+"/"+data.data[3].file_name);
            $('#company-secondary-image-3').parent().css('width','100%');
          }
          data.data.forEach(function(companyImageValue) {
            if ('Y' == companyImageValue.logo) {
              $('#briefcase-or-logo').html('<img src="'+Sizzle.Util.getAssetHost()+"/"+companyImageValue.file_name+'" width=200>');
            }
          });
          $('#videos-frontpage').removeClass('mdl-cell--6-col');
          $('#videos-frontpage').addClass('mdl-cell--12-col');
        } else {
          $('#company-section').hide();
          $('#images-frontpage').css('background',"url('"+assetHost+"/"+data.data[0].file_name+"') center / cover");
        }
      } else {
        $('#company-section').hide();
        $('#images-frontpage').hide();
        $('#videos-frontpage').removeClass('mdl-cell--6-col');
        $('#videos-frontpage').addClass('mdl-cell--12-col');
      }
    });

    if (!learnMoreChecked) {
      /* EXPERIMENT 6 */
      Sizzle.Experiment.checkAndRun(path[4], 6, 'learnMore', 'learnMore');
      /* END EXPERIMENT 6 */

      /* EXPERIMENT 7 */
      Sizzle.Experiment.checkAndRun(path[4], 7, 'requestInterview', 'requestInterview');
      /* END EXPERIMENT 7 */

      /* EXPERIMENT 8 */
      Sizzle.Experiment.checkAndRun(path[4], 8, 'applyNow', 'applyNow');
      /* END EXPERIMENT 8 */

      learnMoreChecked = true;
    }

    url = '/ajax/recruiting_token/get_responses_allowed' + path[4];
    $.post(url, '', handleAjaxRecruitingTokenGetResponsedAllowed, 'json');
EOT;
if ('1B' == $argv[1]) {
    echo <<<'EOT'

    $.post(
      '/ajax/recruiting_token/get_apply_link' + path[4],
      '',
      function(data) {
        if (data.data !== undefined) {
          applicationLink = data.data;
        }
        if ('' !== applicationLink) {
          $('.submit-interest-button').remove();
          $('.apply-button').removeAttr('hidden');
          $('.apply-button').text('APPLY');
          $('.apply-button').removeClass('apply-button');
        }
      },
      'json'
    );
EOT;
}
echo <<<'EOT'

    url = '/ajax/recruiting_token/get_videos' + path[4];
    $.post(url, '', function(data) {
      if (data.data !== undefined && data.data.length > 0) {
        var videoId = data.data[0].source_id;
        if (data.data[0].source == 'youtube') {
          vidUrl = 'https://i.ytimg.com/vi/'+videoId+'/hqdefault.jpg';
          $('#videos-frontpage').css('background',"url('"+vidUrl+"') center / cover");
        }
        if (data.data[0].source == 'vimeo') {
          $.getJSON(
            "https://vimeo.com/api/v2/video/"+ videoId +".json",
            function(data){
              $('#videos-frontpage').css('background',"url('"+data[0].thumbnail_large+"') center / cover");
            }
          );
        }
      } else {
        // expands main image for small screens
        if ($(window).width() < 739) {
          $('#location-main-image').css('width','100%');
        }
        $('#videos-frontpage').hide();
        $('#images-frontpage').removeClass('mdl-cell--6-col');
        $('#images-frontpage').addClass('mdl-cell--12-col');
      }
    });
  } else {
    window.location.href = 'https://www.gosizzle.io';
  }
  Sizzle.Screen.small();
}

/**
 * Handles the data return from /ajax/user/get_recruiter_profile/
 *
 * @param {object} the return
 */
function handleAjaxUserGetRecruiterProfile(data) {
  if (data.data !== undefined) {
    assetHost = Sizzle.Util.getAssetHost();
    if (Sizzle.Util.dataExists(data.data.face_image)) {
      //$('#icon-or-face').html('<img src="'+assetHost+"/"+data.data.face_image+'" width=200>');
      $('#icon-or-face').remove();
      $('#recruiter-face').css('background','url("'+assetHost+"/"+data.data.face_image+'") 50% 50% / cover');
      $('#recruiter-face').css('height','300px');
    }
    if (Sizzle.Util.dataExists(data.data.position)) {
      $('#gt-info-recruiter-position').html(data.data.position);
    } else {
      $('#gt-info-recruiter-position').remove();
    }
    if (Sizzle.Util.dataExists(data.data.about)) {
      $('#gt-info-recruiter-bio').html(data.data.about);
    } else {
      $('#gt-info-recruiter-bio').remove();
    }
    if (Sizzle.Util.dataExists(data.data.linkedin)) {
      $('#linkedin-button').attr('href', data.data.linkedin);
      $('.recruiter-profile-option').removeClass('mdl-cell--3-col');
      $('.recruiter-profile-option').addClass('mdl-cell--12-col');
    } else {
      $('#linkedin-button').remove();
    }
    if (Sizzle.Util.dataExists(data.data.email_address)) {
      $('#email-now-button').attr('href', 'mailto:'+data.data.email_address);
      if ($('#linkedin-button').length) {
        $('.recruiter-profile-option').removeClass('mdl-cell--12-col');
        $('.recruiter-profile-option').addClass('mdl-cell--6-col');
      } else {
        $('.recruiter-profile-option').removeClass('mdl-cell--3-col');
        $('.recruiter-profile-option').addClass('mdl-cell--12-col');
      }
    } else {
      $('#email-now-button').remove();
    }
    if (Sizzle.Util.dataExists(data.data.first_name) || Sizzle.Util.dataExists(data.data.last_name)) {
      $('#gt-info-recruiter-name').html(data.data.first_name+' '+data.data.last_name);
    } else {
      // if there are no names a recruiter profile doesn't make sense
      $('#recruiter-section').remove();
    }
  } else {
    $('#recruiter-section').remove();
  }
  Sizzle.Token.updateSectionPositions();
}

/**
 * Handles the data return from /ajax/recruiting_token/get
 *
 * @param {object} the return
 */
function handleAjaxRecruitingTokenGet(data) {
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
    $.post(url, '', handleAjaxUserGetRecruiterProfile, 'json');
  } else {
    $('#recruiter-section').remove();
  }
  setTimeout(Sizzle.Token.updateSectionPositions, 500);//for slow ajax responses
  setTimeout(Sizzle.Token.updateSectionPositions, 1000);//for slow ajax responses
  setTimeout(Sizzle.Token.updateSectionPositions, 5000);//for slow ajax responses
}

var addedName = false;
/**
 * Handles the data return from /ajax/recruiting_token/get_responses_allowed
 *
 * @param {object} the return
 */
function handleAjaxRecruitingTokenGetResponsedAllowed(data) {
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
}

function getImagesGrid(data, assetHost) {
  var container = $('<ul class="ImageGrid ImageGrid is-loading">'),
      loaded = 0,
      onComplete = function () {
        loaded++;
        container.masonry('layout');
        if (loaded === data.length) {
          container.removeClass('is-loading');
        }
      };

  container.append('<li class="ImageGrid-itemSizer">');
  data.forEach(function (img) {
    container.append(getImageGridItem(img, assetHost, onComplete));
  });

  container.masonry({
    itemSelector: '.ImageGrid-item',
    columnWidth: '.ImageGrid-itemSizer',
    percentPosition: true,
    transitionDuration: '0.1s'
  });

  return container;
}

function getImageGridItem(imgData, assetHost, cb) {
  var preload = new Image(),
      src = assetHost+'/'+imgData.file_name,
      item = $('<li class="ImageGrid-item is-loading">'),
      img = $('<img ' +
          'id="image-' + imgData.id + '" ' +
          'class="ImageGrid-image" ' +
          'onclick="Sizzle.Image.displayPreview(this)" ' +
          'data-src="'+src+'"/>');

  preload.onload = function() {
    cb();
    item.removeClass('is-loading');
    img.attr('src', img.data('src'));
    item.append(img);
  };
  preload.onerror = function() {
    cb();
    item.removeClass('is-loading').addClass('is-error');
  };
  preload.src = src;

  return item;
}

/**
 * Returns html for a spacer
 * @returns {boolean}
 */
function getSpacerHTML() {
  return '<div class="mdl-layout-spacer"></div>';
}

/**
 * Populates learn more button
 */
function learnMore() {
  html = '<section id="learn-more-section" class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp">';
  html += '<paper-button id="learn-more">Learn More</paper-button>';
  html += '</section>';
  $($('section')[0]).after(html);
  $('#learn-more').click(function(event) {
    $('.learn-more-button').html('Learn More')
    if ( $(window).width() < 739) {
      // small screens adjustments
      $('#learn-more-modal-text').html('Enter your email below<br /> to learn more about<br/> this job opportunity.')
      $('#learn-more-dialog').addClass('learn-more-dialog-skinny');
      $('#learn-more-dialog').removeClass('learn-more-dialog-wide');
    } else {
      $('#learn-more-modal-text').html('Enter your email below to learn more <br/> about this job opportunity.')
    }
    $('#learn-more-dialog')[0].open();
    learnMoreOpen = true;
    presentedLearnMore = true;
    $('.interest-fab').addClass('mdl-button--disabled');
  });
}

/**
 * Populates request an interview button
 */
function requestInterview() {
  html = '<section id="request-interview-section" class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp">';
  html += '<paper-button id="request-interview">Request an Interview</paper-button>';
  html += '</section>';
  $($('section')[2]).after(html);
  $('#request-interview').click(function(event) {
    $('#learn-more-modal-text').html('Enter your email <br/>to request an interview')
    $('.learn-more-button').html('Request Interview')
    if ( $(window).width() < 739) {
      // small screens adjustments
      $('#learn-more-dialog').addClass('learn-more-dialog-skinny');
      $('#learn-more-dialog').removeClass('learn-more-dialog-wide');
    }
    $('#learn-more-dialog')[0].open();
    learnMoreOpen = true;
    presentedLearnMore = true;
    $('.interest-fab').addClass('mdl-button--disabled');
  });
}

/**
 * Populates apply now button with the assumption that the learn more button has
 * already been created if it's going to be created.
 */
function applyNow() {
  if ($('#learn-more-section').length) {
    $('#learn-more').css('width', '48%');
    $('#learn-more').css('margin-right', '2%');
    $('#learn-more-section').removeClass('mdl-shadow--2dp');
    $('#learn-more').addClass('mdl-shadow--2dp');
    html = '<paper-button id="half-apply-now" class="open-apply-now-modal mdl-shadow--2dp">Apply Now</paper-button>';
    $('#learn-more').after(html);
  } else {
    html = '<section id="full-apply-now-section" class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp">';
    html += '<paper-button id="full-apply-now" class="open-apply-now-modal">Apply Now</paper-button>';
    html += '</section>';
    $($('section')[2]).after(html);
  }
  $('.open-apply-now-modal').click(function(event) {
    $('#learn-more-modal-text').html('Enter your email <br/>to apply now')
    $('.learn-more-button').html('Apply Now')
    if ( $(window).width() < 739) {
      // small screens adjustments
      $('#learn-more-dialog').addClass('learn-more-dialog-skinny');
      $('#learn-more-dialog').removeClass('learn-more-dialog-wide');
    }
    $('#learn-more-dialog')[0].open();
    learnMoreOpen = true;
    presentedLearnMore = true;
    $('.interest-fab').addClass('mdl-button--disabled');
  });
}

EOT;
