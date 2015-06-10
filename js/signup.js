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
					<input class="dialog-input large-input" id="first_name" name="first_name" type="text" placeholder="First Name">\
					<input class="dialog-input large-input" id="last_name" name="last_name" type="text" placeholder="Last Name">\
					<input class="dialog-input large-input" id="signup_email" name="signup_email" type="text" placeholder="Your Email">\
					<input class="dialog-input large-input" id="signup_password" name="signup_password" type="password" placeholder="New Password">\
					<select class="dialog-input large-input" id="signup_level" name="signup_level">\
					<option value="1">Basic (Free)</option>\
					<option value="2">Standard ($9.99)</option>\
					</select>\
					Already a member? Log in <a href="javascript:void(0)" onclick="switchToLogin()">here</a>\
				</form>\
				 <div class="modal-footer">\
					<div id="fb-root"></div>\
					<button type="button" class="btn-lg btn-primary dialog-button-left" onclick="signupFacebook()"><i class="fa fa-facebook"></i> Sign Up Using Facebook</button>\
					<button type="button" class="btn-lg btn-default dialog-button-right" onclick="signupEmail()">Sign Up</button>\
				</div>\
			</div>\
		</div>\
	</div>\
</div>\
');

function signupOpen(level) {
	signupClear();
	$("#signup_level").val(level);
	$("#signup-dialog").modal();
}

function signupClear() {
	$('#signup-alert-placeholder').html('<div></div>');
	$('#first_name').val("");
	$('#last_name').val("");
	$('#signup_email').val("");
	$('#signup_password').val("");
}

function signupClose() {
	$('#signup-dialog').modal('hide');
}

function signupError(message) {
	$('#signup-alert-placeholder').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span>'+message+'</span></div>')
}

function signupInfo(message) {
	$('#signup-alert-placeholder').html('<div class="alert alert-info"><span>'+message+'</span></div>')
}

function signupSuccess(app_root, signupType, userInfo) {
	var email;
	if (signupType == "FACEBOOK") {
		email = userInfo.signup_email;
	} else {
		email = $("#signup_email").val();
	}
	$('#signup-alert-placeholder').html('<div class="alert alert-success"><span>You have successfully signed up with GiveToken!</span></div>');

	if ($("#signup_level").val() == 2) {
		payWithStripe(email, "SIGNUP");
	} else {
		if (userInfo.reg_type == "FACEBOOK") {
			signupInfo("Logging into GiveToken...");
			userInfo.login_email = userInfo.signup_email;
			userInfo.login_type = userInfo.reg_type;
			processLogin(userInfo);
		} else {
			signupClose();
			openMessage("Welcome!", "You have successfully signed up with GiveToken.  An activation email has been sent to "+email+".  Please activate your account before logging in.");
		}
	}
}

function signupEmail() {
	$("#reg_type").val("EMAIL");
	if (!$("#first_name").val()) {
		signupError("Please enter a first name.");
	} else if (!$("#last_name").val()) {
		signupError("Please enter a last name");
	} else if (!$("#signup_email").val()) {
		signupError("Please enter a valid email.");
	} else if (!$("#signup_password").val()) {
		signupError("Please enter a password.");
	} else {
		processSignup($("#signup-form").serialize(), "EMAIL");
	}
}

function signupFacebook() {
	$("#reg_type").val("FACEBOOK");
	signupInfo("Checking Facebook login status.  Please wait...");
	FB.login(function(response){handleFBReg(response)}, {scope: 'user_photos, public_profile, email'});
}

function handleFBReg(response) {
    if (response.status === 'connected') {
		FB.api('/me?fields=email,last_name,first_name', function(api_response) {
			api_response["reg_type"] = "FACEBOOK";
			api_response["signup_email"] = api_response["email"];
			api_response["signup_level"] = "1";
			processSignup(api_response, "FACEBOOK");
		});
	} else if (response.status === 'not_authorized') {
		// The person is logged into Facebook, but not your app.
		signupSuccess(data.app_root, "FACEBOOK");
    } else {
		// The person is not logged into Facebook, so we're not sure if they are logged into this app or not.
		signupError("Sign Up using Facebook failed.");
    }
}

function processSignup(userInfo, signupType) {
	signupInfo("Processing your registration.  Please wait...");
	$.post("register_ajax.php", userInfo, function(data, textStatus, jqXHR){
		if(data.status === "SUCCESS") {
			signupSuccess(data.app_root, signupType, userInfo);
		} else if (data.status === "ERROR") {
			signupError(data.message);
		}  else {
			signupError("Unknown return status: "+data.status);
		}
	}).fail(function() {
		signupError("Sign up failed.");
	});
}

function switchToLogin() {
	signupClose();
	loginOpen();	
}
