
<!doctype html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge"><![endif]-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
  <title>S!zzle - Learn More</title>
  <meta name="description" content="Recruiting Technology">
  <meta name="keywords" content="recruiting, startups">

  <meta property="og:video" content="https://www.youtube.com/watch?v=uHzRX-8jC3s" />
  <meta property="og:site_name" content="S!zzle" />
  <meta property="og:title" content="S!zzle" />

  <link rel="shortcut icon" type="image/png" href="/images/favicon.png">
  <link rel="stylesheet" type="text/css" href="assets2/css/custom-animations.css" />
  <link rel="stylesheet" type="text/css" href="assets2/css/lib/font-awesome.min.css" />
  <link rel="stylesheet" type="text/css" href="assets2/css/style.css" />

  <!--[if lt IE 9]>
    <script src="assets2/js/html5shiv.js"></script>
    <script src="assets2/js/respond.min.js"></script>
  <![endif]-->
</head>

<body id="shortcodes-page" class="forms-page">
  <!-- Preloader -->
  <div class="preloader-mask">
    <div class="preloader"><div class="spin base_clr_brd"><div class="clip left"><div class="circle"></div></div><div class="gap"><div class="circle"></div></div><div class="clip right"><div class="circle"></div></div></div></div>
  </div>

  <!-- Header -->
  <header>
    <nav class="navigation navigation-header">
      <div class="container">
        <div class="navigation-brand">
          <div class="brand-logo">
            <a href="index.html" class="logo"></a><a href="/" class="logo logo-alt"></a>
          </div>
        </div>
        <button class="navigation-toggle">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <div class="navigation-navbar collapsed">
          <ul class="navigation-bar navigation-bar-left">
            <li><a href="/#hero">Home</a></li>
            <li><a href="/#about">About</a></li>
            <li><a href="/#features">Features</a></li>
            <li><a href="/pricing">Prices</a></li>
            <li><a href="/#feedback">Feedback</a></li>
            <li><a href="/#team">Team</a></li>
            <li><a href="https://blog.gosizzle.io">Blog</a></li>
            <li><a href="/#guarantee">Contact</a></li>
          </ul>
          <ul class="navigation-bar navigation-bar-right">
            <li><a href="/email_signup?action=login">Login</a></li>
            <li class="featured"><a class="btn btn-sm btn-outline-color" href="/pricing">Sign up</a></li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <div class="container-fluid row">

    <div class="window-height light-text form-section form-section3 clearfix">
      <div class="container centered-block">

        <div class="col-sm-6 col-sm-offset-3">
          <div id="call-to-action" class="heading-block align-center">
            <h2>Set Up <span class="highlight">Your Demo</span></h2>
            <p class="heading-font">
              Sizzle is all about improving email outreach. To learn how Sizzle
              works, enter your email below, and we will reach out to schedule a
              demo with you.
            </p>
          </div>

          <div class="align-center">
            <div class="row">
              <span class="response"></span>
              <form id="demo-request-form" class="form form-dark">
                <div class="form-group col-sm-12">
                  <input id="email" type="email" name="email" class="form-control required email" placeholder="Email">
                </div>
                <div class="form-group col-sm-12">
                  <input type="submit" value="Request Demo" class="btn btn-solid">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
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
  <script type="text/javascript" src="assets2/js/startuply.js"></script>

  <script>
  var notoastr = 'stop';
  $( document ).ready(function() {
    // process demo request form
    $('#demo-request-form').on('submit', function (e) {
        e.preventDefault();
        $.post("/ajax/demo_request", $('#demo-request-form').serialize(),
            function (data, textStatus, jqXHR) {
                if (data.status === "SUCCESS") {
                    $(".response").html('Thanks for your interest!<br /><br /> One of our sales team will be in touch with you shortly to schedule a demo.');
                    $('#demo-request-form').hide();
                    $('#call-to-action').hide();
                    $(".response").show();
                }
            }
        )
    });
  });
  </script>
</body>
</html>
