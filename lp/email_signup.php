<?php
if (logged_in()) {
    header('Location: /profile');
}
define('TITLE', 'S!zzle - Sell the S!zzle not the Steak');
include __DIR__.'/../header.php';
?>
<link rel="import" href="/components/paper-button/paper-button.html">
<link rel="import" href="/components/paper-dialog/paper-dialog.html">
<link rel="import" href="/components/paper-input/paper-input.html">
<style>
.white-line {
  margin-bottom: 10px;
}
#signup-call-to-action {
  margin-top: 125px;
}
#left-div-1 {
  padding-top: 50px;
  visibility: hidden;
}
#right-div-1 {
  padding-top: 200px;
  visibility: hidden;
}
#upload-btn {
  margin-top: 50px;
  margin-bottom: 20px;
  background-color: rgb(148,203,197);
  color: black;
}
#customers {
  color: black;
  font-size: 25px;
  font-weight: bold;
  background-color: white;
  padding-bottom: 50px;
}
#customers-heading {
  margin-top:20px;
  margin-bottom:30px;
}
</style>
</head>
<body>

  <!-- =========================
      Navbar
  ============================== -->
  <header class="header" data-stellar-background-ratio="0.5" id="home">
        <?php include __DIR__.'/../navbar.php';?>
  </header>

  <section id="email-signup-call-to-action">
    <div class="container">
      <div class="row">
        <div id="left-div-1" class="col-md-4 wow fadeIn animated" data-wow-offset="10" data-wow-duration="1.5s">
          <h2>How Important is<br /> Candidate Experience?</h2>
          Recruiting Agency, Corporation, or RPO<br />
          First Impressions Matter<br />
          <div id="signup-container">
            <paper-button id="upload-btn" raised class="bottom-button" onclick="uploadDescription()">UPLOAD NOW</paper-button><br />
            30 Day Free Trial
          </div>
          <br />
          <h3>
            Create engaging material with S!zzle
          </h3>
          <div class="white-line">
          </div>
          <p>
          Email, InMail, Text
          <p>
        </div>
        <div id="right-div-1" class="col-md-8 wow fadeIn animated" data-wow-offset="10" data-wow-duration="1.5s">
          <iframe width="560" height="315" src="https://www.youtube.com/embed/uHzRX-8jC3s" frameborder="0" allowfullscreen></iframe>
        </div>
      </div>
    </div>
  </section>

  <section id="customers">
    <div class="container">
      <div class="row" id="customers-heading">
        Some of Our Current Customers
      </div>
      <div class="row">
        <div class="col-sm-4">
          <img src="images/iqtalentlogo.png">
        </div>
        <div class="col-sm-4">
          <img src="images/solutionpartnerslogo.png">
        </div>
        <div class="col-sm-4">
          <img src="images/plumleelogo.jpg">
        </div>
      </div>
    </div>
  </section>

  <paper-dialog class="recruiting-dialog" id="upload-dialog" modal>
    <h2>Upload Your Job Description</h2>
    <form id="description-upload">
      <input class="hidden-file-input" type="file" id="select-list-file" name="listFile" hidden />
      <paper-input id="upload-email" label="Email" name="email" onclick="" autofocus></paper-input>
      <paper-input id="upload-file" label="File Name" name="fileName" onclick="fireHiddenFileInput('#select-list-file')"></paper-input>
    </form>
    <i>We'll make it S!zzle...</i>
    <div class="">
      <paper-button class="dialog-button" onclick="sizzleUpload()">UPLOAD</paper-button>
      <paper-button dialog-dismiss class="dialog-button" onclick="cancelUpload()">CANCEL</paper-button>
    </div>
  </paper-dialog>

  <paper-dialog class="recruiting-dialog" id="upload-process" modal>
    <div id="upload-errors"></div>
    <div class="">
      <paper-button id="try-again-button" class="dialog-button" onclick="tryAgain()" hidden>TRY AGAIN</paper-button>
      <paper-button id="cancel-again-button" dialog-dismiss class="dialog-button" onclick="cancelUpload()" hidden>CANCEL</paper-button>
      <paper-button id="cancel-again-button" dialog-dismiss class="dialog-button" onclick="cancelUpload()" hidden>CANCEL</paper-button>
    </div>
  </paper-dialog>

  <?php include __DIR__.'/../footer.php';?>
  <script>
  /**
   * Opens the Upload Dialog
   */
  function uploadDescription() {
    $('#upload-dialog')[0].open();
  }

  /**
   * Closes the Upload Dialog
   */
  function cancelUpload() {
    $('#upload-errors').html('');
    $('#upload-dialog')[0].close();
    $('#upload-process')[0].close();
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
    <?php
    if (isset($_GET['action']) && 'login' == $_GET['action']) {
        echo '$("#login-dialog").modal();';
    }
    ?>
    $('#select-list-file').change(function() {
      var filename = $('#select-list-file').val().replace('C:\\fakepath\\', '');
      /*if ($('#select-list-file:file')[0].files[0].type !== "text/plain") {
        $('#upload-file label').html('<font color="red">Please choose a text file</font>');
        $('#upload-file').val('');
      } else {*/
        $('#upload-file label').html('File Name');
        $('#upload-file').val(filename);
      //}
    });

    url = '/ajax/slackbot/<?php echo $_SERVER['REMOTE_ADDR'];?>';
    $.post(url);
  });

  /**
   * Attempts to upload the job description to the ajax endpoint & presents success or error
   */
  function sizzleUpload() {
    var invalid = false;
    if ('' == $('#upload-file').val()) {
      $('#upload-file label').html('<font color="red">Please choose a file</font>');
      invalid = true;
    }
    if ('' == $('#upload-email').val()) {
      $('#upload-email label').html('<font color="red">Please enter an email</font>');
      invalid = true;
    }
    if (!invalid) {
      $('#upload-dialog')[0].close();
      $('#upload-errors').html('Processing...');
      $('#upload-process')[0].open();
      var formData = new FormData($('#description-upload')[0]);
      $.ajax({
        url: '/ajax/email/signup/upload/',
        type: 'post',
        data: formData,
        dataType: 'json',
        headers: {
          "X-FILENAME": $('#select-list-file').val(),
        },
        success: function(data, textStatus){
          var message = data.data.message+'<br />';
          if(data.success === 'true') {
            $('#upload-errors').css('color','white');
            window.location = '/thankyou?action=emailsignup';
          }  else {
            if (data.data.errors.length) {
              $('#upload-errors').css('color','red');
              message += '<strong>Errors:</strong><br />';
              $.each(data.data.errors, function(index, error) {
                message += error+'<br />';
              })
            }
            $('#try-again-button').removeAttr('hidden');
            $('#cancel-again-button').removeAttr('hidden');
          }
          $('#upload-errors').html(message);
        },
        //Options to tell jQuery not to process data or worry about content-type.
        cache: false,
        contentType: false,
        processData: false
      }).fail(function() {
        $('#upload-errors').html('Uploading job description failed.');
        $('#try-again-button').removeAttr('hidden');
        $('#cancel-again-button').removeAttr('hidden');
      });
    }
  }

  /**
   * Reverts modal
   */
  function tryAgain() {
    $('#upload-process')[0].close();
    $('#upload-dialog')[0].open();
    //$('#upload-file').val('');
    $('#try-again-button').attr('hidden','hidden');
    $('#cancel-again-button').attr('hidden','hidden');
  }
  </script>
</body>
</html>
