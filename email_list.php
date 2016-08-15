<?php
if (!logged_in()) {
  login_then_redirect_back_here();
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
    <link rel="import" href="/components/paper-styles/paper-styles.html">
    <link rel="import" href="/components/paper-card/paper-card.html">
    <link rel="import" href="/components/paper-button/paper-button.html">
    <link rel="import" href="/components/paper-input/paper-textarea.html">
    <link rel="import" href="/components/paper-dropdown-menu/paper-dropdown-menu.html">
    <link rel="import" href="/components/paper-dialog/paper-dialog.html">

    <style is="custom-style">
        .center-column {
          margin-top: 100px;
          margin-bottom: 500px;
        }
        paper-card {
            display: block;
            width: 100%;
            background: #424242;
            margin-top: 20px;
            --paper-card-header-color: white;
            --paper-card-header-text: {font-weight: normal;}
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
        iron-icon {
            margin-right: 10px;
            color: #676767;
        }
        paper-dialog {
            --paper-dialog-background-color: #424242;
            color: white;
            --paper-dialog-title: {font-size: 24px; font-weight: 300; margin-top: 10px}
        }
        paper-dialog#status-dialog {
            --paper-dialog-background-color: #303030;
        }
        #email-list-dialog {
          height: 270px;
          width: 500px;
        }
        #email-list-errors {
          text-align: left;
          color: rgb(252,84,87);
        }
        #explanation-text {
          text-align: left;
        }
        paper-input, paper-textarea, paper-dropdown-menu {
            --paper-input-container-focus-color: #1094F7;
            --paper-input-container-input-color: white
        }
    </style>

</head>
<body>
  <div>
    <?php require_once __DIR__.'/navbar.php';?>
  </div>
    <div class="center-column">
        <div id="left-column">
          <i id="explanation-text">
            Please click below to upload an email list in the form of a text file
            with a single email on each line
            (<a href="/examples/email_list.txt" download>see example</a>).
            Clicking upload more than once will create more than one list.
          </i>
            <form is="iron-form" id="recruiting-company-form">
                <div class="button-container">
                    <paper-button raised class="bottom-button" onclick="uploadEmailList()">UPLOAD</paper-button>
                </div>
            </form>
        </div>
        <div id="right-column" class="pull-right">
            <div class="button-container">
                <paper-button raised onclick="backToSend('<?php echo $_GET['referrer'] ?? '';?>')">BACK</paper-button>
                <paper-button raised onclick="backToSend('<?php echo $_GET['referrer'] ?? '';?>')">CONTINUE</paper-button>
            </div>
        </div>
        <div id="email-list-errors"></div>
    </div>

    <paper-dialog class="recruiting-dialog" id="email-list-dialog" modal>
        <h2>Upload your email list</h2>
        <form id="email-list-upload">
          <input class="hidden-file-input" type="file" id="select-list-file" name="listFile" />
          <paper-input id="email-list-name" label="List Name" name="listName" autofocus></paper-input>
          <paper-input id="email-list-file" label="File Name" name="fileName" onclick="fireHiddenFileInput('#select-list-file')"></paper-input>
        </form>
        <div class="buttons">
            <paper-button class="dialog-button" onclick="saveEmailList()">UPLOAD</paper-button>
            <paper-button dialog-dismiss class="dialog-button" onclick="cancelEmailListUpload()">Cancel</paper-button>
        </div>
    </paper-dialog>

    <paper-dialog class="recruiting-dialog" id="validation-dialog" modal>
        <h2>Problem...</h2>
        <p id="validation-message">No message supplied</p>
        <div class="buttons">
            <paper-button dialog-dismiss class="dialog-button" id="validation-button">OK</paper-button>
        </div>
    </paper-dialog>

    <paper-dialog class="recruiting-dialog" id="status-dialog">
        <p id="status-message">No message supplied</p>
    </paper-dialog>

    <?php require_once __DIR__.'/footer.php';?>

    <!-- JavaScript -->
    <script
      src="https://code.jquery.com/jquery-2.2.4.min.js"
      integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
      crossorigin="anonymous"></script>
    <script>
    /**
     * Opens the Email List Dialog
     */
    function uploadEmailList() {
      $('#email-list-dialog')[0].open();
    }

    /**
     * Closes the Email List Dialog
     */
    function cancelEmailListUpload() {
      $('#email-list-errors').html('');
      $('#email-list-dialog')[0].close();
    }

    /**
     * Attempts to upload the email list to the ajax endpoint & closes dialog
     */
    function saveEmailList() {
      $('#email-list-errors').html('Processing...');
      var formData = new FormData($('#email-list-upload')[0]);
      $.ajax({
        url: '/ajax/email/list/upload/',
        type: 'post',
        /*data: {
          listName: $('#email-list-name').val(),
          fileName: $('#select-list-file').val(),
        },*/
        data: formData,
        dataType: 'json',
        headers: {
          "X-FILENAME": $('#select-list-file').val(),
        },
        success: function(data, textStatus){
          var message = data.data.message+'<br />';
          if(data.success === 'true') {
            $('#email-list-errors').css('color','white');
          }  else {
            if (data.data.errors.length) {
              message += '<strong>Errors:</strong><br />';
              $.each(data.data.errors, function(index, error) {
                message += error+'<br />';
              })
            }
          }
          $('#email-list-errors').html(message);
        },
        //Options to tell jQuery not to process data or worry about content-type.
        cache: false,
        contentType: false,
        processData: false
      }).fail(function() {
        $('#email-list-errors').html('Uploading email list failed.');
      });
      $('#email-list-dialog')[0].close();
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
        if ($('#select-list-file:file')[0].files[0].type !== "text/plain") {
          $('#email-list-file label').html('<font color="red">Please choose a text file</font>');
          $('#upload-file').val('');
        } else {
          $('#email-list-file label').html('File Name');
          $('#email-list-file').val(filename);
        }
      });
    });
    </script>
</body>
</html>
