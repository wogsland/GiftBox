<?php
use \Sizzle\Bacon\Database\{
    Organization,
    User
};

date_default_timezone_set('America/Chicago');

if (!logged_in()) {
  login_then_redirect_back_here();
}

$user = new User($_SESSION['user_id'] ?? '');
if (isset($user->organization_id) && 0 < (int) $user->organization_id) {
    $organization = new Organization($user->organization_id);
}
define('TITLE', 'S!zzle - Get iframe Code');
require __DIR__.'/header.php';
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/s/dt/jszip-2.5.0,pdfmake-0.1.18,dt-1.10.10,b-1.1.0,b-flash-1.1.0,b-html5-1.1.0,b-print-1.1.0/datatables.min.css"/>
<link rel="stylesheet" type="text/css" href="/css/datatables.min.css"/>

</head>
<body id="token-listing">
  <div>
    <?php require __DIR__.'/navbar.php';?>
  </div>
  <div class="row" id="datatable-div">
    <div class="col-sm-offset-2 col-sm-8">
      <?php if (isset($organization->long_id)) { ?>
          <h2>Embeddable Job Listing Code</h2>
          <p style="text-align:left">
            Place the iframe code below into the HTML on your website to display
            the job listings available for your organization.
          </p>
          <div style="text-align:left; margin-top:30px;">
            <pre>
&lt;iframe
  src="<?=APP_URL.'job_listing?id='.$organization->long_id?>"
  height="400"
  width="100%"
  frameborder="0"&gt;
&lt;/iframe&gt;</pre>
          </div>
      <?php } else { ?>
          Please contact <a href="mailto:rzettler@gosizzle.io?subject=iframe">Robbie Zettler</a>
          to have this feature set up for you.
      <?php }?>
    </div>
  </div>
    <?php require __DIR__.'/footer.php';?>
  <script type="text/javascript" src="https://cdn.datatables.net/s/dt/jszip-2.5.0,pdfmake-0.1.18,dt-1.10.10,b-1.1.0,b-flash-1.1.0,b-html5-1.1.0,b-print-1.1.0/datatables.min.js"></script>
  <script>
  $(document).ready(function() {
      var table = $('#responsive-table').DataTable({
          dom: 'B<"clear">lfrtip',
          buttons: [
              'copy', 'csv', 'excel', 'pdf','print'
          ]
      });
  });
  </script>
</body>
</html>
