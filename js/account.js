function readCookie(name){
	var c = document.cookie.split('; ');
	var cookies = {};
	for(var i = c.length-1; i >= 0; i--){
	   var C = c[i].split('=');
	   cookies[C[0]] = C[1];
	}
	return cookies[name];
}

function changePassword() {
	var newPassword = document.getElementById('new-password').value;
	var confirmPassword = document.getElementById('confirm-password').value;
	var message = document.getElementById('change-password-message');
	if (!newPassword) {
		message.innerHTML = "Please enter a new password.";
	} else if (!confirmPassword) {
		message.innerHTML = "Please confirm the new password";
	} else if (newPassword != confirmPassword) {
		message.innerHTML = "Passwords do not match.";
	} else {
		var xmlhttp = new XMLHttpRequest();
		var url = "change_password_ajax.php?user_id=" + readCookie('user_id') + "&new_password=" + encodeURIComponent(newPassword);
		xmlhttp.open("GET", url, false);
		xmlhttp.send();
		var jsonObj = JSON.parse(xmlhttp.responseText);
		if (jsonObj.message == 'SUCCESS') {
			$.magnificPopup.close();
			document.getElementById('save-password-message').innerHTML = "Your password has been changed.";
		} else {
			document.getElementById('login-message').innerHTML = jsonObj.message;
		}
	}
}

function forgotPassword() {
	$.magnificPopup.close();
	document.location.href = readCookie('app_root') + 'forgot_password.html';
}

function sendPassword(email) {
	alert('Email: ' + email);
}

function login(email, password) {
	var message = document.getElementById('login-message');
	if (!document.getElementById('email').value) {
		message.innerHTML = "An email address is required when logging in with email.";
	} else if (!document.getElementById('password').value) {
		message.innerHTML = "A password is required when logging in with email.";
	} else {
		var xmlhttp = new XMLHttpRequest();
		var url = "login_ajax.php?login_type=EMAIL&email=" + encodeURIComponent(email) + "&password=" + encodeURIComponent(password);
		xmlhttp.open("GET", url, false);
		xmlhttp.send();
		var jsonObj = JSON.parse(xmlhttp.responseText);
		if (jsonObj.message == 'SUCCESS') {
			$.magnificPopup.close();
			document.cookie = "user_id=" + jsonObj.user_id;
			document.cookie = "login_type=EMAIL";
			document.cookie = "app_root=" + jsonObj.app_root;
			document.location.href = jsonObj.app_root;
		} else {
			document.getElementById('login-message').innerHTML = jsonObj.message;
		}
	}
};

function register(first_name, last_name, email, password) {
	var message = document.getElementById('signup-message');
	if (!document.getElementById('first-name').value) {
		message.innerHTML = "Please enter a first name.";
	} else if (!document.getElementById('last-name').value) {
		message.innerHTML = "Please enter a last name";
	} else if (!document.getElementById('email').value) {
		message.innerHTML = "Please enter a valid email.";
	} else if (!document.getElementById('password').value) {
		message.innerHTML = "Please enter a password.";
	} else {
		var xmlhttp = new XMLHttpRequest();
		var url = "register_ajax.php?reg_type=EMAIL&first_name=" + encodeURIComponent(document.getElementById('first-name').value) + "&last_name=" + encodeURIComponent(document.getElementById('last-name').value) + "&email=" + encodeURIComponent(email) + "&password=" + encodeURIComponent(password);
		xmlhttp.open("GET", url, false);
		xmlhttp.send();
		try {
			var jsonObj = JSON.parse(xmlhttp.responseText);
			if (jsonObj.message == 'SUCCESSS'){
				$.magnificPopup.close();
				document.location.href = readCookie('app_root') ;
			}
			else {
				document.getElementById('signup-message').innerHTML = jsonObj.message;
			}
		} catch(err) {
			alert(xmlhttp.responseText);
		}
	}

}

function handleFBLogin(response) {
    if (response.status === 'connected') {
		FB.api('/me?fields=email,last_name,first_name', function(api_response) {
			// Save a Logged in with Facebook event
			var xmlhttp = new XMLHttpRequest();
			var url = "login_ajax.php?login_type=FACEBOOK&email=" + encodeURIComponent(api_response.email);
			xmlhttp.open("GET", url, false);
			xmlhttp.send();
			var jsonObj = JSON.parse(xmlhttp.responseText);
			if (jsonObj.message == 'SUCCESS') {
				$.magnificPopup.close();
				document.cookie = "user_id=" + jsonObj.user_id;
				document.cookie = "login_type=FACEBOOK";
				document.cookie = "app_root=" + jsonObj.app_root;
				document.location.href = jsonObj.app_root;
			} else {
				document.getElementById('login-message').innerHTML = jsonObj.message;
			}
		});
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
		document.getElementById('login-message').innerHTML = "You are now signed up and logged into Giftbox!";
    } else {
      // The person is not logged into Facebook, so we're not sure if they are logged into this app or not.
		document.getElementById('login-message').innerHTML = "Log In with Facebook failed.";
    }
}

function handleFBReg(response) {
    if (response.status === 'connected') {
		FB.api('/me?fields=email,last_name,first_name', function(api_response) {
			// Register the user
			var xmlhttp = new XMLHttpRequest();
			var url = "register_ajax.php?reg_type=FACEBOOK&email=" + encodeURIComponent(api_response.email) + "&first_name=" + encodeURIComponent(api_response.first_name) + "&last_name=" + encodeURIComponent(api_response.last_name);
			xmlhttp.open("GET", url, false);
			xmlhttp.send();
			var jsonObj = JSON.parse(xmlhttp.responseText);
			if (jsonObj.message == 'SUCCESS') {
				$.magnificPopup.close();
				document.cookie = "user_id=" + jsonObj.user_id;
				document.cookie = "login_type=FACEBOOK";
				document.cookie = "app_root=" + jsonObj.app_root;
				document.location.href = jsonObj.app_root;
			} else {
				document.getElementById('signup-message').innerHTML = jsonObj.message;
			}
		});
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
		document.getElementById('signup-message').innerHTML = "You are now signed up and logged into Giftbox!";
    } else {
      // The person is not logged into Facebook, so we're not sure if they are logged into this app or not.
		document.getElementById('signup-message').innerHTML = "Registration using Facebook failed.";
    }
}

function logout() {
	var $login_type = readCookie('login_type');
	if ($login_type == 'FACEBOOK') {
		FB.getLoginStatus(function(response) {
			// are they currently logged into Facebook?
			var myRet = response;
			console.log(response);
			if (response.status === 'connected') {
				//they were authed so do the logout		
				FB.logout(function(response) {
					console.log(response);
				});
			}
		})
	}
	$user_id = readCookie('user_id');
	$app_root = readCookie('app_root');
	var xmlhttp = new XMLHttpRequest();
	var url = "logout_ajax.php?user_id=" + encodeURIComponent($user_id);
	xmlhttp.open("GET", url, false);
	xmlhttp.send();
	try {
		var jsonObj = JSON.parse(xmlhttp.responseText);
		if (jsonObj.message == 'SUCCESS') {
			document.cookie = "user_id=; expires=Thu, 01 Jan 1970 00:00:00 GMT";
			document.cookie = "login_type=; expires=Thu, 01 Jan 1970 00:00:00 GMT";
			document.cookie = "app_root=; expires=Thu, 01 Jan 1970 00:00:00 GMT";
			document.location.href = $app_root;
		} else {
			alert(jsonObj.message);
		}
	} catch(err) {
		alert(xmlhttp.responseText);
	}
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
	if (admin.innerHTML == 'Y') {
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

function saveUser() {
	
	var message = document.getElementById('edit-user-message');
	if (!document.getElementById('first-name-edit').value) {
		message.innerHTML = "Please enter a first name.";
	} else if (!document.getElementById('last-name-edit').value) {
		message.innerHTML = "Please enter a last name";
	} else if (!document.getElementById('email-edit').value) {
		message.innerHTML = "Please enter a valid email.";
	} else {
		// save changes
		var user_id = document.getElementById('user-id').value;
		var firstName = document.getElementById('first-name-'+user_id);
		var lastName = document.getElementById('last-name-'+user_id);
		var email = document.getElementById('email-'+user_id);
		var admin = document.getElementById('admin-'+user_id);
		var firstNameEdit = document.getElementById('first-name-edit');
		var lastNameEdit = document.getElementById('last-name-edit');
		var emailEdit = document.getElementById('email-edit');
		var adminEdit = document.getElementById('admin-edit');

		var xmlhttp = new XMLHttpRequest();
		var url = "update_user_ajax.php?user_id=" + user_id + "&first_name=" + encodeURIComponent(firstNameEdit.value) + "&last_name=" + encodeURIComponent(lastNameEdit.value) + "&email=" + encodeURIComponent(emailEdit.value) + "&admin=" + (adminEdit.checked ? 'Y':'N');
		xmlhttp.open("GET", url, false);
		xmlhttp.send();
		try {
			var jsonObj = JSON.parse(xmlhttp.responseText);
			if (jsonObj.message == 'SUCCESSS'){
				firstName.innerHTML = firstNameEdit.value;
				lastName.innerHTML = lastNameEdit.value;
				email.innerHTML = emailEdit.value;
				admin.innerHTML = adminEdit.checked ? 'Y':'N';
				$.magnificPopup.close();
			}
			else {
				message.innerHTML = jsonObj.message;
			}
		} catch(err) {
			message.innerHTML = xmlhttp.responseText;
		}
		
		
		
		

	}
}
