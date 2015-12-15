<?php
use GiveToken\City;
use GiveToken\RecruitingToken;
use GiveToken\RecruitingTokenImage;
use GiveToken\RecruitingTokenVideo;
use google\appengine\api\cloud_storage\CloudStorageTools;

require_once 'config.php';
if (!logged_in()) {
    header('Location: '.$app_url);
}

if (isset($_GET['id'])) {
    $token = new RecruitingToken(escape_string($_GET['id']), 'long_id');
    $token_images = RecruitingTokenImage::getTokenImages($token->id);
    $token_videos = RecruitingTokenVideo::getTokenVideos($token->id);
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

define('TITLE', 'GiveToken.com - Create Recruiting Token');
require __DIR__.'/header.php';
?>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/create_recruiting.min.css">

    <!-- Polymer -->
    <script src="components/webcomponentsjs/webcomponents-lite.min.js"></script>

    <link rel="import" href="components/iron-icons/iron-icons.html">
    <link rel="import" href="components/iron-icon/iron-icon.html">
    <link rel="import" href="components/iron-form/iron-form.html">
    <link rel="import" href="components/paper-menu/paper-menu.html">
    <link rel="import" href="components/paper-item/paper-item.html">
    <link rel="import" href="components/paper-icon-button/paper-icon-button.html">
    <link rel="import" href="components/paper-input/paper-input.html">
    <link rel="import" href="components/paper-header-panel/paper-header-panel.html">
    <link rel="import" href="components/paper-toolbar/paper-toolbar.html">
    <link rel="import" href="components/paper-styles/paper-styles.html">
    <link rel="import" href="components/paper-card/paper-card.html">
    <link rel="import" href="components/paper-button/paper-button.html">
    <link rel="import" href="components/paper-input/paper-textarea.html">
    <link rel="import" href="components/paper-dropdown-menu/paper-dropdown-menu.html">
    <link rel="import" href="components/paper-dialog/paper-dialog.html">
    <link rel="import" href="components/paper-fab/paper-fab.html">

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
        #home-icon {
            color: white;
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
<!--    <paper-header-panel class="flex">
        <paper-toolbar>
            <div class="center-column" id="navbar">
                <a id="logo-link" href="<?php echo $app_url; ?>"><img id="nav-logo" src="/assets/img/logo-light.png" height="40" alt="GiveToken"></a>
                <paper-icon-button icon="home" id="home-icon" onclick="window.location = '<?php echo $app_url; ?>'"></paper-icon-button>
            </div>
        </paper-toolbar>
    </paper-header-panel>-->
    <div class="center-column">
        <!--<paper-card id="progress-bar">
                <paper-fab icon="looks one" class="progress-fab">1</paper-fab>
                <span class="progress-text">Fill Out Token Form</span>
                <div class="progress-line"></div>
                <paper-fab icon="looks one" class="progress-fab"></paper-fab>
                <span class="progress-text">Preview Token</span>
                <div class="progress-line"></div>
                <paper-fab icon="looks one" class="progress-fab"></paper-fab>
                <span class="progress-text">Send Token</span>
        </paper-card>-->
        <div id="left-column">
            <form is="iron-form" id="recruiting-token-form">
                <input type="hidden" id="id" name="id" value="<?php echo $token->id ?>">
                <input type="hidden" id="long-id" name="long_id" value="<?php echo $token->long_id ?>">

                <paper-card id="send-token-via" heading="Send Token via">
                    <div id="send-link-list-container">
                        <div class="send-link-container send-link-container-hover">
                            <div class="inner-send-link-container">
                                <div><i class="material-icons send-link-icon">image</i></div>
                                <div class="send-link-text-container">Linked Image</div>
                            </div>
                        </div>
                        <div class="send-link-container send-link-container-hover">
                            <div class="inner-send-link-container">
                                <i class="material-icons send-link-icon">insert_link</i>
                                <div class="send-link-text-container">Link</div>
                            </div>
                        </div>
                        <div class="send-link-container send-link-container-hover">
                            <div class="inner-send-link-container">
                                <i class="material-icons send-link-icon">email</i>
                                <div class="send-link-text-container">Token e-Mail</div>
                            </div>
                        </div>
                    </div>
                    <div id="send-link-content-container">
                        <div class="send-link-content">
                            <p>A linked image has been copied to your clipboard.  Simply go to your email, paste the image in, and send out the email.</p>
                            <p>Certain email providers require an image to be linked separately. All information is provided below.</p>
                        </div>
                        <div class="send-link-content">
                        </div>
                        <div class="send-link-content">
                            <p>Have us email out your Token.  This option will provide you with the greatest analytics and potential for A/B split testing.</p>
                        </div>
                    </div>
                </paper-card>

                <paper-card id="required-info" heading="Required Info">
                    <div class="field-container">
                        <?php
                            paper_text('Job Title', 'job-title', $token->job_title, true);
                            paper_textarea('Job Description', 'job-description', $token->job_description, true);

                            $all_cities = City::getAll();
                            $cities = array();
                            $selected_city = null;
                            foreach ($all_cities as $index => $city) {
                                $cities[$city->id] = $city->name;
                                if ($city->id == $token->city_id) {
                                    $selected_city = $index;
                                }
                            }
                            paper_dropdown('Job Location', 'city-id', $cities, $selected_city, true);
                        ?>
                    </div>
                </paper-card>
                <paper-card id="basic-info" heading="Basic Info">
                    <div class="field-container">
                        <?php paper_textarea('Skills Required', 'skills-required', $token->skills_required); ?>
                        <?php paper_textarea('Responsibilities', 'responsibilities', $token->responsibilities); ?>
                        <?php paper_textarea('Perks', 'perks', $token->perks); ?>
                    </div>
                </paper-card>
                <paper-card id="company-info" heading="Important Company Info">
                    <div class="field-container">
                        <?php paper_text('Company Name', 'company', $token->company); ?>
                        <?php //paper_text('Company TagLine', 'company-tagline', $token->company_tagline); ?>
                        <?php //paper_text('Company Website', 'company-website', $token->company_website); ?>
                        <?php paper_textarea('Company Values', 'company-values', $token->company_values); ?>
                        <?php
                            /*$company_sizes = array('Extra Small', 'Small', 'Medium', 'Large', 'Extra Large');
                            $selected_size = null;
                            if (isset($token->company_size) && $token->company_size) {
                                $selected_size = array_search($token->company_size, $company_sizes);
                            }
                            paper_dropdown('Company Size', 'company-size', $company_sizes, $selected_size);*/
                        ?>
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
                        <div class="thumbnail-list-container" id="company-image-container">
                        <?php
                        foreach ($token_images as $token_image) {
                            if ($google_app_engine) {
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
                        ?>
                        </div>
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
                        ?>
                        </div>
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
                              <?php paper_text('', 'company-facebook', $token->company_facebook); ?>
                            </td>
                          </tr>
                        </table>
                        <table>
                          <tr>
                            <td class="company-social-site-td">
                              https://linkedin.com/
                            </td>
                            <td class="company-social-user-td">
                              <?php paper_text('', 'company-linkedin', $token->company_linkedin); ?>
                            </td>
                          </tr>
                        </table>
                        <table>
                          <tr>
                            <td class="company-social-site-td">
                              https://youtube.com/
                            </td>
                            <td class="company-social-user-td">
                              <?php paper_text('', 'company-youtube', $token->company_youtube); ?>
                            </td>
                          </tr>
                        </table>
                        <table>
                          <tr>
                            <td class="company-social-site-td">
                              https://twitter.com/
                            </td>
                            <td class="company-social-user-td">
                              <?php paper_text('', 'company-twitter', $token->company_twitter); ?>
                            </td>
                          </tr>
                        </table>
                        <table>
                          <tr>
                            <td class="company-social-site-td">
                              https://plus.google.com/
                            </td>
                            <td class="company-social-user-td">
                              <?php paper_text('', 'company-google-plus', $token->company_google_plus); ?>
                            </td>
                          </tr>
                        </table>
                    </div>
                </paper-card>
                <div class="button-container">
                    <paper-button raised class="bottom-button" onclick="saveRecruitingToken(true)">SAVE &amp; PREVIEW</paper-button>
                    <!--<paper-button raised class="bottom-button" onclick="finish()" disabled>FINISH</paper-button>-->
                </div>
            </form>
        </div>
        <!--<div id="right-column">
            <paper-card heading="Token Strength" id="token-strength">
            </paper-card>
            <div class="button-container">
                <paper-button raised onclick="openToken()">OPEN</paper-button>
                <paper-button raised onclick="saveRecruitingToken()">SAVE</paper-button>
            </div>
            <?php if (is_admin()) : ?>
                <paper-card heading="Add To Library" id="add-to-library">
                    <div id="library-button-container">
                        <paper-button class="library-button" raised>Company</paper-button>
                        <paper-button class="library-button" raised>Images</paper-button>
                        <paper-button class="library-button" raised>Video</paper-button>
                    </div>
                </paper-card>
            <?php endif; ?>
       </div>-->
    </div>

    <paper-dialog class="recruiting-dialog" id="open-dialog" modal>
        <h2>Open</h2>
        <form is="iron-form" id="open-token-form">
            <div class="field-container">
            <?php
                $user_tokens = RecruitingToken::getUserTokens($_SESSION['user_id']);
                $tokens = array();
                foreach ($user_tokens as $token) {
                    $tokens[$token->long_id] = $token->company." - ".$token->job_title;
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
