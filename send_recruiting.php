<?php
use \Sizzle\{
    EmailList,
    EmailCredential,
    RecruitingCompany,
    RecruitingToken,
    User
};

if (!logged_in() || !is_admin()) {
    header('Location: '.APP_URL);
}

$user_id = (int) ($_SESSION['user_id'] ?? '');
$referrer = (int) ($_GET['referrer'] ?? '');
$recruiting_token_id = $_GET['id'] ?? '';

$user = new User($user_id);
$credentials = (new EmailCredential())->getByUserId($user_id);
$lists = (new EmailList())->getByUserId($user_id);

define('TITLE', 'S!zzle - Send Recruiting Token');
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
          height:150px;
        }
        #send-to-email-list, #send-to-email-credentials {
          width:60%;
        }
        #send-token-button {
          margin-top: 30px;
        }
    </style>

</head>
<body>
  <div>
    <?php require_once __DIR__.'/navbar.php';?>
  </div>
  <div class="center-column">
    <paper-card id="progress-bar">
      <paper-fab icon="looks one" class="progress-fab">1</paper-fab>
      <span class="progress-text">Job Info</span>
      <div class="progress-line"></div>
      <paper-fab icon="looks one" class="progress-fab"></paper-fab>
      <span class="progress-text">Company Info</span>
      <div class="progress-line"></div>
      <paper-fab icon="looks one" class="progress-fab"></paper-fab>
      <span class="progress-text active"><strong>Send Token</strong></span>
    </paper-card>
    <div id="left-column">
      <paper-card id="link-info" heading="Token Link">
        <div class="field-container">
          <div class="pull-left" id="token-link" style="padding-top:15px;">
            <a href="<?php echo APP_URL."token/recruiting/".$recruiting_token_id;?>" target="_blank">
              <?php echo APP_URL."token/recruiting/".$recruiting_token_id;?>
            </a>
          </div>
          <paper-button id="copy-link-button" class="pull-right" raised onclick="copyTokenLink()">COPY</paper-button>
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
          <paper-button id="send-single-button" raised onclick="hideList()">SINGLE EMAIL</paper-button>
          <br />
          <paper-dropdown-menu
            label="Choose Email Credentials"
            id="send-to-email-credentials">
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
          <paper-button id="send-token-button" raised onclick="copyTokenLink()">SEND</paper-button>
        </div>
      </paper-card>
    </div>
    <div id="right-column" class="pull-right">
      <div class="button-container">
        <paper-button raised onclick="backToCompany('<?php echo $referrer;?>', '<?php echo $recruiting_token_id;?>')">BACK</paper-button>
      </div>
    </div>
  </div>
  <?php require_once __DIR__.'/footer.php';?>

  <!-- JavaScript -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
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

  $( document ).ready(function() {

  });
  </script>
</body>
</html>
