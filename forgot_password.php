<?php
define('TITLE', 'S!zzle - Password Reset');
require __DIR__.'/header.php';
?>
<style>
#forgot-password-container {
  margin:200px auto 0 auto;
  text-align:center;
  color: white;
  margin-bottom: 200px;
}
#send-password-button {
  margin-top: 30px;
}
#email {
  margin: auto;
}
</style>
</head>
<body onload="document.forms[0].email.focus()">
    <?php require __DIR__.'/navbar.php';?>
  <div id="forgot-password-container">
    <h5 id="reset-message">
      Please enter the email address used to register your account.
      <br /><br />
      We'll email you a link to reset your password.
    </h5>
    <br />
    <form id="lost-password-form">
      <input class="dialog-input" id="email" name="email" type="text" placeholder="Email address" size="25">
      <a class="btn btn-default standard-button" id="send-password-button">Reset Password</a>
    </form>
  </div>

    <?php require __DIR__.'/footer.php';?>
  <script>
  $(document).ready(function(){
    $('#lost-password-form').submit(function(e) {
      e.preventDefault();
      $('#send-password-button').click();
    });
    $('#send-password-button').on('click', function () {
      url = '/ajax/reset_password/';
      var eventTarget = event.target;
      console.log(eventTarget);
      $(eventTarget).addClass("disable-clicks");
      $.post(
        url,
        {
          email: $('#email').val()
        },
        function (data) {
          var request = '<br /><br />Please enter the email address used to register your account.';
          if (data.success !== undefined && data.data !== undefined) {
            if (data.success == 'true') {
              // Yay!
              $('#lost-password-form').hide();
              $('#reset-message').html('Please check your email for a reset link.');
            } else {
              if (data.data == 'Too many tries. Come back ma&ntilde;ana.') {
                $('#lost-password-form').hide();
                $('#reset-message').html(data.data);
              } else {
                var message = (data.data !== '' ? data.data : 'Unable to reset password.')+request;
                $('#reset-message').html(message);
              }
            }
          } else {
            // boo :(
            $('#reset-message').html('Unable to reset password.'+request);
          }
        },
        'json')
          .always(function() {
            $(eventTarget).removeClass("disable-clicks");
          });
    });
  });
  </script>
</body>
</html>
