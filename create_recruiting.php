<?php
require_once  __DIR__.'/util.php';
_session_start();

if (!logged_in()) {
    header('Location: /');
}

function paper_text($label, $id, $icon = NULL, $suffix = NULL) {
    echo PHP_EOL;
    echo '              <paper-input label="'.$label.'" id="'.$id.'" name="'.str_replace('-', '_', $id).'">'.PHP_EOL;
    echo '                  <iron-icon icon="'.$icon.'" prefix></iron-icon>'.PHP_EOL;
    if ($suffix) {
        echo '<paper-icon-button suffix onclick="" icon="'.$suffix.'" alt="clear" title="clear" tabindex="0">';
    }
    echo '              </paper-input>'.PHP_EOL;
}
function paper_textarea($label, $id, $icon = NULL) {
    echo PHP_EOL;
    echo '              <paper-textarea label="'.$label.'" id="'.$id.'" name="'.str_replace('-', '_', $id).'" rows="1">'.PHP_EOL;
    echo '              </paper-textarea>'.PHP_EOL;
}
function file_input($label, $id) {
    echo PHP_EOL;
    echo '			<div class="form-group form-group-lg">'.PHP_EOL;
    echo '				<label for="'.$id.'-input" class="col-sm-4 control-label">'.$label.'</label>'.PHP_EOL;
    echo '				<div class="col-sm-4">'.PHP_EOL;
    echo '					<input type="hidden" id="'.$id.'" name="'.str_replace('-', '_', $id).'" value="">'.PHP_EOL;
    echo '					<input type="file" id="'.$id.'-input" name="'.str_replace('-', '_', $id).'_input">'.PHP_EOL;
    echo '				</div>'.PHP_EOL;
    echo '				<div class="col-sm-4">'.PHP_EOL;
    echo '					<img id="'.$id.'-img"  src="" alt="No '.$label.' Selected" height="100" width="100">'.PHP_EOL;
    echo '					<button  type="button" class="btn btn-default btn-sm" onclick="clearImage(\''.$id.'\')">Clear Image</button>'.PHP_EOL;
    echo '				</div>'.PHP_EOL;
    echo '			</div>'.PHP_EOL;
}
function paper_file($label, $id) {
    echo PHP_EOL;
    echo '					<input type="hidden" id="'.$id.'" name="'.str_replace('-', '_', $id).'" value="">'.PHP_EOL;
    echo '					<paper-input label="'.$label.'" type="file" placeholder="Choose a file" id="'.$id.'-input" name="'.str_replace('-', '_', $id).'_input">'.PHP_EOL;
    echo '					<img id="'.$id.'-img"  src="" alt="No '.$label.' Selected" height="100" width="100">'.PHP_EOL;
    echo '					<button  type="button" class="btn btn-default btn-sm" onclick="clearImage(\''.$id.'\')">Clear Image</button>'.PHP_EOL;
}
function paper_dropdown($label, $id, $options, $icon = NULL) {
    echo '			<paper-dropdown-menu class="recruiting-field" label="'.$label.'" id="'.$id.'" name="'.str_replace('-', '_', $id).'">'.PHP_EOL;
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
	<link rel="stylesheet" href="css/create_recruiting.css">

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
            width: 100px;
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
        }
        #token-strength {
            width: 100%;
            height: 300px;
        }
    </style>

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

</head>
<body>
    <paper-header-panel mode="waterfall" class="flex">
        <paper-toolbar>
            <a href="/"><img src="/assets/img/logo-light.png" height="40" alt="GiveToken"></a>
            <span class="title"> </span>
            <paper-icon-button icon="home" id="home-icon" onclick="window.location = '/'"></paper-icon-button>
        </paper-toolbar>
    </paper-header-panel>
    <div id="center-column">
        <paper-card id="progress-bar"></paper-card>
        <div id="left-column">
            <form is="iron-form" id="recruiting-token-form">
                <input type="hidden" id="id" name="id" value="<?php echo (isset($_GET['id']) ? $_GET['id'] : null); ?>">

                <?php paper_card('Required Info'); ?>
                    <div class="field-container">
                        <?php paper_text('Job Title', 'job-title', 'label'); ?>
                        <?php paper_textarea('Job Description', 'job-description', 'description'); ?>
                        <?php $cities = array(1 => 'Nashville', 2 => 'Miami', 3 => 'Tallahassee'); ?>
                        <?php paper_dropdown('Job Location', 'city-id', $cities, 'room'); ?>
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
                        <?php paper_text('Company Video (paste YouTube or Vimeo link or select from library)', 'company-video', 'videocam', 'add to photos'); ?>
                        <?php paper_text('Company Values', 'company-values'); ?>
                        <?php $sizes = array(0 => 'Extra Small', 1 => 'Small', 2 => 'Medium', 3 => 'Large', 4 => 'Extra Large'); ?>
                        <?php paper_dropdown('Company Size', 'company-size', $sizes); ?>
                        <?php paper_file('Company Images', 'company-picture'); ?>
                    </div>
                <?php paper_card_end(); ?>

                <?php paper_card('Company Social Media'); ?>
                    <div class="field-container">
                        <?php paper_text('Facebook', 'company-facebook'); ?>
                        <?php paper_text('LinkedIn', 'company-linkedin'); ?>
                        <?php paper_text('Youtube Channel', 'company-youtube'); ?>
                        <?php paper_text('Twitter', 'company-twitter'); ?>
                        <?php paper_text('Google+', 'company-twitter'); ?>
                    </div>
                <?php paper_card_end(); ?>
                <div class="button-container">
                    <paper-button raised>PREVIEW</paper-button>
                    <paper-button raised>FINISH</paper-button>
                </div>
            </form>
        </div>
        <div id="right-column">
            <paper-card heading="Token Strength" id="token-strength">
            </paper-card>
            <div class="button-container">
                <paper-button raised>OPEN</paper-button>
                <paper-button raised onclick="saveRecruitingToken()">SAVE</paper-button>
            </div>
            <?php if (is_admin()): ?>
                <paper-card heading="Add To Library" id="add-to-library">
                    <div id="library-button-container">
                        <paper-button class="library-button" raised><iron-icon icon="domain"></iron-icon> Company</paper-button>
                        <paper-button class="library-button" raised><iron-icon icon="image"></iron-icon> Images</paper-button>
                        <paper-button class="library-button" raised><iron-icon icon="videocam"></iron-icon> Video</paper-button>
                    </div>
                </paper-card>
            <?php endif; ?>
       </div>
    </div>
    <!-- JavaScript -->
	<script src="js/create_recruiting.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script>
		$('#company-picture-input').on('change', handleImageFileSelect);
		$('#company-picture-img').data("saved", true);
		$('#backdrop-picture-img').data("saved", true);
	</script>
</body>
</html>
