Sizzle.Image = {

  'displayPreview': function(self) {
    var test = '<div class="preview preview-image-container">';
    test += '<img class="preview preview-image" src="' + self.src + '">';
    test += '</img></div>';

    $(document.body).append(test);
    $(document.body).find('.preview').bind('click.preview', Sizzle.Image.removePreview);
  },

  'getImagesGrid': function (data, assetHost) {
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
      container.append(Sizzle.Image.getImageGridItem(img, assetHost, onComplete));
    });

    container.masonry({
      itemSelector: '.ImageGrid-item',
      columnWidth: '.ImageGrid-itemSizer',
      percentPosition: true,
      transitionDuration: '0.1s'
    });

    return container;
  },

  'getImageGridItem': function (imgData, assetHost, cb) {
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
        images = Sizzle.Image.getImagesGrid(data.data, assetHost);
        $('#images-container').empty().append(images);

      }
    });
  }
};
