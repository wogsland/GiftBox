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

function youTubeID(url) {
	var result = url.match(/(youtu(?:\.be|be\.com)\/(?:.*v(?:\/|=)|(?:.*\/)?)([\w'-]+))/i);
	if (result) {
		return result[result.length - 1];
	} else {
		return null;
	}
}

function vimeoId(url){
	var result = url.match(/^.*(?:vimeo.com)\/(?:channels\/|channels\/\w+\/|groups\/[^\/]*\/videos\/|album‌​\/\d+\/video\/|video\/|)(\d+)(?:$|\/|\?)/);
	if(result){
		return result[1];
	} else {
		return null;
	}
}
