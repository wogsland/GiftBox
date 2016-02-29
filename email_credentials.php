<?php
if (!logged_in()) {
    header('Location: '.APP_URL);
}

$user_id = $_SESSION['user_id'] ?? '';

define('TITLE', 'S!zzle - Email Credentials');
require __DIR__.'/header.php';
?>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="/css/font-awesome.min.css">
<link rel="stylesheet" href="/css/create_recruiting.min.css">

<!-- Polymer -->
<script src="/components/webcomponentsjs/webcomponents-lite.min.js"></script>

<link rel="import" href="/components/iron-icons/iron-icons.html">
<link rel="import" href="/components/iron-icon/iron-icon.html">
<link rel="import" href="/components/iron-form/iron-form.html">
<link rel="import" href="/components/paper-menu/paper-menu.html">
<link rel="import" href="/components/paper-item/paper-item.html">
<link rel="import" href="/components/paper-icon-button/paper-icon-button.html">
<link rel="import" href="/components/paper-input/paper-input.html">
<link rel="import" href="/components/paper-header-panel/paper-header-panel.html">
<link rel="import" href="/components/paper-toolbar/paper-toolbar.html">
<link rel="import" href="/components/paper-styles/paper-styles.html">
<link rel="import" href="/components/paper-card/paper-card.html">
<link rel="import" href="/components/paper-button/paper-button.html">
<link rel="import" href="/components/paper-input/paper-textarea.html">
<link rel="import" href="/components/paper-dropdown-menu/paper-dropdown-menu.html">
<link rel="import" href="/components/paper-dialog/paper-dialog.html">
<link rel="import" href="/components/paper-fab/paper-fab.html">
<link rel="import" href="/components/paper-tooltip/paper-tooltip.html">

<style is="custom-style">
    .center-column {
      margin-top: 100px;
    }
    .field-container {
      text-align: left;
    }
    paper-card {
        display: block;
        width: 100%;
        background: #424242;
        margin-top: 20px;
        --paper-card-header-color: white;
        --paper-card-header-text: {font-weight: normal;}
    }
    paper-card#send-token-via {
        display: none;
    }
    paper-input, paper-textarea, paper-dropdown-menu {
        --paper-input-container-focus-color: #1094F7;
        --paper-input-container-input-color: white
    }
    paper-button {
        background: #009688;
        color: white;
    }
    paper-button.dialog-button {
        background: #2193ED;
        font-size: 14px;
        margin-top: 0px;
        margin-bottom: 20px;
        border: 0px;
    }
    .library-button {
        margin: 10px 0px;
        width: 100%;
    }
    iron-icon {
        margin-right: 10px;
        color: #676767;
    }
    paper-toolbar {
        --paper-toolbar-background: #111111
    }
    paper-fab{
        --paper-fab-background: #2193ED;
        display: inline-block;
        vertical-align: middle;
    }
    paper-fab.progress-fab {
        margin-left: 10px;
    }
    paper-dialog {
        --paper-dialog-background-color: #424242;
        color: white;
         --paper-dialog-title: {font-size: 24px; font-weight: 300; margin-top: 10px}
    }
    paper-dialog#status-dialog {
        --paper-dialog-background-color: #303030;
    }
    #status-dialog {
      height: 200px;
      width: 500px;
    }
    #status-details {
      color: red;
    }
</style>

</head>
<body>
<div>
<?php require_once __DIR__.'/navbar.php';?>
</div>
<div class="center-column">
    <div id="left-column">
      <form is="iron-form" id="recruiting-company-form">
        <paper-card id="company-info" heading="Email Credentials">
          <div class="field-container">
            <i>
              Instructions:
              <a href="https://blog.gosizzle.io/version-1-10-0-release-7417eb683d62" target="_blank">
                Gmail
              </a>
            </i>
            <paper-input
              label="Username"
              id="credential-email"
              name="credential_email"
              required>
            </paper-input>
            <paper-button
              id="show-password-button"
              class="pull-right"
              raised
              onclick="showPassword()">
              SHOW
            </paper-button>
            <paper-button
              id="hide-password-button"
              class="pull-right"
              raised
              onclick="hidePassword()"
              hidden>
              HIDE
            </paper-button>
            <paper-input
              label="Password"
              id="credential-password"
              name="credential_password"
              type="password"
              required>
            </paper-input>
            <paper-input
              label="SMTP Host"
              id="credential-host"
              name="credential_host"
              required>
            </paper-input>
            <paper-input
              label="SMTP Port"
              id="credential-port"
              name="credential_port"
              required>
            </paper-input>
            <br />
            <i>
              Currently only SMTP TLS authentication is supported. If you have
              any questions please contact
              <a href="mailto:support@gosizzle.io">support@gosizzle.io</a>.
            </i>
          </div>
        </paper-card>
      </form>
    </div>
    <div id="right-column" class="pull-right">
        <div class="button-container">
            <paper-button raised onclick="backToSend('<?php echo $_GET['referrer'] ?? '';?>')">BACK</paper-button>
            <paper-button raised onclick="saveCredentials()">SAVE</paper-button>
        </div>
   </div>
</div>

    <paper-dialog class="recruiting-dialog" id="status-dialog" modal>
      <p id="status-message"></p>
      <p id="status-details"></p>
      <div class="button-container">
        <paper-button raised onclick="dismissStatusDialog()">DISMISS</paper-button>
      </div>
    </paper-dialog>

    <?php require_once __DIR__.'/footer.php';?>

    <!-- JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>
    /**
     * Attempts to upload the email credentials to the ajax endpoint & closes dialog
     */
    function saveCredentials() {
      $.ajax({
        url: '/ajax/email/credential/add/',
        type: 'post',
        data: {
          username: $('#credential-email').val(),
          password: $('#credential-password').val(),
          smtp_host: $('#credential-host').val(),
          smtp_port: $('#credential-port').val(),
        },
        dataType: 'json',
        success: function(data, textStatus){
          var message = data.data.message+'<br />';
          if(data.success === 'true') {
            $('#status-message').html('Email credentials saved');
            $('#status-details').html('');
            $('#status-dialog')[0].open();
          }  else {
            $('#status-message').html('Failed to save email credentials');
            var height = 200;
            var errors = '';
            $.each(data.data.errors, function(i, v) {
              errors += v+'<br/>';
              height += 15;
            });
            $('#status-dialog').css('height',  height+'px');
            $('#status-details').html(errors);
            $('#status-dialog')[0].open();
          }
        }
      }).fail(function() {
        $('#status-message').html('Failed to save email credentials');
        $('#status-dialog')[0].open();
      });
    }

    /**
     * Redirects user back to token send page from email list edit page
     *
     * @param {String} longId The long_id of the token
     */
    function backToSend(longId) {
      window.location = '/send_recruiting?id='+longId;
    }

    /**
     * Closes the Status Dialog
     */
    function dismissStatusDialog() {
      $('#status-dialog')[0].close();
    }

    /**
     * Shows the password
     */
    function showPassword() {
      $('#credential-password').removeAttr('type');
      $('#hide-password-button').removeAttr('hidden');
      $('#show-password-button').attr('hidden', 'hidden');
    }

    /**
     * Hides the password
     */
    function hidePassword() {
      $('#credential-password').attr('type', 'password');
      $('#show-password-button').removeAttr('hidden');
      $('#hide-password-button').attr('hidden', 'hidden');
    }
    </script>
</body>
</html>
