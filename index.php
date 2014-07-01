<?php
	include_once 'util.php';
	include_once 'config.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Giftbox - Home</title>

	<link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/feature-carousel.css" />
	<link rel="stylesheet" href="css/magnific-popup.css">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Montserrat">
	<script src="js/jquery-1.10.2.min.js" type="text/javascript"></script>
    <script src="js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
    <script src="js/jquery.featureCarousel.min.js" type="text/javascript"></script>
	<script src="js/jquery.magnific-popup.js"></script>
	<script src="js/TweenMax.min.js"></script>
  	<script src="js/jquery.superscrollorama.js"></script>
	<script src="js/facebook_init.js"></script>
	<script src="js/scripts.js"></script>
	<script src="js/account.js"></script>
</head>
<body>

	<div id="header-wrapper-fixed">
		<header id="header-fixed">
			<a id="home-icon-black" title="Return to the Homepage" href="<?php echo $app_root ?>">Giftbox</a>
			<nav id="home-top-nav-fixed">
				<ul>
					<?php
					if (logged_in()) {
						echo '<li>';
						echo '<a href="javascript:void(0)" onclick="logout();" style="color: #000000">Logout</a>';
						echo '</li>';
						echo '<li>';
						echo '<a href="my_account.php" style="color: #000000">My Account</a>';
						echo '</li>';
						if (is_admin()) {
							echo '<li>';
							echo '<a href="admin.php" style="color: #000000">Admin</a>';
							echo '</li>';
						}
					} else {
						echo '<li>';
						echo '<a class="open-popup-link" id="login-link" href="#login-form" data-effect="mfp-3d-unfold" style="color: #000000">Login</a>';
						echo '</li>';
						echo '<li>';
						echo '<a class="open-popup-link" id="signup-link" href="#signup-form" data-effect="mfp-3d-unfold" style="color: #000000">Sign Up</a>';
						echo '</li>';
					}
					?>
					<li>
						<a href="about.php" style="color: #000000">About</a>
					</li>
				</ul>
			</nav>
			<!--<div id="create">
				<a id="create-link" class="open-popup-link" id="create-link" href="#login-form" data-effect="mfp-3d-unfold">Create</a>
			</div> -->

		</header>
		<div id="fss-container" class="fss-container">
		</div>
	</div>	
	<div id="content-wrapper">
		<section id="intro-section" data-type="background" data-speed="2.2">
				<div id="header-wrapper">
					<header>
						<a id="home-icon" title="Return to the Homepage" href="<?php echo $app_root ?>">Giftbox</a>
						<nav id="home-top-nav">
							<ul>
								<?php
								if (logged_in()) {
									echo '<li>';
									echo '<a href="javascript:void(0)" onclick="logout();">Logout</a>';
									echo '</li>';
									echo '<li>';
									echo '<a href="my_account.php">My Account</a>';
									echo '</li>';
									if (is_admin()) {
										echo '<li>';
										echo '<a href="admin.php">Admin</a>';
										echo '</li>';
									}
								} else {
									echo '<li>';
									echo '<a class="open-popup-link" id="login-link" href="#login-form" data-effect="mfp-3d-unfold">Login</a>';
									echo '</li>';
									echo '<li>';
									echo '<a class="open-popup-link" id="signup-link" href="#signup-form" data-effect="mfp-3d-unfold">Sign Up</a>';
									echo '</li>';
								}
								?>
								<li>
									<a href="about.php">About</a>
								</li>
							</ul>
						</nav>					
					</header>
				</div>
				<div id="intro-text" class="centered">
					<h1 id="intro-description">
						Want a simple way to personalize digital gifts?<br>
					</h1>
					<p>
						Send your next gift with Giftbox!
					</p>
					<p>
					<?php
					if (logged_in()) {
						echo '<a class="button trans big" href="create.php">Create GiftBox</a>';
					}
					else {
						echo '<a class="button trans big open-popup-link" id="login-link" href="#login-form" data-effect="mfp-3d-unfold">Login</a>';
					}
					?>
					</p>
				</div>
		</section>

		<section id="carousel-section">
			<div>
				<h4 id="small-feature"> 
					Digital Wrapper
				</h4>
				<h3 id="big-feature">
					More than just the gift
				</h3>
				<p id="feature-description">
					Customize any digital gift with personal stories. Just like how you would decorate a real gift.
				</p>
			</div>

			<div class="carousel-container">
				<div id="carousel">
					<div class="carousel-feature">
						<a href="#"><img class="carousel-image" alt="Image Caption" src="images/sample1.jpg"></a>
					</div>
					<div class="carousel-feature">
						<a href="#"><img class="carousel-image" alt="Image Caption" src="images/GiftboxExample1.jpg"></a>
					</div>
					<div class="carousel-feature">
						<a href="#"><img class="carousel-image" alt="Image Caption" src="images/sample3.jpg"></a>
					</div>
					<div class="carousel-feature">
						<a href="#"><img class="carousel-image" alt="Image Caption" src="images/sample4.jpg"></a>
					</div>
					<div class="carousel-feature">
						<a href="#"><img class="carousel-image" alt="Image Caption" src="images/sample5.jpg"></a>
					</div>
				</div>
			<div id="carousel-left"><img src="images/arrow-left.png" /></div>
			<div id="carousel-right"><img src="images/arrow-right.png" /></div>
			</div>
		</section>
		<section id="personalize-section">
			<h4 id="small-feature"> 
				Our Features
			</h4>
			<h3 id="big-feature">
				Go ahead, we got you covered
			</h3>
			<p id="feature-description">
				Our team is working hard to roll out more features everyday. Hover below to learn about what we current offer.
			</p>
			<!--
			<div id="icon-list">
				<div class="icon-container">
					<img class="icon" src="images/magnifier.png">
					<p class="icon-text">Find the right band, gift, card, or ebook in our huge database.</p> 
				</div>
				<div class="icon-container">
					<img class="icon"  src="images/pencil.png">
					<p class="icon-text">Completely customizable for that personal touch.</p> 
				</div>
				<div class="icon-container">
					<img class="icon"  src="images/credit_card.png">
					<p class="icon-text">Our service is completely free. Only pay for the gift itself.</p> 
				</div>
			</div> -->

			<ul class="ch-grid">
				<li>
					<div class="ch-item ch-img-1">				
						<div class="ch-info-wrap">
							<div class="ch-info">
								<div class="ch-info-front ch-img-1"></div>
								<div class="ch-info-back">
									<h3>Find the right band, gift, card, or ebook in our huge database.</h3>
								</div>	
							</div>
						</div>
					</div>
				</li>
				<li>
					<div class="ch-item ch-img-2">
						<div class="ch-info-wrap">
							<div class="ch-info">
								<div class="ch-info-front ch-img-2"></div>
								<div class="ch-info-back">
									<h3>Completely customizable for that personal touch.</h3>
								</div>
							</div>
						</div>
					</div>
				</li>
				<li>
					<div class="ch-item ch-img-3">
						<div class="ch-info-wrap">
							<div class="ch-info">
								<div class="ch-info-front ch-img-3"></div>
								<div class="ch-info-back">
									<h3>Our service is completely free. Only pay for the gift itself.</h3>
								</div>
							</div>
						</div>
					</div>
				</li>
			</ul>
		</section>

		<section id="add-images-section">
			<div>
				<h4 id="small-feature"> 
					Step One of Two
				</h4>
				<h3 id="big-feature">
					Personalize
				</h3>
				<p id="feature-description">
					Search your social media or upload pictures, videos, or notes. Then drag and drop into the bento boxes.
				</p>
			</div>

			<div id="animation-container">
				<div id="search-box">
					<img src="images/search.jpg" width="309" height="423">
					<div id="text-reveal">
					</div>
				</div>
				<img id="blank-template" src="images/blank_template.jpg" width="637" height="423">
				<img id="rhcp-logo" src="images/AddImage1.jpg" width="100" height="100">
				<img id="blank-template-over" src="images/blank_template_over.jpg" width="637" height="423">
			</div>
		</section>
		
		<section id="add-downloads-section">
			<div>
				<h4 id="small-feature"> 
					Step Two of Two
				</h4>
				<h3 id="big-feature">
					Add content
				</h3>
				<p id="feature-description">
					Fill the Giftbox with singles, albums, ebooks, giftcards, and more!
				</p>
			</div>
			<div id="animation-container-2">
				<div id="search-box-2">
					<img src="images/search2.png" width="309" height="423">
					<div id="text-reveal-2">
					</div>
				</div>
				<img id="blank-template-2" src="images/blank_template_2.jpg" width="637" height="423">
				<img id="blank-template-3" src="images/blank_template_3.png" width="637" height="423">
				<img id="download" src="images/music_file_icon.png" width="100" height="100">
				<img id="box-top" src="images/box_top.png" width="243" height="122">
				<img id="box-bottom" src="images/box_bottom.png" width="243" height="138">
			</div>
		</section>
		
	</div>

	<div id="footer-wrapper">
		<footer>
			<nav>
				<!--<ul>
					<li>
						<a href="/about/">ABOUT</a>
					</li>
					<li>
						<a href="/support/faq/">FAQ</a>
					</li>
					<li>
						<a href="/support/">SUPPORT</a>
					</li>
				</ul>-->
					<ul class="dark">
					<li>
						<a href="/privacy/">PRIVACY POLICY</a>
					</li>
					<li>
						<a href="/terms/">TERMS OF SERVICE</a>
					</li>
				</ul>
			</nav>
			<ul class="social">
				<li class="facebook">
					<a id="facebook-icon" target="_bland" href="http://www.facebook.com">Facebook</a>
				</li>
				<li class="twitter">
					<a id="twitter-icon" href="http://twitter.com">Twitter</a>
				</li>
			</ul>
		</footer>
	</div>

	<form id="login-form" class="white-popup mfp-hide" name="login-form">
		<h1 class="dialog-header">Log Into Giftbox</h1>
		<div id="dialog-form-container">
			<p class="dialog-message" id="login-message"></p>
			<input class="dialog-input" id="email" name="email" type="text" placeholder="Email address" size="25">
			<input class="dialog-input" id="password" name="password" type="password" placeholder="Password" size="25">
			<a id="forgot-password" href="javascript:void(0)" onClick="forgotPassword()">Forgot your password?</a>
			<a class="dialog-button" id="facebook-button" href="javascript:void(0)" onClick="FB.login(function(response){handleFBLogin(response)}, {scope: 'public_profile, email'});">Log In with Facebook</a>
			<a class="dialog-button dialog-button-right" href="javascript:void(0)" onClick="var a = document.forms['login-form']; login(a.email.value, a.password.value);">Log In</a>
		</div>
	</form>

	<form id="signup-form" class="white-popup mfp-hide" name="signup-form">
		<h1 class="dialog-header">Sign Up With Giftbox</h1>
		<div id="dialog-form-container">
			<p class="dialog-message" id="signup-message"></p>
			<input class="dialog-input" id="first-name" name="first-name" type="text" placeholder="First Name" size="20">
			<input class="dialog-input" id="last-name" name="last-name" type="text" placeholder="Last Name" size="20">
			<input class="dialog-input" id="email" name="email" type="text" placeholder="Your Email" size="40">
			<input class="dialog-input" id="password" name="password" type="password" placeholder="New Password" size="40">
			<a class="dialog-button" id="facebook-button" href="javascript:void(0)" onClick="FB.login(function(response){handleFBReg(response)}, {scope: 'public_profile, email'});">Sign Up Using Facebook</a>
			<a class="dialog-button dialog-button-right" href="javascript:void(0)" onClick="var a = document.forms['signup-form']; register(a.first-name.value, a.last-name.value, a.email.value, a.password.value);">Sign Up</a>
		</div>
	</form>
	
	<script type="text/javascript">
		TweenLite.from("#home-icon", 2, {left:-600});
		TweenLite.from("#top-nav", 2, {top:-65});
		TweenLite.from("#home-top-nav", 2, {left:500});
		//TweenLite.from("#carousel-description",2, {scaleX:0, scaleY:0}); 
		TweenLite.from(".carousel-container", 2, {scaleX:0, scaleY:0});
	</script>



	<script type="text/javascript">
		var win      = $(window),
		    fxel     = $('#header-wrapper-fixed'),
		    load     = $('#carousel-section'),
		    eloffset = load.offset().top;
		        fxel.slideUp();
		    	fxel.fadeTo(1, 1);

		win.scroll(function() {
		    if (eloffset < win.scrollTop()) {
		        fxel.slideDown();

		    } else {
		    	//fxel.fadeTo(2,0)
		        fxel.slideUp();
		    }
		});
	</script>

	<script src="js/fss.min.js"></script>
    <script>

    var container = document.getElementById('fss-container');
    var renderer = new FSS.CanvasRenderer();
    var scene = new FSS.Scene();
    var light = new FSS.Light('#111122', '#037BCF');
    var geometry = new FSS.Plane(window.innerWidth, 5, 60, 1);
    var material = new FSS.Material('#FFFFFF', '#FFFFFF');
    var mesh = new FSS.Mesh(geometry, material);
    var now, start = Date.now();

    function initialise() {
      scene.add(mesh);
      scene.add(light);
      container.appendChild(renderer.element);
      window.addEventListener('resize', resize);
    }

    function resize() {
      renderer.setSize(container.offsetWidth, container.offsetHeight);
    }

    function animate() {
      now = Date.now() - start;
      light.setPosition(650*Math.sin(now*0.001), 100*Math.cos(now*0.0005), 60);
      renderer.render(scene);
      requestAnimationFrame(animate);
    }

    initialise();
    resize();
    animate();

    </script>


</body>
</html>
