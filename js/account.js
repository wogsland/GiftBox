function getSession() {
	var session = null;
	$.ajax({
		url: "get_session_ajax.php",
		async: false
	}).done(function(data, textStatus, jqXHR){
		session = data;
	});
	return session;
}

function changePassword() {
	var newPassword = $("#new-password").val();
	var confirmPassword = $("#confirm-password").val();
	if (!newPassword) {
		$("#change-password-message").text("Please enter a new password.");
	} else if (!confirmPassword) {
		$("#change-password-message").text("Please confirm the new password");
	} else if (newPassword !== confirmPassword) {
		$("#change-password-message").text("Passwords do not match.");
	} else {
		$.post("change_password_ajax.php", {new_password: newPassword, user_id: 125}, function(data, textStatus, jqXHR){
			$.magnificPopup.close();
			$("#my-account-message").text("Your password has been changed.");
		}).fail(function(){
			alert("Change password failed.");
		});
	}
}

function forgotPassword() {
	loginClose();
	var session = getSession();
	document.location.href = session.app_root+"forgot_password.php";
}

function sendPassword(email) {
	if (document.forms[0].email.value.length === 0) {
		alert('Please provide an email address.');
	}
	else {
		alert('Email: ' + email);
	}
}

function logout() {
	$.post("logout_ajax.php", function(data, textStatus, jqXHR){
		if (data.status === "SUCCESS") {
			if (data.login_type === "FACEBOOK") {
				FB.getLoginStatus(function(response) {
					// are they currently logged into Facebook?
					console.log(response);
					if (response.status === 'connected') {
						//they were authed so do the logout
						FB.logout(function(response) {
							console.log(response);
						});
					}
				});
			}
			document.location.href = data.app_root;
		} else if (data.status === "ERROR") {
			alert(data.message);
		}  else {
			alert("Unknown return status: "+data.status);
		}
	}).fail(function() {
		alert("Logout failed.");
	});
}

function showStatus(id, text) {
	$(id).removeClass("red-text");
	$(id).text(text);
}

function showError(id, text) {
	$(id).addClass("red-text");
	$(id).text(text);
}

function saveMyAccount() {
	if (!$("#first-name").val()) {
		showError("#my-account-message", "Please enter a first name.");
	} else if (!$("#last-name").val()) {
		showError("#my-account-message", "Please enter a last name");
	} else if (!$("#email").val()) {
		showError("#my-account-message", "Please enter a valid email.");
	} else {
		showStatus("#my-account-message", "Saving account information...");
		var posting = $.post("update_user_ajax.php", $("#account-form").serialize());

		posting.done(function(data) {
			showStatus("#my-account-message", "Your account changes have been saved.");
		});

		posting.fail(function(data, textStatus) {
			showError("#my-account-message", textStatus);
			console.log(textStatus);
		});
	}
}
