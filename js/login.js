document.write('\
<div class="modal fade" id="login-dialog" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">\
	<div class="modal-dialog">\
		<div class="modal-content">\
			<div class ="modal-header">\
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
				<h2 class="modal-title" id="gridSystemModalLabel"><b>Log Into GiveToken</b></h2>\
			</div>\
			<div class="modal-body">\
				<div id="login-alert-placeholder"></div>\
				<form id="login-form">\
					<input type="hidden" name="login_type" value="EMAIL">\
					<input class="dialog-input large-input" id="login_email" name="login_email" type="text" placeholder="Email address" size="25">\
					<input class="dialog-input large-input" id="password" name="password" type="password" placeholder="Password" size="25">\
				</form>\
				<a id="forgot-password" href="javascript:void(0)" onClick="forgotPassword()">Forgot your password?</a>\
			</div>\
			<div class="modal-footer">\
				<div id="fb-root"></div>\
				<a class="dialog-button" id="facebook-button" href="javascript:void(0)" onClick="loginFacebook()">Log In with Facebook</a>\
				<a class="dialog-button dialog-button-right" href="javascript:void(0)" onClick="loginEmail();">Log In</a>\
			</div>\
		</div>\
	</div>\
</div>\
');

function loginOpen() {
	loginClear();
	$("#login-dialog").modal();
}

function loginClear() {
	$('#login-alert-placeholder').html('<div></div>');
	$('#login_email').val("");
	$('#password').val("");
}

function loginClose() {
	$('#login-dialog').modal('hide');
}

function loginError(message) {
	$('#login-alert-placeholder').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span>'+message+'</span></div>')
}

function loginInfo(message) {
	$('#login-alert-placeholder').html('<div class="alert alert-info"><span>'+message+'</span></div>')
}

function loginSuccess(app_root) {
	$('#login-alert-placeholder').html('<div class="alert alert-success"><span>You have successfully logged into GiveToken.</span></div>');
	setTimeout(function(){
		$('#login-dialog').modal('hide');
		document.location.href = app_root;
	}, 500);
}

function loginFacebook() {
	loginInfo("Logging in with Facebook...");
	FB.login(function(response){handleFBLogin(response)}, {scope: 'user_photos, public_profile, email'});
}

function processLogin(userInfo) {
	loginInfo("Logging into GiveToken.  Please wait...");
	$.post("login_ajax.php", userInfo, function(data, textStatus, jqXHR){
		if(data.status === "SUCCESS") {
			loginSuccess(data.app_root);
		} else if (data.status === "ERROR") {
			loginError("Login failed. "+data.message);
		}  else {
			loginError("Login failed. Unknown return status: "+data.status);
		}
	}).fail(function() {
		loginError("Login failed.");
	});
}

function loginEmail() {
	if (!$("#login_email").val()) {
		loginError("An email address is required when logging in with email.");
	} else if (!$("#password").val()) {
		loginError("A password is required when logging in with email.");
	} else {
		processLogin($("#login-form").serialize());
	}
};

function handleFBLogin(response) {
    if (response.status === 'connected') {
		FB.api('/me?fields=email,last_name,first_name', function(api_response) {
			api_response["login_type"] = "FACEBOOK";
			api_response["login_email"] = api_response["email"];
			response["email"] = api_response["email"];
			response["access_token"] = FB.getAuthResponse().accessToken;
			$.post("update_access_token_ajax.php", response, function(data, textStatus, jqXHR){
				if(data.status === "SUCCESS"){
					processLogin(api_response);
				} else if (data.status === "ERROR"){
					loginError("Facebook authorization failed on login.");
				} else if (data.status === "NO_USER"){
					loginError("This Facebook account is not registered. Please use the sign up button to continue.");
				}
			}).fail(function() {
				loginError("Facebook authorization failed");
			});
		});
    } else if (response.status === 'not_authorized') {
		// The person is logged into Facebook, but not your app.
		loginError("Log In with Facebook failed. Facebook response status: "+response.status);
    } else {
		// The person is not logged into Facebook, so we're not sure if they are logged into this app or not.
		loginError("Log In with Facebook failed. Facebook response status: "+response.status);
    }
}

/* For handeling pressing enter to Submit... why are the buttons not in the form to begin with? */
$('#login_email').keypress(function(e) {
if (e.which == '13') {
         loginEmail();
   }
});
$('#password').keypress(function(e) {
if (e.which == '13') {
         loginEmail();
   }
});
