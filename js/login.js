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
					<input type="hidden" name="login-type" value="EMAIL">\
					<input class="dialog-input" id="login_email" name="login_email" type="text" placeholder="Email address" size="25">\
					<input class="dialog-input" id="password" name="password" type="password" placeholder="Password" size="25">\
				</form>\
				<a id="forgot-password" href="javascript:void(0)" onClick="forgotPassword()">Forgot your password?</a>\
			</div>\
			<div class="modal-footer">\
				<div id="fb-root"></div>\
				<a class="dialog-button" id="facebook-button" href="javascript:void(0)" onClick="login_facebook()">Log In with Facebook</a>\
				<a class="dialog-button dialog-button-right" href="javascript:void(0)" onClick="login(document.forms[\'login-form\']);">Log In</a>\
			</div>\
		</div>\
	</div>\
</div>\
');

function login_close() {
	$('#login-dialog').modal('hide');
}
function login_error(message) {
	$('#login-alert-placeholder').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span>'+message+'</span></div>')
}

function login_info(message) {
	$('#login-alert-placeholder').html('<div class="alert alert-info"><span>'+message+'</span></div>')
}

function login_success(app_root) {
	$('#login-alert-placeholder').html('<div class="alert alert-success"><span>You have successfully logged into GiveToken using Facebook.</span></div>');
	setTimeout(function(){
		$('#login-dialog').modal('hide');
		document.location.href = app_root;
	}, 500);	
}

function login_facebook() {
	login_info("Logging in with Facebook...")
	FB.login(function(response){handleFBLogin(response)}, {scope: 'public_profile, email'});
}

function login() {
	if (!$("#login_email").val()) {
		login_error("An email address is required when logging in with email.");
	} else if (!$("#password").val()) {
		login_error("A password is required when logging in with email.");
	} else {
		login_info("Loggin into GiveToken.  Please wait...");
		$.post("login_ajax.php", $("#login-form").serialize(), function(data, textStatus, jqXHR){
			if(data.status === "SUCCESS") {
				login_success(data.app_root);
			} else if (data.status === "ERROR") {
				login_error("Login failed. "+data.message);
			}  else {
				login_error("Login failed. Unknown return status: "+data.status);
			}
		}).fail(function() {
			login_error("Login failed.");
		});
	}
};

function handleFBLogin(response) {
    if (response.status === 'connected') {
		FB.api('/me?fields=email,last_name,first_name', function(api_response) {
			api_response["login-type"] = "FACEBOOK";
			api_response["login_email"] = api_response["email"];
			$.post("login_ajax.php", api_response, function(data, textStatus, jqXHR){
				if(data.status === "SUCCESS") {
					login_success(data.app_root);
				} else if (data.status === "ERROR") {
					login_error("Log In with Facebook failed. "+data.message);
				}  else {
					login_error("Log In with Facebook failed. Status: "+data.status);
				}
			}).fail(function() {
				login_error("Log In with Facebook failed.");
			});
		});
    } else if (response.status === 'not_authorized') {
		// The person is logged into Facebook, but not your app.
		login_error("Log In with Facebook failed. Facebook response status: "+response.status);
    } else {
		// The person is not logged into Facebook, so we're not sure if they are logged into this app or not.
		login_error("Log In with Facebook failed. Facebook response status: "+response.status);
    }
}

