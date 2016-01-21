<?php
use \Sizzle\City;
use \Sizzle\HTML;
use \Sizzle\RecruitingCompany;
use \Sizzle\RecruitingToken;
use \Sizzle\RecruitingCompanyImage;
use \Sizzle\RecruitingCompanyVideo;
use \google\appengine\api\cloud_storage\CloudStorageTools;

if (!logged_in()) {
    header('Location: '.APP_URL);
}

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';

if (isset($_GET['id'])) {
    $token = new RecruitingToken(escape_string($_GET['id']), 'long_id');
    $token_company = new RecruitingCompany($token->recruiting_company_id);
    $token_images = RecruitingCompanyImage::getTokenImages($token->id);
    $token_videos = RecruitingCompanyVideo::getTokenVideos($token->id);
} else {
    $token = new RecruitingToken();
    $token_images = array();
    $token_videos = array();
}

function paper_text($label, $id, $value, $required = false)
{
    echo PHP_EOL;
    echo '              <paper-input value="'.htmlspecialchars($value).'" '.($required ? 'required error-message="This is a required field"' : null).' label="'.$label.'" id="'.$id.'" name="'.str_replace('-', '_', $id).'"></paper-input>'.PHP_EOL;
}
function paper_textarea($label, $id, $value, $required = false)
{
    echo PHP_EOL;
    echo '              <paper-textarea value="'.htmlspecialchars($value).'" '.($required ? 'required error-message="This is a required field"' : null).' label="'.$label.'" id="'.$id.'" name="'.str_replace('-', '_', $id).'" rows="1">'.PHP_EOL;
    echo '              </paper-textarea>'.PHP_EOL;
}
function paper_dropdown($label, $id, $options, $selected_index = null, $required = false)
{
    echo '      <paper-dropdown-menu '.($required ? 'required error-message="This is a required field"' : null).' class="recruiting-field" label="'.$label.'" id="'.$id.'" name="'.str_replace('-', '_', $id).'">'.PHP_EOL;
    echo '        <paper-menu class="dropdown-content"'.(is_null($selected_index) ? null : ' selected="'.$selected_index.'"').'>'.PHP_EOL;
    foreach ($options as $value => $option) {
        echo '          <paper-item id="'.$value.'">'.ucwords($option).'</paper-item>'.PHP_EOL;
    }
    echo '        </paper-menu>'.PHP_EOL;
    echo '      </paper-dropdown-menu>'.PHP_EOL;
}

define('TITLE', 'S!zzle - Create Recruiting Token');
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
            <form is="iron-form" id="recruiting-token-form">
                <input type="hidden" id="id" name="id" value="<?php echo $token->id ?>">
                <input type="hidden" id="long-id" name="long_id" value="<?php echo $token->long_id ?>">

                <?php if (!isset($token_company)) { ?>
                    <paper-card id="company-info" heading="Important Company Info">
                        <div class="field-container">
                            <?php paper_text('Company Name', 'company', ''); ?>
                            <?php //paper_text('Company Website', 'company-website', $token_company->website); ?>
                            <?php paper_textarea('Company Values', 'company-values', ''); ?>
                        </div>
                    </paper-card>
                    <paper-card id="company-images" heading="Company Images">
                        <div class="field-container">
                            <div class="icon-bar">
                                <span class="icon-bar-text">Add Images From: </span>
                                <div class="icon-container">
                                <input class="hidden-file-input" type="file" multiple id="select-image-file" />
                                    <a class="icon-link" id="desktop-icon-link" href="javascript:void(0)" onclick="$('#select-image-file').trigger('click')"><i class="fa fa-laptop fa-2x add-icon"></i></a>
    <!--                            <a class="icon-link" id="dropbox-icon-link" href="javascript:void(0)" onclick="openDropBoxImage()"><i class="fa fa-dropbox fa-2x add-icon"></i></a>
                                    <a class="icon-link" href="javascript:void(0)" onclick="selectFacebookImage()"><i class="fa fa-facebook-square fa-2x add-icon"></i></a>
                                    <paper-button class="icon-button" raised onclick="webAddress()">WEB ADDRESS</paper-button>
                                    <paper-button class="icon-button" raised onclick="library()">LOCAL LIBRARY</paper-button>
    -->                            </div>
                            </div>
                            <?php if (count($token_images) > 0) {?>
                              <div class="thumbnail-list-container" id="company-image-container">
                              <?php
                              foreach ($token_images as $token_image) {
                                  if (GOOGLE_APP_ENGINE) {
                                      $image_path = CloudStorageTools::getPublicUrl($file_storage_path.$token_image->file_name, $use_https);
                                  } else {
                                      $image_path = $file_storage_path.$token_image->file_name;
                                  }
                                  $image_id = str_replace('.', '_', $token_image->file_name);
                                  echo '<div class="thumbnail-container">';
                                  echo '  <div class="inner-thumbnail-container">';
                                  echo '      <img class="recruiting-token-image photo-thumbnail" id="'.$image_id.'" data-id="'.$token_image->id.'" src="'.$image_path.'">';
                                  echo '      <paper-button raised class="remove-button" data-saved="true" onclick="removeImageById(\''.$image_id.'\')">REMOVE</paper-button>';
                                  echo ' </div>';
                                  echo '</div>';
                              }
                              echo '</div>';
                            } else { ?>
                              <div class="thumbnail-list-container" id="company-image-container" hidden></div>
                            <?php } ?>
                        </div>
                    </paper-card>
                    <paper-card id="company-videos" heading="Company Videos">
                        <div class="field-container">
                            <div class="icon-bar">
                                <span class="icon-bar-text">Add Videos From: </span>
                                <div class="icon-container">
                                    <paper-button class="icon-button" raised onclick="openVideoDialog()">WEB ADDRESS</paper-button>
    <!--                            <a class="icon-link" id="desktop-icon-link" href="javascript:void(0)" onclick="$('#select-video-file').trigger('click')"><i class="fa fa-laptop fa-2x add-icon"></i></a>
                                    <a class="icon-link" id="dropbox-icon-link" href="javascript:void(0)" onclick="openDropBoxImage()"><i class="fa fa-dropbox fa-2x add-icon"></i></a>
                                    <a class="icon-link" href="javascript:void(0)" onclick="selectFacebookImage()"><i class="fa fa-facebook-square fa-2x add-icon"></i></a>
                                    <paper-button class="icon-button" raised onclick="library()">LOCAL LIBRARY</paper-button>
    -->
                                </div>
                            </div>
                            <?php if (count($token_images) > 0) {?>
                              <div class="thumbnail-list-container" id="company-video-container">
                              <?php
                              foreach ($token_videos as $token_video) {
                                  $image_id = substr($token_video->url, strrpos($token_video->url, '/')+1);
                                  echo '<div class="thumbnail-container">';
                                  echo '  <div class="inner-thumbnail-container">';
                                  echo '      <img class="recruiting-token-video photo-thumbnail" id="'.$image_id.'" data-id="'.$token_video->id.'" src="'.$token_video->thumbnail_src.'">';
                                  echo '      <paper-button raised class="remove-button" data-saved="true" onclick="removeImageById(\''.$image_id.'\')">REMOVE</paper-button>';
                                  echo ' </div>';
                                  echo '</div>';
                              }
                              echo '</div>';
                            } else { ?>
                              <div class="thumbnail-list-container" id="company-video-container" hidden></div>
                            <?php } ?>
                        </div>
                    </paper-card>
                    <paper-card id="company-social-media" heading="Company Social Media">
                        <div class="field-container">
                            <table>
                              <tr>
                                <td class="company-social-site-td">
                                  https://facebook.com/
                                </td>
                                <td class="company-social-user-td">
                                  <?php paper_text('', 'company-facebook', ''); ?>
                                </td>
                              </tr>
                            </table>
                            <table>
                              <tr>
                                <td class="company-social-site-td">
                                  https://linkedin.com/
                                </td>
                                <td class="company-social-user-td">
                                  <?php paper_text('', 'company-linkedin', ''); ?>
                                </td>
                              </tr>
                            </table>
                            <table>
                              <tr>
                                <td class="company-social-site-td">
                                  https://youtube.com/
                                </td>
                                <td class="company-social-user-td">
                                  <?php paper_text('', 'company-youtube', ''); ?>
                                </td>
                              </tr>
                            </table>
                            <table>
                              <tr>
                                <td class="company-social-site-td">
                                  https://twitter.com/
                                </td>
                                <td class="company-social-user-td">
                                  <?php paper_text('', 'company-twitter', ''); ?>
                                </td>
                              </tr>
                            </table>
                            <table>
                              <tr>
                                <td class="company-social-site-td">
                                  https://plus.google.com/
                                </td>
                                <td class="company-social-user-td">
                                  <?php paper_text('', 'company-google-plus', ''); ?>
                                </td>
                              </tr>
                            </table>
                        </div>
                    </paper-card>
                <?php } ?>

                <div class="button-container">
                    <paper-button raised class="bottom-button" onclick="saveRecruitingToken(true)">SAVE</paper-button>
                </div>
            </form>
        </div>
        <div id="right-column" class="pull-right">
            <div class="button-container">
                <paper-button raised onclick="openToken()">OPEN</paper-button>
                <paper-button raised onclick="saveRecruitingToken()">SAVE</paper-button>
            </div>
       </div>
    </div>

    <paper-dialog class="recruiting-dialog" id="open-dialog" modal>
        <h2>Open</h2>
        <form is="iron-form" id="open-token-form">
            <div class="field-container">
            <?php
                $user_tokens = RecruitingToken::getUserTokens($user_id);
                $tokens = array();
                foreach ($user_tokens as $token) {
                    $tokenCompanyName = ''!=$token->company ? $token->company : 'Unnamed Company';
                    $tokens[$token->long_id] = $tokenCompanyName." - ".$token->job_title;
                }
                paper_dropdown('Select a Token to open', 'token-to-open', $tokens, null, true);
            ?>
            </div>
        </form>
        <div class="buttons">
            <paper-button class="dialog-button" onclick="processOpen()">Open</paper-button>
            <paper-button dialog-dismiss class="dialog-button">Cancel</paper-button>
        </div>
    </paper-dialog>

    <paper-dialog class="recruiting-dialog" id="video-dialog" modal>
        <h2>Upload video from web address</h2>
        <paper-input id="video-dialog-url" label="Paste video embed URL here" autofocus></paper-input>
        <div class="buttons">
            <paper-button class="dialog-button" onclick="processVideoURL()">Add</paper-button>
            <paper-button dialog-dismiss class="dialog-button" onclick="cancelVideoURL()">Cancel</paper-button>
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
    <script src="components/Autolinker.js/dist/Autolinker.min.js"></script>
    <script src="js/create_common.min.js?v=<?php echo VERSION;?>"></script>
    <script src="js/create_recruiting.min.js?v=<?php echo VERSION;?>"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>
        $( document ).ready(function() {
            $('#select-image-file').on('change', handleImageFileSelect);
            $('#company-image-container').data('deleted', []);
            $('#company-video-container').data('deleted', []);
            $('.recruiting-token-image').each(function() {
                var img = $(this);
                img.data('saved', true);
            });
            $('.recruiting-token-video').each(function() {
                var img = $(this);
                img.data('saved', true);
            });
        });
    </script>
</body>
</html>
