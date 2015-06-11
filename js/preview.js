$(document).ready(function(){

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

});

function displayGallery(bento){
	$("."+$(bento)[0].classList[2]).colorbox({rel:$(bento)[0].classList[2], innerWidth:640, innerHeight:390})
}
