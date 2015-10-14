<?php
use \Detection\MobileDetect as Mobile_Detect;
use \GiveToken\Token;
use google\appengine\api\cloud_storage\CloudStorageTools;

include_once 'config.php';

$token = new Token($_GET['id']);
$detect = new Mobile_Detect();

if ($google_app_engine) {
    $token->image_path = CloudStorageTools::getPublicUrl($file_storage_path.$token->thumbnail_name, $use_https);
} else {
    $token->image_path = $file_storage_path.$token->thumbnail_name;
}

$animation_color = null;
$animation_style = null;
$animation_enter_css = null;
$animation_pop_css = null;

	if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') != TRUE) {
		$animation_style = "none";
	} else {
		$animation_color = $token->animation_color;
		$animation_style = $token->animation_style;
	}

	if ($animation_style == "none") {
		$container_id = "flip-container";
	} else {
		if ($animation_style == "default") {
			$animation_enter_css = "bounceInLeft";
			$animation_pop_css = "swing";
		} else if ($animation_style == "business") {
			$animation_enter_css = "fadeIn";
			$animation_pop_css = "pulse";
		} else if ($animation_style == "casual") {
			$animation_enter_css = "flipInX";
			$animation_pop_css = "tada";
		}
		$container_id = "flip-container-envelope";
	}


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />

	<title><?php echo $token->name ?></title>
	<meta name="og:title" property="og:title" content= <?php echo '"'.$token->name.'"' ?> />
	<meta name="og:site_name" property="og:site_name" content="Givetoken"/>
	<meta name="og:url" property="og:url" content=<?php if (isset($_SERVER['HTTP_HOST']) and isset($_SERVER['REQUEST_URI'])) { echo '"'."http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'"'; } ?> />
	<meta name="og:description" property="og:description" content=<?php echo '"'.$token->description.'"'?>/>
	<meta name="fb:app_id" property="fb:app_id" content="1498055593756885" />
	<meta name="og:type" property="og:type" content="article" />
	<meta name="og:image" property="og:image" content=<?php echo $token->image_path; ?>

	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/preview.css" />
	<link rel="stylesheet" href="css/create_and_preview.css" />
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="//vjs.zencdn.net/4.11/video-js.css">
	<link rel="stylesheet" href="css/colorbox.css" />
	<link rel="stylesheet" href="css/animate.min.css" />
	<script src="js/jquery-1.10.2.min.js" type="text/javascript"></script>
	<script src="js/jquery.colorbox-min.js"></script>
	<script src="//vjs.zencdn.net/4.11/video.js"></script>

	<script src="js/preview.js"></script>

	<!-- CUSTOM STYLESHEETS -->
	<script src="js/preloader.js"></script>

	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

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

	<script>
		selectedAnimationColor = "<?= $token->animation_color; ?>";
		selectedAnimationStyle = "<?= $token->animation_style; ?>";
		animationEnterCss = "<?= $animation_enter_css; ?>";
		animationPopCss = "<?= $animation_pop_css; ?>";
	</script>
</head>
<body>
	<?php include_once("analyticstracking.php"); ?>

	<?php if ($animation_style == "none"): ?>
	<div class="preloader">
	  <div class="status">&nbsp;</div>
	</div>
	<?php endif; ?>

	<?php if ($animation_style != "none"): ?>
	<div class="shrink-box">
		<?= '<div class="shaking-box animated ' . $animation_enter_css . '" id="shaking-box">'; ?>

			<div class="envelope">
				<div class="svg-container base">
					<!-- Generator: Adobe Illustrator 19.0.0, SVG Export Plug-In  -->
					<svg version="1.1"
							 id="base"
							 viewBox="0 0 1327.4 974.6"
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
					<linearGradient id="SVGID_1_" gradientUnits="userSpaceOnUse" x1="277.4933" y1="758.0084" x2="-235.2553" y2="245.2598">
						<stop  offset="0" style="stop-color:#447193"/>
						<stop  offset="1" style="stop-color:#578CAA"/>
					</linearGradient>
					<polygon class="st0" points="7.1,2.9 7.1,972.4 466,569.5 "/>
					<linearGradient id="SVGID_2_" gradientUnits="userSpaceOnUse" x1="1550.1256" y1="745.3784" x2="1065.3538" y2="260.6064">
						<stop  offset="0" style="stop-color:#447193"/>
						<stop  offset="1" style="stop-color:#578CAA"/>
					</linearGradient>
					<polygon class="st1" points="867.5,578.2 1323.1,972.4 1323.1,2.9 "/>
					<linearGradient id="SVGID_3_" gradientUnits="userSpaceOnUse" x1="499.5696" y1="1257.3304" x2="890.646" y2="579.9663">
						<stop  offset="0" style="stop-color:#447193"/>
						<stop  offset="1" style="stop-color:#578CAA"/>
					</linearGradient>
					<path class="st2" d="M6.1,972.4h1316L827.7,543.7c-31.8-22.1-295.9-23.4-326.3-1C312.4,681.9,195,833.2,6.1,972.4z"/>
					<linearGradient id="SVGID_4_" gradientUnits="userSpaceOnUse" x1="1077.6912" y1="800.3622" x2="1533.2278" y2="149.7885">
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
					<polygon class="st3" points="867.5,578.2 1323.1,972.2 1323.1,2.6 "/>
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
			<?php endif; ?>
			<?php
			echo '<div id="triggerTab"></div>';
			echo '<div class="giftbox panel" id="' . $container_id . '">';
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

	<!-- Closing down a shrink box -->
	<?php if ($animation_style != "none"): ?>
		</div>
	</div>
	<?php endif; ?>

</body>
</html>
