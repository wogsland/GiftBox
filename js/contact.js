function sendMessage(event) {

	function isEmail(str) {
		return /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/.test( str );
	}

	// When the user submits the contact form...
	var contactForm = $( "#contact" );

	// Hide any messages from previous send attempts
	contactForm.find( ".success" ).hide();
	contactForm.find( ".error" ).hide();

	var name = $( "#name" ).val();
	var email = $( "#email" ).val();
	var subject = $( "#subject" ).val();
	var message = $( "#message" ).val();

	// If any field isn't filled in, show the error message and stop processing
	if ( !name.length || !isEmail(email) || !subject.length || !message.length ) {
		contactForm.find( ".error" ).show();
		return;
	}
	var eventTarget = event.target;
	$(eventTarget).addClass("disable-clicks");

	// Submit the form via Ajax
	$.post("/ajax/sendemail", contactForm.serialize(),
		function(data, textStatus, jqXHR){
			if(data.status === "SUCCESS") {
				contactForm.find( ".success" ).show();
			} else if (data.status === "ERROR") {
				// TODO
				alert( "error1" );
			} else {
				// TODO
				alert( "error2" );
			}
		}
	).fail(function() {
		// TODO
		alert( "error3" );
	}).always(function() {
		$(eventTarget).removeClass("disable-clicks");
	});

}
