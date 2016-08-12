Sizzle.JobDescription = {
  'overviewClick': function(event) {
    $('.current-section').text('Overview');
    $('.mdl-layout__drawer').removeClass('is-visible');
    this.$.list.sharedElements = {
      'fade-in': event.target,
      'fade-out': event.target
    };
    this.$.pages.selected = 4;
    Sizzle.Screen.small();
  },
  'perksClick': function(event) {
    $('.current-section').text('Perks');
    $('.mdl-layout__drawer').removeClass('is-visible');
    this.$.list.sharedElements = {
      'fade-in': event.target,
      'fade-out': event.target
    };
    this.$.pages.selected = 4;
    Sizzle.Screen.small();
  },
  'responsibilitiesClick': function(event) {
    $('.current-section').text('Responsibilities');
    $('.mdl-layout__drawer').removeClass('is-visible');
    this.$.list.sharedElements = {
      'fade-in': event.target,
      'fade-out': event.target
    };
    this.$.pages.selected = 4;
    Sizzle.Screen.small();
  },
  'skillsClick': function(event) {
    $('.current-section').text('Skills Required');
    $('.mdl-layout__drawer').removeClass('is-visible');
    this.$.list.sharedElements = {
      'fade-in': event.target,
      'fade-out': event.target
    };
    this.$.pages.selected = 4;
    Sizzle.Screen.small();
  },
  'valuesClick': function(event) {
    $('.current-section').text('Values');
    $('.mdl-layout__drawer').removeClass('is-visible');
    this.$.list.sharedElements = {
      'fade-in': event.target,
      'fade-out': event.target
    };
    this.$.pages.selected = 4;
    Sizzle.Screen.small();
  },
};
