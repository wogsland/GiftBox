<?php
	include_once 'util.php';
	include_once 'config.php';
	_session_start();
	if (!logged_in()) {
            header('Location: '.$app_url);
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Giftbox - Create</title>

	<link rel="stylesheet" href="assets/elegant-icons/style.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/jquery-ui-1.10.4.min.css" />
	<link rel="stylesheet" href="css/create.css" />
	<link rel="stylesheet" href="css/create_and_preview.css" />
	<link rel="stylesheet" href="//vjs.zencdn.net/4.7/video-js.css">
	
	<script src="js/jquery-1.10.2.min.js" type="text/javascript"></script>
	<script src="js/jquery-ui-1.10.4.min.js" type="text/javascript"></script>
	<script src="js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
	<script src="js/id3-minimized.js"></script>
	<script src="js/util.js"></script>
	<script src="js/create.js"></script>
	<script src="js/init.js"></script>
	<script src="//vjs.zencdn.net/4.7/video.js"></script>
	<script src="//w.soundcloud.com/player/api.js" type="text/javascript"></script>
</head>
<body id="create-body">
	<?php include_once("analyticstracking.php") ?>
	<div id="content-wrapper">
		<section id="create-section">
			<div id="palette">
				<div id="palette-top">
					<a id="create-page-logo" href="javascript:void(0)" onclick=""><i class="arrow_triangle-left_alt2 popout-arrow"></i></a>
				</div>
				<div id="palette-line"></div>
				<div id="palette-body">
					<a href="#"><img id="give-token-palette" src="assets/img/logo-light.png" width="225"></a>
					<a class="sidebar-tab selected-sidebar-tab template-tab-selected" id="template-tab" href="javascript:void(0)" onclick="selectSidebarTab(this)"></a>
					<a class="sidebar-tab sidebar-tab-hover text-tab" id="text-tab" href="javascript:void(0)" onclick="featureNotAvailable('Text')"></a>
					<a class="sidebar-tab sidebar-tab-hover opener-tab" id="opener-tab" href="javascript:void(0)" onclick="featureNotAvailable('Opener')"></a>
					<a class="sidebar-tab sidebar-tab-hover send-tab" id="send-tab" href="javascript:void(0)" onclick="selectSidebarTab(this)"></a>

					<div class="sidebar-tab-container" id="template-tab-container">
						<span class="template-tab-text">PICK A TEMPLATE</span>
						<a class="template-number template-number-selected" id="template-number-all" href="javascript:void(0)" onclick="showTemplates('all')">ALL</a>
						<a class="template-number template-number-hover" id="template-number-2" href="javascript:void(0)" onclick="showTemplates(2)">2</a>
						<a class="template-number template-number-hover" id="template-number-3" href="javascript:void(0)" onclick="showTemplates(3)">3</a>
						<a class="template-number template-number-hover" id="template-number-4" href="javascript:void(0)" onclick="showTemplates(4)">4</a>
						<a class="template-number template-number-hover" id="template-number-5" href="javascript:void(0)" onclick="showTemplates(5)">5</a>
						<a class="template-number template-number-hover" id="template-number-6" href="javascript:void(0)" onclick="showTemplates(6)">6</a>
						<a class="template-number template-number-hover" id="template-number-7" href="javascript:void(0)" onclick="showTemplates(7)">7</a>
						<a class="template-number template-number-hover" id="template-number-8" href="javascript:void(0)" onclick="showTemplates(8)">8</a>
						<a class="template-number template-number-hover" id="template-number-9" href="javascript:void(0)" onclick="showTemplates(9)">9</a>

						<div class="template-thumbnail-container">
							<div class="template-thumbnail template-4" id="template-thumbnail-4" onclick="stack('template-1', 'template-2', 'template-3')">
								<div class="thumb-padded column height100 width33"></div>
								<div class="thumb-padded column height100 width33"></div>
								<div class="thumb-column height100 width33">
									<div class="thumb-padded thumb-column height50 width100"></div>
									<div class="thumb-padded thumb-column height50 width100"></div>
								</div>						
							</div>
							
							<div class="template-thumbnail template-5" id="template-thumbnail-5" onclick="stack('template-2', 'template-3', 'template-1')">
								<div class="thumb-column height100 width50">
									<div class="thumb-padded thumb-column height50 width100"></div>
									<div class="thumb-padded thumb-column height50 width100"></div>
								</div>						
								<div class="thumb-column height100 width50">
									<div class="thumb-padded thumb-column height33 width100"></div>
									<div class="thumb-padded thumb-column height33 width100"></div>
									<div class="thumb-padded thumb-column height33 width100"></div>
								</div>						
							</div>
							
							<div class="template-thumbnail template-6" id="template-thumbnail-6" onclick="stack('template-3', 'template-1', 'template-2')">
								<div class="thumb-column height100 width33">
									<div class="thumb-padded thumb-column height33 width100"></div>
									<div class="thumb-padded thumb-column height66 width100"></div>
								</div>						
								<div class="thumb-column height100 width33">
									<div class="thumb-padded thumb-column height50 width100"></div>
									<div class="thumb-padded thumb-column height50 width100"></div>
								</div>						
								<div class="thumb-column height100 width33">
									<div class="thumb-padded thumb-column height66 width100"></div>
									<div class="thumb-padded thumb-column height33 width100"></div>
								</div>						
							</div>
							

						</div>
					</div>
					<div class="sidebar-tab-container" id="send-tab-container">
						<a href="javascript:void(0)" onclick="featureNotAvailable('Facebook')"><div class="send-button" id="facebook-send-button"></div></a>
						<a href="javascript:void(0)" onclick="featureNotAvailable('Twitter')"><div class="send-button" id="twitter-send-button"></div></a>
						<a href="javascript:void(0)" onclick="featureNotAvailable('Pinterest')"><div class="send-button" id="pinterest-send-button"></div></a>
						<a href="javascript:void(0)" onclick="featureNotAvailable('Instagram')"><div class="send-button" id="instagram-send-button"></div></a>
						<a href="javascript:void(0)" onclick="featureNotAvailable('Google+')"><div class="send-button" id="googleplus-send-button"></div></a>
<!--						<a href="javascript:void(0)" onclick="featureNotAvailable('Send For Corporate')"><div class="palette-button" id="corporate-send"></div></a> -->
						<button class="palette-button" onclick="featureNotAvailable('Send For Corporate')">SEND FOR CORPORATE</button>
						<span class="template-tab-text">LINK</span>
						<input id="send-link-input" type="text"  readonly="readonly">
						<button class="palette-button" onclick="send()">ADVANCED SEND</button>
					</div>
				</div>
			</div>

			<div id="templates">
				<div id="template-nav-container">
					<ul class="template-nav-bar">

	<!--				<a class="template-button" id="letter-button" href="javascript:void(0)" onclick="$('#letter-text').val(window.top_template.letterText); $('#letter-dialog').dialog('open');">Letter</a>
						<a class="template-button" id="wrapper-button" href="javascript:void(0)" onclick="wrapper()">Wrapper</a>
	 -->
						<li><a href="javascript:void(0)" onclick="saveButton()"><i class="fa fa-save fa-lg"></i>SAVE</a></li>
						<li><a href="javascript:void(0)" onclick="preview()"><i class="fa fa-eye fa-lg"></i>PREVIEW</a></li>
						<li><a href="javascript:void(0)" onclick="selectSaved()"><i class="fa fa-folder-open fa-lg"></i>OPEN</a></li>
					</ul>
				</div>
				<div id="template-container">
					<div class="template" id="template-3">
						<div class="divider-container" id="divider-container-3-1"></div>
						<div class="divider-container" id="divider-container-3-2"></div>
						<div class="divider-container" id="divider-container-3-3"></div>
						<div class="divider-container" id="divider-container-3-4"></div>
						<div class="divider-container" id="divider-container-3-5"></div>
						<div id="column-3-1" class="column height100 width33">
							<div id="column-3-4" class="padded column height33 width100">
								<div class="bento" id="bento-3-1">
									<p class="click-to-add">click to add</p>
									<div class="image-slider" id="bento-3-1-slider"></div>
									<div class="close-button" id="bento-3-1-close" onclick="closeClicked(event, this)"></div>
								</div>
							</div>
							<div id="column-3-5" class="padded column height66 width100">
								<div class="bento" id="bento-3-2">
									<p class="click-to-add">click to add</p>
									<div class="image-slider" id="bento-3-2-slider"></div>
									<div class="close-button" id="bento-3-2-close" onclick="closeClicked(event, this)"></div>
								</div>
							</div>
						</div>
						<div id="column-3-2" class="column height100 width33">
							<div id="column-3-6" class="padded column height50 width100">
								<div class="bento" id="bento-3-3">
									<p class="click-to-add">click to add</p>
									<div class="image-slider" id="bento-3-3-slider"></div>
									<div class="close-button" id="bento-3-3-close" onclick="closeClicked(event, this)"></div>
								</div>
							</div>
							<div id="column-3-7" class="padded column height50 width100">
								<div class="bento" id="bento-3-4">
									<p class="click-to-add">click to add</p>
									<div class="image-slider" id="bento-3-4-slider"></div>
									<div class="close-button" id="bento-3-4-close" onclick="closeClicked(event, this)"></div>
								</div>
							</div>
						</div>
						<div id="column-3-3" class="column height100 width33">
							<div id="column-3-8" class="padded column height66 width100">
								<div class="bento" id="bento-3-5">
									<p class="click-to-add">click to add</p>
									<div class="image-slider" id="bento-3-5-slider"></div>
									<div class="close-button" id="bento-3-5-close" onclick="closeClicked(event, this)"></div>
								</div>
							</div>
							<div id="column-3-9" class="padded column height33 width100">
								<div class="bento" id="bento-3-6">
									<p class="click-to-add">click to add</p>
									<div class="image-slider" id="bento-3-6-slider"></div>
									<div class="close-button" id="bento-3-6-close" onclick="closeClicked(event, this)"></div>
								</div>
							</div>
						</div>	
						<div class="vertical divider" id="divider-3-1"></div>
						<div class="vertical divider" id="divider-3-2"></div>
						<div class="horizontal divider" id="divider-3-3"></div>
						<div class="horizontal divider" id="divider-3-4"></div>
						<div class="horizontal divider" id="divider-3-5"></div>
					</div>
					
					<div class="template" id="template-2">
						<div class="divider-container" id="divider-container-2-1"></div>
						<div class="divider-container" id="divider-container-2-2"></div>
						<div class="divider-container" id="divider-container-2-3"></div>
						<div class="divider-container" id="divider-container-2-4"></div>
						<div id="column-2-1" class="column height100 width50">
							<div id="column-2-3" class="padded column height50 width100">
								<div class="bento" id="bento-2-1" onclick="bentoClick(this)">
									<p class="click-to-add">click to add</p>
									<div class="image-slider" id="bento-2-1-slider"></div>
									<div class="close-button" id="bento-2-1-close" onclick="closeClicked(event, this)"></div>
								</div>
							</div>
							<div id="column-2-4" class="padded column height50 width100">
								<div class="bento" id="bento-2-2" onclick="bentoClick(this)">
									<p class="click-to-add">click to add</p>
									<div class="image-slider" id="bento-2-2-slider"></div>
									<div class="close-button" id="bento-2-2-close" onclick="closeClicked(event, this)"></div>
								</div>
							</div>
						</div>
						<div id="column-2-2" class="column height100 width50">
							<div id="column-2-5" class="padded column height33 width100">
								<div class="bento" id="bento-2-3" onclick="bentoClick(this)">
									<p class="click-to-add">click to add</p>
									<div class="image-slider" id="bento-2-3-slider"></div>
									<div class="close-button" id="bento-2-3-close" onclick="closeClicked(event, this)"></div>
								</div>
							</div>
							<div id="column-2-6" class="padded column height33 width100">
								<div class="bento" id="bento-2-4" onclick="bentoClick(this)">
									<p class="click-to-add">click to add</p>
									<div class="image-slider" id="bento-2-4-slider"></div>
									<div class="close-button" id="bento-2-4-close" onclick="closeClicked(event, this)"></div>
								</div>
							</div>
							<div id="column-2-7" class="padded column height33 width100">
								<div class="bento" id="bento-2-5" onclick="bentoClick(this)">
									<p class="click-to-add">click to add</p>
									<div class="image-slider" id="bento-2-5-slider"></div>
									<div class="close-button" id="bento-2-5-close" onclick="closeClicked(event, this)"></div>
								</div>
							</div>
						</div>	
						<div class="vertical divider" id="divider-2-1"></div>
						<div class="horizontal divider" id="divider-2-2"></div>
						<div class="horizontal divider" id="divider-2-3"></div>
						<div class="horizontal divider" id="divider-2-4"></div>
					</div>
					
					<div class="template" id="template-1">
						<div class="divider-container" id="divider-container-1-1"></div>
						<div class="divider-container" id="divider-container-1-2"></div>
						<div class="divider-container" id="divider-container-1-3"></div>
						<div id="column-1-1" class="column padded height100 width33">
							<div class="bento" id="bento-1-1" onclick="bentoClick(this)">
								<p class="click-to-add">click to add</p>
								<div class="image-slider" id="bento-1-1-slider"></div>
								<div class="close-button" id="bento-1-1-close" onclick="closeClicked(event, this)"></div>
							</div>
						</div>
						<div id="column-1-2" class="column padded height100 width33">
							<div class="bento" id="bento-1-2" onclick="bentoClick(this)">
								<p class="click-to-add">click to add</p>
								<div class="image-slider" id="bento-1-2-slider"></div>
								<div class="close-button" id="bento-1-2-close" onclick="closeClicked(event, this)"></div>
							</div>
						</div>
						<div id="column-1-3" class="column height100 width33">
							<div id="column-1-4" class="column padded height50 width100">
								<div class="bento" id="bento-1-3" onclick="bentoClick(this)">
									<p class="click-to-add">click to add</p>
									<div class="image-slider" id="bento-1-3-slider"></div>
									<div class="close-button" id="bento-1-3-close" onclick="closeClicked(event, this)"></div>
								</div>
							</div>
							<div id="column-1-5" class="column padded height50 width100">
								<div class="bento" id="bento-1-4" onclick="bentoClick(this)">
									<p class="click-to-add">click to add</p>
									<div class="image-slider" id="bento-1-4-slider"></div>
									<div class="close-button" id="bento-1-4-close" onclick="closeClicked(event, this)"></div>
								</div>
							</div>
						</div>
						<div class="vertical divider" id="divider-1-1"></div>
						<div class="vertical divider" id="divider-1-2"></div>
						<div class="horizontal divider" id="divider-1-3"></div>
					</div>
				</div>
			</div>
		</section>
	</div>

	<!-- DIALOGS -------------------------------------------------------------------------------------------------------->
	
	<div id="send-dialog" title="Advanced Send">
		<p class="dialog-message" id="send-message"></p>
		<form id="send-form">
		    <fieldset>
				<label class="input-label" for="email">Send to:</label>
				<input class="dialog-input" id="email" name="email" type="text" placeholder="Email address" size="30"><br><br>
				<label class="input-label" for="preview-link">Or, copy this link into an email and send it yourself:</label>
				<input class="dialog-input" id="preview-link" name="preview-link" type="text" size="60" value="" readonly="readonly">
		    </fieldset>
		</form>
	</div>	
	
	<div id="save-dialog" title="Save">
		<form>
		    <fieldset>
				<label class="input-label" for="save-name">Name</label>
				<input type="text" name="save-name" id="save-name" class="text ui-widget-content ui-corner-all" style="padding: .4em; width: 95%;">
		</form>
	</div>

	<div id="url-dialog">
		<form>
		    <fieldset>
				<labe class="input-label"l for="save-name">Paste link address here</label>
				<input type="text" name="url" id="url" class="text ui-widget-content ui-corner-all" style="padding: .4em; width: 95%;">
		    </fieldset>
		</form>
	</div>

	<div id="add-dialog" title="SELECT AN IMAGE TO ADD TO YOUR TOKEN">
		<input class="hidden-file-input" type="file" multiple id="select-image-file" />
		<input class="hidden-file-input" type="file" multiple id="select-media-file" />
		<div id="add-nav-container">
			<ul id="add-nav-bar">
				<li><a class="add-nav-link add-nav-link-hover" id="add-stock" href="javascript:void(0)" onclick="selectAddNav(this)">STOCK LIBRARY</a></li>
				<li><a class="add-nav-link add-nav-link-selected" id="add-images" class="nav-selected" href="javascript:void(0)" onclick="selectAddNav(this)">IMAGES</a></li>
				<li><a class="add-nav-link add-nav-link-hover" id="add-video-audio" href="javascript:void(0)" onclick="selectAddNav(this)">VIDEO & AUDIO</a></li>
				<li><a class="add-nav-link add-nav-link-hover" id="add-letter" href="javascript:void(0)" onclick="selectAddNav(this)">LETTER</a></li>
			</ul>
		</div>
		
			<!------------------ STOCK LIBRARY ------------------------>
			<div id="add-stock-container" class="add-content-container">
				<div class="add-content add-content-no-icons">
				</div>
			</div>
			
			<!--------------------- IMAGES ---------------------------->
			<div id="add-images-container" class="add-content-container">
				<div class="add-content-icon-bar">
					<div class="add-icon-container">
						<a class="add-images-icon-link" href="javascript:void(0)" onclick="featureNotAvailable('Facebook Images')"><i class="fa fa-facebook fa-3x add-images-icon"></i></a>
						<a class="add-images-icon-link" href="javascript:void(0)" onclick="featureNotAvailable('Flickr Images')"><i class="fa fa-flickr fa-3x add-images-icon"></i></a>
						<a class="add-images-icon-link" href="javascript:void(0)" onclick="featureNotAvailable('Dropbox Images')"><i class="fa fa-dropbox fa-3x add-images-icon"></i></a>
						<a class="add-images-icon-link" id="desktop-icon-link" href="javascript:void(0)" onclick="$('#select-image-file').trigger('click')"><i class="fa fa-desktop fa-3x add-images-icon"></i></a>
					</div>
				</div>
				<div class="add-content">
					<div id="add-images-desktop">
					</div>
				</div>
			</div>

			<!--------------------- VIDEO & AUDIO --------------------->
			<div id="add-video-audio-container" class="add-content-container">
				<div class="add-content-icon-bar">
					<div class="add-icon-container">
						<a class="add-images-icon-link" href="javascript:void(0)" onclick=""><i class="fa fa-youtube fa-3x add-images-icon"></i></a>
						<a class="add-images-icon-link" href="javascript:void(0)" onclick="featureNotAvailable('Vimeo Video')"><i class="fa fa-vimeo-square fa-3x add-images-icon"></i></a>
						<a class="add-images-icon-link" href="javascript:void(0)" onclick=""><i class="fa fa-soundcloud fa-3x add-images-icon"></i></a>
						<a class="add-images-icon-link" href="javascript:void(0)" onclick=""><i class="fa fa-spotify fa-3x add-images-icon"></i></a>
						<a class="add-images-icon-link" href="javascript:void(0)" onclick="featureNotAvailable('Dropbox Video/Audio')"><i class="fa fa-dropbox fa-3x add-images-icon"></i></a>
						<a class="add-images-icon-link" id="desktop-icon-link" href="javascript:void(0)" onclick="$('#select-media-file').trigger('click')"><i class="fa fa-desktop fa-3x add-images-icon"></i></a>
					</div>
				</div>
				<div class="add-content">
					<div id="add-av-youtube">
					</div>
					<div id="add-av-soundcloud">
					</div>
					<div id="add-av-desktop">
					</div>
					<div id="add-av-spotify">
					</div>
				</div>
			</div>

			<!------------------------ LETTER ------------------------->
			<div id="add-letter-container" class="add-content-container">
				<form id="letter-form">
					<textarea id="letter-text">
					</textarea>
				</form>
			</div>
			
		<div id="add-button-container">
			<a class="add-button" href="javascript:void(0)" onclick="$('#add-dialog').dialog('close')">CANCEL</a>
			<a class="add-button" href="javascript:void(0)" onclick="doAdd()">USE</a>
		</div>
	</div>
	
	<div id="wrapper-dialog" title="Wrapper">
		<form>
			<fieldset>
				<label class="input-label" for="wrapper-type">Select a wrapper type</label>
				<select name="wrapper-type" id="wrapper-type">
					<option selected="selected" value="">None</option>
					<option value="food-box">Unload Boxes</option>
					<option value="briefcase">Unload Bags</option>
				</select>
				<br><br>
				<label class="input-label" for="unload-count">Number of items to unload</label>
				<input id="unload-count" name="unload-count">
			</fieldset>			
		</form>
	</div>

	<div id="open-dialog" title="Open">
		<fieldset>
			<label class="input-label" for="token-list">Select a Token to open:</label>
			<select id="token-list" name="token-list" size="9" style="margin: auto"></select>
		</fieldset>			
	</div>

	<script>
		document.getElementById('select-image-file').addEventListener('change', handleImageFileSelect, false);
		document.getElementById('select-media-file').addEventListener('change', handleMediaFileSelect, false);
		
		var template1 = document.getElementById('template-1');
		var template2 = document.getElementById('template-2');
		var template3 = document.getElementById('template-3');
	
		template1.giftboxName = "Untitled";
		template1.giftboxId = null;
		template1.letterText = null;
		template1.wrapperType = "";
		template1.unloadCount = 3;
		
		template2.giftboxName = "Untitled";
		template2.giftboxId = null;
		template2.letterText = null;
		template2.wrapperType = "";
		template2.unloadCount = 3;

		template3.giftboxName = "Untitled";
		template3.giftboxId = null;
		template3.letterText = null;
		template3.wrapperType = "";
		template3.unloadCount = 3;

		window.top_template = template1;
		$("#preview-link").val("");
	</script>
	
</body>
</html>