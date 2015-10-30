<?php
if ($google_app_engine && $application_id === "s~stone-timing-557") {
    // See from whence the vistor hails
    $url = "http://ipinfo.io/{$_SERVER['REMOTE_ADDR']}";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $response = curl_exec($ch);
    $locale = json_decode($response);

    // Have Slackbot inform us of the visitor
    $message = "New visitor to $app_url from ";
    $message .= isset($locale->city) && '' != $locale->city ? $locale->city . ', ' : '';
    $message .= isset($locale->region) && '' != $locale->region ? $locale->region . ', ' : '';
    $message .= isset($locale->country) && '' != $locale->country ? $locale->country : '';
    $message = rtrim($message);
    $message .= " ({$_SERVER['REMOTE_ADDR']}) ";
    $message .= isset($locale->org) && '' != $locale->org ? 'using ' . $locale->org : '';
    $data = "payload=$message";
    $url = "https://givetoken.slack.com/services/hooks/slackbot?token=abmmCzTPQPszuDhcKUY4sgWe&channel=%23random";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $response = curl_exec($ch);
    curl_close($ch);
}
