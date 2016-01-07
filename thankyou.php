<?php
use \GiveToken\User;

if (isset($_GET['signup'])) {
    $message = 'Thank you for signing up!<br/><i>Look for a confirmation email to hit your inbox soon.</i>';
} else {
    $message = 'Thank you for being awesome.<br/>';
}

define('TITLE', 'GiveToken.com - Thank You!');
require __DIR__.'/header.php';

?>
<link rel="stylesheet" href="/css/ball-robot.min.css" />
</head>

<body id="thank-you-page">

<!-- =========================
     HEADER
============================== -->
<header class="header" data-stellar-background-ratio="0.5" id="account-profile">

<!-- SOLID COLOR BG -->
<div class=""> <!-- To make header full screen. Use .full-screen class with solid-color. Example: <div class="solid-color full-screen">  -->
    <?php require __DIR__.'/navbar.php';?>
</div>
<!-- /END COLOR OVERLAY -->
</header>
<!-- /END HEADER -->

<!-- =========================
     PRICNG SECTION
============================== -->
<center style="margin-top:150px;margin-bottom:375px;">
  <h3>
    <?php echo $message;?>
  </h3>
</center>


<div class="sand"></div>
<div class="ball-robot">
  <div class="antennas">
    <div class="antenna short"></div>
    <div class="antenna long"></div>
  </div>
  <div class="head">
    <div class="stripe one"></div>
    <div class="stripe two"></div>
    <div class="eyes">
      <div class="eye one"></div>
      <div class="eye two"></div>
    </div>
    <div class="stripe three"></div>
  </div>
  <div class="ball">
    <div class="lines one"></div>
    <div class="lines two"></div>
    <div class="ring one"></div>
    <div class="ring two"></div>
    <div class="ring three"></div>
  </div>
  <div class="shadow"></div>
</div>


<?php require __DIR__.'/footer.php';?>
<!-- =========================
     PAGE SPECIFIC SCRIPTS
============================== -->
<script>
var $w = $( window ).width();
var $dW = $('.ball-robot').css('width');
$dW = $dW.replace('px', '');
$dW = parseInt($dW);
var $dPos = 0;
var $dSpeed = 1;
var $dMinSpeed = 1;
var $dMaxSpeed = 4;
var $dAccel = 1.04;
var $dRot = 0;
var $mPos = $w - $w/5;
var $slowOffset = 120;
var $movingRight = false;

function moveDroid(){
  if($mPos > $dPos + ($dW/4)){
    // moving right
    if(!$movingRight){
      $movingRight = true;
      $('.antennas').addClass('right');
      $('.eyes').addClass('right');
    }
    if($mPos - $dPos > $slowOffset){
      if($dSpeed < $dMaxSpeed){
        // speed up
        $dSpeed = $dSpeed * $dAccel;
      }
    } else if($mPos-$dPos < $slowOffset){
      if($dSpeed > $dMinSpeed){
        // slow down
        $dSpeed = $dSpeed / $dAccel;
      }
    }
    $dPos = $dPos + $dSpeed;
    $dRot = $dRot + $dSpeed;
  } else if($mPos < $dPos - ($dW/4)){
    // moving left
    if($movingRight){
      $movingRight = false;
      $('.antennas').removeClass('right');
      $('.eyes').removeClass('right');
    }
    if($dPos - $mPos > $slowOffset){
      if($dSpeed < $dMaxSpeed){
        // speed up
        $dSpeed = $dSpeed * $dAccel;
      }
    } else if($dPos - $mPos < $slowOffset){
      if($dSpeed > $dMinSpeed){
        // slow down
        $dSpeed = $dSpeed / $dAccel;
      }
    }
    $dPos = $dPos - $dSpeed;
    $dRot = $dRot - $dSpeed;
  } else { }
  $('.ball-robot').css('left', $dPos);
  $('.ball').css({ WebkitTransform: 'rotate(' + $dRot + 'deg)'});
  $('.ball').css({ '-moz-transform': 'rotate(' + $dRot + 'deg)'});
}

setInterval(moveDroid, 10);

$( document ).on( "mousemove", function( event ) {
  $('h2').addClass('hide');
  $mPos = event.pageX;
  return $mPos;
});
</script>

<!-- Codepen from http://codepen.io/apexdesignstudio/pen/PPEJwz -->
</body>
</html>
