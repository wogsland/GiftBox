<?php
use \GiveToken\User;

require_once __DIR__.'/config.php';

if (isset($_GET['signup'])) {
  $message = 'Thank you for signing up!<br/><i>Look for a confirmation email to hit your inbox soon.</i>';
} else {
  $message = 'Thank you for being awesome.<br/>';
}

define('TITLE', 'GiveToken.com - Thank You!');
require __DIR__.'/header.php';

?>
<style>
*, *:before, *:after {
  box-sizing: border-box;
}

body {
  background: #869F9D;
  overflow: hidden;
}

.sand {
  background: #B69C77;
  height: 30%;
  position: absolute;
  width: 100%;
  z-index: -1;
  right: 0;
  bottom: 0;
  left: 0;
}

.bb8 {
  position: absolute;
  margin-left: -70px;
  width: 140px;
  bottom: 20%;
  left: 0;
}

.antennas {
  position: absolute;
  transition: left .6s;
  left: 22%;
}
.antennas.right {
  left: 0%;
}

.antenna {
  background: #e0d2be;
  position: absolute;
  width: 2px;
}
.antenna.short {
  height: 20px;
  top: -60px;
  left: 50px;
}
.antenna.long {
  border-top: 6px solid #020204;
  border-bottom: 6px solid #020204;
  height: 36px;
  top: -78px;
  left: 56px;
}

.head {
  background: #e0d2be;
  border-radius: 90px 90px 14px 14px;
  -moz-border-radius: 90px 90px 14px 14px;
  -webkit-border-radius: 90px 90px 14px 14px;
  height: 56px;
  margin-left: -45px;
  overflow: hidden;
  position: absolute;
  width: 90px;
  z-index: 1;
  top: -46px;
  left: 50%;
}
.head .stripe {
  position: absolute;
  width: 100%;
}
.head .stripe.one {
  background: #999;
  height: 6px;
  opacity: .8;
  z-index: 1;
  top: 6px;
}
.head .stripe.two {
  background: #CD7640;
  height: 4px;
  top: 17px;
}
.head .stripe.three {
  background: #999;
  height: 4px;
  opacity: .5;
  bottom: 3px;
}
.head .eyes {
  display: block;
  height: 100%;
  position: absolute;
  width: 100%;
  transition: left .6s;
  left: 0%;
}
.head .eyes.right {
  left: 36%;
}
.head .eye {
  border-radius: 50%;
  display: block;
  position: absolute;
}
.head .eye.one {
  background: #020204;
  border: 4px solid #e0d2be;
  height: 30px;
  width: 30px;
  top: 12px;
  left: 12%;
}
.head .eye.one:after {
  background: white;
  border-radius: 50%;
  content: "";
  display: block;
  height: 3px;
  position: absolute;
  width: 3px;
  top: 4px;
  right: 4px;
}
.head .eye.two {
  background: #e0d2be;
  border: 1px solid #020204;
  height: 16px;
  width: 16px;
  top: 30px;
  left: 40%;
}
.head .eye.two:after {
  background: #020204;
  border-radius: 50%;
  content: "";
  display: block;
  height: 10px;
  position: absolute;
  width: 10px;
  top: 2px;
  left: 2px;
}

.ball {
  background: #d1c3ad;
  border-radius: 50%;
  height: 140px;
  overflow: hidden;
  position: relative;
  width: 140px;
}

.lines {
  border: 2px solid #B19669;
  border-radius: 50%;
  height: 400px;
  opacity: .6;
  position: absolute;
  width: 400px;
}
.lines.two {
  top: -10px;
  left: -250px;
}

.ring {
  background: #CD7640;
  border-radius: 50%;
  height: 70px;
  margin-left: -35px;
  position: absolute;
  width: 70px;
}
.ring:after {
  background: #d1c3ad;
  border-radius: 50%;
  content: "";
  display: block;
  height: 70%;
  margin-top: -35%;
  margin-left: -35%;
  position: absolute;
  width: 70%;
  top: 50%;
  left: 50%;
}
.ring.one {
  margin-left: -40px;
  height: 80px;
  width: 90px;
  top: 6%;
  left: 50%;
}
.ring.two {
  height: 38px;
  width: 76px;
  -ms-transform: rotate(36deg);
  -webkit-transform: rotate(36deg);
  transform: rotate(36deg);
  top: 70%;
  left: 18%;
}
.ring.two:after {
  top: 100%;
}
.ring.three {
  height: 30px;
  -ms-transform: rotate(-50deg);
  -webkit-transform: rotate(-50deg);
  transform: rotate(-50deg);
  top: 66%;
  left: 90%;
}
.ring.three:after {
  top: 110%;
}

.shadow {
  background: #3A271C;
  border-radius: 50%;
  height: 23.33333px;
  opacity: .7;
  position: absolute;
  width: 140px;
  z-index: -1;
  left: 5px;
  bottom: -8px;
}

.shameless {
  position: absolute;
  bottom: 10px;
  right: 10px;
}

a {
  color: #333;
  font-family: 'Raleway', sans-serif;
  text-decoration: none;
}

a:visited {
  color: #333;
}

a:hover,
a:focus {
  color: white;
}
</style>
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
<div class="bb8">
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
var $dW = $('.bb8').css('width');
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
  $('.bb8').css('left', $dPos);
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
