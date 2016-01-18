<?php if (!logged_in()) { ?>
  <!-- MODALS -->
  <div class="modal fade" id="signup-dialog" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class ="modal-header" style="border-bottom: 0px;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body center">
          <div id="fb-root"></div>
          <div type="button" class="btn-lg dialog-button-center btn-facebook" onclick="signupFacebook()" style="margin-right: 20px; margin-left: 20px; text-align: center;">
            <i class="fa fa-facebook"></i> Sign Up With Facebook
          </div>
          <div style="margin-top: 20px; text-align: center;">
            <span class="center">Or</span>
          </div>
          <div id="signup-alert-placeholder"></div>
          <form id="signup-form" class="text-center">
            <input type="hidden" id="reg_type" name="reg_type" value="">
            <input id="first_name" name="first_name" type="hidden" value="">
            <input id="last_name" name="last_name" type="hidden" value="">
            <input class="dialog-input large-input" id="signup_email" name="signup_email" type="text" placeholder="Email">
            <input class="dialog-input large-input" id="signup_password" name="signup_password" type="password" placeholder="Password">
            <input type=hidden id="signup_level" name="signup_level" value="1">
            Already a member? Log in <a href="javascript:void(0)" onclick="switchToLogin()">here</a>
          </form>
          <div type="button" class="btn-lg btn-primary dialog-button-center" onclick="signupEmail()" style="border: 1px solid #e5e5e5; margin-top: 15px;margin-right: 20px; margin-left: 20px; text-align: center;">
            Sign Up With Email
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="login-dialog" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class ="modal-header" style="border-bottom: 0px;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <div id="fb-root"></div>
          <div type="button" class="btn-lg dialog-button-center btn-facebook" onclick="loginFacebook()" style="margin-right: 20px; margin-left: 20px;text-align: center;">
            <i class="fa fa-facebook"></i> Log In With Facebook
          </div>
          <div style="margin-top: 20px; text-align: center;">
            <span class="center">Or</span>
          </div>
          <div id="login-alert-placeholder"></div>
          <form id="login-form">
            <input type="hidden" name="login_type" value="EMAIL">
            <input class="dialog-input large-input" id="login_email" name="login_email" type="text" placeholder="Email address" size="25">
            <input class="dialog-input large-input" id="password" name="password" type="password" placeholder="Password" size="25">
          </form>
          <a id="forgot-password" href="/forgot_password">Forgot your password?</a>
          <div type="button" class="btn-lg btn-primary dialog-button-center" onclick="loginEmail()" style="border: 1px solid #e5e5e5; margin-top: 15px;margin-right: 20px; margin-left: 20px; text-align: center;">
            Log In With Email
          </div>
        </div>
      </div>
    </div>
  </div>
<?php }?>
<!-- =========================
     FOOTER
============================== -->
<footer id="contact" class="deep-dark-bg mt20">

<div class="container">
  <!-- LOGO -->
  <img src="/assets/img/sizzle-logo.png" alt="LOGO">

  <!-- SOCIAL ICONS -->
  <ul class="social-icons">
    <li><a href="https://www.linkedin.com/company/4788844"><i class="social_linkedin_square"></i></a></li>
    <li><a href="https://www.facebook.com/givetokencom"><i class="social_facebook_square"></i></a></li>
    <li><a href="https://twitter.com/give_token"><i class="social_twitter_square"></i></a></li>
    <li><a href="https://www.pinterest.com/GiveToken/"><i class="social_pinterest_square"></i></a></li>
<!--    <li><a href="#"><i class="social_googleplus_square"></i></a></li> -->
    <li><a href="https://instagram.com/givetoken"><i class="social_instagram_square"></i></a></li>
<!--    <li><a href="#"><i class="social_flickr_square"></i></a></li> -->
  </ul>

  <!--Terms and Policy-->
  <ul class="terms-policy">
    <li><a href="/about">About Us</a></li>
    <li><a href="/terms">Terms and Conditions</a></li>
    <li><a href="/privacy">Privacy Policy</a></li>
  </ul>

  <!-- COPYRIGHT TEXT -->
  <p class="copyright">
    &copy;2016 GoS!zzle.io, GiveToken.com &amp; Giftly Inc., All Rights Reserved.
  </p>

</div>
<!-- /END CONTAINER -->

</footer>
<!-- /END FOOTER -->


<!-- =========================
     SCRIPTS
============================== -->
<script src="/js/bootstrap.min.js"></script>
<script src="/js/smoothscroll.min.js"></script>
<script src="/js/jquery.scrollTo.min.js"></script>
<script src="/js/jquery.localScroll.min.js"></script>
<script src="/js/jquery-ui.min.js"></script>
<script src="/js/owl.carousel.min.js"></script>
<script src="/js/nivo-lightbox.min.js"></script>
<script src="/js/simple-expand.min.js"></script>
<script src="/js/wow.min.js"></script>
<script src="/js/jquery.stellar.min.js"></script>
<script src="/js/retina-1.1.0.min.js"></script>
<script src="/js/jquery.nav.min.js"></script>
<script src="/js/matchMedia.min.js"></script>
<script src="/js/jquery.ajaxchimp.min.js"></script>
<script src="/js/jquery.fitvids.min.js"></script>
<script src="/js/custom.min.js?v=<?php echo VERSION;?>"></script>
<script src="/js/facebook_init.min.js?v=<?php echo VERSION;?>"></script>
<script src="/js/util.min.js?v=<?php echo VERSION;?>"></script>
<script src="/js/pay_with_stripe.js?v=<?php echo VERSION;?>"></script>
<?php if (!logged_in()) { ?>
  <script src="/js/login.min.js?v=<?php echo VERSION;?>"></script>
  <script src="/js/signup.min.js?v=<?php echo VERSION;?>"></script>
<?php } elseif (isset($_SESSION['stripe_id'])) { ?>
  <script>
  $(document).ready(function() {
    setTimeout(function () {
      $('#upgrade-dropdown').hide();
      $('#upgrade-divider').hide();
    }, 500);
  });
  </script>
<?php }?>
<script src="/js/account.min.js?v=<?php echo VERSION;?>"></script>
<script src="https://checkout.stripe.com/checkout.js"></script>
