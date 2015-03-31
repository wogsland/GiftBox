<?php
include 'database.php';
require 'Zebra_Session.php';
$session = new Zebra_Session($mysqli, 'sEcUr1tY_c0dE');
print_r('<pre>');
print_r($session->get_settings());