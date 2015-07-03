<?php
	include_once 'Token.class.php';
	include_once 'config.php';
	use google\appengine\api\cloud_storage\CloudStorageTools;
	if ($google_app_engine) {
		include_once 'google/appengine/api/cloud_storage/CloudStorageTools.php';
	}

	$token = new Token($_GET['id']);

	if ($google_app_engine) {
		$token->image_path = CloudStorageTools::getPublicUrl($file_storage_path.$token->thumbnail_name, $use_https);
	} else {
		$token->image_path = $file_storage_path.$token->thumbnail_name;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />

	<title><?php echo $token->name ?></title>
	<meta name="og:title" property="og:title" content= <?php echo '"'.$token->name.'"' ?> />
	<meta name="og:site_name" property="og:site_name" content="Givetoken"/>
	<meta name="og:url" property="og:url" content=<?php echo '"'."http://".$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI].'"' ?> />
	<meta name="og:description" property="og:description" content=<?php echo '"'.$token->description.'"'?>/>
	<meta name="fb:app_id" property="fb:app_id" content="1498055593756885" />
	<meta name="og:type" property="og:type" content="article" />
	<meta name="og:image" property="og:image" content=<?php echo $token->image_path; ?>
	
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/preview.css" />
	<link rel="stylesheet" href="css/create_and_preview.css" />
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="//vjs.zencdn.net/4.11/video-js.css">
	<link rel="stylesheet" href="css/colorbox.css" />
	<script src="js/jquery-1.10.2.min.js" type="text/javascript"></script>
	<script src="js/jquery.colorbox-min.js"></script>
	<script src="//vjs.zencdn.net/4.11/video.js"></script>
	<script src="js/preview.js"></script>

	<!-- CUSTOM STYLESHEETS -->
	<script src="js/preloader.js"></script>

	<!-- Favicon -->
	<link rel="apple-touch-icon" sizes="57x57" href="assets/gt-favicons.ico/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="assets/gt-favicons.ico/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="assets/gt-favicons.ico/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="assets/gt-favicons.ico/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="assets/gt-favicons.ico/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="assets/gt-favicons.ico/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="assets/gt-favicons.ico/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="assets/gt-favicons.ico/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="assets/gt-favicons.ico/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="assets/gt-favicons.ico/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="assets/gt-favicons.ico/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/gt-favicons.ico/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="assets/gt-favicons.ico/favicon-16x16.png">
	<link rel="manifest" href="assets/gt-favicons.ico/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
	<!-- endFavicon -->
</head>
<body>
	<?php include_once("analyticstracking.php"); ?>
	<!-- =========================
	     PRE LOADER       
	============================== -->
	<div class="preloader">
	  <div class="status">&nbsp;</div>
	</div>
	<div class="shrink-box shake">
		<div class="envelope">

		<!-- Generator: Adobe Illustrator 19.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
		<svg id="base" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
			 viewBox="0 0 1260 890" style="enable-background:new 0 0 1260 890;" xml:space="preserve">
		<style type="text/css">
			.st0{fill:url(#SVGID_1_);stroke:#7B99B2;stroke-width:2;stroke-miterlimit:10;}
			.st1{fill:url(#SVGID_2_);stroke:#7B99B2;stroke-width:2;stroke-miterlimit:10;}
			.st2{fill:url(#SVGID_3_);stroke:#7B99B2;stroke-width:4;stroke-miterlimit:10;}
			.st3{fill:url(#SVGID_4_);}
			.st4{fill:#78D070;}
			.st5{fill:none;stroke:url(#SVGID_5_);stroke-miterlimit:10;}
			.st6{fill:none;stroke:url(#SVGID_6_);stroke-miterlimit:10;}
			.st7{fill:none;stroke:url(#SVGID_7_);stroke-miterlimit:10;}
			.st8{fill:none;stroke:url(#SVGID_8_);stroke-miterlimit:10;}
			.st9{fill:#78D070;stroke:url(#SVGID_9_);stroke-miterlimit:10;}
		</style>
		<linearGradient id="SVGID_1_" gradientUnits="userSpaceOnUse" x1="257.2321" y1="702.4414" x2="-222.3954" y2="222.8139">
			<stop  offset="0" style="stop-color:#55708F"/>
			<stop  offset="1" style="stop-color:#698AA6"/>
		</linearGradient>
		<polygon class="st0" points="0,0.4 0,890 439.4,520.3 "/>
		<linearGradient id="SVGID_2_" gradientUnits="userSpaceOnUse" x1="1463.764" y1="686.2359" x2="1018.9733" y2="241.4452">
			<stop  offset="0" style="stop-color:#55708F"/>
			<stop  offset="1" style="stop-color:#698AA6"/>
		</linearGradient>
		<polygon class="st1" points="823.8,528.3 1260,890 1260,0.4 "/>
		<linearGradient id="SVGID_3_" gradientUnits="userSpaceOnUse" x1="471.5" y1="1162.798" x2="838.5178" y2="527.1046">
			<stop  offset="0" style="stop-color:#55708F"/>
			<stop  offset="1" style="stop-color:#698AA6"/>
		</linearGradient>
		<path class="st2" d="M-1,890h1260L785.6,496.6c-30.4-20.3-283.3-21.4-312.5-0.9C292.3,623.4,179.9,762.3-1,890z"/>
		<g id="XMLID_1_">
			<g>
			</g>
			<g>
			</g>
		</g>
		<linearGradient id="SVGID_4_" gradientUnits="userSpaceOnUse" x1="1028.7369" y1="727.8586" x2="1446.7035" y2="130.9405">
			<stop  offset="0" style="stop-color:#000000;stop-opacity:0.15"/>
			<stop  offset="6.274092e-02" style="stop-color:#161E24;stop-opacity:0.1406"/>
			<stop  offset="0.1376" style="stop-color:#2C3A46;stop-opacity:0.1294"/>
			<stop  offset="0.2202" style="stop-color:#3F5364;stop-opacity:0.117"/>
			<stop  offset="0.3108" style="stop-color:#4F677C;stop-opacity:0.1034"/>
			<stop  offset="0.4127" style="stop-color:#5A778F;stop-opacity:8.809577e-02"/>
			<stop  offset="0.5325" style="stop-color:#63829C;stop-opacity:7.012378e-02"/>
			<stop  offset="0.687" style="stop-color:#6888A4;stop-opacity:4.694376e-02"/>
			<stop  offset="1" style="stop-color:#698AA6;stop-opacity:0"/>
		</linearGradient>
		<polygon class="st3" points="823.8,528.3 1260,889.8 1260,0.2 "/>
		<g>
			<g id="XMLID_2_">
				<g>
					<path class="st4" d="M822.7-328L1260,0.4L0,0.5l435-326.7c60.8,0.3,121.5,3.5,182.2,4.9c29.6,0.7,59.5,1.5,89.1,0
						c26.1-1.3,52-4,78.1-5.5C797.1-327.6,809.9-328.1,822.7-328z"/>
				</g>
				<g>
					<linearGradient id="SVGID_5_" gradientUnits="userSpaceOnUse" x1="-0.3003" y1="-162.8771" x2="435.3503" y2="-162.8771">
						<stop  offset="0" style="stop-color:#1500A4;stop-opacity:0.15"/>
						<stop  offset="9.454441e-02" style="stop-color:#170091;stop-opacity:0.1358"/>
						<stop  offset="0.2277" style="stop-color:#1A007F;stop-opacity:0.1158"/>
						<stop  offset="0.3852" style="stop-color:#1C0072;stop-opacity:9.221923e-02"/>
						<stop  offset="0.5884" style="stop-color:#1D006A;stop-opacity:6.174141e-02"/>
						<stop  offset="1" style="stop-color:#1D0068;stop-opacity:0"/>
					</linearGradient>
					<line class="st5" x1="0" y1="0.5" x2="435" y2="-326.3"/>
					<linearGradient id="SVGID_6_" gradientUnits="userSpaceOnUse" x1="822.3798" y1="-163.8264" x2="1260.3002" y2="-163.8264">
						<stop  offset="0" style="stop-color:#1500A4;stop-opacity:0.15"/>
						<stop  offset="9.454441e-02" style="stop-color:#170091;stop-opacity:0.1358"/>
						<stop  offset="0.2277" style="stop-color:#1A007F;stop-opacity:0.1158"/>
						<stop  offset="0.3852" style="stop-color:#1C0072;stop-opacity:9.221923e-02"/>
						<stop  offset="0.5884" style="stop-color:#1D006A;stop-opacity:6.174141e-02"/>
						<stop  offset="1" style="stop-color:#1D0068;stop-opacity:0"/>
					</linearGradient>
					<line class="st6" x1="822.7" y1="-328" x2="1260" y2="0.4"/>
					<linearGradient id="SVGID_7_" gradientUnits="userSpaceOnUse" x1="-5.650432e-05" y1="0.4249" x2="1260" y2="0.4249">
						<stop  offset="0" style="stop-color:#1500A4;stop-opacity:0.15"/>
						<stop  offset="9.454441e-02" style="stop-color:#170091;stop-opacity:0.1358"/>
						<stop  offset="0.2277" style="stop-color:#1A007F;stop-opacity:0.1158"/>
						<stop  offset="0.3852" style="stop-color:#1C0072;stop-opacity:9.221923e-02"/>
						<stop  offset="0.5884" style="stop-color:#1D006A;stop-opacity:6.174141e-02"/>
						<stop  offset="1" style="stop-color:#1D0068;stop-opacity:0"/>
					</linearGradient>
					<line class="st7" x1="1260" y1="0.4" x2="0" y2="0.5"/>
					<linearGradient id="SVGID_8_" gradientUnits="userSpaceOnUse" x1="435.0475" y1="-324.2614" x2="822.684" y2="-324.2614">
						<stop  offset="0" style="stop-color:#1500A4;stop-opacity:0.15"/>
						<stop  offset="9.454441e-02" style="stop-color:#170091;stop-opacity:0.1358"/>
						<stop  offset="0.2277" style="stop-color:#1A007F;stop-opacity:0.1158"/>
						<stop  offset="0.3852" style="stop-color:#1C0072;stop-opacity:9.221923e-02"/>
						<stop  offset="0.5884" style="stop-color:#1D006A;stop-opacity:6.174141e-02"/>
						<stop  offset="1" style="stop-color:#1D0068;stop-opacity:0"/>
					</linearGradient>
					<path class="st8" d="M435-326.3c60.8,0.3,121.5,3.5,182.2,4.9c29.6,0.7,59.5,1.5,89.1,0c26.1-1.3,52-4,78.1-5.5
						c12.7-0.7,25.5-1.2,38.3-1.1"/>
				</g>
			</g>
			<linearGradient id="SVGID_9_" gradientUnits="userSpaceOnUse" x1="426.665" y1="-356.1345" x2="833.3433" y2="-356.1345">
				<stop  offset="0" style="stop-color:#1500A4;stop-opacity:0.15"/>
				<stop  offset="9.454441e-02" style="stop-color:#170091;stop-opacity:0.1358"/>
				<stop  offset="0.2277" style="stop-color:#1A007F;stop-opacity:0.1158"/>
				<stop  offset="0.3852" style="stop-color:#1C0072;stop-opacity:9.221923e-02"/>
				<stop  offset="0.5884" style="stop-color:#1D006A;stop-opacity:6.174141e-02"/>
				<stop  offset="1" style="stop-color:#1D0068;stop-opacity:0"/>
			</linearGradient>
			<path class="st9" d="M427-319.9c102-92.1,299.5-100.6,406,0"/>
		</g>
		</svg>
		</div> <!--  END ENVELOPE -->
		<div class="opener">
			<!-- Generator: Adobe Illustrator 19.0.0, SVG Export Plug-In  -->
			<svg id="top" version="1.1"
				 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/"
				 x="0px" y="0px" width="1268.7px" height="626px" viewBox="0 0 1268.7 626" style="enable-background:new 0 0 1268.7 626;"
				 xml:space="preserve">
			<style type="text/css">
				.st0{fill:url(#SVGID_1_);stroke:#6C9BB6;stroke-width:4;stroke-miterlimit:10;}
				.st1{fill:url(#SVGID_2_);stroke:#6C9BB6;stroke-width:4;stroke-miterlimit:10;}
			</style>
			<defs>
			</defs>
			<linearGradient id="SVGID_1_" gradientUnits="userSpaceOnUse" x1="477.0969" y1="1645.6335" x2="933.0829" y2="855.8427" gradientTransform="matrix(1 0 0 -1 0 1374.8356)">
				<stop  offset="0" style="stop-color:#447193"/>
				<stop  offset="1" style="stop-color:#578CAA"/>
			</linearGradient>
			<path class="st0" d="M4.6,2h1260L791.2,600c-30.4,30.9-283.3,32.6-312.5,1.4C297.9,407.2,185.5,196.1,4.6,2z"/>
			</svg>
		</div>
		<?php
		echo '<div id="triggerTab"></div>';
		echo '<div class="giftbox panel" id="flip-container">';
		echo '<div class="front">';
		echo ($token->letter_text || $token->attachments)  ? '<a class="flip-over flip-tab" id="view-letter" href="javascript:void(0);">View Letter</a>'.PHP_EOL : NULL;

		$token->render();

		echo "</div>";
		echo '<div class="back">';
		echo ($token->letter_text || $token->attachments) ? '<a class="flip-back flip-tab" id="close-letter" href="javascript:void(0);">View Token</a>'.PHP_EOL : NULL;

		echo '<div id="letter-text-container">';
		echo '<div id="letter-text">';
		echo '<p>'.($token->letter_text).'</p>';
		echo '<p id="letter-attachments">';
		foreach ($token->attachments as $attachment) {
			if ($google_app_engine) {
				$image_path = CloudStorageTools::getPublicUrl($file_storage_path.$attachment->download_file_name, $use_https);
			} else {
				$image_path = $file_storage_path.$attachment->download_file_name;
			}
			echo '<a href="'.$image_path.'" target="_blank"><i class="fa fa-file fa-x2"></i> '.$attachment->file_name.'</a>';
		}
		echo '</p>';
		echo '</div>'; // letter-text
		echo "</div>"; // letter-text-container
		echo "</div>"; // back
		echo "</div>"; // flip-container
		?>
	</div>
</body>
</html>