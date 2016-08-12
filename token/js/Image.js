Sizzle.Image = {

  'displayPreview': function(self) {
    var test = '<div class="preview preview-image-container">';
    test += '<img class="preview preview-image" src="' + self.src + '">';
    test += '</img></div>';

    $(document.body).append(test);
    $(document.body).find('.preview').bind('click.preview', Sizzle.Image.removePreview);
  },

  'removePreview': function() {
    $('.preview-image-container').remove();
    $('.preview').unbind('click.preview');
  },

  'sectionClick': function(event) {
    //$('.current-section').text('Images');
    $('.mdl-layout__drawer').removeClass('is-visible');
    this.$.list.sharedElements = {
      'fade-in': event.target,
      'fade-out': event.target
    };
    this.$.pages.selected = 2;
    path = Sizzle.Util.getUrlPath();
    url = '/ajax/recruiting_token/get_images' + path[4];
    $.post(url, '', function(data) {
      if (data.data !== undefined) {
        assetHost = Sizzle.Util.getAssetHost();
        images = getImagesGrid(data.data, assetHost);
        $('#images-container').empty().append(images);

      }
    });
  }
};
