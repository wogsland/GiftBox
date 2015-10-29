var scope = document.querySelector('template[is="dom-bind"]');
//console.log(scope);

scope._onOverviewClick = function(event) {
  console.log(this);
  $('.current-section').text('Overview');
  $('.mdl-layout__drawer').removeClass('is-visible');
  this.$.list.sharedElements = {
    'fade-in': event.target,
    'fade-out': event.target
  };
  this.$.pages.selected = 7;
};

scope._onSkillsClick = function(event) {
  $('.current-section').text('Skills Required');
  $('.mdl-layout__drawer').removeClass('is-visible');
  this.$.list.sharedElements = {
    'fade-in': event.target,
    'fade-out': event.target
  };
  this.$.pages.selected = 7;
};

scope._onValuesClick = function(event) {
  $('.current-section').text('Values');
  $('.mdl-layout__drawer').removeClass('is-visible');
  this.$.list.sharedElements = {
    'fade-in': event.target,
    'fade-out': event.target
  };
  this.$.pages.selected = 7;
};

scope._onResponsibilitiesClick = function(event) {
  $('.current-section').text('Responsibilities');
  $('.mdl-layout__drawer').removeClass('is-visible');
  this.$.list.sharedElements = {
    'fade-in': event.target,
    'fade-out': event.target
  };
  this.$.pages.selected = 7;
};

scope._onPerksClick = function(event) {
  $('.current-section').text('Perks');
  $('.mdl-layout__drawer').removeClass('is-visible');
  this.$.list.sharedElements = {
    'fade-in': event.target,
    'fade-out': event.target
  };
  this.$.pages.selected = 7;
};

scope._onLocationClick = function(event) {
  //$('.current-section').text('Location');
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
};

scope._onMaybeClick = function(event) {
  this.$.list.sharedElements = {
    'ripple': event.target,
    'reverse-ripple': event.target
  };
  this.$.pages.selected = 2;
};

scope._onNoClick = function(event) {
  this.$.list.sharedElements = {
    'ripple': event.target,
    'reverse-ripple': event.target
  };
  this.$.pages.selected = 3;
};

scope._onBackClick = function(event) {
  this.$.pages.selected = 0;
};

scope._onTrack = function(event) {
  $('.current-section').text(' - '+$('.gt-info-jobtitle')[0].innerHTML);
};

$(document).ready(function(){
  function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
      vars[key] = value;
    });
    return vars;
  }
  url = '/ajax/recruiting_token/get/' + getUrlVars().id;
  $.post(url, '', function(data) {
    if (data.success == 'false') {
      window.location.href = 'https://www.givetoken.com';
    }
    $('title').text(data.data.company+' - '+data.data.job_title);
    $('.gt-info-company').text(data.data.company);
    $('.gt-info-jobtitle').text(data.data.job_title);
    $('.gt-info-overview').html(data.data.job_description);
    $('.gt-info-skills').html(data.data.skills_required);
    $('.gt-info-responsibilities').html(data.data.responsibilities);
    $('.gt-info-values').html(data.data.company_values);
    $('.gt-info-perks').html(data.data.perks);
    $('.gt-info-location').html(data.data.job_locations);
    $('.gt-info-twitter').attr('href', 'http://twitter.com/'+data.data.company_twitter);
    $('.gt-info-facebook').attr('href', 'http://facebook.com/'+data.data.company_facebook);
    $('.gt-info-linkedin').attr('href', 'http://linkedin.com/'+data.data.company_linkedin);
    $('.gt-info-youtube').attr('href', 'http://youtube.com/'+data.data.company_youtube);
    //$('.gt-info-gplus').attr('href', 'http://plus.google.com/'+data.data.company_google_plus);
    //$('.gt-info-pinterest').attr('href', 'http://pinterest.com/'+data.data.company_pinterest);
    $('.gt-info-gplus').attr('href', 'http://plus.google.com/');
    $('.gt-info-pinterest').attr('href', 'http://pinterest.com/');
  },'json');
});
