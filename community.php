<?php
include_once 'config.php';

	_session_start();

	$message = null;
	$first_name = null;
	$last_name = null;
	$email = null;
	$user_id = null;

	if (logged_in()){
		$results = execute_query("SELECT user.*, level.id, level.name FROM user, level WHERE user.level = level.id and user.id = ".$_SESSION['user_id']);
		if ($results->num_rows == 1) {
			$user = $results->fetch_object();
			$first_name = $user->first_name;
			$last_name = $user->last_name;
			$email = $user->email_address;
			$level = $user->name;
			$user_id = $user->id;
		}
	}

?>

<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="author" content="Gary Peters">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- SITE TITLE -->
<title>GiveToken.com - Community Page</title>

<!-- =========================
      FAV AND TOUCH ICONS

<link rel="icon" href="assets/img/favicon.ico">
<link rel="apple-touch-icon" href="assets/img/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="72x72" href="assets/img/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="114x114" href="assets/img/apple-touch-icon-114x114.png">
============================== -->

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

<!-- =========================
     STYLESHEETS
============================== -->
<!-- BOOTSTRAP -->
<link rel="stylesheet" href="css/bootstrap.min.css">

<!-- FONT ICONS -->
<link rel="stylesheet" href="assets/elegant-icons/style.css">
<link rel="stylesheet" href="assets/app-icons/styles.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<!--[if lte IE 7]><script src="lte-ie7.js"></script><![endif]-->

<!-- WEB FONTS -->
<link href='//fonts.googleapis.com/css?family=Roboto:100,300,100italic,400,300italic' rel='stylesheet' type='text/css'>

<!-- CAROUSEL AND LIGHTBOX -->
<link rel="stylesheet" href="css/owl.theme.css">
<link rel="stylesheet" href="css/owl.carousel.css">
<link rel="stylesheet" href="css/nivo-lightbox.css">
<link rel="stylesheet" href="css/nivo_themes/default/default.css">

<!-- ANIMATIONS -->
<link rel="stylesheet" href="css/animate.min.css">

<!-- CUSTOM STYLESHEETS -->
<link rel="stylesheet" href="css/styles.css">

<!-- COLORS -->
<link rel="stylesheet" href="css/colors.css">

<!-- RESPONSIVE FIXES -->
<link rel="stylesheet" href="css/responsive.css">

<link rel="stylesheet" href="css/magnific-popup.css">



<!--[if lt IE 9]>
			<script src="js/html5shiv.js"></script>
			<script src="js/respond.min.js"></script>
<![endif]-->

<!-- JQUERY -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

</head>

<body id="profile-page">
<!-- =========================
     PRE LOADER
============================== -->
<div class="preloader">
  <div class="status">&nbsp;</div>
</div>

<!-- =========================
     HEADER
============================== -->

<header class="header" data-stellar-background-ratio="0.5" id="account-profile">

<!-- SOLID COLOR BG -->
<div class=""> <!-- To make header full screen. Use .full-screen class with solid-color. Example: <div class="solid-color full-screen">  -->

	<!-- STICKY NAVIGATION -->
	<div class="navbar navbar-inverse bs-docs-nav navbar-fixed-top sticky-navigation">
		<div class="container">
			<div class="navbar-header">

				<!-- LOGO ON STICKY NAV BAR -->
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#kane-navigation">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.php#"><img src="assets/img/logo-light.png" alt=""></a>

			</div>

			<!-- NAVIGATION LINKS -->
			<div class="navbar-collapse collapse" id="kane-navigation">
				<ul class="nav navbar-nav navbar-right main-navigation">
					<li><a href="index.php" class="external">Home</a></li>
					<?php
					if (logged_in()) {
						echo '<li><a href="javascript:void(0)" onclick="logout();">Logout</a></li>';
						echo '<li><a href="profile.php" class="external">My Account</a></li>';
						if (is_admin()) {
							echo '<li><a href="admin.php" class="external">Admin</a></li>';
						}
					} else {
						echo '<li><a href="javascript:void(0)" onclick="$(\'#login-dialog\').modal()">Login</a></li>';
						echo '<li><a href="javascript:void(0)" onclick="$(\'#signup-dialog\').modal()">Sign Up</a></li>';
					}
					?>
				</ul>
			</div>
		</div> <!-- /END CONTAINER -->
	</div> <!-- /END STICKY NAVIGATION -->

</div>

</header>
<!-- /END HEADER -->
<br>
<section class="profile" id="account-profile">
	<div class="contentpanel">
		<div class="row">
			<!-- Sidebar -->
			<div class="col-sm-4 col-md-3">
				<?php
					if (logged_in()) {
						echo '<div class="text-center">
					            <img src="assets/gt-favicons.ico/favicon-96x96.png" class="img-circle img-offline img-responsive img-profile" alt="">
					            <h4 class="profile-name mb5">' . " $first_name  $last_name " . '</h4>
					            <div class="small-txt mb5"><i class="fa fa-gift"></i> 0 Give Tokens</div>
					            <div class="small-txt mb5"><i class="fa fa-star"></i> 0 Token Views</div>
					            <div class="small-txt mb5"><i class="fa fa-map-marker"></i> Las Vegas, Nevada, USA</div>
					            <!--<div class="small-txt mb5"><i class="fa fa-briefcase"></i> Marketing Director at <a href="">Company, Inc.</a></div>-->

					            <div class="mb20"></div>

					            <div class="btn-group">
					                <a href="create.php" class="btn btn-primary btn-bordered">Create GiveToken</a>
					                <a href="create.php" class="btn btn-primary btn-bordered">Send GiveToken</a>
					            </div>

					            <div class="mb20"></div>
					        </div>
					        <h5 class="md-title">Welcome to the Community Page!</h5>
							<p class="mb30 small-txt">This is a space to collaborate with other users and learn practices that allow you to make the most of our product!</p>
					        <h5 class="md-title">Connect</h5>
							<ul class="list-unstyled social-list">
					            <li><i class="fa fa-twitter"></i> <a href="">twitter.com/#</a></li>
					            <li><i class="fa fa-facebook"></i> <a href="">facebook.com/#</a></li>
					            <li><i class="fa fa-youtube"></i> <a href="">youtube.com/#</a></li>
					            <li><i class="fa fa-linkedin"></i> <a href="">linkedin.com/#</a></li>
					            <li><i class="fa fa-pinterest"></i> <a href="">pinterest.com/#</a></li>
					            <li><i class="fa fa-instagram"></i> <a href="">instagram.com/#</a></li>
					        </ul>';
					} else {
						echo '<h5 class="md-title">Welcome to the Community Page!</h5>
								<p class="mb30 small-txt">This is a space to collaborate with other users and learn practices that allow you to make the most of our product!<a href="">Show More</a></p>';
						echo '<div class="btn-group buttons login-button text-center">
								<button href="#login-form" class="open-popup-link btn btn-primary btn-bordered">Login</button>
								<button href="#signup-form" class="open-popup-link btn btn-primary btn-bordered">Sign Up</button>
							  </div>';
					}
				?>
			</div><!-- /Sidebar -->
			<div class="col-sm-8 col-md-9">
				<!-- Tab Navigation -->
				<ul class="nav nav-tabs nav-line">
			        <li class="active"><a href="#tutorials" data-toggle="tab"><strong>Tutorials</strong></a></li>
			        <li class=""><a href="#mastering" data-toggle="tab"><strong>Mastering SEO</strong></a></li>
			        <li class=""><a href="#promotional" data-toggle="tab"><strong>Promotional Videos</strong></a></li>
			        <li class=""><a href="#blog" data-toggle="tab"><strong>GiveToken Blog</strong></a></li>
			        <li class=""><a href="#spotlight" data-toggle="tab"><strong>Spotlight</strong></a></li>
			        <li class="" style="float: right;"><a href="index.php"><strong>Home</strong></a></li>
			       	<?php
				        if (is_admin()) {
								echo '<li><a href="admin.php" data-toggle="tab"><strong>Admin</strong></a></li>';
						}
					?>
			    </ul>

			    <div class="tab-content nopadding noborder">
			    	<!-- Tutorials -->
			    	<div class="tab-pane active" id="tutorials">
			    		<h2>Tutorials</h2>
			    		<ul class="nav nav-community nav-tabs">
			    			<li class="active"><a href="#beginner" data-toggle="tab"><strong>Beginner</strong></a></li>
			    			<li class=""><a href="#intermediate" data-toggle="tab"><strong>Intermediate</strong></a></li>
			    			<li class=""><a href="#expert" data-toggle="tab"><strong>Expert</strong></a></li>
			    		</ul>
			    		<div class="tab-content nopadding noborder">
				    		<div class="tab-pane active" id="beginner">
				    			<ul class="timeline">
				    				<!--Plug this up to the list of elements in the database. -->
				    				<li>
							        	<div class="timeline-badge solid-lt-blue"><i class="fa fa-file-text-o"></i></div>
							        	<div class="timeline-panel">
							        		<div class="timeline-heading">
							            		<h4 class="timeline-title">Add an image:</h4>
							            		<p><small class="text-muted"><i class="fa fa-twitter"></i> 2 weeks ago via Twitter</small></p>
							            	</div>
							            	<div class="timeline-body">
												<p>
												    1. Click on the location from which you want to add an image
												</p>
												<p>
												    2. Upload the image from your computer and click OK
												</p>
												<p>
													3. Select “Use” and the media will appear in selected box
												</p>
												<p>
												    4. Use the scrollbar on the image to zoom in and out for the perfect display
												</p>
												<p>
												    5. Click and hold image to move the image within the box
												</p>
												<p>
													6. Use moveable borders around the box to enlarge or shrink your image
												</p>
							            	</div>
							        	</div>
							        </li>
									<li class="timeline-inverted">
							        	<div class="timeline-badge solid-lt-green"><i class="fa fa-file-text-o"></i></div>
							        	<div class="timeline-panel">
							        		<div class="timeline-heading">
							            		<h4 class="timeline-title">Add Music:</h4>
							            		<p><small class="text-muted"><i class="fa fa-twitter"></i> 2 weeks ago via Twitter</small></p>
							            	</div>
							            	<div class="timeline-body">
												<p>
												    <strong>Spotify</strong>
												</p>
												<p>
												    1. Click on the Spotify Logo
												</p>
												<p>
												    2. Insert the desired Spotify Link and click OK
												</p>
												<p>
												    3.Select “Use” and the media will appear in selected box
												</p>
												<p>
												    4. Use the moveable borders around an individual box to enlarge or shrink it
												</p>
												<p>
												    <strong>SoundCloud</strong>
												</p>
												<p>
												    1. Click on the SoundCloud Logo
												</p>
												<p>
												    2. Insert the desired SoundCloud Link and click OK
												</p>
												<p>
												    3. Select “Use” and the media will appear in selected box
												</p>
												<p>
												    4. Use the moveable borders around an individual box to enlarge or shrink it
												</p>
												<p>
												    <strong>MP3</strong>
												</p>
												<p>
												    1. Click on the My Computer Logo
												</p>
												<p>
												    2. Select the desired MP3 and click OK
												</p>
												<p>
												    3.Select “Use” and the media will appear in selected box
												</p>
												<p>
												    4. Use the moveable borders around an individual box to enlarge or shrink it
												</p>
							            	</div>
							        	</div>
							        </li>
									<li>
							        	<div class="timeline-badge solid-blue"><i class="fa fa-file-text-o"></i></div>
							        	<div class="timeline-panel">
							        		<div class="timeline-heading">
							            		<h4 class="timeline-title">Add an Video:</h4>
							            		<p><small class="text-muted"><i class="fa fa-twitter"></i> 2 weeks ago via Twitter</small></p>
							            	</div>
							            	<div class="timeline-body">
												<p>
												    <strong>YouTube</strong>
												</p>
												<p>
												    1. Click on the YouTube Logo
												</p>
												<p>
												    2. Insert the desired YouTube Link and click OK
												</p>
												<p>
												    3. Select “Use” and the video will appear in selected box
												</p>
												<p>
												    4. Use the moveable borders around an individual box to enlarge or shrink it
												</p>
												<p>
												    <strong>MP4</strong>
												</p>
												<p>
												    1. Click on the My Computer Logo
												</p>
												<p>
												    2. Select the desired MP4 and click OK
												</p>
												<p>
												    3. Select “Use” and the video will appear in selected box
												</p>
												<p>
												    4. Use the moveable borders around an individual box to enlarge or shrink it
												</p>
							            	</div>
							        	</div>
							        </li>
				    				<li class="timeline-inverted">
							        	<div class="timeline-badge solid-green"><i class="fa fa-file-text-o"></i></div>
							        	<div class="timeline-panel">
							        		<div class="timeline-heading">
							            		<h4 class="timeline-title">Multi-Media Intro MP3 vs MP4: </h4>
							            		<p><small class="text-muted"><i class="fa fa-facebook-square"></i> 1 month ago via Facebook</small></p>
							            	</div>
							            	<div class="timeline-body">
												<p>
												    With GiveToken, multiple forms of media are allowed to be sent. MP3s and MP4 files, as well as media from SoundCloud, Spotify and YouTube, are easily able
												    to be uploaded and distributed using GiveToken.
												</p>
												<br/>
												<p>
												    MP3 files are simply compressed audio files, while MP4 files are a multimedia format most commonly used for video and audio. SoundCloud is a distribution
												    platform where bands can upload and promote their music for listeners to download. Spotify is a music platform that gives listeners access to millions of
												    songs when using the service. Both of these music platforms allow fans to create playlists, and YouTube can be used to search for videos of any kind, while
												    also subscribing to a variety of channels.
												</p>
											</div>
							        	</div>
							        </li>
				    				<li>
							        	<div class="timeline-badge solid-lt-green"><i class="fa fa-film"></i></div>
							        	<div class="timeline-panel">
							        		<div class="timeline-heading">
							            		<h4 class="timeline-title">Intro</h4>
							            		<p><small class="text-muted"><i class="fa fa-facebook-square"></i> 1 month ago via Facebook</small></p>
							            	</div>
							            	<div class="timeline-body">
						    					<div class="video">
													<iframe src="//player.vimeo.com/video/119287742?title=0&byline=0&portrait=0" width="640" height="360" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
												</div>
											</div>
							        	</div>
							        </li>
				    			</ul>
				    		</div>
				    		<div class="tab-pane" id="intermediate">
				    			<ul class="timeline">
						    		<li>
				    				 	<div class="timeline-badge solid-green"><i class="fa fa-file-text-o"></i></div>
				    				 	<div class="timeline-panel">
					    				 	<div class="timeline-heading">
						    				 	<h4 class="timeline-title">Best practices for adding music: </h4>
								            	<p><small class="text-muted"><i class="fa fa-facebook-square"></i> 1 week ago via Facebook</small></p>
								            </div>
								            <div class="timeline-body">
												<p>
												    Streaming songs from Spotify or SoundCloud will always be easier than using an MP3 file, simply because the tracks do not carry as much data. The more
												    data, the longer a Token™ creation will take to load. If a personal music file is the desired way to distribute music, GiveToken requires MP3 format.
												    Remember, the Token™ creation is being shared, so only use MP3 files if the music it is legal to distribute, otherwise stream from Spotify or SoundCloud.
												    GiveToken allows more than just individual songs but entire playlists. SoundCloud is the preferred platform for linking playlists, and Spotify is a better
												    option if for the distribution of a single song.
												</p>
												<br/>
												<p>
												    <strong> Add a song from Spotify: </strong>
												</p>
												<br/>
												<p>
												    1. In Spotify, right click on the track you wish to include and select “Copy HTTP Link”
												</p>
												<p>
												    2. Click on the box where you would like the music to be displayed
												</p>
												<p>
												    3. Select Spotify, paste your link, and click OK
												</p>
												<br/>
												<p>
												    <strong> Add a playlist from SoundCloud: </strong>
												</p>
												<br/>
												<p>
												    1. Make sure the playlist you wish to include from SoundCloud is public, then copy the link to your playlist page
												</p>
												<p>
												    2. Click on the box where you would like the playlist to be displayed
												</p>
												<p>
												    3. Select SoundCloud, paste your link, and click OK
												</p>
												<br/>
												<p>
												    <strong> Upload MP3 files: </strong>
												</p>
												<br/>
												<p>
												    1. Click on the box where you would like to display your music
												</p>
												<p>
												    2. Upload the MP3 file and click OK
												</p>
											</div>
										</div>
				    				</li>
				    				<li class="timeline-inverted">
							        	<div class="timeline-badge solid-lt-green"><i class="fa fa-file-text-o"></i></div>
							        	<div class="timeline-panel">
							        		<div class="timeline-heading">
							            		<h4 class="timeline-title">Best practices for adding videos:</h4>
							            		<p><small class="text-muted"><i class="fa fa-facebook-square"></i> 1 month ago via Facebook</small></p>
							            	</div>
							            	<div class="timeline-body">
												<p>
												    Similar to uploading music, streaming videos is easier than using an MP4 file. MP4 files carry a lot of data, which causes the Token™ creation to take
												    longer for the receiver to open. While MP4 videos are allowed, streaming from YouTube is the simplest way to ensure that a viewer can watch the video
												    without a minute wasted.
												</p>
												<p>
												    <strong id="docs-internal-guid-68f41699-136a-2d2f-996d-bd8dee2acb48">
												        <br/>
												    </strong>
												</p>
												<p>
												    <strong> Upload a video from YouTube: </strong>
												</p>
												<p>
												    <strong>
												        <br/>
												    </strong>
												</p>
												<p>
												    1. Copy the link of the YouTube video you wish to include
												</p>
												<p>
												    2. Click on the box where you would like to add the video
												</p>
												<p>
												    3. Paste the link and click OK to add the video in the selected box
												</p>
												<p>
												    <strong>
												        <br/>
												    </strong>
												</p>
												<p>
												    <strong> Upload MP4 files: </strong>
												</p>
												<p>
												    <strong>
												        <br/>
												    </strong>
												</p>
												<p>
												    1. Click on the box where you would like to add the video
												</p>
												<p>
												    2. Upload the MP4 file from your computer and click OK to add the video in the selected box
												</p>
											</div>
							        	</div>
							        </li>
				    				<!--Plug this up to the list of elements in the database. -->
				    				<li>
				    				 	<div class="timeline-badge solid-blue"><i class="fa fa-film"></i></div>
				    				 	<div class="timeline-panel">
					    				 	<div class="timeline-heading">
						    				 	<h4 class="timeline-title"> Give A Token of Appreciation - Intermediate</h4>
								            	<p><small class="text-muted"><i class="fa fa-twitter"></i> 2 months ago via Twitter</small></p>
								            </div>
								            <div class="timeline-body">
						    					<div class="video">
													<iframe src="//player.vimeo.com/video/119287742?title=0&byline=0&portrait=0" width="640" height="360" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
												</div>
											</div>
										</div>
				    				</li>
				    			</ul>
				    		</div>
				    		<div class="tab-pane" id="expert">
				    			<ul class="timeline">
				    				<!--Plug this up to the list of elements in the database. -->
				    				<li>
				    				 	<div class="timeline-badge solid-blue"><i class="fa fa-film"></i></div>
				    				 	<div class="timeline-panel">
					    				 	<div class="timeline-heading">
						    				 	<h4 class="timeline-title">More To Come - Expert</h4>
								            	<p><small class="text-muted"><i class="fa fa-twitter"></i> 11 hours ago via Twitter</small></p>
								            </div>
								            <div class="timeline-body">
						    					<div class="video">
													<iframe src="//player.vimeo.com/video/119287742?title=0&byline=0&portrait=0" width="640" height="360" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
												</div>
											</div>
										</div>
				    				</li>
				    			</ul>
				    		</div>
				    	</div>
			    	</div>
			    	<div class="tab-pane" id="mastering">
			    		<h2>Mastering SEO</h2>
		    			<ul class="timeline">
 							<li>
					        	<div class="timeline-badge solid-lt-green"><i class="fa fa-file-text-o"></i></div>
					        	<div class="timeline-panel">
					        		<div class="timeline-heading">
					            		<h4 class="timeline-title">3 Ways to Improve Your Email Marketing</h4>
					            		<p><small class="text-muted"><i class="fa fa-facebook-square"></i> 2 days ago via Facebook</small></p>
					            	</div>
					            	<div class="timeline-body">
										<p>
											Email marketing has been around for years, and it is constantly evolving and growing. Changes continue to occur to improve open and click-through rates for an email, blog, or specific promotion. Personalization makes a significant impact on improving these key metrics.
										</p>
										<p>
										    Here are 3 key ways to improve the personalization of email marketing to improve on those metrics.
										</p>
										<p>
										    <strong>1. Make a VIP List</strong>
										</p>
										<p>
											Send out a special invite to an event to the VIP members before the public release with a custom snippet of what they’ll experience at the event. What better way to get them excited about an event or fundraiser than with a glimpse of what it will entail and what the benefits will be? Plus, giving clients a “pre-sale” offer will make them feel like they are getting the first shot at a deal.
										</p>
										<p>
										    <strong>2.Pre-release sale</strong>
										</p>
										<p>
										    Send out a special invite to an event before the release of tickets to the public for only the VIP members, along with a custom snippet of what they’ll
										    experience at the event. What better way to get them excited about an event or fundraiser than to get glimpse of what it will entail and what the benefits
										    will be. Plus, giving clients a “pre-sale” offer will make them feel like they are getting a deal.<a href="https://www.givetoken.com/preview.php?id=316">Click Here!</a>
										</p>
										<p>
										    <strong>3. Simply Say Hello!</strong>
										</p>
										<p>
											Send out a Token™ Creation just to say, “Hello.” People are sold products and asked to donate all the time. By sending a note from your CEO or President purely to engage with the customer shows how much the customer is valued by a company. In the future, they will be more apt to buy or donate when they feel valued as a human being, and not just a dollar sign.
										</p>
					            	</div>
					        	</div>
					        </li>
		    				<!--Plug this up to the list of elements in the database. -->
 							<li class="timeline-inverted">
					        	<div class="timeline-badge solid-lt-blue"><i class="fa fa-file-text-o"></i></div>
					        	<div class="timeline-panel">
					        		<div class="timeline-heading">
					            		<h4 class="timeline-title">Blogging With GiveToken</h4>
							           <p><small class="text-muted"><i class="fa fa-facebook-square"></i> 1 week ago via Facebook</small></p>
					            	</div>
					            	<div class="timeline-body">
										<p>
										    Nowadays, everyone blogs. It’s a way to get your name out there, to educate people on your company, or keep people up to date on what’s going on in your
										    community. Companies with blogs receive 97% more inbound links than those who don’t. That’s a big difference! In fact, 37% of marketers say blogs are the
										    most valuable content type for marketing.
										</p>
										<p>
										    With so many blogs and sites flying around the web, how do you make your brand stand out? How do you attract more readers, and in turn, more people
										    investing in your company? Give them something that stands out from the status quo.
										</p>
										<p>
										    GiveToken not only provides a different and unique way to attract readership, but it also makes it easy to share visual content on your social media.
										    Interesting content is a top 3 reason people follow brands on social media. The sharing they do on social media leads to more inbound links, which leads to
										    more sales, donations and interest. Blogs give sites 444% (yes, that’s four hundred and forty-four percent) more indexed pages and 97% more indexed links.
										    In layman’s terms, that’s more pages + more links = bigger slice of the online pie ( <a href="http://wwww.contentplus.co.uk/">contentplus.co.uk</a>).
										</p>
										<p>
										    Creating your identity through a blog generates a relationship with your readers. It’s not just about the content; it’s about the community.
										</p>
										<p>
										    Using Video in your blogs and social media outlets allows you to humanize your brand. According to some social media gurus, videos will be the best way to
										    humanize businesses and create a deeper relationship and community with their audience this year.
										</p>
										<p>
										    Stand out from the crowd. Give people what they want. Give them a Token™ Creation.
										</p>
					            	</div>
					        	</div>
					        </li>
		    				<!--Plug this up to the list of elements in the database. -->
 							<li>
					        	<div class="timeline-badge solid-lt-green"><i class="fa fa-file-text-o"></i></div>
					        	<div class="timeline-panel">
					        		<div class="timeline-heading">
					            		<h4 class="timeline-title">Using Video to boost your SEO ranking</h4>
					            		<p><small class="text-muted"><i class="fa fa-facebook-square"></i> 2 weeks ago via Facebook</small></p>
					            	</div>
					            	<div class="timeline-body">
										<p>
										    All companies are looking for ways to drive more traffic to their sites, close more sales and reach more customers while spending the least amount of time
										    and money possible. GiveToken has the tool that will help with their video tool.
										</p>
										<p>
										YouTube is the leading online source for videos, and there is a reason it’s so popular— people love video. A survey conducted by    <a href="http://animoto.com">animoto.com</a> showed that 96% of consumers find videos helpful when making purchase decisions online, so give the people
										    what they want and add more videos. That’s 96% of perspective customers that want to see the product. Companies will see your company as more reliable, as
										    well as much more engaging and personable with customers. These more trusting relationship have a direct correlation with sales.
										</p>
										<p>
										    Another perk to putting video on a website is the increase in popularity. Studies show that users are more likely to watch video than reading text, which
										    leads to longer stays on your page. Adding keywords to the Token™ creation boosts the probability of users finding you in a search engine.
										</p>
										<p>
										    <a href="https://www.givetoken.com/preview.php?id=320">Click Here</a>
										</p>
										<p>
										    GiveToken adds an increased level of sharability through social media and email. Mixing that with key-words and videos will have a drastic impact in search
										    engine rankings and site visits
										</p>
									</div>
					        	</div>
					        </li>
		    				<li class="timeline-inverted">
		    				 	<div class="timeline-badge solid-blue"><i class="fa fa-film"></i></div>
		    				 	<div class="timeline-panel">
			    				 	<div class="timeline-heading">
				    				 	<h4 class="timeline-title">What is GiveToken?</h4>
						            	<p><small class="text-muted"><i class="fa fa-vimeo-square"></i> 1 month ago via Vimeo</small></p>
						            </div>
						            <div class="timeline-body">
				    					<div class="video">
											<iframe src="//player.vimeo.com/video/119287742?title=0&byline=0&portrait=0" width="640" height="360" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
										</div>
									</div>
								</div>
		    				</li>
		    			</ul>
			    	</div>
			    	<div class="tab-pane" id="promotional">
			    		<h2>Promotional Videos</h2>
			    		<ul class="videos">
			    			<li>
					    		<div class="video">
									<iframe src="//player.vimeo.com/video/119287742?title=0&byline=0&portrait=0" width="640" height="360" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
								</div>
							</li>
						</ul>
			    	</div>
			    	<!-- Start of GiveToken Blog, not sure why I can't find GiveToken Blog text.... -->
			    	<div class="tab-pane" id="blog">
			    		<h2>GiveToken Blog</h2>
				    	<ul class="timeline" id="timeline-blog">
				    		<li>
					        	<div class="timeline-badge solid-green"><i class="fa fa-file-text-o"></i></div>
					        	<div class="timeline-panel test">
					        		<div class="timeline-heading">
					            		<h4 class="timeline-title headers" id="post-title-1">Discovering GiveToken — Customization: Text, Quotes, and Collage features</h4>
					            		<p><small class="text-muted"><i class="fa fa-twitter"></i> 1 week ago via Facebook</small></p>
					            	</div>
					            	<div class="timeline-body">
										<p>
										    Creating a Token™ creation through GiveToken is simple and easy. With so many different features, each Token™ creation is completely customizable. Each one
										    can be shared with customers and can offer an individual, personal touch to make them feel like a VIP.
										</p>
										<p>
										    <strong> Collage </strong>
										</p>
										<p>
										    Design the Token™ creation with a variety of multimedia files into an effortless collage showing a unique personal touch. The pre-made templates provided
										    enable simple click to add functionality, and then adjust each section to fit the specific needs for the customer. Simply click the box you want to fill
										    and select the image, video, or music desired.
										</p>
										<p>
										    <strong> Text &amp; Quotes </strong>
										</p>
										<p>
										    Token™ creation can also be personalized by using customer specific text and quotes. Whether a famous quote or personal note, these messages can be added
										    to the collage with a simple click of a button. A unique feature to GiveToken is the ability to send a letter along with the multi-media portion of the
										    collage. Remind customers or employees about a special event, say thank you, send special offers, or simply just say hello.
										</p>
										<p>
										    With a Token™ creation from GiveToken, customers can feel like a VIP and be sure to come back for repeat business.
										</p>
									</div>
					        	</div>
					        </li>
					        <li class="timeline-inverted">
					        	<div class="timeline-badge solid-lt-green"><i class="fa fa-file-text-o"></i></div>
					        	<div class="timeline-panel">
					        		<div class="timeline-heading">
					            		<h4 class="timeline-title headers" id="post-title-2">We’re Here! Dive deeper into GiveToken</h4>
					            		<p><small class="text-muted"><i class="fa fa-facebook-square"></i> 1 month ago via Facebook</small></p>
					            	</div>
					            	<div class="timeline-body">
										<p>
										    GiveToken is here. For companies struggling to engage potential customers, GiveToken provides a new tool that enables the recipient to feel the changes
										    that a product or service can have.
										</p>
										<p>
										    GiveToken is a tool that is used to market, sell or educate others about a service or product. By allowing the user to combine any type of media, be it
										    pictures, videos, or music, with text and attachments, the user can show the customer the full power of a product. Token™ creations can be created and then
										    shared using any platform that is desired, whether that’s social media, email, or texts.
										</p>
										<p>
										    There inlies the beauty of GiveToken. It is completely customizable to however the user wants to create and share an experience with the customer.
										</p>
										<p>
										    GiveToken is the blank canvas to create a personalized digital content.
										</p>
										<p>
										    • Customize a Token™ creation with a unique mix of videos, music, photos and more
										</p>
										<p>
										    • Click and drag media from the user’s computer or from anywhere on the web
										</p>
										<p>
										    • Share a Token™ creation on any platform with just a simple link
										</p>
										<p>
										    • Make it personal and send the Token™ creation to a specific person or group
										</p>
										<p>
										    Stay tuned for an in depth look at all of the best features GiveToken has to offer.
										</p>
									</div>
					        	</div>
					        </li>
				    	</ul>
				    </div>
				    <div class="tab-pane" id="spotlight">
			    		<h2>Spotlight</h2>
		    			<ul class="timeline">
		    				<!--Plug this up to the list of elements in the database. -->
		    				<li>
		    				 	<div class="timeline-badge solid-blue"><i class="fa fa-user"></i></div>
		    				 	<div class="timeline-panel">
			    				 	<div class="text-center">
							            <img src="assets/img/user.png" class="img-circle img-offline img-responsive img-profile" alt="">
							            <h4 class="profile-name mb5"><i class="fa fa-briefcase"></i><a href=""> Juice Plus, Inc.</a></h4>
							            <div class="small-txt mb5"><i class="fa fa-map-marker"></i> Memphis, Tenneessee, USA</div>
							        </div>
								</div>
								<div class="solid-lt-green timeline-badge-spotlight"><i class="fa fa-file-text-o"></i></div>
								<div class="timeline-panel timeline-panel-post">
									<div class="timeline-heading">
					            		<h4 class="timeline-title">JuicePlus</h4>
					            		<p><small class="text-muted"><i class="fa fa-facebook-square"></i> 1 month ago via Facebook</small></p>
					            	</div>
					            	<div class="timeline-body">
										<p>
										    GiveToken is a multi-purpose tool, with a variety of different options to improve the digital experience. One such way is as a teaching tool. When trying
										    to teach employees about new products or continue their sales education, GiveToken can be utilized to combine facts, figures, and pictures with video in
										    order to deliver the full load of information. Sending further education using GiveToken provides context to the bland information and gives the product
										    the chance to come to life.
										</p>
										<br/>
										<p>
										    Take this example for Juice Plus+.
										</p>
										<br/>
										<p>
										    Juice Plus+ is whole food based nutrition, including juice powder concentrates from 30 different fruits, vegetables and grains. Juice Plus+ helps bridge
										    the gap between what you should eat and what you do eat every day. Not a multivitamin, medicine, treatment or cure for any disease, Juice Plus+ is made
										    from quality ingredients carefully monitored from farm to capsule to provide natural nutrients your body needs to be at its best.
										</p>
										<br/>
										<p>
										    <a href="https://www.givetoken.com/preview.php?id=315"> Click Me! </a>
										</p>
										<br/>
										<p>
										    As you can see, all of the information that a new employee might need to start growing their business is right there at their fingertips in one easy,
										    simple to use Token™ creation. With continuing education on their products being a key to the success as a company, JuicePlus+ is trying to make their new
										    classes and product information as readily available and accessible as possible, and GiveToken is the perfect way to do that.
										</p>
										<br/>
										<p>
										    What is your biggest challenge in educating your employees and keeping them motivated?
										</p>
							       	</div>
								</div>
		    				</li>
		    			</ul>
			    	</div>
			    </div>
			</div>
		</div>
	</div>
</section>


<script>

function togglePost(){
	var val = this.id.substring('post-title'.length);
	if (document.getElementById('full-post' + val).style.display == 'none'){
		expandPost(this);
	} else {
		shrinkPost(this);
	}
}

function expandPost(el){
	var val = el.id.substring('post-title'.length);
	document.getElementById('full-post' + val).style.display = 'initial';
	document.getElementById('preview' + val).style.display = 'none';

	var li = document.getElementsByClassName('headers');
	for(i = 0; i < li.length; i++){
		var val2 = li[i].id.substring('post-title'.length);
		if(val != val2){
			shrinkPost(li[i]);
		}
	}
}

function shrinkPost(el){
	var val = el.id.substring('post-title'.length);
	document.getElementById('full-post' + val).style.display = 'none';
	document.getElementById('preview' + val).style.display = 'initial';
}

var els = document.getElementsByClassName('headers');
for(i = 0; i < els.length; i++){
	els[i].onclick = togglePost;
}
</script>

<header class="header" data-stellar-background-ratio="0.5" id="account-profile">

<script src="js/bootstrap.min.js"></script>
<script src="js/smoothscroll.js"></script>
<script src="js/jquery.scrollTo.min.js"></script>
<script src="js/jquery.localScroll.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/nivo-lightbox.min.js"></script>
<script src="js/simple-expand.min.js"></script>
<script src="js/wow.min.js"></script>
<script src="js/jquery.stellar.min.js"></script>
<script src="js/retina-1.1.0.min.js"></script>
<script src="js/jquery.nav.js"></script>
<script src="js/matchMedia.js"></script>
<script src="js/jquery.ajaxchimp.min.js"></script>
<script src="js/jquery.fitvids.js"></script>
<script src="js/custom.js"></script>
<script src="js/jquery.magnific-popup.js"></script>
<script src="js/facebook_init.js"></script>
<script src="js/login.js"></script>
<script src="js/signup.js"></script>
<script src="js/account.js"></script>

</body>
</html>
