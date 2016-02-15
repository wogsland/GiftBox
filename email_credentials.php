<?php
if (!logged_in() || !is_admin()) {
    header('Location: '.APP_URL);
}

$user_id = $_SESSION['user_id'] ?? '';

define('TITLE', 'S!zzle - Email List');
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
    .company-social-site-td {
      border:0;
      font-size: 18px;
    }
    .company-social-user-td {
      border:0;
      padding-bottom: 20px;
      padding-left: 5px;
      width: 500px;
      font-size: 18px;
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
                      <paper-input
                        value="The input"
                        label="Email Address"
                        id="credential-email"
                        name="credential_email">
                      </paper-input>
                      <paper-input
                        value="The input"
                        label="Password"
                        id="credential-password"
                        name="credential_password">
                      </paper-input>
                      <paper-input
                        value="The input"
                        label="SMTP Host"
                        id="credential-host"
                        name="credential_host">
                      </paper-input>
                      <paper-input
                        value="The input"
                        label="SMTP Port"
                        id="credential-port"
                        name="credential_port">
                      </paper-input>
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

    <paper-dialog class="recruiting-dialog" id="status-dialog">
        <p id="status-message"></p>
    </paper-dialog>

    <?php require_once __DIR__.'/footer.php';?>

    <!-- JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>
    /**
     * Attempts to upload the email list to the ajax endpoint & closes dialog
     */
    function saveCredentials() {
      $('#email-list-errors').html('Processing...');
      var formData = new FormData($('#email-list-upload')[0]);
      $.ajax({
        url: '/ajax/email/credential/add/',
        type: 'post',
        data: {
          username: $('#credential-email').val(),
          password: $('#credentialpassword').val(),
          smtp_host: $('#credential-host').val(),
          smtp_port: $('#credential-port').val(),
        },
        data: formData,
        dataType: 'json',
        success: function(data, textStatus){
          var message = data.data.message+'<br />';
          if(data.success === 'true') {
            $('#status-message').html('Email credentials successfully saved');
          }  else {
            alert('fail')
            /*if (data.data.errors.length) {
              message += '<strong>Errors:</strong><br />';
              $.each(data.data.errors, function(index, error) {
                message += error+'<br />';
              })
            }*/
          }
        },
        //Options to tell jQuery not to process data or worry about content-type.
        cache: false,
        contentType: false,
        processData: false
      }).fail(function() {
        //$('#email-list-errors').html('Uploading email list failed.');
      });
      //$('#email-list-dialog')[0].close();
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
     * Registers click on hidden file input.
     *
     * @param {String} identifier The jQuery identifier to click
     */
    function fireHiddenFileInput(identifier) {
       $(identifier).trigger('click');
    }
    $( document ).ready(function() {
      $('#select-list-file').change(function() {
        var filename = $('#select-list-file').val().replace('C:\\fakepath\\', '');
        console.log('filename is '+filename)
        if ($('#select-list-file:file')[0].files[0].type !== "text/plain") {
          $('#email-list-file label').html('<font color="red">Please choose a text file</font>');
        } else {
          $('#email-list-file label').html('File Name');
          $('#email-list-file').val(filename);
        }
      });
    });
    </script>
</body>
</html>
