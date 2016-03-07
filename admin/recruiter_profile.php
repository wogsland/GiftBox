<?php
use \Sizzle\User;

if (!logged_in() || !is_admin()) {
    header('Location: '.'/');
}

define('TITLE', 'S!zzle - Update Rcruiter Profile');
require __DIR__.'/../header.php';
?>
<style>
body {
  background-color: white;
}
#user-info {
  margin-top: 100px;
  color: black;
  text-align: left;
}
.greyed {
  background-color: lightgrey;
  font-style: normal;
}
</style>
</head>
<body id="recruiter">
  <div>
    <?php require __DIR__.'/../navbar.php';?>
  </div>
  <div class="row" id="user-info">
    <div class="col-sm-offset-3 col-sm-6">
      <iframe width="420" height="315" src="https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1" frameborder="0" allowfullscreen></iframe>
    </div>
  </div>
    <?php require __DIR__.'/../footer.php';?>
</body>
</html>
