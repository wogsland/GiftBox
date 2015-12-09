<?php
use \GiveToken\RecruitingToken;
use \Stripe\Invoice;
use \Stripe\Stripe;

date_default_timezone_set('America/Chicago');

require_once __DIR__.'/config.php';
if (!logged_in()) {
    header('Location: '.$app_root);
}

Stripe::setApiKey($stripe_secret_key);
$success = 'true';
$data = Invoice::retrieve(array('id'=>$_GET['id']));
$invoice = json_decode(ltrim($data,'Stripe\Invoice JSON: '));
$paid = ($invoice->ending_balance == 0);

define('TITLE', 'GiveToken.com - Invoice Details');
require __DIR__.'/header.php';
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/s/dt/jszip-2.5.0,pdfmake-0.1.18,dt-1.10.10,b-1.1.0,b-flash-1.1.0,b-html5-1.1.0,b-print-1.1.0/datatables.min.css"/>
<link rel="stylesheet" type="text/css" href="/css/datatables.css"/>

</head>
<body id="payments-listing">
  <div>
    <?php require __DIR__.'/navbar.php';?>
  </div>
  <div class="row" id="datatable-div">
    <div class="col-sm-offset-2 col-sm-8">
      <?php if ($paid) {?>
        <button class="btn btn-xs btn-success pull-right">Paid</button>
      <?php } else { ?>
        <button class="btn btn-xs btn-danger pull-right">Unpaid</button>
      <?php }?>
      <h2>Invoice Details</h2>
      <?php if (isset($_SESSION['stripe_id'])) { ?>
        <table id="responsive-table" class="table table-striped table-hover">
          <thead>
            <th>Amount</th>
            <th>Plan</th>
            <th>Period</th>
          </thead>
          <tbody>
            <?php
            foreach ($invoice->lines->data as $line) {
                echo '<tr>';
                echo "<td>$ {$line->amount}</td>";
                echo "<td>{$line->plan->name}</td>";
                echo "<td>".date('d/m/Y', $line->period->start).' - '.date('d/m/Y', $line->period->end)."</td>";
                echo '</tr>';
            }?>
          </tbody>
        </table>
      <?php } else { ?>
        No invoice information available at this time.
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
