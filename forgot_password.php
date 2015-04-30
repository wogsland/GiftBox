<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<!-- SITE TITLE -->
	<title>GiveToken.com - Forgot Password</title>
	<link rel="stylesheet" href="css/style.css" />
	<script src="js/account.js"></script>
</head>
<body onload="document.forms[0].email.focus()">
	<div style="margin:20px auto 0 auto; text-align:center">
		<p id="login-message"></p>
		<p style="color:black">Please enter the email address used to register your account.<br>We will email you a link to reset your password.</p><br>
		<form id="lost-password-form">
			<input class="dialog-input" id="email" name="email" type="text" placeholder="Email address" size="25" style="margin:auto">
			<a class="dialog-button" id="send-password-button" href="javascript:void(0)" onClick="if (document.forms[0].email.value.length == 0) alert('Please provide an email address.'); else sendPassword(document.forms[0].email.value);">Continue</a>
		</form>
	</div>
</body>
</html>
