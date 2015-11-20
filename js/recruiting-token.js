var scope = document.querySelector('template[is="dom-bind"]');
//console.log(scope);

function getUrlPath() {
  var vars = {};
  i = 0;
  var parts = window.location.href.replace(/\/([a-zA-Z0-9]*)/gi, function(value) {
    vars[i] = value;
    i++;
  });
  return vars;
}

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

scope._onLocationClick = function(event) {
  $('.mdl-layout__drawer').removeClass('is-visible');
  this.$.list.sharedElements = {
    'fade-in': event.target,
    'fade-out': event.target
  };
  this.$.pages.selected = 4;
  url = '/ajax/city/get/2';
  $.post(url, '', function(data) {
    if (data.data.id !== undefined & data.data.id > 0) {
      console.log(data);
      var population = numberWithCommas(data.data.population);
      $('.gt-city-population').text(population);
      $('.gt-city-timezone').text(data.data.timezone);
      $('.gt-city-county').text(data.data.county);
      $('google-map')[0].latitude = data.data.latitude;
      $('google-map')[0].longitude = data.data.longitude;
      $('google-map').resize();
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
    }
  },'json');

};

scope._onImagesClick = function(event) {
  //$('.current-section').text('Images');
  $('.mdl-layout__drawer').removeClass('is-visible');
  this.$.list.sharedElements = {
    'fade-in': event.target,
    'fade-out': event.target
  };
  this.$.pages.selected = 5;
};

scope._onVideosClick = function(event) {
  //$('.current-section').text('Videos');
  $('.mdl-layout__drawer').removeClass('is-visible');
  this.$.list.sharedElements = {
    'fade-in': event.target,
    'fade-out': event.target
  };
  this.$.pages.selected = 6;
};

scope._onYesClick = function(event) {
  $('#placeholder').css('background-color', 'green');
  //console.log('yes clicked');
  //console.log($('#placeholder'));
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
      $('title').text(data.data.company+' - '+data.data.job_title);
      $('.gt-info-company').text(data.data.company);
      $('.gt-info-jobtitle').text(data.data.job_title);
      $('.gt-info-overview').html(data.data.job_description);
      var overview = '' + data.data.job_description;
      var words = overview.split(' ');
      var shortDescription = '';
      for (i = 0; i < 25; i++) {
        shortDescription += words[i] + ' ';
      }
      if (words.length >= 25) {
        shortDescription += ' ... ';
        shortDescription += '<a href="#" id="read-more" class="mdl-color-text--primary-dark">read more</a>';
      }
      $('.gt-info-overview-short').html(shortDescription);
      $('.gt-info-skills').html(data.data.skills_required);
      $('.gt-info-responsibilities').html(data.data.responsibilities);
      $('.gt-info-values').html(data.data.company_values);
      $('.gt-info-perks').html(data.data.perks);
      $('.gt-info-location').text(data.data.job_locations);
      var socialCount = 0;
      if ('' !== data.data.company_twitter) {
        $('.gt-info-twitter').attr('href', 'http://twitter.com/'+data.data.company_twitter);
        socialCount++;
      } else {
        $('.gt-info-twitter').remove();
      }
      if ('' !== data.data.company_facebook) {
        $('.gt-info-facebook').attr('href', 'http://facebook.com/'+data.data.company_facebook);
        socialCount++;
      } else {
        $('.gt-info-facebook').remove();
      }
      if ('' !== data.data.company_linkedin) {
        $('.gt-info-linkedin').attr('href', 'http://linkedin.com/'+data.data.company_linkedin);
        socialCount++;
      } else {
        $('.gt-info-linkedin').remove();
      }
      if ('' !== data.data.company_youtube) {
        $('.gt-info-youtube').attr('href', 'http://youtube.com/'+data.data.company_youtube);
        socialCount++;
      } else {
        $('.gt-info-youtube').remove();
      }
      if ('' !== data.data.company_google_plus) {
        $('.gt-info-gplus').attr('href', 'http://plus.google.com/'+data.data.company_google_plus);
        socialCount++;
      } else {
        $('.gt-info-gplus').remove();
      }
      if ('' !== data.data.company_pinterest) {
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
      $('#videos-frontpage').css('background',"url('https://i.ytimg.com/vi/AY-Sxu8Itsw/hqdefault.jpg') center / cover");
      if (data.data.company_video !== '') {
        $('.gt-info-video').attr('src', data.data.company_video);
      }
    },'json');
  } else {
    console.log('redirecting...');
    window.location.href = 'https://www.givetoken.com';
  }
  smallScreen();
});

function smallScreen() {
  if ( $(window).width() < 739) {
    // small screens adjustments
    $('.back-button-lower').addClass('back-button-lower-right');
    $('.back-button-lower-right').removeClass('back-button-lower');
  }
}

function numberWithCommas(x) {
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
