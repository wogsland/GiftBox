$(document).ready(function(){

	$('.flip-over').click(function(e){
		$('.giftbox').addClass('flip');
		e.preventDefault();
	});
	
	$('.flip-back').click(function(e){
		$('.giftbox').removeClass('flip');
		e.preventDefault();
	});

});
