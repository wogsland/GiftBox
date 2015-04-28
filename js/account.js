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
		$.post("change_password_ajax.php", newPassword, function(data, textStatus, jqXHR){
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
	alert('Email: ' + email);
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

function editUser(user_id) {
	document.getElementById('edit-user-message').innerHTML = "";
	document.getElementById('user-id').value = user_id;
	var firstName = document.getElementById('first-name-'+user_id);
	var lastName = document.getElementById('last-name-'+user_id);
	var email = document.getElementById('email-'+user_id);
	var admin = document.getElementById('admin-'+user_id);
	var firstNameEdit = document.getElementById('first-name-edit');
	var lastNameEdit = document.getElementById('last-name-edit');
	var emailEdit = document.getElementById('email-edit');
	var adminEdit = document.getElementById('admin-edit');

	firstNameEdit.value = firstName.innerHTML;
	lastNameEdit.value = lastName.innerHTML;
	emailEdit.value = email.innerHTML;
	if (admin.innerHTML === 'Y') {
		adminEdit.checked = true;
	} else {
		adminEdit.checked = false;
	}
	
	$.magnificPopup.open({
	  items: {
	    src: '#edit-user-form',
	    type: 'inline'
	  }
	});
}

function editUserStatus(text) {
	$("#edit-user-message").removeClass("red-text");
	$("#edit-user-message").text(text);
}

function editUserError(text) {
	$("#edit-user-message").addClass("red-text");
	$("#edit-user-message").text(text);
}

function saveUser() {
	var firstName = $("#first-name-edit");
	var lastName = $("#last-name-edit");
	var emailAddress = $("#email-edit");
	var admin = $("#admin-edit");
	
	if (!firstName.val()) {
		editUserError("Please enter a first name.");
	} else if (!lastName.val()) {
		editUserError("Please enter a last name");
	} else if (!emailAddress.val()) {
		editUserError("Please enter a valid email.");
	} else {
		editUserStatus("Saving user information...");
		var posting = $.post("update_user_ajax.php", $("#edit-user-form").serialize());

		posting.done(function(data) {
			var userId = $("#user-id").val();
			$("#first-name-" + userId).html(firstName.val());
			$("#last-name-" + userId).html(lastName.val());
			$("#email-" + userId).html(emailAddress.val());
			var yesNo = admin.is(":checked") ? "Y" : "N";
			$("#admin-" + userId).html(yesNo);
			$.magnificPopup.close();
		});

		posting.fail(function(data, textStatus) {
			editUserError(textStatus);
			console.log(textStatus);
		});
	}
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
		var posting = $.post("update_user_ajax.php", $("#edit-user-form").serialize());

		posting.done(function(data) {
			showStatus("#my-account-message", "Your account changes have been saved.");
		});

		posting.fail(function(data, textStatus) {
			showError("#my-account-message", textStatus);
			console.log(textStatus);
		});
	}
}