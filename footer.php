<!-- =========================
     FOOTER
============================== -->
<footer id="contact" class="deep-dark-bg mt20">

<div class="container">
	<div class="verticleHeight40"></div>
	<!-- LOGO -->
	<img src="/assets/img/logo-light.png" alt="LOGO" class="responsive-img" />

	<!-- SOCIAL ICONS -->
	<ul class="social-icons">
		<li><a href="https://www.linkedin.com/company/4788844"><i class="social_linkedin_square"></i></a></li>
		<li><a href="https://www.facebook.com/givetokencom"><i class="social_facebook_square"></i></a></li>
		<li><a href="https://twitter.com/give_token"><i class="social_twitter_square"></i></a></li>
		<li><a href="https://www.pinterest.com/GiveToken/"><i class="social_pinterest_square"></i></a></li>
<!--		<li><a href="#"><i class="social_googleplus_square"></i></a></li> -->
		<li><a href="https://instagram.com/givetoken"><i class="social_instagram_square"></i></a></li>
<!--		<li><a href="#"><i class="social_flickr_square"></i></a></li> -->
	</ul>

  <!--Terms and Policy-->
  <ul class="terms-policy">
		<li><a href="/about">About Us</a></li>
		<li><a href="/terms">Terms and Conditions</a></li>
    <li><a href="/privacy">Privacy Policy</a></li>
  </ul>

	<!-- COPYRIGHT TEXT -->
	<p class="copyright">
		&copy;2015 GiveToken.com &amp; Giftly Inc., All Rights Reserved
	</p>

</div>
<!-- /END CONTAINER -->

</footer>
<!-- /END FOOTER -->


<!-- =========================
     SCRIPTS
============================== -->
<script src="/js/bootstrap.min.js"></script>
<script src="/js/smoothscroll.js"></script>
<script src="/js/jquery.scrollTo.min.js"></script>
<script src="/js/jquery.localScroll.min.js"></script>
<script src="/js/jquery-ui.min.js"></script>
<script src="/js/owl.carousel.min.js"></script>
<script src="/js/nivo-lightbox.min.js"></script>
<script src="/js/simple-expand.min.js"></script>
<script src="/js/wow.min.js"></script>
<script src="/js/jquery.stellar.min.js"></script>
<script src="/js/retina-1.1.0.min.js"></script>
<script src="/js/jquery.nav.js"></script>
<script src="/js/matchMedia.js"></script>
<script src="/js/jquery.ajaxchimp.min.js"></script>
<script src="/js/jquery.fitvids.js"></script>
<script src="/js/custom.js?v=<?php echo VERSION;?>"></script>
<script src="/js/facebook_init.js?v=<?php echo VERSION;?>"></script>
<script src="/js/util.js?v=<?php echo VERSION;?>"></script>
<script src="/pay_with_stripe.php?v=<?php echo VERSION;?>"></script>
<?php if (!logged_in()) { ?>
	<script src="/js/login.js?v=<?php echo VERSION;?>"></script>
	<script src="/js/signup.js?v=<?php echo VERSION;?>"></script>
<?php }?>
<script src="/js/account.js?v=<?php echo VERSION;?>"></script>
<script src="https://checkout.stripe.com/checkout.js"></script>
