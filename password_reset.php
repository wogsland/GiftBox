<?php
use \Sizzle\Bacon\Database\User;

// make sure the secret is valid
if (isset($_GET['secret'])) {
    $reset_code = $_GET['secret'];
    $user = (new User())->fetch($reset_code, 'reset_code');
    if (!isset($user->email_address)) {
        header('Location: '.'/');
    }
} else {
    header('Location: '.'/');
}

define('TITLE', 'S!zzle - Password Reset');
require __DIR__.'/header.php';
?>
<style>
#new-password-container {
  margin:150px auto 0 auto;
  text-align:center;
  color: white;
  margin-bottom: 200px;
}
#send-password-button {
  margin-top: 30px;
}
.dialog-input {
  margin-left: auto;
  margin-right: auto;
}
</style>
</head>
<body onload="document.forms[0].password1.focus()">
    <?php require __DIR__.'/navbar.php';?>
  <div id="new-password-container">
    <h5 id="reset-message">
      Please enter a new password.
      <br /><br />
      We'll reset it so you can log in.
    </h5>
    <br />
    <form id="new-password-form">
      <input class="dialog-input" id="password1" name="password1" type="password" placeholder="Password" size="25">
      <input class="dialog-input" id="password2" name="password2" type="password" placeholder="Retype Password" size="25">
      <a class="btn btn-default standard-button" id="new-password-button">Reset Password</a>
    </form>
  </div>

    <?php require __DIR__.'/footer.php';?>
  <script>
  $(document).ready(function(){
    $('#new-password-form').submit(function(e) {
      e.preventDefault();
      $('#new-password-button').click();
    });
    $('#new-password-button').on('click', function () {
      // check passwords match
      var password1 = $('#password1').val();
      var password2 = $('#password2').val();
      if (password1 === password2 && password1 !== '' && password1.length >= 8) {
        var eventTarget = event.target;
        $(eventTarget).addClass("disable-clicks");
        $.post(
          '/ajax/password_reset/',
          {
            reset_code: '<?php echo $reset_code ?? '';?>',
            password: password1
          },
          function (data) {
            if (data.success !== undefined && data.data !== undefined) {
              if (data.success == 'true') {
                // Yay!
                $('#new-password-form').hide();
                $('#reset-message').html('Please log in.');
                $('#login-dialog').modal();
              } else {
                if (data.data == 'Too many tries. Come back ma&ntilde;ana.') {
                  $('#new-password-form').hide();
                  $('#reset-message').html(data.data);
                } else {
                  var message = (data.data !== '' ? data.data : 'Unable to reset password.');
                  $('#reset-message').html(message);
                }
              }
            } else {
              // boo :(
              $('#reset-message').html('Unable to reset password.');
            }
          },
          'json');
        } else if (password1 === '') {
          $('#reset-message').html('Password cannont be left blank.');
        } else if (password1.length < 8) {
          $('#reset-message').html('Password must be at least 8 characters.');
        } else if (password1 !== password2) {
          $('#reset-message').html('Passwords entered below must match.');
        }
    });
  });
  </script>
</body>
</html>
