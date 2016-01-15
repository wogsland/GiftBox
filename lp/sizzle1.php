<?php
if (logged_in()) {
    header('Location: /profile');
}
define('TITLE', 'Sizzle - Sell the Sizzle not the Steak');
include __DIR__.'/../header.php';
?>
    <style>
    .white-line {
      margin-bottom: 10px;
    }
    #signup-call-to-action {
      margin-top: 125px;
    }
    #left-div-1 {
      padding-top: 50px;
    }
    #signup-form-container {
      margin-top: 35px;
      margin-bottom: 35px;
      text-align: center;
    }
    #sizzle-signup-form {
      width: 250px;
      margin:auto;
    }
    #continue-btn {
      width: 250px;
      background-color: rgb(148,203,197);
      color: black;
    }
    #partial-sizzle {
      height: 700px;
    }
    #inline-logo {
      margin-bottom: 50px;
    }
    #what-is-sizzle {
      background-image: linear-gradient(90deg, rgb(9,167,68), rgb(91,179,238));
      padding: 50px;
      margin: 0;
    }
    #left-div-2 {
      vertical-align: middle;
      padding-top: 100px;
      color: white;
    }
    #sizzle-envelope {
      position: relative;
      top: 0;
      left: 50px;
      width: 600px;
    }
    #sizzle-enveloped-token {
      position: absolute;
      top: 60px;
      left: 0px;
      width: 640px;
    }
    #sell-the-job {
      background-image: linear-gradient(90deg, rgb(23,42,111), rgb(22,215,222));
      padding: 50px;
      margin: 0;
    }
    #left-div-3 {
      vertical-align: middle;
      padding-top: 50px;
      color: white;
    }
    #ipad-token-back {
      position: relative;
      top: 0;
      left: 0;
      width: 680px;
    }
    #ipad-token {
      position: absolute;
      top: 30px;
      left: 90px;
      width: 600px;
    }
    #put-a-bow-on-it {
      background-image: linear-gradient(90deg, rgb(4,124,39), rgb(14,206,114));
      padding: 50px;
      margin: 0;
    }
    #left-div-4 {
      vertical-align: middle;
      padding-top: 80px;
      color: white;
    }
    #live-examples {
      background-color: white;
      padding: 50px;
      margin: 0;
    }
    #analyze-and-split-test {
      background-image: linear-gradient(90deg, rgb(132,74,148), rgb(129,42,255));
      padding: 50px;
      margin: 0;
    }
    #analyze-graph {
      background-color: white;
      padding-top: 15px;
      width: 650px;
    }
    #right-div-5 {
      vertical-align: middle;
      padding-top: 50px;
      color: white;
    }
    #sizzle-contact-footer {
      background-image: linear-gradient(135deg, rgb(11,91,229), rgb(22,211,93));
      padding: 50px;
      margin: 0;
    }
    #contact-container {
      margin: auto;
      float: none;
    }
    #contact-form-column {
      margin: auto;
      float: none;
    }
    #sizzle-contact-form {
      border-radius: 4px;
      background-color: black;
      padding: 30px;
    }
    #contact-email, #contact-message {
      margin-bottom: 20px;
    }
    </style>
  </head>
  <body>

    <?php /*
    <!-- =========================
         PRE LOADER
    ============================== -->
    <div class="preloader">
      <div class="status">&nbsp;</div>
    </div>
    */?>

    <!-- =========================
        Navbar
    ============================== -->
    <header class="header" data-stellar-background-ratio="0.5" id="home">
          <?php include __DIR__.'/../navbar.php';?>
    </header>

    <section id="signup-call-to-action">
      <div class="container">
        <div class="row">
          <div id="left-div-1" class="col-md-7 wow fadeIn animated" data-wow-offset="10" data-wow-duration="1.5s">
            <h2>How Important is<br /> Candidate Experience?</h2>
            Recruiting Agency, Corporation, or RPO<br />
            First Impressions Matter<br />
            <div id="signup-form-container">
              <form id="sizzle-signup-form" action="/ajax/signup" method="post">
                <div class="form-group" id="email-form-group">
                  <input type="email" class="form-control" id="sizzle1_signup_email" name="sizzle1_signup_email" placeholder="Email" autocomplete="off" required>
                </div>
                <div class="form-group" id="password-form-group" hidden>
                  <input type="password" class="form-control" id="sizzle1_signup_password" name="sizzle1_signup_password" placeholder="Password" autocomplete="off" required>
                </div>
                <?php /*
                <div class="checkbox">
                  <label>
                    <input type="checkbox" checked> Send me the Sizzling Newsletter
                  </label>
                </div>
                */?>
                <div id="continue-btn" class="btn">Continue</div>
              </form>
              30 Day Free Trial
            </div>
            <br />
            <h3>
              Create enagaging material with Sizzle
            </h3>
            <div class="white-line">
            </div>
            <p>
            Email, InMail, Text
            <p>
          </div>
          <div class="col-md-5 wow fadeIn animated" data-wow-offset="10" data-wow-duration="1.5s">
            <img src="/assets/img/partial-screenshot.png" alt="screenshot" id="partial-sizzle">
          </div>
        </div>
      </div>
    </section>

    <section id="what-is-sizzle">
      <div class="container">
        <div class="row">
          <div id="left-div-2" class="col-md-4 wow fadeInLeft animated" data-wow-offset="10" data-wow-duration="1.5s">
            <h2>Reduced Time</h2>
            <div class="white-line"></div>
            With more enagaging content, recruiters will see a
            higher conversion rate. This means that recruiters will
            need to source and outreach to fewer candidates,
            creating more time for other placements.
          </div>
          <div id="right-div-2" class="col-md-8 wow fadeInRight animated" data-wow-offset="10" data-wow-duration="1.5s">
            <img src="/assets/img/Env.png" alt="example token" id="sizzle-envelope"/>
            <img src="/assets/img/Horizontal_Token.png" alt="example token" id="sizzle-enveloped-token"/>
          </div>
        </div>
      </div>
    </section>

    <section id="sell-the-job">
      <div class="container">
        <div class="row">
          <div id="left-div-3" class="col-md-4 wow fadeInLeft animated" data-wow-offset="10" data-wow-duration="1.5s">
            <h2>Increased Revenue</h2>
            <div class="white-line">
            </div>
            Improving placement rates provides value
            for both corporate recruiters and agency
            recruiters. Corporate recuiters spend less
            mean lower cost per hire. Agency recruiters
            can make placements quicker and increase
            business.
          </div>
          <div class="col-md-8 wow fadeInRight animated" data-wow-offset="10" data-wow-duration="1.5s">
            <img src="/assets/img/ipad-back.png" alt="example token ipad" id="ipad-token-back">
            <img src="/assets/img/ipad.png" alt="example token" id="ipad-token">
          </div>
        </div>
      </div>
    </section>

    <section id="put-a-bow-on-it">
      <div class="container">
        <div class="row">
          <div id="left-div-4" class="col-md-6 wow fadeInLeft animated" data-wow-offset="10" data-wow-duration="1.5s">
            <h2>Increased Reputation</h2>
            <div class="white-line">
            </div>
            Quicker, more efficient placements coupled with
            an overall better candidate experience leads to a
            stronger brand value, which in turn leads to new
            customer acquisition.
          </div>
          <div id="right-div-4" class="col-md-6 wow fadeInRight animated" data-wow-offset="10" data-wow-duration="1.5s">
            <img src="/assets/img/token-iphone-cropped.png" alt="fake example" width=250>
          </div>
        </div>
      </div>
    </section>

    <section id="not-steak">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1>Sell the <img src="/assets/img/sizzle-logo.png" alt="Sizzle" id="inline-logo"> not the Steak</h1>
          </div>
        </div>
      </div>
    </section>

    <section id="analyze-and-split-test">
      <div class="container">
        <div class="row">
          <div class="col-md-8 wow fadeInLeft animated" data-wow-offset="10" data-wow-duration="1.5s">
            <div id="analyze-graph">
              <img id="analyze-graph-img" src="/assets/img/analyze_graph.png" alt="analyze_graph"width=600>
            </div>
          </div>
          <div  id="right-div-5" class="col-md-4 wow fadeInRight animated" data-wow-offset="10" data-wow-duration="1.5s">
            <h2>Analyze and Split Test</h2>
            <div class="white-line">
            </div>
            Recruiters send hundreds of messages and need a way to track
            the success of each message. Sizzle provides an analytics
            package that allows the recruiter to see what candidates actually
            engage with.
          </div>
        </div>
      </div>
    </section>

    <section id="sizzle-contact-footer">
      <div class="container" id="contact-container">
        <div id="contact" class="row">
          <div class="col-md-8" id="contact-form-column">
            <form id="sizzle-contact-form" role="form">
              <!-- IF MAIL SENT SUCCESSFULLY -->
              <h4 class="success">
                <i class="icon_check"></i> Your message has been sent successfully.
              </h4>
              <!-- IF MAIL SENDING UNSUCCESSFULL -->
              <h4 class="error">
                <i class="icon_error-circle_alt"></i> Unable to send message.
              </h4>
              <div class="col-md-12">
                <input class="form-control input-box" id="contact-email" type="email" name="email" placeholder="Your Email">
              </div>
              <div class="col-md-12">
                <textarea class="form-control textarea-box" id="contact-message" name="message" rows="8" placeholder="Message"></textarea>
              </div>
              <button class="btn btn-primary btn-lg" id="send-message-button">Send Message</button>
            </form>
          </div>
        </div>
      </div>
    </section>

    <?php include __DIR__.'/../footer.php';?>

    <!-- =========================
        PAGE SPECIFIC SCRIPTS
    ============================== -->
    <script>
    $(document).ready(function(){
      <?php
      if (isset($_GET['action']) && 'login' == $_GET['action']) {
          echo '$("#login-dialog").modal();';
      }
      ?>

      if ( $(window).width() < 739) {
        // small screens adjustments
        $('#partial-sizzle').hide();
        $('#what-is-sizzle').hide();
        $('#not-steak').hide();
        setTimeout(function() {
          $('#right-div-4').hide();
        },1501);
        $('#analyze-graph').width(300);
        $('#analyze-graph-img').width(290);
      }
      $('h4.success').hide();
      $('h4.error').hide();
      url = '/ajax/slackbot/<?php echo $_SERVER['REMOTE_ADDR'];?>';
      $.post(url);

      $('#email-form-group').on('click', function () {
        $('#password-form-group').show();
      });

      // process sign up form
      $('#continue-btn').on('click', function(e) {
        //alert('click!');
        //$('#sizzle-signup-form').submit();
        $.post(
          "/ajax/signup",
          {
            signup_email: $('#sizzle1_signup_email').val(),
            signup_password: $('#sizzle1_signup_password').val()
          },
          function(data, textStatus, jqXHR){
            if(data.status === "SUCCESS") {
              window.location.href = '/thankyou?signup'
            } else if (data.status === "ERROR") {
              console.log(data.message);
            }  else {
              console.log("Unknown return status: "+data.status);
            }
        }).fail(function() {
          console.log("Sign up failed.");
        });
      });

      // process contact form
      $('#send-message-button').on('click', function(e) {
        e.preventDefault();
        $.post("/ajax/sendemail", $('#sizzle-contact-form').serialize(),
          function(data, textStatus, jqXHR){
            if(data.status === "SUCCESS") {
              $( ".error" ).hide();
              $( ".success" ).show();
            } else {
              $( ".success" ).hide();
              $( ".error" ).show();
            }
          }
        ).fail(function() {
          $( ".error" ).show();
        });
      });
    });
    </script>
  </body>
</html>
