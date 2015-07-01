<?php

$tokenPath = '/preview.php?id=' . $_GET['id'];

function printResults($results) {
  // Parses the response from the Core Reporting API and prints
  // the profile name and total sessions.
  if (count($results->getRows()) > 0) {

    // Get the entry for the first entry in the first row.
    $rows = $results->getRows();
    $results = $rows[0][0];

    // Print the results.
    print $results;
  } else {
    print "No results found.\n";
  }
}

function getTotalResults($analytics, $profileId, $page) {
  // Calls the Core Reporting API and queries for the number of pageviews
  // for the last 30 days.

  $options = array(
    'dimensions' => 'ga:date',
    'filters' => 'ga:pagepath==' . $page,
    'output' => 'dataTable', 
    );

  return $analytics->data_ga->get(
     'ga:' . $profileId,
     '30daysAgo',
     'today',
     'ga:pageviews',
     $options);
}

function totalResults($analytics, $profileId, $page) {
  // Calls the Core Reporting API and queries for the total number of pageviews
  // for the last 30 days.
  $options = array(
    'filters' => 'ga:pagepath==' . $page,
    );

  return $analytics->data_ga->get(
    'ga:' . $profileId,
    '30daysAgo',
    'today',
    'ga:pageviews',
    $options);
}

function getUniqueResults($analytics, $profileId, $page) {
  // Calls the Core Reporting API and queries for the number of pageviews
  // for the last 30 days.

  $options = array(
    'dimensions' => 'ga:date',
    'filters' => 'ga:pagepath==' . $page,
    'output' => 'dataTable', 
    );

  return $analytics->data_ga->get(
     'ga:' . $profileId,
     '30daysAgo',
     'today',
     'ga:uniquePageviews',
     $options);
}

function uniqueResults($analytics, $profileId, $page) {
  // Calls the Core Reporting API and queries for the total number of pageviews
  // for the last 30 days.
  $options = array(
    'filters' => 'ga:pagepath==' . $page,
    );

  return $analytics->data_ga->get(
    'ga:' . $profileId,
    '30daysAgo',
    'today',
    'ga:uniquePageviews',
    $options);
}

function getAverageResults($analytics, $profileId, $page) {
  // Calls the Core Reporting API and queries for the number of pageviews
  // for the last 30 days.

  $options = array(
    'dimensions' => 'ga:date',
    'filters' => 'ga:pagepath==' . $page,
    'output' => 'dataTable', 
    );

  return $analytics->data_ga->get(
     'ga:' . $profileId,
     '30daysAgo',
     'today',
     'ga:avgTimeOnPage',
     $options);
}

function averageResults($analytics, $profileId, $page) {
  // Calls the Core Reporting API and queries for the total number of pageviews
  // for the last 30 days.
  $options = array(
    'filters' => 'ga:pagepath==' . $page,
    );

  return $analytics->data_ga->get(
    'ga:' . $profileId,
    '30daysAgo',
    'today',
    'ga:avgTimeOnPage',
    $options);
}

function getBouncesResults($analytics, $profileId, $page) {
  // Calls the Core Reporting API and queries for the number of pageviews
  // for the last 30 days.

  $options = array(
    'dimensions' => 'ga:date',
    'filters' => 'ga:pagepath==' . $page,
    'output' => 'dataTable', 
    );

  return $analytics->data_ga->get(
     'ga:' . $profileId,
     '30daysAgo',
     'today',
     'ga:bounces',
     $options);
}

function bouncesResults($analytics, $profileId, $page) {
  // Calls the Core Reporting API and queries for the total number of pageviews
  // for the last 30 days.
  $options = array(
    'filters' => 'ga:pagepath==' . $page,
    );

  return $analytics->data_ga->get(
    'ga:' . $profileId,
    '30daysAgo',
    'today',
    'ga:bounces',
    $options);
}

function getFacebookResults($analytics, $profileId, $page) {
  // Calls the Core Reporting API and queries for the number of pageviews
  // for the last 30 days.

  $options = array(
    'dimensions' => 'ga:date',
    'filters' => 'ga:pagepath==' . $page . ',ga:socialNetwork==Facebook',
    'output' => 'dataTable', 
    );

  return $analytics->data_ga->get(
     'ga:' . $profileId,
     '30daysAgo',
     'today',
     'ga:pageViews',
     $options);
}

function facebookResults($analytics, $profileId, $page) {
  // Calls the Core Reporting API and queries for the total number of pageviews
  // for the last 30 days.
  $options = array(
    'filters' => 'ga:pagepath==' . $page . ',ga:socialNetwork==Facebook',
    );

  return $analytics->data_ga->get(
    'ga:' . $profileId,
    '30daysAgo',
    'today',
    'ga:pageViews',
    $options);
}

function getTwitterResults($analytics, $profileId, $page) {
  // Calls the Core Reporting API and queries for the number of pageviews
  // for the last 30 days.

  $options = array(
    'dimensions' => 'ga:date',
    'filters' => 'ga:pagepath==' . $page . ',ga:socialNetwork==Twitter',
    'output' => 'dataTable', 
    );

  return $analytics->data_ga->get(
     'ga:' . $profileId,
     '30daysAgo',
     'today',
     'ga:pageViews',
     $options);
}

function twitterResults($analytics, $profileId, $page) {
  // Calls the Core Reporting API and queries for the total number of pageviews
  // for the last 30 days.
  $options = array(
    'filters' => 'ga:pagepath==' . $page . ',ga:socialNetwork==Twitter',
    );

  return $analytics->data_ga->get(
    'ga:' . $profileId,
    '30daysAgo',
    'today',
    'ga:pageViews',
    $options);
}

function getEmailResults($analytics, $profileId, $page) {
  // Calls the Core Reporting API and queries for the number of pageviews
  // for the last 30 days.

  $options = array(
    'dimensions' => 'ga:date',
    'filters' => 'ga:pagepath==' . $page . ',ga:channelGrouping==Direct',
    'output' => 'dataTable', 
    );

  return $analytics->data_ga->get(
     'ga:' . $profileId,
     '30daysAgo',
     'today',
     'ga:pageViews',
     $options);
}

function emailResults($analytics, $profileId, $page) {
  // Calls the Core Reporting API and queries for the total number of pageviews
  // for the last 30 days.
  $options = array(
    'filters' => 'ga:pagepath==' . $page . ',ga:channelGrouping==Direct',
    );

  return $analytics->data_ga->get(
    'ga:' . $profileId,
    '30daysAgo',
    'today',
    'ga:pageViews',
    $options);
}

function getGenderResults($analytics, $profileId, $page) {
  // Calls the Core Reporting API and queries for the number of pageviews
  // for the last 30 days.

  $options = array(
    'dimensions' => 'ga:userGender',
    'filters' => 'ga:pagepath==' . $page,
    'output' => 'dataTable', 
    );

  return $analytics->data_ga->get(
     'ga:' . $profileId,
     '30daysAgo',
     'today',
     'ga:pageViews',
     $options);
}

function getAgeResults($analytics, $profileId, $page) {
  // Calls the Core Reporting API and queries for the number of pageviews
  // for the last 30 days.

  $options = array(
    'dimensions' => 'ga:userAgeBracket',
    'filters' => 'ga:pagepath==' . $page,
    'output' => 'dataTable', 
    );

  return $analytics->data_ga->get(
     'ga:' . $profileId,
     '30daysAgo',
     'today',
     'ga:pageViews',
     $options);
}

function getGeoResults($analytics, $profileId, $page) {
  // Calls the Core Reporting API and queries for the number of pageviews
  // for the last 30 days.

  $options = array(
    'dimensions' => 'ga:city',
    'filters' => 'ga:pagepath==' . $page,
    'output' => 'dataTable', 
    );

  return $analytics->data_ga->get(
     'ga:' . $profileId,
     '30daysAgo',
     'today',
     'ga:pageViews',
     $options);
}

function getDeviceResults($analytics, $profileId, $page) {
  // Calls the Core Reporting API and queries for the number of pageviews
  // for the last 30 days.

  $options = array(
    'dimensions' => 'ga:deviceCategory',
    'filters' => 'ga:pagepath==' . $page,
    'output' => 'dataTable', 
    );

  return $analytics->data_ga->get(
     'ga:' . $profileId,
     '30daysAgo',
     'today',
     'ga:pageViews',
     $options);
}

function getDesktopResults($analytics, $profileId, $page) {
  // Calls the Core Reporting API and queries for the number of pageviews
  // for the last 30 days.

  $options = array(
    'dimensions' => 'ga:date',
    'filters' => 'ga:pagepath==' . $page . ',ga:deviceCategory==desktop',
    'output' => 'dataTable', 
    );

  return $analytics->data_ga->get(
     'ga:' . $profileId,
     '30daysAgo',
     'today',
     'ga:pageViews',
     $options);
}

function getTabletResults($analytics, $profileId, $page) {
  // Calls the Core Reporting API and queries for the number of pageviews
  // for the last 30 days.

  $options = array(
    'dimensions' => 'ga:date',
    'filters' => 'ga:pagepath==' . $page . ',ga:deviceCategory==tablet',
    'output' => 'dataTable', 
    );

  return $analytics->data_ga->get(
     'ga:' . $profileId,
     '30daysAgo',
     'today',
     'ga:pageViews',
     $options);
}

function getMobileResults($analytics, $profileId, $page) {
  // Calls the Core Reporting API and queries for the number of pageviews
  // for the last 30 days.

  $options = array(
    'dimensions' => 'ga:date',
    'filters' => 'ga:pagepath==' . $page . ',ga:deviceCategory==mobile',
    'output' => 'dataTable', 
    );

  return $analytics->data_ga->get(
     'ga:' . $profileId,
     '30daysAgo',
     'today',
     'ga:pageViews',
     $options);
}


try {

  $totalResults = getTotalResults($analytics, $profile, $tokenPath);
  $numTotalResults = totalResults($analytics, $profile, $tokenPath);

  $uniqueResults = getUniqueResults($analytics, $profile, $tokenPath);
  $numUniqueResults = uniqueResults($analytics, $profile, $tokenPath);

  $averageResults = getAverageResults($analytics, $profile, $tokenPath);
  $numAverageResults = averageResults($analytics, $profile, $tokenPath);

  $bouncesResults = getBouncesResults($analytics, $profile, $tokenPath);
  $numBouncesResults = bouncesResults($analytics, $profile, $tokenPath);

  $facebookResults = getFacebookResults($analytics, $profile, $tokenPath);
  $numFacebookResults = facebookResults($analytics, $profile, $tokenPath);

  $twitterResults = getTwitterResults($analytics, $profile, $tokenPath);
  $numTwitterResults = twitterResults($analytics, $profile, $tokenPath);

  $emailResults = getEmailResults($analytics, $profile, $tokenPath);
  $numEmailResults = emailResults($analytics, $profile, $tokenPath);

  $genderResults = getGenderResults($analytics, $profile, '/index.php');

  $ageResults = getAgeResults($analytics, $profile, '/index.php');

  $geoResults = getGeoResults($analytics, $profile, $tokenPath);

  $deviceResults = getDeviceResults($analytics, $profile, $tokenPath);

  $desktopResults = getDesktopResults($analytics, $profile, $tokenPath);

  $tabletResults = getTabletResults($analytics, $profile, $tokenPath);

  $mobileResults = getMobileResults($analytics, $profile, $tokenPath);


} catch (apiServiceException $e) {
  // Handle API service exceptions.
  $error = $e->getMessage();
}