document.write('\
<div class="modal fade" id="signup-dialog" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">\
	<div class="modal-dialog">\
		<div class="modal-content">\
			<div class ="modal-header">\
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
				<h2 class="modal-title" id="gridSystemModalLabel"><b>Sign Up With GiveToken</b></h2>\
			</div>\
			<div class="modal-body">\
				<div id="signup-alert-placeholder"></div>\
				<form id="signup-form">\
					<input type="hidden" id="reg_type" name="reg_type" value="">\
					<input class="dialog-input" id="first_name" name="first_name" type="text" placeholder="First Name">\
					<input class="dialog-input" id="last_name" name="last_name" type="text" placeholder="Last Name">\
					<input class="dialog-input large-input" id="signup_email" name="signup_email" type="text" placeholder="Your Email">\
					<input class="dialog-input large-input" id="signup_password" name="signup_password" type="password" placeholder="New Password">\
				</form>\
				 <div class="modal-footer">\
					<div id="fb-root"></div>\
					<a class="dialog-button" id="facebook-button" href="javascript:void(0)" onClick="FB.login(function(response){handleFBReg(response)}, {scope: \'public_profile, email\'});">Sign Up Using Facebook</a>\
					<a class="dialog-button dialog-button-right" href="javascript:void(0)" onClick="signup();">Sign Up</a>\
				</div>\
			</div>\
		</div>\
	</div>\
</div>\
');

function signup_error(message) {
	$('#signup-alert-placeholder').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span>'+message+'</span></div>')
}

function signup_info(message) {
	$('#signup-alert-placeholder').html('<div class="alert alert-info"><span>'+message+'</span></div>')
}

function signup_success(app_root) {
	$('#signup-alert-placeholder').html('<div class="alert alert-success"><span>You have successfully signed up with GiveToken!</span></div>');
    setTimeout(function(){
		$('#signup-dialog').modal('hide');
		document.location.href = app_root;
	}, 5000);	
}

function signup() {
	$("#reg_type").val("EMAIL");
	if (!$("#first_name").val()) {
		signup_error("Please enter a first name.");
	} else if (!$("#last_name").val()) {
		signup_error("Please enter a last name");
	} else if (!$("#signup_email").val()) {
		signup_error("Please enter a valid email.");
	} else if (!$("#signup_password").val()) {
		signup_error("Please enter a password.");
	} else {
		signup_info("Processing your registration.  Please wait...");
		$.post("register_ajax.php", $("#signup-form").serialize(), function(data, textStatus, jqXHR){
			if(data.status === "SUCCESS") {
				signup_success(data.app_root);
			} else if (data.status === "ERROR") {
				signup_error(data.message);
			}  else {
				signup_error("Unknown return status: "+data.status);
			}
		}).fail(function() {
			signup_error("Sign up failed.");
		});
	}
}

function handleFBReg(response) {
    if (response.status === 'connected') {
		FB.api('/me?fields=email,last_name,first_name', function(api_response) {
			api_response["reg_type"] = "FACEBOOK";
			api_response["signup_email"] = api_response["email"];
			$.post("register_ajax.php", api_response, function(data, textStatus, jqXHR){
				if(data.status === "SUCCESS") {
					signup_success(data.app_root);
				} else if (data.status === "ERROR") {
					signup_error("Sign Up using Facebook failed. "+data.status);
				}  else {
					signup_error("Sign Up using Facebook failed. Unknown return status: "+data.status);
				}
			}).fail(function() {
				signup_error("Sign Up using Facebook failed.");
			});
		});
    } else if (response.status === 'not_authorized') {
		// The person is logged into Facebook, but not your app.
		signup_success(data.app_root);
    } else {
		// The person is not logged into Facebook, so we're not sure if they are logged into this app or not.
		signup_error("Sign Up using Facebook failed.");
    }
}


