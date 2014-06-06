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
			document.location.href = '/giftbox';
		} else {
			document.getElementById('login-message').innerHTML = jsonObj.message;
		}
	}
};

function register() {
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
				document.location.href = '/giftbox';
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

function handleFBReg(response) {
    if (response.status === 'connected') {
		FB.api('/me?fields=email,last_name,first_name', function(api_response) {
			// Register the user
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.open("GET", "register_ajax.php?reg_type=FACEBOOK&email=" + encodeURIComponent(api_response.email) + "&first_name=" + encodeURIComponent(api_response.fisrt_name) + "&last_name=" + encodeURIComponent(api_response.last_name) , false);
			xmlhttp.send();
			var jsonObj = JSON.parse(xmlhttp.responseText);
			if (jsonObj.message == 'SUCCESS') {
				$.magnificPopup.close();
				document.cookie = "user_id=" + jsonObj.user_id;
				document.cookie = "email_address=" + jsonObj.email_address;
				document.cookie = "first_name=" + jsonObj.first_name;
				document.cookie = "last_name=" + jsonObj.last_name;
				document.location.href = '/giftbox';
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

  // This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
		console.log('Logged into your app and Facebook.');
		FB.api('/me', function(response) {
		  console.log('Successful login for: ' + response.name);
		});
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
      console.log('Logged into Facebook, but not your app');
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
      console.log('Not logged into Facebook.');
    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    console.log('checkLoginState');
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }

  window.fbAsyncInit = function() {
	  FB.init({
		appId      : '866886230005253',
		cookie     : true,  // enable cookies to allow the server to access 
							// the session
		xfbml      : true,  // parse social plugins on this page
		version    : 'v2.0' // use version 2.0
	  });

	  // Now that we've initialized the JavaScript SDK, we call 
	  // FB.getLoginStatus().  This function gets the state of the
	  // person visiting this page and can return one of three states to
	  // the callback you provide.  They can be:
	  //
	  // 1. Logged into your app ('connected')
	  // 2. Logged into Facebook, but not your app ('not_authorized')
	  // 3. Not logged into Facebook and can't tell if they are logged into
	  //    your app or not.
	  //
	  // These three cases are handled in the callback function.

	  FB.getLoginStatus(function(response) {
		statusChangeCallback(response);
	  });

  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));