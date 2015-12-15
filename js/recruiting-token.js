var scope = document.querySelector('template[is="dom-bind"]');

scope._onOverviewClick = function(event) {
  $('.current-section').text('Overview');
  $('.mdl-layout__drawer').removeClass('is-visible');
  this.$.list.sharedElements = {
    'fade-in': event.target,
    'fade-out': event.target
  };
  this.$.pages.selected = 7;
  smallScreen();
};

scope._onSkillsClick = function(event) {
  $('.current-section').text('Skills Required');
  $('.mdl-layout__drawer').removeClass('is-visible');
  this.$.list.sharedElements = {
    'fade-in': event.target,
    'fade-out': event.target
  };
  this.$.pages.selected = 7;
  smallScreen();
};

scope._onValuesClick = function(event) {
  $('.current-section').text('Values');
  $('.mdl-layout__drawer').removeClass('is-visible');
  this.$.list.sharedElements = {
    'fade-in': event.target,
    'fade-out': event.target
  };
  this.$.pages.selected = 7;
  smallScreen();
};

scope._onResponsibilitiesClick = function(event) {
  $('.current-section').text('Responsibilities');
  $('.mdl-layout__drawer').removeClass('is-visible');
  this.$.list.sharedElements = {
    'fade-in': event.target,
    'fade-out': event.target
  };
  this.$.pages.selected = 7;
  smallScreen();
};

scope._onPerksClick = function(event) {
  $('.current-section').text('Perks');
  $('.mdl-layout__drawer').removeClass('is-visible');
  this.$.list.sharedElements = {
    'fade-in': event.target,
    'fade-out': event.target
  };
  this.$.pages.selected = 7;
  smallScreen();
};

var cityId = 1;
scope._onLocationClick = function(event) {
  $('.mdl-layout__drawer').removeClass('is-visible');
  this.$.list.sharedElements = {
    'fade-in': event.target,
    'fade-out': event.target
  };
  this.$.pages.selected = 4;
  $('google-map').resize();
};

scope._onImagesClick = function(event) {
  //$('.current-section').text('Images');
  $('.mdl-layout__drawer').removeClass('is-visible');
  this.$.list.sharedElements = {
    'fade-in': event.target,
    'fade-out': event.target
  };
  this.$.pages.selected = 5;
  path = getUrlPath();
  url = '/ajax/recruiting_token/get_images' + path[4];
  $.post(url, '', function(data) {
    if (data.data !== undefined) {
      assetHost = getAssetHost();
      i=1;
      images = '';
      $.each(data.data, function(index, value){
        if (i%3 === 1) {
          images += '<section class="section--center mdl-grid mdl-grid--no-spacing">';
        }
        images += '<div id="image-'+i+'" class="demo-card-image mdl-card mdl-cell--4-col-phone mdl-shadow--2dp">';
        images += '<div class="mdl-card__title mdl-card--expand"></div>';
        images += '</div>';
        if (i%3 === 0) {
          images += '</section>';
        } else {
          images += '<div class="mdl-layout-spacer"></div>';
        }
        i++;
      });
      if ((i-1)%3 !== 0) {
        // the last line has only one or two images
        images += '<div class="demo-card-image mdl-card mdl-cell--4-col-phone">';
        images += '<div class="mdl-card__title mdl-card--expand"></div>';
        images += '</div>';
        if ((i-1)%3 === 1) {
          // the last line has only one image
          images += '<div class="demo-card-image mdl-card mdl-cell--4-col-phone">';
          images += '<div class="mdl-card__title mdl-card--expand"></div>';
          images += '</div>';
        }
        images += '</section>';
      }
      images += '<section class="section--footer mdl-color--light-grey mdl-grid">';
      images += '</section>';
      $('#images-container').html(images);
      i=1;
      $.each(data.data, function(index, value){
        $('#image-' + i).css('background',"url('"+assetHost+"/"+value.file_name+"') center / cover");
        i++;
      });
    }
  });
};

scope._onVideosClick = function(event) {
  //$('.current-section').text('Videos');
  $('.mdl-layout__drawer').removeClass('is-visible');
  this.$.list.sharedElements = {
    'fade-in': event.target,
    'fade-out': event.target
  };
  this.$.pages.selected = 6;
  path = getUrlPath();
  url = '/ajax/recruiting_token/get_videos' + path[4];
  $.post(url, '', function(data) {
    if (data.data !== undefined && data.data.length > 0) {
      var videos = '';
      $.each(data.data, function(index, vid) {
        if (vid.source == 'youtube') {
          vidUrl = 'https://www.youtube.com/embed/';
        }
        if (vid.source == 'vimeo') {
          vidUrl = 'https://player.vimeo.com/video/';
        }
        videos += '<section class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp">';
        videos += '<div class="mdl-card mdl-cell mdl-cell--12-col">';
        videos += '<div class="mdl-card__title">';
        videos += '<iframe class="gt-info-video"';
        videos += '  width="853"';
        videos += '  height="480"';
        videos += '  src="'+vidUrl+vid.source_id+'"';
        videos += '  frameborder="0" allowfullscreen>';
        videos += '</iframe>';
        videos += '</div>';
        videos += '</div>';
        videos += '</section>';
      });
      videos += '<section class="section--footer mdl-color--light-grey mdl-grid">';
      videos += '</section>';
      $('#videos-container').html(videos);
    } else {

    }
  });
};

scope._onYesClick = function(event) {
  $('#placeholder').css('background-color', 'green');
  this.$.list.sharedElements = {
    'ripple': event.target,
    'reverse-ripple': event.target
  };
  this.$.pages.selected = 1;
  $('#yes-submit').click(function( event ) {
    event.preventDefault();
    url = '/ajax/recruiting_token_response/create' + path[4];
    url += '/' + encodeURIComponent($('#yes-email').val()) + '/yes';
    $.post(url, '', function(data) {
      if (data.data.id !== undefined & data.data.id > 0) {
        $('#yes-content').text('Thanks for your interest!');
      }
    },'json');
  });
};

scope._onMaybeClick = function(event) {
  this.$.list.sharedElements = {
    'ripple': event.target,
    'reverse-ripple': event.target
  };
  this.$.pages.selected = 2;
  $('#maybe-submit').click(function( event ) {
    event.preventDefault();
    url = '/ajax/recruiting_token_response/create' + path[4];
    url += '/' + encodeURIComponent($('#maybe-email').val()) + '/maybe';
    $.post(url, '', function(data) {
      if (data.data.id !== undefined & data.data.id > 0) {
        $('#maybe-content').text('Thanks for your interest!');
      }
    },'json');
  });
};

scope._onNoClick = function(event) {
  this.$.list.sharedElements = {
    'ripple': event.target,
    'reverse-ripple': event.target
  };
  this.$.pages.selected = 3;
  $('#no-submit').click(function( event ) {
    event.preventDefault();
    url = '/ajax/recruiting_token_response/create' + path[4];
    url += '/' + encodeURIComponent($('#no-email').val()) + '/no';
    $.post(url, '', function(data) {
      if (data.data.id !== undefined & data.data.id > 0) {
        $('#no-content').text("Thanks for telling us. We'll take you off our list!");
      }
    },'json');
  });
};

scope._onBackClick = function(event) {
  this.$.pages.selected = 0;
};

$(document).ready(function(){
  path = getUrlPath();
  if (path[2] === '/token' & path[3] == '/recruiting' & typeof path[4] !== 'undefined') {
    url = '/ajax/recruiting_token/get' + path[4];
    $.post(url, '', function(data) {
      if (data.success == 'false') {
        window.location.href = 'https://www.givetoken.com';
      }
      var tokenTitle;
      if (dataExists(data.data.company)) {
        $('.gt-info-company').text(data.data.company+' -');
        tokenTitle = data.data.company+' - '+data.data.job_title;
      } else {
        tokenTitle = data.data.job_title;
      }
      $('title').text(tokenTitle);
      $('.gt-info-jobtitle').text(data.data.job_title);
      $('.gt-info-overview').html(data.data.job_description);
      var overview = '' + data.data.job_description;
      var words = overview.split(' ');
      var shortDescription = '';
      for (i = 0; i < 25; i++) {
        if (words[i] !== undefined) {
          shortDescription += words[i] + ' ';
        }
      }
      if (words.length >= 25) {
        shortDescription += ' ... ';
        shortDescription += '<a href="#" id="read-more" class="mdl-color-text--primary-dark">read more</a>';
      }
      $('.gt-info-overview-short').html(shortDescription);
      if (!dataExists(data.data.job_description)) {
        $('#overview-drawer').hide();
        $('#overview-section-2').hide();
      }
      var descriptionCount = 0;
      if (dataExists(data.data.skills_required)) {
        $('.gt-info-skills').html(data.data.skills_required);
        descriptionCount++;
      } else {
        $('#skills-drawer').hide();
        $('#skills-button').hide();
        $('#skills-section').hide();
        $('#skills-section-2').hide();
      }
      if (dataExists(data.data.responsibilities)) {
        $('.gt-info-responsibilities').html(data.data.responsibilities);
        descriptionCount++;
      } else {
        $('#responsibilities-button').hide();
        $('#responsibilities-drawer').hide();
        $('#responsibilities-section').hide();
        $('#responsibilities-section-2').hide();
      }
      if (dataExists(data.data.company_values)) {
        $('.gt-info-values').html(data.data.company_values);
        descriptionCount++;
      } else {
        $('#values-button').hide();
        $('#values-drawer').hide();
        $('#values-section').hide();
        $('#values-section-2').hide();
      }
      if (dataExists(data.data.perks)) {
        $('.gt-info-perks').html(data.data.perks);
        descriptionCount++;
      } else {
        $('#perks-button').hide();
        $('#perks-drawer').hide();
        $('#perks-section').hide();
        $('#perks-section-2').hide();
      }

      if (descriptionCount < 4) {
        switch (descriptionCount) {
          case 3:
          $('.job-description-option').removeClass('mdl-cell--3-col');
          //$('.job-description-option').removeClass('mdl-cell--2-col-phone');
          $('.job-description-option').addClass('mdl-cell--4-col');
          break;
          case 2:
          $('.job-description-option').removeClass('mdl-cell--3-col');
          $('.job-description-option').addClass('mdl-cell--6-col');
          break;
          case 1:
          $('.job-description-option').removeClass('mdl-cell--3-col');
          //$('.job-description-option').removeClass('mdl-cell--2-col-phone');
          $('.job-description-option').addClass('mdl-cell--12-col');
          break;
        }
      }
      if(dataExists(data.data.city_id)) {
        cityId = data.data.city_id;
        url = '/ajax/city/get/'+cityId;
        $.post(url, '', function(data) {
          if (data.data.id !== undefined & data.data.id > 0) {
            $('.gt-info-location').text(data.data.name);
            var population = numberWithCommas(data.data.population);
            $('.gt-city-population').text(population);
            $('.gt-city-timezone').text(data.data.timezone);
            $('.gt-city-county').text(data.data.county);
            $('google-map')[0].latitude = data.data.latitude;
            $('google-map')[0].longitude = data.data.longitude;
            $('.gt-city-spring-hi').text(data.data.temp_hi_spring);
            $('.gt-city-spring-lo').text(data.data.temp_lo_spring);
            $('.gt-city-spring-avg').text(data.data.temp_avg_spring);
            $('.gt-city-summer-hi').text(data.data.temp_hi_summer);
            $('.gt-city-summer-lo').text(data.data.temp_lo_summer);
            $('.gt-city-summer-avg').text(data.data.temp_avg_summer);
            $('.gt-city-fall-hi').text(data.data.temp_hi_fall);
            $('.gt-city-fall-lo').text(data.data.temp_lo_fall);
            $('.gt-city-fall-avg').text(data.data.temp_avg_fall);
            $('.gt-city-winter-hi').text(data.data.temp_hi_winter);
            $('.gt-city-winter-lo').text(data.data.temp_lo_winter);
            $('.gt-city-winter-avg').text(data.data.temp_avg_winter);
            assetHost = getAssetHost();
            $('#location-frontpage').css('background',"url('"+assetHost+"/"+data.data.image_file+"') center / cover");
            $('#location-back').css('background',"url('"+assetHost+"/"+data.data.image_file+"') center / cover");
          }
        });
      } else {
        $('#location-frontpage').remove();
        $('#location-drawer').remove();
      }
      var socialCount = 0;
      if (dataExists(data.data.company_twitter)) {
        $('.gt-info-twitter').attr('href', 'http://twitter.com/'+data.data.company_twitter);
        socialCount++;
      } else {
        $('.gt-info-twitter').remove();
      }
      if (dataExists(data.data.company_facebook)) {
        $('.gt-info-facebook').attr('href', 'http://facebook.com/'+data.data.company_facebook);
        socialCount++;
      } else {
        $('.gt-info-facebook').remove();
      }
      if (dataExists(data.data.company_linkedin)) {
        $('.gt-info-linkedin').attr('href', 'http://linkedin.com/'+data.data.company_linkedin);
        socialCount++;
      } else {
        $('.gt-info-linkedin').remove();
      }
      if (dataExists(data.data.company_youtube)) {
        $('.gt-info-youtube').attr('href', 'http://youtube.com/'+data.data.company_youtube);
        socialCount++;
      } else {
        $('.gt-info-youtube').remove();
      }
      if (dataExists(data.data.company_google_plus)) {
        $('.gt-info-gplus').attr('href', 'http://plus.google.com/'+data.data.company_google_plus);
        socialCount++;
      } else {
        $('.gt-info-gplus').remove();
      }
      if (dataExists(data.data.company_pinterest)) {
        $('.gt-info-pinterest').attr('href', 'http://pinterest.com/'+data.data.company_pinterest);
        socialCount++;
      } else {
        $('.gt-info-pinterest').remove();
      }
      if (socialCount < 6) {
        switch (socialCount) {
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
      if (dataExists(data.data.company_logo)) {
        $('#briefcase-or-logo').html('<img src="'+assetHost+"/"+data.data.company_logo+'" width=200>');
      }
    },'json');
    url = '/ajax/recruiting_token/get_images' + path[4];
    $.post(url, '', function(data) {
      if (data.data !== undefined && data.data.length > 0) {
        assetHost = getAssetHost();
        $('#images-frontpage').css('background',"url('"+assetHost+"/"+data.data[0].file_name+"') center / cover");
      } else {
        $('#images-frontpage').hide();
        $('#videos-frontpage').removeClass('mdl-cell--6-col');
        $('#videos-frontpage').addClass('mdl-cell--12-col');
        $('#images-drawer').hide();
      }
    });
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
        $('#videos-frontpage').hide();
        $('#images-frontpage').removeClass('mdl-cell--6-col');
        $('#images-frontpage').addClass('mdl-cell--12-col');
        $('#videos-drawer').hide();
      }
    });
  } else {
    window.location.href = 'https://www.givetoken.com';
  }
  smallScreen();
});

/**
 * Makes adjustments for small screens
 */
function smallScreen() {
  if ( $(window).width() < 739) {
    // small screens adjustments
    $('.back-button-lower').addClass('back-button-lower-right');
    $('.back-button-lower-right').removeClass('back-button-lower');
  }
}

/**
 * Takes a number and adds commas to it every third digit
 *
 * @param {number} x The number to add commas to
 * @return {string} The number with commas added
 */
function numberWithCommas(x) {
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

/**
 * Checks if data is defined, not null and not the empty string
 *
 * @param {mixed} data The data to check
 * @return {boolean} If data exists
 */
function dataExists (data) {
  return data !== undefined && data !== null && '' !== data;
}

/**
 * Returns the URL path broken into pieces
 *
 * @return {array} The URL path broken into pieces
 */
function getUrlPath() {
  var vars = {};
  i = 0;
  var parts = window.location.href.replace(/\/([a-zA-Z0-9]*)/gi, function(value) {
    vars[i] = value;
    i++;
  });
  return vars;
}

/**
 * Returns the host for referencing assets based on environment
 *
 * @return {string} The host for referencing assets
 */
function getAssetHost() {
  switch (window.location.hostname) {
    case 'www.givetoken.com':
    return 'https://tokenstorage.storage.googleapis.com';
    case 'dev.givetoken.com':
    return 'https://tokenstorage-staging.storage.googleapis.com';
    default:
    return '/uploads';
  }
}
