$(document).ready(function(){

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
		$(".opener").addClass("open");
		setTimeout(function(){ $(".opener").css('z-index', '-10'); $(".envelope").css('z-index', '-10'); }, 1000);
		$(".panel").addClass('panel-open');
		e.preventDefault;
	})

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
				event.target.playVideo();
			}
		}
	}
}

function onPlayerStateChange(event){
	if(event.data == YT.PlayerState.ENDED){
		$('#triggerTab').trigger('click');
	}
}

