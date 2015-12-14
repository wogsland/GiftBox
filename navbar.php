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

      <?php if (DEVELOPMENT) { ?>
        <h3 class="pull-right" style="color:red;">DEVELOPMENT</h3>
      <?php }?>

      <a class="navbar-brand" href="<?php echo $app_root ?>">
        <img src="/assets/img/logo-light.png" alt="">
      </a>

    </div>

    <!-- NAVIGATION LINKS -->
    <div class="navbar-collapse collapse" id="kane-navigation">
      <ul class="nav navbar-nav navbar-right main-navigation">
        <?php if (!logged_in()) { ?>
            <li><a href="/" class="external">Home</a></li>
        <?php } else { ?>
            <li><a href="/create_recruiting" class="external">Create Token</a></li>
        <?php } ?>
        <?php if (!logged_in()) { ?>
          <li><a href="/pricing" class="external">Pricing</a></li>
        <?php } ?>
        <!--<li><a href="blog.givetoken.com" class="external">Blog</a></li>-->
        <?php if (logged_in()) { ?>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle external" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Account <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="/upgrade" class="external account-dropdown" id="upgrade-dropdown">Upgrade</a></li>
                <li role="separator" class="divider" id="upgrade-divider"></li>
                <li><a href="/tokens" class="external account-dropdown">My Tokens</a></li>
                <li><a href="/profile" class="external account-dropdown">Profile</a></li>
                <li><a href="/payments" class="external account-dropdown">Payments</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="javascript:void(0)" class="account-dropdown" onclick="logout();">Logout</a></li>
              </ul>
            </li>
            <?php if (is_admin()) { ?>
                <li><a href="/admin" class="external">Admin</a></li>
            <?php }?>
        <?php } else { ?>
            <li><a href="javascript:void(0)" onclick="loginOpen()">Login</a></li>
            <li><a href="javascript:void(0)" onclick="signupOpen(1)">Sign Up</a></li>
        <?php }?>
      </ul>
    </div>
  </div> <!-- /END CONTAINER -->
</div> <!-- /END STICKY NAVIGATION -->
