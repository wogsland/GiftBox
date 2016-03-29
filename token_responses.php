<?php
use \Sizzle\Database\RecruitingTokenResponse;

date_default_timezone_set('America/Chicago');

if (!logged_in()) {
    header('Location: '.'/');
}
$user_id = $_SESSION['user_id'] ?? '';

define('TITLE', 'S!zzle - Token Responses');
require __DIR__.'/header.php';
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/s/dt/jszip-2.5.0,pdfmake-0.1.18,dt-1.10.10,b-1.1.0,b-flash-1.1.0,b-html5-1.1.0,b-print-1.1.0/datatables.min.css"/>
<link rel="stylesheet" type="text/css" href="/css/datatables.min.css"/>

</head>
<body id="token-responses">
  <div>
    <?php require __DIR__.'/navbar.php';?>
  </div>
  <div class="row" id="datatable-div">
    <div class="col-sm-offset-2 col-sm-8">
      <h2>Token Responses</h2>
      <table id="responsive-table" class="table table-striped table-hover">
        <thead>
          <th>Token</th>
          <th>Email</th>
          <th>Response</th>
          <th>Date &amp; Time (CST)</th>
        </thead>
        <tbody>
            <?php
            $RecruitingTokenResponse = new RecruitingTokenResponse();
            $responses = $RecruitingTokenResponse->get((int) $user_id);
            foreach ($responses as $response) {
                echo '<tr>';
                echo "<td><a href=\"/token/recruiting/{$response['long_id']}\">{$response['job_title']}</a><i hidden>{$response['long_id']}</i></td>";
                echo "<td>{$response['email']}</td>";
                echo "<td>{$response['response']}</td>";
                echo "<td>".date('m/d/Y g:i a', strtotime($response['created']))."</td>";
                echo '</tr>';
            }?>
        </tbody>
      </table>
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
      <?php if (isset($_GET['id'])) { ?>
          $('input').val("<?php echo $_GET['id'];?>");
          $('input').focus();
          table.search("<?php echo $_GET['id'];?>").draw();
      <?php }?>
  });
  </script>

</body>
</html>
