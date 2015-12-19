var imageType = /image.*/;
var videoType = /video.*/;

function isVimeo(url){
  retVal = false;
  if(url.indexOf("vimeo.com") > -1){
    retVal = true;
  }
  return retVal;
}

function isYouTube(url) {
  retVal = false;
  if (url.indexOf("youtube.com") > -1 || url.indexOf("youtu.be") > -1) {
    retVal = true;
  }
  return retVal;
}

/**
 * Gets the id from a YouTube URL
 *
 * @param {String} url The URL of a YouTube video
 * @return {String} The id extract from the URL if it's valid, null otherwise
 */
function youTubeID(url) {
  //var result = url.match(/(youtu(?:\.be|be\.com)\/(?:.*v(?:\/|=)|(?:.*\/)?)([\w'-]+))/i);
  if (url !== undefined || url !== '') {
    var regExp = /^.*(youtu(?:\.be|be\.com)\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
    var match = url.match(regExp);
    if (match && match[2].length == 11) {
      return match[match.length - 1];
    }
  }
  return null;
}

/**
 * Gets the id from a Vimeo URL
 *
 * @param {String} url The URL of a Vimeo video
 * @return {String} The id extract from the URL if it's valid, null otherwise
 */
function vimeoId(url){
  var result = url.match(/^.*(?:vimeo.com)\/(?:channels\/|channels\/\w+\/|groups\/[^\/]*\/videos\/|album‌​\/\d+\/video\/|video\/|)(\d+)(?:$|\/|\?)/);
  if(result){
    return result[1];
  } else {
    return null;
  }
}
