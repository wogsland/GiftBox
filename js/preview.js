/* =================================
   LOADER                     
=================================== */
// makes sure the whole site is loaded
var selectedAnimationColor = null;
var selectedAnimationStyle = null;
var animationEnterCss = null;
var animationPopCss = null;
jQuery(window).load(function() {

	if (selectedAnimationStyle == "none") {
			// will first fade out the loading animation
		jQuery(".status").fadeOut();
	        // will fade out the whole DIV that covers the website.
		jQuery(".preloader").delay(1000).fadeOut("slow");
	} else {
		$('.shaking-box.animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', animate() );
	}

	function animate() {
		setTimeout(function() { $('.shaking-box.animated').removeClass(animationEnterCss); }, 1000);
		$('.shaking-box.animated').addClass(animationPopCss);
		setTimeout(function() { $('.shaking-box.animated.' + animationPopCss).css('-webkit-animation-duration', '1s'); }, 1000);
		setTimeout(function() { $('.shaking-box.animated.' + animationPopCss).css('-webkit-animation-iteration-count', 'infinite'); }, 1000);
		setTimeout(function() { $(".shrink-box").trigger("click"); }, 2000);
	}
});

$(document).ready(function(){
	
	// cache the window object
   $window = $(window);

	var tag = document.createElement('script');
  	tag.src = 'https://www.youtube.com/iframe_api';
  	var firstScriptTag = document.getElementsByTagName('script')[0];
  	firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

  	var trig = $('#triggerTab');
	trig.on('click', function(){
		if($("#redirect_url")[0].innerHTML != ""){
			window.location.href = $("#redirect_url")[0].innerHTML;
		}
	});

	$('.flip-over').click(function(e){
		$('.giftbox').addClass('flip');
		e.preventDefault();
	});
	
	$('.flip-back').click(function(e){
		$('.giftbox').removeClass('flip');
		e.preventDefault();
	});

	$(".bento").each(function(){
		displayGallery(this);
	});

	$(".shrink-box").click(function(e){
		$(".opener > .svg-container").addClass("open");
		setTimeout(function(){$(".opener").css('z-index', '-10');}, 500);
		$(".animated").removeClass(animationPopCss);
		setTimeout(function(){ $(".envelope").css('z-index', '-10'); }, 1000);
		$(".panel").addClass('panel-open');
		e.preventDefault;
	});

});

function displayGallery(bento){
	$("."+$(bento)[0].classList[2]).colorbox({rel:$(bento)[0].classList[2], innerWidth:640, innerHeight:390})
}


var player = [];
function onYouTubeIframeAPIReady(){
	$(".youtube-video").each(function(){
		var vid_id = this.id.split('?');
		player.push(new YT.Player(this.id, {
			videoId: vid_id[1],
			events: {
				'onReady': onPlayerReady,
				'onStateChange': onPlayerStateChange
			}
		}));	  	
	});
	
}
	
function onPlayerReady(event){
	for(key in event.target){
		if(event.target[key].classList){
			if(event.target[key].classList.contains('auto-play')){
				if (selectedAnimationStyle != "none") {
					setTimeout(function() { event.target.playVideo(); }, 3500);
				} else {
					event.target.playVideo();
				}
			}
		}
	}
}

function onPlayerStateChange(event){
	if(event.data == YT.PlayerState.ENDED){
		$('#triggerTab').trigger('click');
	}
}

