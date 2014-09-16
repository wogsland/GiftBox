<?php
	include_once 'util.php';
	include_once 'config.php';
	if (!logged_in()) {
            header('Location: /giftbox');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Giftbox - Create</title>

	<link rel="stylesheet" href="css/jquery-ui-1.10.4.min.css" />
	<link rel="stylesheet" href="css/magnific-popup.css">
	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="css/create.css" />
	<link rel="stylesheet" href="//vjs.zencdn.net/4.7/video-js.css">
	
	<script src="js/jquery-1.10.2.min.js" type="text/javascript"></script>
	<script src="js/jquery-ui-1.10.4.min.js" type="text/javascript"></script>
	<script src="js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
	<script src="js/jquery.magnific-popup.js"></script>
	<script src="js/id3-minimized.js"></script>
	<script src="js/create.js"></script>
	<script src="//vjs.zencdn.net/4.7/video.js"></script>
	
	<script>
		$(function() {
			$( "#tabs" ).tabs();
		});

		$(function() {
			$( "#status-dialog" ).dialog({ autoOpen: false, dialogClass: "no-close"});
		});
  
		$(function() {
			$( "#letter-dialog" ).dialog({
				autoOpen: false,
				resizable: false,
				width: 800,
				height: 600,
				modal: true,
				buttons: {
					OK: function() {
						save_letter();
					},
					Cancel: function() {
						$( this ).dialog( "close" );
					}
				}
			});
		});
  
		$(function() {
			$("#unload-count").bind("keydown", function (event) {
				event.preventDefault();
			});			
			$( "#unload-count" ).spinner({min: 0, max: 20});
			$( "#wrapper-dialog" ).dialog({
				autoOpen: false,
				resizable: false,
				width: 500,
				height: 250,
				modal: true,
				buttons: {
					OK: function() {
						save_wrapper();
					},
					Cancel: function() {
						$( this ).dialog( "close" );
					}
				}
			});
		});
  
		$(function() {
			$( "#save-dialog" ).dialog({ 
				autoOpen: false,
				resizable: false,
				height:200,
				width: 400,
				modal: true,
				buttons: {
					Save: function() {
						save();
					},
					Cancel: function() {
						$( this ).dialog( "close" );
					}
				},
				open: function() {
					$("#save-dialog").keypress(function(e) {
						if (e.keyCode == $.ui.keyCode.ENTER) {
							save();
							return false;
						}
					});
				}
			});
		});
  
		$(function() {
			$( "#confirm-dialog" ).dialog({
				autoOpen: false,
				resizable: false,
				height:200,
				width: 400,
				modal: true,
				buttons: {
					OK: function() {
						$( this ).dialog( "close" );
					}
				}
			});
		});
	</script>	
</head>
<body id="create-body">
	<div id="content-wrapper">
		<div class="header-wrapper" id="create-header-wrapper">
			<header>
				<h1>
					<a id="create-home-icon" title="Return to the Homepage" href="<?php echo $app_root ?>">Giftbox</a>
				</h1>
				<nav id="create-top-nav">
					<ul>
						<li>
							<a href="<?php echo $app_root ?>">Home</a>
						</li>
					</ul>
				</nav>
			</header>
		</div>
	
		<section id="create-section">
			<div id="palette">
				<div class="palette-box">
					<div class="palette-box-header">
						<span class="palette-box-header-text">Pick A Template</span>
					</div>
					<div class="template-thumbnail">
						<img src="./images/template-thumb-4.jpg" class="thumb-image" onclick="stack('template-1', 'template-2', 'template-3')">
					</div>
					<div class="template-thumbnail">
						<img src="./images/template-thumb-5.jpg" class="thumb-image" onclick="stack('template-2', 'template-3', 'template-1')">
					</div>
					<div class="template-thumbnail">
						<img src="./images/template-thumb-6.jpg" class="thumb-image" onclick="stack('template-3', 'template-1', 'template-2')">
					</div>
				</div>
				<div class="palette-box">
					<div class="palette-box-header">
						<span class="palette-box-header-text">Border Settings</span>
					</div>
				</div>
				<div class="palette-box">
					<div class="palette-box-header">
						<span class="palette-box-header-text">Background Settings</span>
					</div>
				</div>
				<div class="palette-box">
					<div class="palette-box-header">
						<span class="palette-box-header-text">Pick A Wrapper</span>
					</div>
				</div>
			</div>

			<div id="uploads">
				<div id="tabs">
					<ul>
						<li><a class="tab-text" href="#images-tab">Images</a></li>
						<li><a class="tab-text" href="#media-tab">Downloads</a></li>
					</ul>
					<div class="tab-panel" id="images-tab">
						<div class="icon-container" id="images-icon-container">
							<ul class="icon-list">
								<li>
									<img id="select-image" src="images/computer.png">
									<input type="file" multiple id="select-image-file" />
								</li>
							</ul>
						</div>
						<div class="file-drop-zone" id="image-drop-zone">
							<p class="drop-zone-text">Drag and drop image files here</p>
						</div>
					</div>
					<div class="tab-panel" id="media-tab">
						<div class="icon-container" id="media-icon-container">
							<ul class="icon-list">
								<li>
									<img id="select-media" src="images/computer.png">
									<input type="file" multiple id="select-media-file" />
								</li>
							</ul>
						</div>
						<div class="file-drop-zone" id="media-drop-zone">
							<p class="drop-zone-text">Drag and drop music/video files here</p>
						</div>
<!--
						<form class="search-form">
							<input type="text" name="image-search" id="image-search" placeholder="Search" class="text ui-widget-content ui-corner-all search">
						</form>
-->
					</div>
				</div>
			</div>
			
			<div id="templates">
				<div id="template-button-container">
					<a class="template-button" id="letter-button" href="javascript:void(0)" onclick="$('#letter-text').val(window.top_template.letterText); $('#letter-dialog').dialog('open');">Letter</a>
					<a class="template-button" id="wrapper-button" href="javascript:void(0)" onclick="wrapper()">Wrapper</a>
					<a class="template-button" id="save-button" href="javascript:void(0)" onclick="$('#save-name').val(window.top_template.giftboxName); $('#save-dialog').dialog('open');">Save</a>
					<a class="template-button" id="preview-button" href="javascript:void(0)" onclick="preview()">Preview</a>
					<a class="template-button" id="send-button" href="javascript:void(0)" onclick="send()">Send</a>
					<p id="template-status"></p>
				</div>
				<div id="template-container">
					<div class="template" id="template-3">
						<div class="divider-container" id="divider-container-3-1"></div>
						<div class="divider-container" id="divider-container-3-2"></div>
						<div class="divider-container" id="divider-container-3-3"></div>
						<div class="divider-container" id="divider-container-3-4"></div>
						<div class="divider-container" id="divider-container-3-5"></div>
						<div class="bento" id="bento-3-1">
							<div class="image-slider" id="bento-3-1-slider"></div>
							<div class="close-button" id="bento-3-1-close" onclick="closeClicked(this)"></div>
						</div>
						<div class="bento" id="bento-3-2">
							<div class="image-slider" id="bento-3-2-slider"></div>
							<div class="close-button" id="bento-3-2-close" onclick="closeClicked(this)"></div>
						</div>
						<div class="bento" id="bento-3-3">
							<div class="image-slider" id="bento-3-3-slider"></div>
							<div class="close-button" id="bento-3-3-close" onclick="closeClicked(this)"></div>
						</div>
						<div class="bento" id="bento-3-4">
							<div class="image-slider" id="bento-3-4-slider"></div>
							<div class="close-button" id="bento-3-4-close" onclick="closeClicked(this)"></div>
						</div>
						<div class="bento" id="bento-3-5">
							<div class="image-slider" id="bento-3-5-slider"></div>
							<div class="close-button" id="bento-3-5-close" onclick="closeClicked(this)"></div>
						</div>
						<div class="bento" id="bento-3-6">
							<div class="image-slider" id="bento-3-6-slider"></div>
							<div class="close-button" id="bento-3-6-close" onclick="closeClicked(this)"></div>
						</div>
						<div class="divider" id="divider-3-1"></div>
						<div class="divider" id="divider-3-2"></div>
						<div class="divider" id="divider-3-3"></div>
						<div class="divider" id="divider-3-4"></div>
						<div class="divider" id="divider-3-5"></div>
					</div>
					<div class="template" id="template-2">
						<div class="divider-container" id="divider-container-2-1"></div>
						<div class="divider-container" id="divider-container-2-2"></div>
						<div class="divider-container" id="divider-container-2-3"></div>
						<div class="divider-container" id="divider-container-2-4"></div>
						<div class="bento" id="bento-2-1">
							<div class="image-slider" id="bento-2-1-slider"></div>
							<div class="close-button" id="bento-2-1-close" onclick="closeClicked(this)"></div>
						</div>
						<div class="bento" id="bento-2-2">
							<div class="image-slider" id="bento-2-2-slider"></div>
							<div class="close-button" id="bento-2-2-close" onclick="closeClicked(this)"></div>
						</div>
						<div class="bento" id="bento-2-3">
							<div class="image-slider" id="bento-2-3-slider"></div>
							<div class="close-button" id="bento-2-3-close" onclick="closeClicked(this)"></div>
						</div>
						<div class="bento" id="bento-2-4">
							<div class="image-slider" id="bento-2-4-slider"></div>
							<div class="close-button" id="bento-2-4-close" onclick="closeClicked(this)"></div>
						</div>
						<div class="bento" id="bento-2-5">
							<div class="image-slider" id="bento-2-5-slider"></div>
							<div class="close-button" id="bento-2-5-close" onclick="closeClicked(this)"></div>
						</div>
						<div class="divider" id="divider-2-1"></div>
						<div class="divider" id="divider-2-2"></div>
						<div class="divider" id="divider-2-3"></div>
						<div class="divider" id="divider-2-4"></div>
					</div>
					<div class="template" id="template-1">
						<div class="divider-container" id="divider-container-1-1"></div>
						<div class="divider-container" id="divider-container-1-2"></div>
						<div class="divider-container" id="divider-container-1-3"></div>
						<div class="bento" id="bento-1-1">
							<div class="image-slider" id="bento-1-1-slider"></div>
							<div class="close-button" id="bento-1-1-close" onclick="closeClicked(this)"></div>
						</div>
						<div class="bento" id="bento-1-2">
							<div class="image-slider" id="bento-1-2-slider"></div>
							<div class="close-button" id="bento-1-2-close" onclick="closeClicked(this)"></div>
						</div>
						<div class="bento" id="bento-1-3">
							<div class="image-slider" id="bento-1-3-slider"></div>
							<div class="close-button" id="bento-1-3-close" onclick="closeClicked(this)"></div>
						</div>
						<div class="bento" id="bento-1-4">
							<div class="image-slider" id="bento-1-4-slider"></div>
							<div class="close-button" id="bento-1-4-close" onclick="closeClicked(this)"></div>
						</div>
						<div class="divider" id="divider-1-1"></div>
						<div class="divider" id="divider-1-2"></div>
						<div class="divider" id="divider-1-3"></div>
					</div>
				</div>
<!--				<div id="template-downloads-container">  -->
				</div>
			</div>
		</section>
	</div>

	<form id="send-form" class="white-popup mfp-hide" name="send-form">
		<h1 class="dialog-header">Send to:</h1>
		<div id="dialog-form-container">
			<p class="dialog-message" id="send-message"></p>
			<input class="dialog-input" id="email" name="email" type="text" placeholder="Email address" size="30">
			<p>Or, copy this link into an email and send it yourself:</p>
			<input class="dialog-input" id="preview-link" name="preview-link" type="text" size="60" value="" readonly="readonly">
			<a class="dialog-button dialog-button-right" href="javascript:void(0)" onClick="sendGiftbox()">Send</a>
		</div>
	</form>
	
	<div id="status-dialog" title="No title specified">
		<p id="status-text">No status text specified</p>
	</div>
	<div id="confirm-dialog" title="No title specified">
		<p id="confirm-text">No status text specified</p>
	</div>

	<div id="save-dialog" title="Save">
		<form>
		    <fieldset style="margin-top: 25px">
				<label for="save-name">Name</label>
				<input type="text" name="save-name" id="save-name" class="text ui-widget-content ui-corner-all" style="padding: .4em; width: 95%;">
		    </fieldset>
		</form>
	</div>
	
	<div id="letter-dialog" title="Letter">
		<form>
			<textarea rows="29" cols="55" id="letter-text" class="text ui-widget-content ui-corner-all" style="padding: .4em; width: 95%;">
			</textarea>
		</form>
	</div>
	
	<div id="wrapper-dialog" title="Wrapper">
		<form>
			<fieldset style="margin-top: 30px">
				<label for="wrapper-type">Select a wrapper type</label>
				<select name="wrapper-type" id="wrapper-type">
					<option selected="selected" value="">None</option>
					<option value="food-box">Unload Boxes</option>
					<option value="briefcase">Unload Bags</option>
				</select>
				<br><br>
				<label for="unload-count">Number of items to unload</label>
				<input id="unload-count" name="unload-count">
			</fieldset>			
		</form>
	</div>
	
	<script>
		var bentos = document.querySelectorAll('.bento');
		[].forEach.call(bentos, function(bento) {
			bento.addEventListener('dragenter', handleDragEnter, false);
			bento.addEventListener('dragover', handleDragOver, false);
			bento.addEventListener('dragleave', handleDragLeave, false);
			bento.addEventListener('drop', handleDrop, false);
			bento.addEventListener('dragend', handleDragEnd, false);
		});
		
		var dropZone = document.getElementById("image-drop-zone");
		dropZone.addEventListener('dragenter', handleAddImageDragEnter, false);
		dropZone.addEventListener('dragover', handleAddImageDragOver, false);
		dropZone.addEventListener('dragleave', handleAddImageDragLeave, false);
		dropZone.addEventListener('drop', handleAddImageDrop, false);
		dropZone.addEventListener('dragend', handleAddImageDragEnd, false);
		
		dropZone = document.getElementById("media-drop-zone");
		dropZone.addEventListener('dragenter', handleAddImageDragEnter, false);
		dropZone.addEventListener('dragover', handleAddImageDragOver, false);
		dropZone.addEventListener('dragleave', handleAddImageDragLeave, false);
		dropZone.addEventListener('drop', handleAddMediaDrop, false);
		dropZone.addEventListener('dragend', handleAddImageDragEnd, false);
		
		document.getElementById('select-image-file').addEventListener('change', handleImageFileSelect, false);
		document.getElementById('select-media-file').addEventListener('change', handleMediaFileSelect, false);
		
		var template1 = document.getElementById('template-1');
		var template2 = document.getElementById('template-2');
		var template3 = document.getElementById('template-3');
	
		template1.giftboxName = "Untitled-1";
		template1.giftboxId = null;
		template1.letterText = null;
		template1.wrapperType = "";
		template1.unloadCount = 3;
		
		template2.giftboxName = "Untitled-2";
		template2.giftboxId = null;
		template2.letterText = null;
		template2.wrapperType = "";
		template2.unloadCount = 3;

	template3.giftboxName = "Untitled-3";
		template3.giftboxId = null;
		template3.letterText = null;
		template3.wrapperType = "";
		template3.unloadCount = 3;

		window.top_template = template1;
		$("#preview-link").val("");
	</script>
	
</body>
</html>