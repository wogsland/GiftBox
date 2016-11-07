<?php
if (logged_in()) {
    header('Location: /profile');
}
?>
<!doctype html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge"><![endif]-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
  <title>S!zzle - Sell the Sizzle not the Steak</title>
  <meta name="description" content="Recruiting Technology">
  <meta name="keywords" content="recruiting, startups">

  <meta property="og:video" content="https://www.youtube.com/watch?v=uHzRX-8jC3s" />
  <meta property="og:site_name" content="S!zzle" />
  <meta property="og:title" content="S!zzle" />

  <link rel="shortcut icon" href="/images/favicon.png">
  <link rel="stylesheet" type="text/css" href="assets2/css/custom-animations.css" />
  <link rel="stylesheet" type="text/css" href="assets2/css/lib/font-awesome.min.css" />
  <link rel="stylesheet" type="text/css" href="assets2/css/style.css" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">

  <?php require_once __DIR__."/analyticstracking.php" ?>

  <!--[if lt IE 9]>
    <script src="assets2/js/html5shiv.js"></script>
    <script src="assets2/js/respond.min.js"></script>
  <![endif]-->
</head>

<body id="landing-page" class="landing-page">
  <!-- Preloader -->
  <div class="preloader-mask">
    <div class="preloader"><div class="spin base_clr_brd"><div class="clip left"><div class="circle"></div></div><div class="gap"><div class="circle"></div></div><div class="clip right"><div class="circle"></div></div></div></div>
  </div>

  <header class="fixed-menu">
    <nav class="navigation navigation-header">
      <div class="container">
        <div class="navigation-brand">
          <div class="brand-logo">
            <a href="index.html" class="logo"></a><a href="index.html" class="logo logo-alt"></a>
          </div>
        </div>
        <button class="navigation-toggle">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <div class="navigation-navbar collapsed">
          <ul class="navigation-bar navigation-bar-left">
            <li><a href="#hero">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#features">Features</a></li>
            <li><a href="/pricing">Prices</a></li>
            <li><a href="#feedback">Feedback</a></li>
            <li><a href="#team">Team</a></li>
            <li><a href="https://blog.gosizzle.io">Blog</a></li>
            <li><a href="#guarantee">Contact</a></li>
          </ul>
          <ul class="navigation-bar navigation-bar-right">
            <li><a href="/email_signup?action=login">Login</a></li>
            <li class="featured"><a class="btn btn-sm btn-outline-color" href="/pricing">Sign up</a></li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <section id="product" class="section product-section align-center dark-text animated" data-animation="fadeInUp" data-duration="500" style="margin-top:50px;">
    <div class="container">
      <div class="section-header">
        <h2>PRODUCT <span class="highlight">PACKAGES</span></h2>
        <p class="sub-header">
          Pick a plan and start sizzling!
          <br />
          That's right. <b>En fuego.</b>
          Just use the slider to select
          <br />
          the number of job postings you need per month.
        </p>
      </div>
      <div class="section-content row">

        <div class="col-sm-4">
          <div class="package-column disabled">
            <div class="package-title">STARTER</div>
            <div class="package-price">
              <div class="price"><span class="currency">$</span>1,250</div>
              <div class="period">one time</div>
            </div>
            <div class="package-detail">
              <ul class="list-unstyled">
                <li><strong>1</strong> Recruiter</li>
                <li><strong>5</strong> Job Bundle</li>
                <li><strong>$250</strong> Cost Per Job<sup>*</sup></li>
              </ul>
              <a href="#" class="btn btn-outline-color btn-block">Buy Now</a>
            </div>
          </div>
        </div>

        <div class="col-sm-4">
          <div class="package-column disabled">
            <div class="package-title">TIER 1</div>
            <div class="package-price">
              <div class="price"><span class="currency">$</span>2,400</div>
              <div class="period">one time</div>
            </div>
            <div class="package-detail">
              <ul class="list-unstyled">
                <li><strong>3</strong> Recruiters</li>
                <li><strong>10</strong> Job Bundle</li>
                <li><strong>$240</strong> Cost Per Job<sup>*</sup></li>
              </ul>
              <a href="#" class="btn btn-outline-color btn-block">Buy Now</a>
            </div>
          </div>
        </div>

        <div class="col-sm-4">
          <div class="package-column disabled">
            <div class="package-title">TIER 2</div>
            <div class="package-price">
              <div class="price"><span class="currency">$</span>4,100</div>
              <div class="period">one time</div>
            </div>
            <div class="package-detail">
              <ul class="list-unstyled">
                <li><strong>5</strong> Recruiters</li>
                <li><strong>18</strong> Job Bundle</li>
                <li><strong>$227.70</strong> Cost Per Job<sup>*</sup></li>
              </ul>
              <a href="#" class="btn btn-outline-color btn-block">Buy Now</a>
            </div>
          </div>
        </div>

        <div class="col-sm-4">
          <div class="package-column disabled">
            <div class="package-title">TIER 3</div>
            <div class="package-price">
              <div class="price"><span class="currency">$</span>7500</div>
              <div class="period">one time</div>
            </div>
            <div class="package-detail">
              <ul class="list-unstyled">
                <li><strong>10</strong> Recruiters</li>
                <li><strong>35</strong> Job Bundle</li>
                <li><strong>$214.30</strong> Cost Per Job<sup>*</sup></li>
              </ul>
              <a href="#" class="btn btn-outline-color btn-block">Buy Now</a>
            </div>
          </div>
        </div>

        <div class="col-sm-4">
          <div class="package-column disabled">
            <div class="package-title">TIER 4</div>
            <div class="package-price">
              <div class="price"><span class="currency">$</span>12,600</div>
              <div class="period">one time</div>
            </div>
            <div class="package-detail">
              <ul class="list-unstyled">
                <li><strong>12</strong> Recruiters</li>
                <li><strong>60</strong> Job Bundle</li>
                <li><strong>$210</strong> Cost Per Job<sup>*</sup></li>
              </ul>
              <a href="#" class="btn btn-outline-color btn-block">Buy Now</a>
            </div>
          </div>
        </div>

        <div class="col-sm-4">
          <div class="package-column disabled">
            <div class="package-title">TIER 5</div>
            <div class="package-price">
              <div class="price"><span class="currency">$</span>21,000</div>
              <div class="period">one time</div>
            </div>
            <div class="package-detail">
              <ul class="list-unstyled">
                <li><strong>15</strong> Recruiters</li>
                <li><strong>100</strong> Job Bundle</li>
                <li><strong>$210</strong> Cost Per Job<sup>*</sup></li>
              </ul>
              <a href="#" class="btn btn-outline-color btn-block">Buy Now</a>
            </div>
          </div>
        </div>

        <div class="col-sm-4">
          <div class="package-column disabled">
            <div class="package-title">ENTERPRISE</div>
            <div class="package-price">
              <div class="price">Boom</div>
              <div class="period">contact us for pricing</div>
            </div>
            <div class="package-detail">
              <ul class="list-unstyled">
                <li><strong>More</strong> Recruiters</li>
                <li><strong>Larger</strong> Job Bundle</li>
                <li><strong>Cheaper</strong> Cost Per Job<sup>*</sup></li>
              </ul>
              <a href="#" class="btn btn-outline-color btn-block">Contact Us</a>
            </div>
          </div>
        </div>

        <br />
        * Activity fee of $50 per job per month also applied to all active jobs.
      </div>
    </div>
  </section>

  <footer id="footer" class="footer light-text">
    <div class="container">
      <div class="footer-content row">
        <div class="col-sm-4 col-xs-12">
          <div class="logo-wrapper">
            <img width="130" height="45" src="assets2/img/Logo-Sizzle-Sizzle.png" alt="logo" />
          </div>
          <p>Life is short and your time is valuable. Our mission is to save you and your clients time while bringing them a quality product that fully services their needs.</p>
          <p><strong>Gary Peters, Founder</strong></p>
        </div>
        <div class="col-sm-5 social-wrap col-xs-12">
          <strong class="heading">Social Networks</strong>
          <ul class="list-inline socials">
            <li><a href="https://www.facebook.com/GoSizzle/"><span class="icon icon-socialmedia-08"></span></a></li>
            <li><a href="https://www.linkedin.com/company/7585107"><span class="icon icon-socialmedia-05"></span></a></li>
            <li><a href="https://twitter.com/Go_Sizzle"><span class="icon icon-socialmedia-06"></span></a></li>
          </ul>
        </div>
        <div class="col-sm-3 col-xs-12">
          <strong class="heading">Our Contacts</strong>
          <ul class="list-unstyled">
            <li><span class="icon icon-chat-messages-14"></span><a href="mailto:token@GoSizzle.io">token@GoSizzle.io</a></li>
            <li><span class="icon icon-seo-icons-34"></span>Nashville, TN 37204</li>
            <li><span class="icon icon-seo-icons-17"></span>(901)-486-7886</li>
          </ul>
        </div>
      </div>
    </div>
    <div class="copyright">
      &copy; Giftly Inc, 2016. All rights reserved.<br />
      <!--Terms and Policy-->
      <a href="/terms" style="color:white;">Terms and Conditions</a> |
      <a href="/privacy" style="color:white;">Privacy Policy</a> |
      <a href="/support" style="color:white;">Contact Support</a> |
      <a href="/affiliates" style="color:white;">Affiliate Program</a> |
      <a href="/careers" style="color:white;">Careers</a>
    </div>
  </footer>

  <div class="back-to-top"><i class="fa fa-angle-up fa-3x"></i></div>

  <!--[if lt IE 9]>
    <script type="text/javascript" src="assets2/js/jquery-1.11.3.min.js?ver=1"></script>
  <![endif]-->
  <!--[if (gte IE 9) | (!IE)]><!-->
    <script type="text/javascript" src="assets2/js/jquery-2.1.4.min.js?ver=1"></script>
  <!--<![endif]-->

  <script type="text/javascript" src="assets2/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="assets2/js/jquery.flexslider-min.js"></script>
  <script type="text/javascript" src="assets2/js/jquery.appear.js"></script>
  <script type="text/javascript" src="assets2/js/jquery.plugin.js"></script>
  <script type="text/javascript" src="assets2/js/jquery.countdown.js"></script>
  <script type="text/javascript" src="assets2/js/jquery.waypoints.min.js"></script>
  <script type="text/javascript" src="assets2/js/jquery.validate.min.js"></script>
  <script type="text/javascript" src="assets2/js/toastr.min.js"></script>
  <script>
  var pricingHeader = true;
  </script>
  <script type="text/javascript" src="assets2/js/startuply.js"></script>
</body>
</html>
