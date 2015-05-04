<?php
include_once 'util.php';
include_once 'config.php';
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="author" content="Maverick Blair & Co. | www.maverickblair.com">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- SITE TITLE -->
<title>GiveToken.com - Give a Token of Appreciation</title>

<!-- =========================
      FAV AND TOUCH ICONS  

<link rel="icon" href="assets/img/favicon.ico">
<link rel="apple-touch-icon" href="assets/img/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="72x72" href="assets/img/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="114x114" href="assets/img/apple-touch-icon-114x114.png">
============================== -->

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
					<li><a href="index.php#home" class="external">Home</a></li>
					<li><a href="#">My Account</a></li>
					<li><a href="#">Login</a></li>
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
					            <img src="assets/img/user.png" class="img-circle img-offline img-responsive img-profile" alt="">
					            <h4 class="profile-name mb5">Tom Brady</h4>
					            <div class="small-txt mb5"><i class="fa fa-gift"></i> 4 Give Tokens</div>
					            <div class="small-txt mb5"><i class="fa fa-star"></i> 423 Token Views</div>
					            <div class="small-txt mb5"><i class="fa fa-map-marker"></i> San Francisco, California, USA</div>
					            <div class="small-txt mb5"><i class="fa fa-briefcase"></i> Marketing Director at <a href="">Company, Inc.</a></div>
					        
					            <div class="mb20"></div>
					        
					            <div class="btn-group">
					                <button class="btn btn-primary btn-bordered">Create GiveToken</button>
					                <button class="btn btn-primary btn-bordered">Send GiveToken</button>
					            </div>
					            
					            <div class="mb20"></div>
					        </div>
					        <h5 class="md-title">Welcome to the Community Page!</h5>
							<p class="mb30 small-txt">This is a space to collaborate with other users and learn practices that allow you to make the most of our product!<a href="">Show More</a></p>
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
				        if (!is_admin()) {
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
				    				 	<div class="timeline-badge solid-blue"><i class="fa fa-film"></i></div>
				    				 	<div class="timeline-panel">
					    				 	<div class="timeline-heading">
						    				 	<h4 class="timeline-title">Mussum ipsum cacilds- Beginner</h4>
								            	<p><small class="text-muted"><i class="fa fa-twitter"></i> 11 hours ago via Twitter</small></p>
								            </div>
								            <div class="timeline-body">
						    					<div class="video">
													<iframe src="//player.vimeo.com/video/119287742?title=0&byline=0&portrait=0" width="640" height="360" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe> 
												</div>
											</div>
										</div>
				    				</li>
				    				<li class="timeline-inverted">
							        	<div class="timeline-badge solid-lt-green"><i class="fa fa-file-text-o"></i></div>
							        	<div class="timeline-panel">
							        		<div class="timeline-heading">
							            		<h4 class="timeline-title">Mussum ipsum cacilds</h4>
							            		<p><small class="text-muted"><i class="fa fa-twitter"></i> 11 hours ago via Twitter</small></p>
							            	</div>
							            	<div class="timeline-body">
							            		<p>Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis. Mé faiz elementum girarzis, nisi eros vermeio, in elementis mé pra quem é amistosis quis leo. Manduma pindureta quium dia nois paga. Sapien in monti palavris qui num significa nadis i pareci latim. Interessantiss quisso pudia ce receita de bolis, mais bolis eu num gostis.</p>
							            	</div>
							        	</div>
							        </li>
				    			</ul>
				    		</div>
				    		<div class="tab-pane" id="intermediate">
				    			<ul class="timeline">
				    				<!--Plug this up to the list of elements in the database. -->
				    				<li>
				    				 	<div class="timeline-badge solid-blue"><i class="fa fa-film"></i></div>
				    				 	<div class="timeline-panel">
					    				 	<div class="timeline-heading">
						    				 	<h4 class="timeline-title">Mussum ipsum cacilds - Intermediate</h4>
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
				    		<div class="tab-pane" id="expert">
				    			<ul class="timeline">
				    				<!--Plug this up to the list of elements in the database. -->
				    				<li>
				    				 	<div class="timeline-badge solid-blue"><i class="fa fa-film"></i></div>
				    				 	<div class="timeline-panel">
					    				 	<div class="timeline-heading">
						    				 	<h4 class="timeline-title">Mussum ipsum cacilds - Expert</h4>
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
		    				<!--Plug this up to the list of elements in the database. -->
		    				<li>
		    				 	<div class="timeline-badge solid-blue"><i class="fa fa-film"></i></div>
		    				 	<div class="timeline-panel">
			    				 	<div class="timeline-heading">
				    				 	<h4 class="timeline-title">Mussum ipsum cacilds- Beginner</h4>
						            	<p><small class="text-muted"><i class="fa fa-twitter"></i> 11 hours ago via Twitter</small></p>
						            </div>
						            <div class="timeline-body">
				    					<div class="video">
											<iframe src="//player.vimeo.com/video/119287742?title=0&byline=0&portrait=0" width="640" height="360" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe> 
										</div>
									</div>
								</div>
		    				</li>
		    				<li class="timeline-inverted">
					        	<div class="timeline-badge solid-lt-green"><i class="fa fa-file-text-o"></i></div>
					        	<div class="timeline-panel">
					        		<div class="timeline-heading">
					            		<h4 class="timeline-title">Mussum ipsum cacilds</h4>
					            		<p><small class="text-muted"><i class="fa fa-twitter"></i> 11 hours ago via Twitter</small></p>
					            	</div>
					            	<div class="timeline-body">
					            		<p>Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis. Mé faiz elementum girarzis, nisi eros vermeio, in elementis mé pra quem é amistosis quis leo. Manduma pindureta quium dia nois paga. Sapien in monti palavris qui num significa nadis i pareci latim. Interessantiss quisso pudia ce receita de bolis, mais bolis eu num gostis.</p>
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
			    	<div class="tab-pane" id="blog">
				    	<ul class="timeline" id="timeline-blog">
				    		<li>
					        	<div class="timeline-badge solid-lt-green"><i class="fa fa-file-text-o"></i></div>
					        	<div class="timeline-panel test">
					        		<div class="timeline-heading">
					            		<h4 class="timeline-title headers" id="post-title-1">Mussum ipsum cacilds</h4>
					            		<p><small class="text-muted"><i class="fa fa-twitter"></i> 11 hours ago via Twitter</small></p>
					            	</div>
					            	<div class="timeline-body">
					            		<p>Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , <span id="preview-1">...</span><span id="full-post-1" style="display:none;">depois divoltis porris, paradis. Paisis, filhis, espiritis santis. Mé faiz elementum girarzis, nisi eros vermeio, in elementis mé pra quem é amistosis quis leo. Manduma pindureta quium dia nois paga. Sapien in monti palavris qui num significa nadis i pareci latim. Interessantiss quisso pudia ce receita de bolis, mais bolis eu num gostis.</span></p>
					            	</div>
					        	</div>
					        </li>
					        <li class="timeline-inverted">
					        	<div class="timeline-badge solid-lt-green"><i class="fa fa-file-text-o"></i></div>
					        	<div class="timeline-panel">
					        		<div class="timeline-heading">
					            		<h4 class="timeline-title headers" id="post-title-2">Mussum ipsum cacilds</h4>
					            		<p><small class="text-muted"><i class="fa fa-twitter"></i> 11 hours ago via Twitter</small></p>
					            	</div>
					            	<div class="timeline-body">
					            		<p>Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , <span id="preview-2">...</span><span id="full-post-2" style="display:none">depois divoltis porris, paradis. Paisis, filhis, espiritis santis. Mé faiz elementum girarzis, nisi eros vermeio, in elementis mé pra quem é amistosis quis leo. Manduma pindureta quium dia nois paga. Sapien in monti palavris qui num significa nadis i pareci latim. Interessantiss quisso pudia ce receita de bolis, mais bolis eu num gostis.</span></p>
					            	</div>
					        	</div>
					        </li>
					        <li>
					        	<div class="timeline-badge solid-lt-green"><i class="fa fa-file-text-o"></i></div>
					        	<div class="timeline-panel">
					        		<div class="timeline-heading">
					            		<h4 class="timeline-title headers" id="post-title-3">Mussum ipsum cacilds</h4>
					            		<p><small class="text-muted"><i class="fa fa-twitter"></i> 11 hours ago via Twitter</small></p>
					            	</div>
					            	<div class="timeline-body">
					            		<p>Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , <span id="preview-3">...</span><span id="full-post-3" style="display:none">depois divoltis porris, paradis. Paisis, filhis, espiritis santis. Mé faiz elementum girarzis, nisi eros vermeio, in elementis mé pra quem é amistosis quis leo. Manduma pindureta quium dia nois paga. Sapien in monti palavris qui num significa nadis i pareci latim. Interessantiss quisso pudia ce receita de bolis, mais bolis eu num gostis.</span></p>
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
							            <h4 class="profile-name mb5"><i class="fa fa-briefcase"></i><a href=""> Company, Inc.</a></h4>							            
							            <div class="small-txt mb5"><i class="fa fa-map-marker"></i> San Francisco, California, USA</div>
							        </div>
								</div>
								<div class="solid-lt-green timeline-badge-spotlight"><i class="fa fa-file-text-o"></i></div>
								<div class="timeline-panel timeline-panel-post">
									<div class="timeline-heading">
					            		<h4 class="timeline-title">Mussum ipsum cacilds</h4>
					            		<p><small class="text-muted"><i class="fa fa-twitter"></i> 11 hours ago via Twitter</small></p>
					            	</div>
					            	<div class="timeline-body">
					            		<p>Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis. Mé faiz elementum girarzis, nisi eros vermeio, in elementis mé pra quem é amistosis quis leo. Manduma pindureta quium dia nois paga. Sapien in monti palavris qui num significa nadis i pareci latim. Interessantiss quisso pudia ce receita de bolis, mais bolis eu num gostis.</p>
					            		<p>Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis. Mé faiz elementum girarzis, nisi eros vermeio, in elementis mé pra quem é amistosis quis leo. Manduma pindureta quium dia nois paga. Sapien in monti palavris qui num significa nadis i pareci latim. Interessantiss quisso pudia ce receita de bolis, mais bolis eu num gostis.</p>

					            	</div>
								</div>
		    				</li>
		    				<li>
					        	<div class="timeline-badge solid-blue"><i class="fa fa-user"></i></div>
		    				 	<div class="timeline-panel">
			    				 	<div class="text-center">
							            <img src="assets/img/user.png" class="img-circle img-offline img-responsive img-profile" alt="">
							            <h4 class="profile-name mb5"><i class="fa fa-briefcase"></i><a href=""> Company, Inc.</a></h4>							            
							            <div class="small-txt mb5"><i class="fa fa-map-marker"></i> San Francisco, California, USA</div>
							        </div>
								</div>
								<div class="solid-lt-green timeline-badge-spotlight"><i class="fa fa-file-text-o"></i></div>
								<div class="timeline-panel-post timeline-panel">
									<div class="timeline-heading">
					            		<h4 class="timeline-title">Mussum ipsum cacilds</h4>
					            		<p><small class="text-muted"><i class="fa fa-twitter"></i> 11 hours ago via Twitter</small></p>
					            	</div>
					            	<div class="timeline-body">
					            		<p>Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis. Mé faiz elementum girarzis, nisi eros vermeio, in elementis mé pra quem é amistosis quis leo. Manduma pindureta quium dia nois paga. Sapien in monti palavris qui num significa nadis i pareci latim. Interessantiss quisso pudia ce receita de bolis, mais bolis eu num gostis.</p>
					            		<p>Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis. Mé faiz elementum girarzis, nisi eros vermeio, in elementis mé pra quem é amistosis quis leo. Manduma pindureta quium dia nois paga. Sapien in monti palavris qui num significa nadis i pareci latim. Interessantiss quisso pudia ce receita de bolis, mais bolis eu num gostis.</p>
					            		
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
<script src="js/account.js"></script>

</body>
</html>
