<?php
use \Sizzle\Bacon\Database\{
    EmailList,
    EmailCredential,
    RecruitingCompany,
    RecruitingToken,
    User
};

if (!logged_in()) {
  login_then_redirect_back_here();
}

$user_id = (int) ($_SESSION['user_id'] ?? '');
$referrer = (int) ($_GET['referrer'] ?? '');
$recruiting_token_id = $_GET['id'] ?? '';
$token = new RecruitingToken($recruiting_token_id, 'long_id');

$user = new User($user_id);
$credentials = (new EmailCredential())->getByUserId($user_id);
$lists = (new EmailList())->getByUserId($user_id);

define('TITLE', 'S!zzle - Send Recruiting Token');
require __DIR__.'/header.php';
?>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
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
        #progress-bar {
            width: 100%;
            height: 70px;
            padding: 7px 0px 0px 70px;
        }
        #token-strength {
            width: 100%;
            height: 300px;
        }
        paper-fab{
            --paper-fab-background: #2193ED;
            display: inline-block;
            vertical-align: middle;
        }
        paper-fab.progress-fab {
            margin-left: 10px;
        }
        paper-fab.current-fab {
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
        .progress-text.active {
          color: #009688;
        }
        #link-info {
          height:260px;
        }
        #send-to-email-list, #send-to-email-credentials {
          width:60%;
        }
        #send-token-button {
          margin-top: 30px;
        }
        #social-shares {
          margin-top:0px;
        }
        #facebook-share {

        }
    </style>

</head>
<body>
  <div>
    <?php require_once __DIR__.'/navbar.php';?>
  </div>
  <div class="center-column">
    <paper-card id="progress-bar">
      <a href="<?php echo '/create_recruiting?id='.$recruiting_token_id;?>">
        <paper-fab icon="looks one" class="progress-fab">1</paper-fab>
      </a>
      <span class="progress-text">Job Info</span>
      <div class="progress-line"></div>
      <a href="<?php echo '/create_company?id='.$referrer.'&referrer='.$recruiting_token_id;?>">
        <paper-fab icon="looks one" class="progress-fab"></paper-fab>
      </a>
      <span class="progress-text">Company Info</span>
      <div class="progress-line"></div>
      <paper-fab icon="looks one" class="progress-fab"></paper-fab>
      <span class="progress-text active"><strong>Send Token</strong></span>
    </paper-card>
    <div id="left-column">
      <paper-card id="link-info" heading="Share Token Link">
        <div class="field-container">
          <div class="pull-left" id="token-link" style="padding-top:15px;">
            <a href="<?php echo APP_URL."token/recruiting/".$recruiting_token_id;?>" target="_blank">
              <?php echo APP_URL."token/recruiting/".$recruiting_token_id;?>
            </a>
          </div>
          <div class="pull-right" id="social-shares">
            <paper-button
              id="copy-link-button"
              style="margin-left:0px"
              raised
              onclick="copyTokenLink()">
            COPY</paper-button>

              <a id="download-qr-code-link"><paper-button
                id="download-qr-code-button"
                style="margin-left:0px;"
                raised
                onclick=null">
                Download QR Code
                <div id="qr-code" hidden></div></paper-button></a>

            <div id="li-root" style="margin-top:20px"></div>
            <script src="//platform.linkedin.com/in.js" type="text/javascript"> lang: en_US</script>
            <script
              type="IN/Share"
              data-url="<?php echo APP_URL.'token/recruiting/'.$recruiting_token_id;?>">
            </script>

            <div id="tw-root" style="margin-top:10px"></div>
            <script>window.twttr = (function(d, s, id) {
              var js, fjs = d.getElementsByTagName(s)[0],
                t = window.twttr || {};
              if (d.getElementById(id)) return t;
              js = d.createElement(s);
              js.id = id;
              js.src = "https://platform.twitter.com/widgets.js";
              fjs.parentNode.insertBefore(js, fjs);

              t._e = [];
              t.ready = function(f) {
                t._e.push(f);
              };

              return t;
            }(document, "script", "twitter-wjs"));</script>
            <a class="twitter-share-button"
              href="https://twitter.com/intent/tweet?text=<?=urlencode($token->job_title)?>&url=<?=APP_URL.'token/recruiting/'.$recruiting_token_id?>"
              >
            Tweet</a>
            <div id="fb-root"></div>
            <script>(function(d, s, id) {
              var js, fjs = d.getElementsByTagName(s)[0];
              if (d.getElementById(id)) return;
              js = d.createElement(s); js.id = id;
              js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5&appId=82256972765";
              fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>
            <div class="fb-share-button"
              id="facebook-share"
              data-href="<?=APP_URL.'token/recruiting/'.$recruiting_token_id?>"
              data-layout="button">
            </div>
          </div>
        </div>
      </paper-card>

      <h3>or</h3>

      <paper-card id="send-to-info" heading="Send Via Email">
        <div class="field-container">
          <i>Send to an email or an email list.</i><br />
          <paper-input
            label="Email Address"
            id="send-to-email"
            hidden>
          </paper-input>
          <paper-button id="send-list-button" raised onclick="hideSingle()" hidden>EMAIL LIST</paper-button>
          <paper-dropdown-menu
            label="Choose Email List"
            id="send-to-email-list">
            <paper-menu class="dropdown-content">
              <?php foreach ($lists as $list) {
                  echo '<paper-item value="'.$list['id'].'">'.$list['name'].'</paper-item>';
              }?>
            </paper-menu>
          </paper-dropdown-menu>
          <a id="new-list-button" href="/email_list?referrer=<?php echo $recruiting_token_id;?>">
            <paper-button>NEW LIST</paper-button>
          </a>
          <paper-button id="send-single-button" raised onclick="hideList()" hidden>SINGLE EMAIL</paper-button>
          <br />
          <paper-dropdown-menu
            label="Choose Email Credentials"
            id="send-to-email-credentials"
            on-iron-select="_itemSelected">
            <paper-menu class="dropdown-content">
              <?php foreach ($credentials as $credential) {
                  echo '<paper-item value="'.$credential['id'].'">'.$credential['credential'].'</paper-item>';
              }?>
            </paper-menu>
          </paper-dropdown-menu>
          <a href="/email_credentials?referrer=<?php echo $recruiting_token_id;?>">
            <paper-button>NEW CREDENTIALS</paper-button>
          </a>
          <br />
          <paper-textarea
            label="Optional Message"
            id="send-to-email-message"
            rows="1">
          </paper-textarea>
          <br />
          <paper-button id="send-token-button" raised onclick="sendEmails()">SEND</paper-button>
        </div>
      </paper-card>

    </div>
    <div id="right-column" class="pull-right">
      <div class="button-container">
        <paper-button raised onclick="backToCompany('<?php echo $referrer;?>', '<?php echo $recruiting_token_id;?>')">BACK</paper-button>
      </div>
    </div>
  </div>

  <paper-dialog class="recruiting-dialog" id="sent-dialog" modal>
      <p id="sent-message">Your email(s) are being sent!</p>
      <div class="button-container">
          <paper-button dialog-dismiss id="ok-sent-button" hidden>OK</paper-button>
      </div>
  </paper-dialog>

  <?php require_once __DIR__.'/footer.php';?>

  <!-- JavaScript -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>
  <script>

  /**
   * Redirects user back to the company edit page
   *
   * @param {String} id The id of the company to go back to
   * @param {String} token The long_id of the token to go back to
   */
  function backToCompany(id, token) {
    window.location = '/create_company?id='+id+'&referrer='+token;
  }

  /**
   *  Generates QR Code and adds to link for download.
   *
   */
  $("#qr-code").qrcode("<?php echo APP_URL."token/recruiting/".$recruiting_token_id;?>");
  $("#download-qr-code-link")[0].href = $("#qr-code canvas")[0].toDataURL("image/png");
  $("#download-qr-code-link")[0].download = "recruiting_token_qr_code.png";

  /**
   * Copies the token link to the keyboard
   */
  function copyTokenLink() {
    var $temp = $("<input>")
    $("body").append($temp);
    $temp.val($('#token-link a').text()).select();
    document.execCommand("copy");
    $temp.remove();
    $('#copy-link-button').text('Copied!')
  }

  /**
   * Replaces the email list option with a single email
   */
  function hideList() {
    $('#send-to-email-list').hide();
    $('#new-list-button').hide();
    $('#send-single-button').hide();
    $('#send-to-email').removeAttr('hidden');
    //$('#send-list-button').removeAttr('hidden');
  }

  /**
   * Queues up the email(s) to be sent & informs users
   */
  function sendEmails() {
    $('#sent-dialog')[0].open();
    $('#sent-message').html('Processing...');
    $.ajax({
      url: '/ajax/email/list/send/',
      type: 'post',
      data: {
        token_id: '<?php echo $recruiting_token_id;?>',
        email_list_id: $("#send-to-email-list paper-item[aria-selected='true']").attr('value'),
        message: $('#send-to-email-message').val(),
        email_credential_id: $("#send-to-email-credentials paper-item[aria-selected='true']").attr('value'),
      },
      dataType: 'json',
      success: function(data, textStatus){
        //var message = data.data.message+'<br />';
        if(data.success === 'true') {
          $('#sent-message').html('Your emails were sent.');
        } else if (typeof data.data.errors !== 'undefined') {
          var height = 120;
          var errors = '';

          $.each(data.data.errors, function(i, v) {
            errors += v+'<br/>';
            height += 15;
          });
          $('#sent-dialog').css('height',  height+'px');
          $('#sent-message').html(errors);
        } else {
          $('#sent-message').html('Failed to send emails.');
        }
        $('#ok-sent-button').removeAttr('hidden');
      }
    }).fail(function() {
      $('#sent-message').html('Failed to send emails.');
      $('#ok-sent-button').removeAttr('hidden');
    });
  }
  </script>
</body>
</html>
