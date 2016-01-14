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
    .show-more-btn {
      background-color: black;
      opacity: .3;
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
    }
    #sizzle-envelope {
      position: relative;
      top: 0;
      left: 0;
      width: 600px;
    }
    #sizzle-enveloped-token {
      position: absolute;
      top: 40px;
      left: 50px;
      width: 600px;
    }
    #sell-the-job {
      background-image: linear-gradient(90deg, rgb(23,42,111), rgb(22,215,222));
      padding: 50px;
      margin: 0;
    }
    #left-div-3 {
      vertical-align: middle;
      padding-top: 50px;
    }
    #put-a-bow-on-it {
      background-image: linear-gradient(90deg, rgb(4,124,39), rgb(14,206,114));
      padding: 50px;
      margin: 0;
    }
    #left-div-4 {
      vertical-align: middle;
      padding-top: 80px;
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
    }
    #sizzle-contact-footer {
      background-image: linear-gradient(135deg, rgb(11,91,229), rgb(22,211,93));
      padding: 50px;
      margin: 0;
    }
    #contact-container {
      margin: 0;
    }
    #sizzle-contact-form {
      background-color: black;
      opacity: .3;
      padding: 30px;
    }
    #contact-email, #contact-message {
      margin-bottom: 20px;
      background-color: black;
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
          <div id="left-div-1" class="col-md-7 wow fadeInLeft animated" data-wow-offset="10" data-wow-duration="1.5s">
            <h2>How Important is Candidate Experience?</h2>
            Recruiting Agency, Corporation, or RPO<br />
            First Impressions Matter<br />
            <div id="signup-form-container">
              <form id="sizzle-signup-form">
                <div class="form-group" id="email-form-group">
                  <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
                </div>
                <div class="form-group" id="password-form-group" hidden>
                  <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
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
              Send engaging outbound material with Sizzle
            </h3>
            <div class="white-line">
            </div>
            <p>
            Email, InMail, Text
            <p>
          </div>
          <div class="col-md-5 wow fadeInRight animated" data-wow-offset="10" data-wow-duration="1.5s">
            <img src="/assets/img/partial-screenshot.png" alt="screenshot" id="partial-sizzle">
          </div>
        </div>
      </div>
    </section>

    <section id="what-is-sizzle">
      <div class="container">
        <div class="row">
          <div id="left-div-2" class="col-md-4 wow fadeInLeft animated" data-wow-offset="10" data-wow-duration="1.5s">
            <h2>What is Sizzle?</h2>
            <div class="btn show-more-btn">Show More ></div>
          </div>
          <div id="right-div-2" class="col-md-8 wow fadeInRight animated" data-wow-offset="10" data-wow-duration="1.5s">
            <img src="/assets/img/Env.png" alt="example token" id="sizzle-envelope"/>
            <img src="/assets/img/Horizontal_Token.png" alt="example token" id="sizzle-enveloped-token"/>
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

    <section id="sell-the-job">
      <div class="container">
        <div class="row">
          <div id="left-div-3" class="col-md-4 wow fadeInLeft animated" data-wow-offset="10" data-wow-duration="1.5s">
            <h2>Sell the Job</h2>
            <div class="white-line">
            </div>
            The candidate is engaged and wants to hear
            more about the job. It's time to combine
            pictures, videos, text and attachments to show
            the candidate the kind of job and company
            that they have been searching for.
          </div>
          <div class="col-md-8 wow fadeInRight animated" data-wow-offset="10" data-wow-duration="1.5s">
            <img src="/assets/img/ipad.png" alt="example token" width=600>
          </div>
        </div>
      </div>
    </section>

    <section id="put-a-bow-on-it">
      <div class="container">
        <div class="row">
          <div id="left-div-4" class="col-md-6 wow fadeInLeft animated" data-wow-offset="10" data-wow-duration="1.5s">
            <h2>Put a Bow On It</h2>
            <div class="white-line">
            </div>
            Candidates want personalization, not just a salary and set
            of skills. Using our "wrapper" functionality, create a message
            that stands out from other recruiters and other opportunities.
          </div>
          <div id="right-div-4" class="col-md-6 wow fadeInRight animated" data-wow-offset="10" data-wow-duration="1.5s">
            <img src="/assets/img/token-iphone-cropped.png" alt="fake example" width=250>
          </div>
        </div>
      </div>
    </section>

    <section id="live-examples">
      <div class="container">
        <div class="row">
          <div class="col-md-12 wow fadeInBottom animated" data-wow-offset="10" data-wow-duration="1.5s">
            <h2>Live Examples</h2>
            <div class="white-line">
            </div>
            See Token Creations from friends of GiveToken
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
            the success of each message. GiveToken provides an analytics
            package that allows the recruiter to see what candidates actually
            engage with.
          </div>
        </div>
      </div>
    </section>

    <section id="sizzle-contact-footer">
      <div class="container" id="contact-container">
        <div class="row">
          <div class="col-md-offset-2 col-md-8">
            <form id="sizzle-contact-form" role="form">
              <!-- IF MAIL SENT SUCCESSFULLY -->
              <h4 class="success">
                <i class="icon_check"></i> Your message has been sent successfully.
              </h4>
              <!-- IF MAIL SENDING UNSUCCESSFULL -->
              <h4 class="error">
                <i class="icon_error-circle_alt"></i> E-mail must be valid and message must be longer than 1 character.
              </h4>
              <div class="col-md-12">
                <input class="form-control input-box" id="contact-email" type="email" name="email" placeholder="Your Email">
              </div>
              <div class="col-md-12">
                <textarea class="form-control textarea-box" id="contact-message" name="message" rows="8" placeholder="Message"></textarea>
              </div>
              <button class="btn btn-primary btn-lg" id="send-message-button" onclick="sendMessage(event); return false;">Send Message</button>
            </form>
          </div>
        </div>
      </div>
    </section>

    <?php include __DIR__.'/../footer.php';?>

    <!-- =========================
        PAGE SPECIFIC SCRIPTS
    ============================== -->
    <script src="/js/contact.min.js?v=<?php echo VERSION;?>"></script>
    <script>
    $(document).ready(function(){
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
    });
    </script>
  </body>
</html>
