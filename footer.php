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
    <li><a href="https://www.linkedin.com/company/7585107" target="_blank"><i class="social_linkedin_square"></i></a></li>
    <li><a href="https://www.facebook.com/GoSizzle/" target="_blank"><i class="social_facebook_square"></i></a></li>
    <li><a href="https://twitter.com/Go_Sizzle" target="_blank"><i class="social_twitter_square"></i></a></li>
  </ul>

  <!--Terms and Policy-->
  <ul class="terms-policy">
    <li><a href="/about">About Us</a></li>
    <li><a href="/terms">Terms and Conditions</a></li>
    <li><a href="/privacy">Privacy Policy</a></li>
    <li><a href="/support">Contact Support</a></li>
    <li><a href="/affiliates">Affiliate Program</a></li>
    <li><a href="/careers">Careers</a></li>
  </ul>

  <!-- COPYRIGHT TEXT -->
  <p class="copyright">
    &copy;2016 GoSizzle.io, GiveToken.com &amp; Giftly Inc., All Rights Reserved.
  </p>

</div>
<!-- /END CONTAINER -->

</footer>
<!-- /END FOOTER -->


<!-- =========================
     SCRIPTS
============================== -->
<script src="/js/dist/sizzle.min.js?v=<?php echo VERSION;?>"></script>
<?php if (!logged_in()) {
  /** TODO Move these into marketing.min build */
?>
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
<script src="https://checkout.stripe.com/checkout.js"></script>
