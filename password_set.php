<?php
use \Sizzle\Bacon\Database\User;

define('TITLE', 'S!zzle - Set Password');
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
      <?php echo $message;?>
    </h5>
    <br />
    <form id="new-password-form">
      <input class="dialog-input" id="password1" name="password1" type="password" placeholder="Password" size="25">
      <input class="dialog-input" id="password2" name="password2" type="password" placeholder="Retype Password" size="25">
      <a class="btn btn-default standard-button" id="new-password-button">Create Password</a>
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
          '/ajax/nopassword/',
          {
            activation_key: '<?php echo $_SESSION['activation_key'] ?? '';?>',
            password: password1
          },
          function (data) {
            var failMessage = 'Error setting up account. Please contact ';
            failMessage += '<a href="mailto:support@gosizzle.io">support@gosizzle.io</a>';
            failMessage += ' for assistance.';
            if (data.success !== undefined && data.data !== undefined) {
              if (data.success == 'true' && data.data.url !== undefined) {
                window.location = data.data.url;
              } else {
                $('#new-password-form').hide();
                $('#reset-message').html(failMessage);
              }
            } else {
              // boo :(
              $('#reset-message').html(failMessage);
            }
          },
          'json'
        );
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
