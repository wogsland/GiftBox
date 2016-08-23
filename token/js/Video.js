Sizzle.Video = {
  'sectionClick': function(event) {
    //$('.current-section').text('Videos');
    $('.mdl-layout__drawer').removeClass('is-visible');
    this.$.list.sharedElements = {
      'fade-in': event.target,
      'fade-out': event.target
    };
    this.$.pages.selected = 3;
    path = Sizzle.Util.getUrlPath();
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
      }
    });
  },
};
