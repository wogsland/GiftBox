Sizzle.Token = {
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
