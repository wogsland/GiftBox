<?php
require_once __DIR__.'/config.php';
_session_start();

define('TITLE', 'GiveToken.com - Password Reset');
require __DIR__.'/header.php';
?>
<style>
#forgot-password-container {
	margin:200px auto 0 auto;
	text-align:center;
	color: white;
}
#send-password-button {
	margin-top: 30px;
	margin-bottom: 100px;
}
</style>
</head>
<body onload="document.forms[0].email.focus()">
    <?php require __DIR__.'/navbar.php';?>
	<div id="forgot-password-container">
		<p id="login-message"></p>
		<h5>Please enter the email address used to register your account.
			<br />We will email you a link to reset your password.
		</h5>
		<br />
		<form id="lost-password-form">
			<input class="dialog-input" id="email" name="email" type="text" placeholder="Email address" size="25" style="margin:auto">
			<a class="btn btn-default btn-lg standard-button" id="send-password-button" href="javascript:void(0)" onClick="sendPassword(document.forms[0].email.value);">Continue</a>
		</form>
	</div>
    <?php require __DIR__.'/footer.php';?>
</body>
</html>
