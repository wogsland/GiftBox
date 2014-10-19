<?php

execute("UPDATE user set first_name = '".$_POST['first-name']."', last_name = '".$_POST['last-name']."', email_address = '".$_POST['email']."' WHERE id = ".$_SESSION['user_id']);
$event = new eventLogger($_SESSION['user_id'], UPDATE_ACCOUNT_INFO);
$event->log();