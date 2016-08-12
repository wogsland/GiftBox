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

  'populateData': function(data) {
    $('.gt-info-jobtitle').text(data.job_title);
    $('.gt-info-overview').html(data.job_description);
    var overview = '' + data.job_description;
    var words = overview.split(' ');
    var shortDescription = '';
    for (i = 0; i < 50; i++) {
      if (words[i] !== undefined) {
        shortDescription += words[i] + ' ';
      }
    }
    var paragraphCount = (shortDescription.match(/<p>/g) || []).length;
    if (4 < paragraphCount) {
      shortDescription = shortDescription.substring(0, Sizzle.Util.getPosition(shortDescription, '<p>', 5));
    }
    if (words.length >= 50 || 4 < paragraphCount) {
      shortDescription += ' ... ';
      shortDescription += '<a href="#overview-section" id="read-more" class="mdl-color-text--primary-dark">read more</a>';
    }
    $('.gt-info-overview-short').html(shortDescription);
    if (!Sizzle.Util.dataExists(data.job_description)) {
      $('#overview-section-2').hide();
    }
    var descriptionCount = 0;
    if (Sizzle.Util.dataExists(data.skills_required)) {
      $('.gt-info-skills').html(data.skills_required);
      descriptionCount++;
    } else {
      $('#skills-button').hide();
      $('#skills-section').hide();
      $('#skills-section-2').hide();
    }
    if (Sizzle.Util.dataExists(data.responsibilities)) {
      $('.gt-info-responsibilities').html(data.responsibilities);
      descriptionCount++;
    } else {
      $('#responsibilities-button').hide();
      $('#responsibilities-section').hide();
      $('#responsibilities-section-2').hide();
    }
    if (Sizzle.Util.dataExists(data.company_values)) {
      $('.gt-info-values').html(data.company_values);
      descriptionCount++;
    } else {
      $('#values-button').hide();
      $('#values-section').hide();
      $('#values-section-2').hide();
    }
    if (Sizzle.Util.dataExists(data.perks)) {
      $('.gt-info-perks').html(data.perks);
      descriptionCount++;
    } else {
      $('#perks-button').hide();
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
