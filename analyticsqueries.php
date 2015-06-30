<?php
function getResults(&$analytics, $profileId) {
  // Calls the Core Reporting API and queries for the number of sessions
  // for the last seven days.
   return $analytics->data_ga->get(
       'ga:' . $profileId,
       '2009-04-20',
       'today',
       'ga:sessions');
}
