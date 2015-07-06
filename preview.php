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
			<div class="svg-container">
			<!-- Generator: Adobe Illustrator 19.0.0, SVG Export Plug-In  -->
			<svg version="1.1"
				 id="base"
				 viewBox="0 0 1270.8 1007.1"
				 preserveAspectRatio="xMinYMin meet" class="svg-content">
			<style type="text/css">
				.st0{fill:url(#SVGID_1_);stroke:#6C9BB6;stroke-width:2;stroke-miterlimit:10;}
				.st1{fill:url(#SVGID_2_);stroke:#6C9BB6;stroke-width:2;stroke-miterlimit:10;}
				.st2{fill:url(#SVGID_3_);stroke:#6C9BB6;stroke-width:4;stroke-miterlimit:10;}
				.st3{fill:url(#SVGID_4_);}
				.st4{fill:url(#SVGID_5_);stroke:#6C9BB6;stroke-width:2;stroke-miterlimit:10;}
				.st5{fill:url(#SVGID_6_);stroke:#6C9BB6;stroke-width:2;stroke-miterlimit:10;}
				.st6{fill:url(#SVGID_7_);stroke:#6C9BB6;stroke-width:4;stroke-miterlimit:10;}
				.st7{fill:url(#SVGID_8_);}
			</style>
			<defs>
			</defs>
			<linearGradient id="SVGID_1_" gradientUnits="userSpaceOnUse" x1="268.6937" y1="765.8865" x2="-243.7052" y2="253.4877">
				<stop  offset="0" style="stop-color:#447193"/>
				<stop  offset="1" style="stop-color:#578CAA"/>
			</linearGradient>
			<polygon class="st0" points="6.7,3.1 6.7,1004.8 446.1,588.5 "/>
			<linearGradient id="SVGID_2_" gradientUnits="userSpaceOnUse" x1="1509.9323" y1="761.5882" x2="1009.0633" y2="260.7192">
				<stop  offset="0" style="stop-color:#447193"/>
				<stop  offset="1" style="stop-color:#578CAA"/>
			</linearGradient>
			<polygon class="st1" points="830.5,597.5 1266.7,1004.8 1266.7,3.1 "/>
			<linearGradient id="SVGID_3_" gradientUnits="userSpaceOnUse" x1="478.2293" y1="1277.5892" x2="866.7679" y2="604.6205">
				<stop  offset="0" style="stop-color:#447193"/>
				<stop  offset="1" style="stop-color:#578CAA"/>
			</linearGradient>
			<path class="st2" d="M5.7,1004.8h1260l-473.4-443c-30.4-22.9-283.3-24.2-312.5-1C299,704.6,186.6,861,5.7,1004.8z"/>
			<linearGradient id="SVGID_4_" gradientUnits="userSpaceOnUse" x1="1024.7603" y1="835.127" x2="1495.4231" y2="162.9507">
				<stop  offset="0" style="stop-color:#000000;stop-opacity:0.15"/>
				<stop  offset="6.872708e-02" style="stop-color:#142128;stop-opacity:0.1397"/>
				<stop  offset="0.1431" style="stop-color:#263D4A;stop-opacity:0.1285"/>
				<stop  offset="0.2251" style="stop-color:#355668;stop-opacity:0.1162"/>
				<stop  offset="0.3152" style="stop-color:#426A80;stop-opacity:0.1027"/>
				<stop  offset="0.4164" style="stop-color:#4B7993;stop-opacity:8.753419e-02"/>
				<stop  offset="0.5355" style="stop-color:#5284A0;stop-opacity:6.967628e-02"/>
				<stop  offset="0.689" style="stop-color:#568AA8;stop-opacity:4.664386e-02"/>
				<stop  offset="1" style="stop-color:#578CAA;stop-opacity:0"/>
			</linearGradient>
			<polygon class="st3" points="830.5,597.5 1266.7,1004.6 1266.7,2.8 "/>
			</svg>

			</div>
		</div> <!--  END ENVELOPE -->
		<div class="opener">
			<div class="svg-container">
				<!-- Generator: Adobe Illustrator 19.0.0, SVG Export Plug-In  -->
				<svg id="top" version="1.1"
					 viewBox="0 0 1268.7 626"
					 preserveAspectRatio="xMinYMin meet" class="svg-content">
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