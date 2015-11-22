<?php
use GiveToken\City;

require_once 'config.php';
if (!logged_in() || !is_admin()) {
    header('Location: '.$app_url);
}

function paper_text($label, $id) {
    echo PHP_EOL;
    echo '              <paper-input label="'.$label.'" id="'.$id.'" name="'.str_replace('-', '_', $id).'">'.PHP_EOL;
    echo '              </paper-input>'.PHP_EOL;
}
function paper_textarea($label, $id, $icon = NULL) {
    echo PHP_EOL;
    echo '              <paper-textarea label="'.$label.'" id="'.$id.'" name="'.str_replace('-', '_', $id).'" rows="1">'.PHP_EOL;
    echo '              </paper-textarea>'.PHP_EOL;
}
function paper_dropdown($label, $id, $options, $required = false) {
    echo '			<paper-dropdown-menu '.($required ? 'required' : null).' class="recruiting-field" label="'.$label.'" id="'.$id.'" name="'.str_replace('-', '_', $id).'">'.PHP_EOL;
    echo '				<paper-menu class="dropdown-content">'.PHP_EOL;
    foreach ($options as $value => $option) {
        echo '  				<paper-item value="'.$value.'">'.ucwords($option).'</paper-item>'.PHP_EOL;
    }
    echo '				</paper-menu>'.PHP_EOL;
    echo '			</paper-dropdown-menu>'.PHP_EOL;
}
function paper_card($title) {
    echo '<paper-card heading="'.$title.'">'.PHP_EOL;
}
function paper_card_end() {
    echo '</paper-card>'.PHP_EOL;
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>GiveToken.com - Create Recruiting Token</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/create_recruiting.css">

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
        paper-card {
            display: block;
            width: 100%;
            background: #424242;
            margin-top: 20px;
            --paper-card-header-color: white;
            --paper-card-header-text: {font-weight: normal;}
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
    </style>

</head>
<body>
    <paper-header-panel class="flex">
        <paper-toolbar>
            <div class="center-column" id="navbar">
                <a id="logo-link" href="<?php echo $app_url; ?>"><img id="nav-logo" src="/assets/img/logo-light.png" height="40" alt="GiveToken"></a>
                <paper-icon-button icon="home" id="home-icon" onclick="window.location = '<?php echo $app_url; ?>'"></paper-icon-button>
            </div>
        </paper-toolbar>
    </paper-header-panel>
    <div class="center-column">
        <paper-card id="progress-bar">
                <paper-fab icon="looks one" class="progress-fab">1</paper-fab>
                <span class="progress-text">Fill Out Token Form</span>
                <div class="progress-line"></div>
                <paper-fab icon="looks one" class="progress-fab"></paper-fab>
                <span class="progress-text">Preview Token</span>
                <div class="progress-line"></div>
                <paper-fab icon="looks one" class="progress-fab"></paper-fab>
                <span class="progress-text">Send Token</span>
        </paper-card>
        <div id="left-column">
            <form is="iron-form" id="recruiting-token-form">
                <input type="hidden" id="id" name="id" value="">
                <input type="hidden" id="long-id" name="long_id" value="<?php echo (isset($_GET['id']) ? $_GET['id'] : null); ?>">

                <?php paper_card('Required Info'); ?>
                    <div class="field-container">
                        <paper-input autofocus label="Job Title" id="job-title" name="job_title" required auto-validate error-message="This is a required field"></paper-input>
                        <paper-input label="Job Description" id="job-description" name="job_description" required auto-validate error-message="This is a required field"></paper-input>
                        <?php
                            $all_cities = City::getAll();
                            $cities = array();
                            foreach($all_cities as $city) {
                                $cities[$city->id] = $city->name;
                            }
                            paper_dropdown('Job Location', 'city-id', $cities, true);
                        ?>
                    </div>
                <?php paper_card_end(); ?>
                <?php paper_card('Basic Info'); ?>
                    <div class="field-container">
                        <?php paper_textarea('Skills Required (copy and paste from word doc)', 'skills-required'); ?>
                        <?php paper_textarea('Responsibilities (copy and paste from word doc)', 'responsibilities'); ?>
                        <?php paper_textarea('Perks (copy and paste from word doc)', 'perks'); ?>
                    </div>
                <?php paper_card_end(); ?>
                <?php paper_card('Important Company Info'); ?>
                    <div class="field-container">
                        <?php paper_text('Company Name', 'company', 'domain'); ?>
                        <?php paper_text('Company TagLine', 'company-tagline', 'local offer'); ?>
                        <?php paper_text('Company Website', 'company-website', 'http'); ?>
                        <?php paper_text('Company Values', 'company-values'); ?>
                        <?php $sizes = array(0 => 'Extra Small', 1 => 'Small', 2 => 'Medium', 3 => 'Large', 4 => 'Extra Large'); ?>
                        <?php paper_dropdown('Company Size', 'company-size', $sizes); ?>
                    </div>
                <?php paper_card_end(); ?>
                <?php paper_card('Company Images'); ?>
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
                        </div>
                    </div>
                <?php paper_card_end(); ?>
                <?php paper_card('Company Videos'); ?>
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
                        </div>
                    </div>
                <?php paper_card_end(); ?>
                <?php paper_card('Company Social Media'); ?>
                    <div class="field-container">
                        <?php paper_text('Facebook', 'company-facebook'); ?>
                        <?php paper_text('LinkedIn', 'company-linkedin'); ?>
                        <?php paper_text('Youtube Channel', 'company-youtube'); ?>
                        <?php paper_text('Twitter', 'company-twitter'); ?>
                        <?php paper_text('Google+', 'company-google-plus'); ?>
                    </div>
                <?php paper_card_end(); ?>
                <div class="button-container">
                    <paper-button raised class="bottom-button" onclick="saveRecruitingToken(true)">PREVIEW</paper-button>
                    <paper-button raised class="bottom-button">FINISH</paper-button>
                </div>
            </form>
        </div><div id="right-column">
            <paper-card heading="Token Strength" id="token-strength">
            </paper-card>
            <div class="button-container">
                <paper-button raised>OPEN</paper-button>
                <paper-button raised onclick="saveRecruitingToken()">SAVE</paper-button>
            </div>
            <?php if (is_admin()): ?>
                <paper-card heading="Add To Library" id="add-to-library">
                    <div id="library-button-container">
                        <paper-button class="library-button" raised>Company</paper-button>
                        <paper-button class="library-button" raised>Images</paper-button>
                        <paper-button class="library-button" raised>Video</paper-button>
                    </div>
                </paper-card>
            <?php endif; ?>
       </div>
    </div>

    <paper-dialog class="recruiting-dialog" id="video-dialog" modal>
        <h2>Upload video from web address</h2>
        <paper-input id="video-dialog-url" label="Paste video URL here" patter="^https:\/\/youtube.com|https:\/\/youtu.be|https:\/\/vimeo.com" error-message="Not a valid video URL!" autofocus></paper-input>
        <div class="buttons">
            <paper-button class="dialog-button" onclick="processVideoURL()">Add</paper-button>
            <paper-button dialog-dismiss class="dialog-button">Cancel</paper-button>
        </div>
    </paper-dialog>

    <paper-dialog class="recruiting-dialog" id="validation-dialog" modal>
        <h2>Problem...</h2>
        <p id="validation-message">No message supplied</p>
        <div class="buttons">
            <paper-button dialog-dismiss class="dialog-button" id="validation-button">OK</paper-button>
        </div>
    </paper-dialog>


    <!-- JavaScript -->
	<script src="js/create_common.js"></script>
	<script src="js/create_recruiting.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script>
		$('#select-image-file').on('change', handleImageFileSelect);
        $('#company-image-container').data('deleted', []);
        $('#company-video-container').data('deleted', []);
	</script>
</body>
</html>
