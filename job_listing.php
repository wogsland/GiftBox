<?php
use \Sizzle\Database\Organization;

$organ = new Organization($_GET['id'] ?? '');
?>
<html>
<head>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
  <style>
  body {
    background-color: white;
    font-family: 'Roboto', sans-serif;
    width: 100%;
  }
  .job-description {
    text-align: justify;
    background-color: #D3D3D3;
    padding: 15px;
  }
  .footsie {
    color: grey;
    text-align: center;
    vertical-align: middle;
  }
  a {
    text-decoration: none;
    color: black;
  }
  </style>
</head>
<body>
  <?php foreach ($organ->getJobs() as $job) { ?>
      <a href="<?=APP_URL.'token/recruiting/'.$job['long_id']?>" target="_blank">
        <h2><?=$job['title']?></h2>
        <div class="job-description"><?=$job['description']?></div>
      </a>
      <br />
  <?php }?>
  <br />
  <div class="footsie">
    Powered by
    <a href="<?=APP_URL?>" target="_blank">
      <img src="assets/img/sizzle-logo.png" height="30" />
    </a>
  <div>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script>
  $(document).ready(function() {
    var pWidth = (window.innerWidth - 45)+'px';
    $('.job-description').css('width', pWidth);
    $('body').css('width', window.innerWidth - 10);
  });
  </script>
</body>
</head>
