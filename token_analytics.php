<?php
use \GiveToken\Token;
use google\appengine\api\cloud_storage\CloudStorageTools;

require_once 'config.php';
require_once 'analyticsauth.php';
require_once 'analyticsqueries.php';

_session_start();

$message = null;
$first_name = null;
$last_name = null;
$email = null;
$user_id = null;

$token = new Token($_GET['id']);

if ($google_app_engine) {
    $token->image_path = CloudStorageTools::getPublicUrl($file_storage_path.$token->thumbnail_name, $use_https);
} else {
    $token->image_path = $file_storage_path.$token->thumbnail_name;
}

define('TITLE', 'GiveToken.com - Analytics');
require __DIR__.'/header.php';
?>

<!-- CUSTOM STYLESHEETS -->
<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap.vertical-tabs.min.css">
<link rel="stylesheet" href="css/analytics.css">
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script src="js/draw.js?v=<?php echo VERSION;?>"></script>

</head>

<body id="analytics-page">
<!-- =========================
     PRE LOADER
============================== -->

<div class="preloader" >
  <div class="status">&nbsp;</div>
</div>


<!-- =========================
     HEADER
============================== -->
<header class="header" data-stellar-background-ratio="0.5" id="account-profile">

<!-- SOLID COLOR BG -->
<div class=""> <!-- To make header full screen. Use .full-screen class with solid-color. Example: <div class="solid-color full-screen">  -->
    <?php require __DIR__.'/navbar.php';?>
</div>
<!-- /END COLOR OVERLAY -->
</header>
<!-- /END HEADER -->

<!-- =========================
     ACCOUNT PROFILE
============================== -->

<div class="container">
	<div class="main-body">
		<div class="row">
			<div class="col-sm-4" id="thumbnail">
				<h3><?= $token->name; ?></h3>
				<?= "<img src=". $token->image_path .">" ;?>
			</div>
			<div class="col-sm-6" id="generalInfo">
				<ul class="list-group">
				  <li class="list-group-item odd"><h4>Total Views: <?= printResults($numTotalResults); ?></h4></li>
				  <li class="list-group-item"><h4>Unique Views: <?= printResults($numUniqueResults); ?></h4></li>
				  <li class="list-group-item odd"><h4>Average Time on the Token: <?= printTimeResults($numAverageResults); ?></h4></li>
				  <li class="list-group-item"><h4>Bounces: <?= printBounceResults($numBouncesResults); ?></h4></li>
				</ul>
<!-- 				<h3>Total Views: <?= printResults($numTotalResults); ?></h3>
				<h3>Unique Views: <?= printResults($numUniqueResults); ?></h3>
				<h3>Average Time on the Token: <?= printTimeResults($numAverageResults); ?></h3>
				<h3>Bounces: <?= printResults($numBouncesResults); ?></h3> -->
			</div>
		</div>
		<div class="row" id="analytics-panel">

			<div class="col-xs-2"> <!-- required for floating -->
			    <!-- Nav tabs -->
			    <ul class="nav nav-tabs tabs-left">
			      <li class="active"><a href="#general" data-toggle="tab">General</a></li>
			      <li><a href="#social" data-toggle="tab">Social Media</a></li>
			      <li><a href="#audience" data-toggle="tab">Audience</a></li>
			      <li><a href="#technology" data-toggle="tab">Technology</a></li>
			      <li class="disabled"><a>Popular Trends <span class="soon">(coming soon)</span></a></li>
			      <li class="disabled"><a>Custom Search <span class="soon">(coming soon)</span></a></li>
			    </ul>
			</div>

			<div class="col-xs-10">
			    <!-- Tab panes -->
			    <div class="tab-content">

			      <div class="tab-pane active" id="general">
			      		<div class="col-sm-6">

			            <section id="total-timeline"></section>
			              <script>
			              totalChartData = <?php
                              echo json_encode($totalResults->getDataTable()->toSimpleObject())
                    ?>;
			              totalChartNumber = "<?= printResults($numTotalResults); ?>";
			              </script>

			            <section id="unique-timeline"></section>
			              <script>
			              uniqueChartData = <?php
                              echo json_encode($uniqueResults->getDataTable()->toSimpleObject())
                    ?>;
			              uniqueChartNumber = "<?= printResults($numUniqueResults); ?>";
			              </script>

			          </div>
			          <div class="col-sm-6">

			            <section id="average-time-timeline"></section>
			              <script>
			              averageChartData = <?php
                              echo json_encode($averageResults->getDataTable()->toSimpleObject())
                    ?>;
			              averageChartNumber = "<?= printTimeResults($numAverageResults); ?>";
			              </script>

			            <section id="bounces-timeline"></section>
			              <script>
			              bouncesChartData = <?php
                              echo json_encode($bouncesResults->getDataTable()->toSimpleObject())
                    ?>;
			              bouncesChartNumber = "<?= printBounceResults($numBouncesResults); ?>";
			              </script>

			          </div>
			      </div>

			      <div class="tab-pane" id="social">
			      		<div class="col-sm-6">

			            <section id="facebook-timeline"></section>
			              <script>
			              facebookChartData = <?php
                              echo json_encode($facebookResults->getDataTable()->toSimpleObject())
                    ?>;
			              facebookChartNumber = "<?= printResults($numFacebookResults); ?>";
			              </script>

			            <section id="twitter-timeline"></section>
			              <script>
			              twitterChartData = <?php
                              echo json_encode($twitterResults->getDataTable()->toSimpleObject())
                    ?>;
			              twitterChartNumber = "<?= printBounceResults($numTwitterResults); ?>";
			              </script>
			             <!-- twitterChartNumber = "<?= printResults($numTwitterResults); ?>"; -->


			          	</div>
			          	<div class="col-sm-6">

				            <section id="email-timeline"></section>
				              <script>
				              emailChartData = <?php
                                  echo json_encode($emailResults->getDataTable()->toSimpleObject())
                    ?>;
				              emailChartNumber = "<?= printResults($numEmailResults); ?>";
				              </script>
			          	</div>
			      </div>


			      <div class="tab-pane" id="audience">
			      	<div class="row">
			      		<div class="col-sm-6">
			            <section id="gender-timeline"></section>
			              <script>
			              genderChartData = <?php
                              echo json_encode($genderResults->getDataTable()->toSimpleObject())
                    ?>;
			              </script>
			            </div>
			            <div class="col-sm-6">
			            <section id="age-timeline"></section>
			              <script>
			              ageChartData = <?php
                              echo json_encode($ageResults->getDataTable()->toSimpleObject())
                    ?>;
			              </script>
			            </div>
			        </div>
		            <div class="row">
		            	<div class="col-sm-6 col-sm-offset-3">
		            	<p>Cities</p>
		            	<section id="geo-timeline"></section>
			              <script>
			              geoChartData = <?php
                              echo json_encode($geoResults->getDataTable()->toSimpleObject())
                    ?>;
			              </script>
		            	</div>
		            </div>
			      </div>


			      <div class="tab-pane" id="technology">
			      		<div class="row">
				      		<div class="col-sm-6">

				            <section id="device-timeline"></section>
				              <script>
				              deviceChartData = <?php
                                  echo json_encode($deviceResults->getDataTable()->toSimpleObject())
                    ?>;
				              </script>

				            <section id="desktop-timeline"></section>
				              <script>
				              desktopChartData = <?php
                                  echo json_encode($desktopResults->getDataTable()->toSimpleObject())
                    ?>;
				              desktopChartNumber = "<?= printResults($numDesktopResults); ?>";
				              </script>

				            </div>
				            <div class="col-sm-6">

				            <section id="tablet-timeline"></section>
				              <script>
				              tabletChartData = <?php
                                  echo json_encode($tabletResults->getDataTable()->toSimpleObject())
                    ?>;
				              tabletChartNumber = "<?= printResults($numTabletResults); ?>";
				              </script>

				            <section id="mobile-timeline"></section>
				              <script>
				              mobileChartData = <?php
                                  echo json_encode($mobileResults->getDataTable()->toSimpleObject())
                    ?>;
				              mobileChartNumber = "<?= printResults($numMobileResults); ?>";
				              </script>
				              				            </div>
				        </div>
			      </div>
			    </div>
			</div>
		</div>
	</div>
</div>

<?php require __DIR__.'/footer.php';?>
</body>
</html>
