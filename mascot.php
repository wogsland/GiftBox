<?php
define('TITLE', 'S!zzle Mascot');
require __DIR__.'/header.php';
?>
<style>
#sizzle-me {
  margin-top: 150px;
  margin-bottom: 500px;
}
</style>
</head>
<body id="mascot">
  <div>
    <?php require __DIR__.'/navbar.php';?>
  </div>
  <div class="row" id="sizzle-me">
    <center>
      <img src="/images/sizzle_mascot_cant_wait_to_sizzle.jpg" />
    </center>
  </div>
  <?php require __DIR__.'/footer.php';?>
</body>
</html>
