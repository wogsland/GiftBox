function login(email, password) {
	if (!document.getElementById('email').value) {
		document.getElementById('login-message').innerHTML = "An email address is required when logging in with email.";
	} else if (!document.getElementById('password').value) {
		document.getElementById('login-message').innerHTML = "A password is required when logging in with email.";
	} else {
		var xmlhttp = new XMLHttpRequest();
		var url = "login_ajax.php?login_type=EMAIL&email=" + encodeURIComponent(email) + "&password=" + encodeURIComponent(password);
		xmlhttp.open("GET", url, false);
		xmlhttp.send();
		var jsonObj = JSON.parse(xmlhttp.responseText);
		if (jsonObj.message == 'SUCCESS') {
			$.magnificPopup.close();
			document.cookie = "user_id=" + jsonObj.user_id;
			document.cookie = "email_address=" + jsonObj.email_address;
			document.cookie = "first_name=" + jsonObj.first_name;
			document.cookie = "last_name=" + jsonObj.last_name;
			document.location.href = '/';
		} else {
			document.getElementById('login-message').innerHTML = jsonObj.message;
		}
	}
}

function register(first_name, last_name, email, password) {
	if (!document.getElementById('email').value) {
		document.getElementById('login-message').innerHTML = "Please enter a valid email.";
	} else if (!document.getElementById('password').value) {
		document.getElementById('login-message').innerHTML = "Please enter a password.";
	} else if (!document.getElementById('first-name').value) {
		document.getElementById('login-message').innerHTML = "Please enter a first name.";
	} else if (!document.getElementById('last-name').value) {
		document.getElementById('login-message').innerHTML = "Please enter a last name";
	} else {
		var xmlhttp = new XMLHttpRequest();
		var url = "register_ajax.php?reg_type=EMAIL&first_name=" + encodeURIComponent(document.getElementById('first-name').value) + "&last_name=" + encodeURIComponent(document.getElementById('last-name').value) + "&email=" + encodeURIComponent(email) + "&password=" + encodeURIComponent(password);
		xmlhttp.open("GET", url, false);
		xmlhttp.send();
		var jsonObj = JSON.parse(xmlhttp.responseText);
		if (jsonObj.message == 'SUCCESSS'){
			$.magnificPopup.close();
			//document.getElementById('login-message').innerHTML = "Successful Registration";
		}
		else {
			document.getElementById('login-message').innerHTML = jsonObj.message;
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
				document.cookie = "email_address=" + jsonObj.email_address;
				document.cookie = "first_name=" + jsonObj.first_name;
				document.cookie = "last_name=" + jsonObj.last_name;
				document.location.href = '/';
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
				document.cookie = "email_address=" + jsonObj.email_address;
				document.cookie = "first_name=" + jsonObj.first_name;
				document.cookie = "last_name=" + jsonObj.last_name;
				document.location.href = '/';
			} else {
				document.getElementById('login-message').innerHTML = jsonObj.message;
			}
		});
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
		document.getElementById('login-message').innerHTML = "You are now signed up and logged into Giftbox!";
    } else {
      // The person is not logged into Facebook, so we're not sure if they are logged into this app or not.
		document.getElementById('login-message').innerHTML = "Registration using Facebook failed.";
    }
}

function logout() {
}

window.fbAsyncInit = function() {
	FB.init({
		appId      : '1498055593756885', // Test App ID
		cookie     : true,  // enable cookies to allow the server to access the session
		xfbml      : true,  // parse social plugins on this page
		version    : 'v2.0' // use version 2.0
	});

};

(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/en_US/sdk.js";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));