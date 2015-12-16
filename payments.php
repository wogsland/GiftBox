<?php
use \GiveToken\RecruitingToken;
use \Stripe\Charge;
use \Stripe\Stripe;

date_default_timezone_set('America/Chicago');

if (!logged_in()) {
    header('Location: '.$app_root);
}

define('TITLE', 'GiveToken.com - Payments');
require __DIR__.'/header.php';
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/s/dt/jszip-2.5.0,pdfmake-0.1.18,dt-1.10.10,b-1.1.0,b-flash-1.1.0,b-html5-1.1.0,b-print-1.1.0/datatables.min.css"/>
<link rel="stylesheet" type="text/css" href="/css/datatables.min.css"/>

</head>
<body id="payments-listing">
  <div>
    <?php require __DIR__.'/navbar.php';?>
  </div>
  <div class="row" id="datatable-div">
    <div class="col-sm-offset-2 col-sm-8">
      <h2>Payments</h2>
      <?php if (isset($_SESSION['stripe_id'])) { ?>
        <table id="responsive-table" class="table table-striped table-hover">
          <thead>
            <th>Payment</th>
            <th>Status</th>
            <th>Method</th>
            <th>Invoice</th>
            <th>Date &amp; Time</th>
          </thead>
          <tbody>
            <?php
            Stripe::setApiKey($stripe_secret_key);
            $success = 'true';
            $data = Charge::all(array('customer'=>$_SESSION['stripe_id']));
            $payments = json_decode(ltrim($data,'Stripe\Collection JSON: '))->data;
            foreach ($payments as $payment) {
                echo '<tr>';
                echo "<td>$".money_format('%i',$payment->amount/100)."</td>";
                echo "<td>{$payment->status}</td>";
                echo "<td>{$payment->source->brand} ending in {$payment->source->last4}</td>";
                echo "<td><a href=\"/invoice?id={$payment->invoice}\" target=_blank>invoice details</a></td>";
                echo "<td>".date('d/m/Y g:i a', $payment->created)."</td>";
                echo '</tr>';
            }?>
          </tbody>
        </table>
      <?php } else { ?>
        No payments yet.
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
