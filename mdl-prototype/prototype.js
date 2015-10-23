var scope = document.querySelector('template[is="dom-bind"]');
//console.log(scope);

scope._onOverviewClick = function(event) {
  $('.current-section').text('Overview');
  $('.mdl-layout__drawer').toggleClass('is-visible');
};

scope._onSkillsClick = function(event) {
  $('.current-section').text('Skills Required');
  $('.mdl-layout__drawer').toggleClass('is-visible');
};

scope._onValuesClick = function(event) {
  $('.current-section').text('Values');
  $('.mdl-layout__drawer').toggleClass('is-visible');
};

scope._onResponsibilitiesClick = function(event) {
  $('.current-section').text('Responsibilities');
  $('.mdl-layout__drawer').toggleClass('is-visible');
};

scope._onPerksClick = function(event) {
  $('.current-section').text('Perks');
  $('.mdl-layout__drawer').toggleClass('is-visible');
};

scope._onLocationClick = function(event) {
  //$('.current-section').text('Location');
  $('.mdl-layout__drawer').toggleClass('is-visible');
  this.$.list.sharedElements = {
    'fade-in': event.target,
    'fade-out': event.target
  };
  this.$.pages.selected = 4;
};

scope._onImagesClick = function(event) {
  //$('.current-section').text('Images');
  $('.mdl-layout__drawer').toggleClass('is-visible');
  this.$.list.sharedElements = {
    'fade-in': event.target,
    'fade-out': event.target
  };
  this.$.pages.selected = 5;
};

scope._onVideosClick = function(event) {
  //$('.current-section').text('Videos');
  $('.mdl-layout__drawer').toggleClass('is-visible');
  this.$.list.sharedElements = {
    'fade-in': event.target,
    'fade-out': event.target
  };
  this.$.pages.selected = 6;
};

scope._onYesClick = function(event) {
  $('#placeholder').css('background-color', 'green');
  console.log('yes clicked');
  console.log($('#placeholder'));
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
