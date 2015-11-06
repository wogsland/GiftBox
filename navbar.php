<!-- STICKY NAVIGATION (Animation removed)-->
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

      <a class="navbar-brand" href="<?php echo $app_root ?>"><img src="/assets/img/logo-light.png" alt=""></a>

    </div>

    <!-- NAVIGATION LINKS -->
    <div class="navbar-collapse collapse" id="kane-navigation">
      <ul class="nav navbar-nav navbar-right main-navigation">
        <li><a href="/" class="external">Home</a></li>
        <li><a href="/community.php" class="external">Community</a></li>
        <li><a href="/pricing.php" class="external">Pricing</a></li>
        <?php
        if (logged_in()) {
          echo '<li><a href="javascript:void(0)" onclick="logout();">Logout</a></li>';
          echo '<li><a href="/profile.php" class="external">Account</a></li>';
          if (is_admin()) {
            echo '<li><a href="/admin.php" class="external">Admin</a></li>';
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
