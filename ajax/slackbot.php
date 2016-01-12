<?php
use \Monolog\Handler\SlackHandler;
use \Monolog\Logger;

if ($google_app_engine && $application_id === "s~stone-timing-557") {
    // See from whence the vistor hails
    $url = "http://ipinfo.io/{$_SERVER['REMOTE_ADDR']}";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $response = curl_exec($ch);
    $locale = json_decode($response);

    //see if the visitor is NEW
    $new = '*New*';
    $visitor_cookie = isset($_COOKIE, $_COOKIE['visitor']) ? escape_string($_COOKIE['visitor']) : '';
    $sql = "SELECT COUNT(*) requests FROM web_request
            WHERE visitor_cookie = '$visitor_cookie'";
    $result = execute_query($sql);
    if (($row = $result->fetch_assoc()) && $row['requests'] > 3) {
        $new = 'Returning';
    }

    // see what visitor type is
    if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'googlebot') !== false) {
        $visitor = 'Googlebot';
    } else if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'bingbot') !== false) {
        $visitor = 'Bingbot';
    } else if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'slackbot') !== false) {
        $visitor = 'Slackbot';
    } else if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'ahrefsBot') !== false) {
        $visitor = 'AhrefsBot (https://ahrefs.com/)';
    } else if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'mj12bot') !== false) {
        $visitor = 'MJ12bot (http://www.majestic12.co.uk/)';
    } else if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'blexbot') !== false) {
        $visitor = 'BLEXBot (http://webmeup-crawler.com/)';
    } else if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'twitterbot') !== false) {
        $visitor = 'Twitterbot';
    } else if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'yandexbot') !== false) {
        $visitor = 'YandexBot (http://yandex.com/)';
    } else if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'nextgensearchbot') !== false) {
        $visitor = 'NextGenSearchBot (http://www.zoominfo.com/)';
    } else if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'xovibot') !== false) {
        $visitor = 'XoviBot (http://www.xovibot.net/)';
    } else if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'exabot') !== false) {
        $visitor = 'Exabot (http://www.exabot.com/)';
    } else if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'seznambot') !== false) {
        $visitor = 'SeznamBot (http://fulltext.sblog.cz/)';
    } else if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'dotbot') !== false) {
        $visitor = 'DotBot (http://www.opensiteexplorer.org/dotbot)';
    } else if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'meanpathbot') !== false) {
        $visitor = 'DotBot (http://www.opensiteexplorer.org/dotbot)';
    } else if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'spbot') !== false) {
        $visitor = "spbot (http://OpenLinkProfiler.org/bot)";
    } else if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'duckduckgo-favicons-bot') !== false) {
        $visitor = "DuckDuckGo-Favicons-Bot (http://duckduckgo.com)";
    } else if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'baiduspider') !== false) {
        $visitor = "Baiduspider (http://www.baidu.com)";
    } else if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'yahoo! slurp') !== false) {
        $visitor = "Yahoo! Slurp";
    } else if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'megaindex.ru') !== false) {
        $visitor = "MegaIndex.ru crawler (http://megaindex.com/crawler)";
    } else if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'crazywebcrawler') !== false) {
        $visitor = "crazywebcrawler (http://www.crazywebcrawler.com)";
    } else if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'bot') !== false
        || strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'crawler') !== false
        || strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'spider') !== false
    ) {
        $visitor = "unknown bot: {$_SERVER['HTTP_USER_AGENT']}";
    } else {
        $visitor = 'visitor';
    }

    // Have Slackbot inform us of the visitor
    $message = "$new $visitor to $app_url from ";
    $message .= isset($locale->city) && '' != $locale->city ? $locale->city . ', ' : '';
    $message .= isset($locale->region) && '' != $locale->region ? $locale->region . ', ' : '';
    $message .= isset($locale->country) && '' != $locale->country ? $locale->country : '';
    $message = rtrim($message);
    $message .= " ({$_SERVER['REMOTE_ADDR']}) ";
    $message .= isset($locale->org) && '' != $locale->org ? 'using ' . $locale->org : '';
    $visitorLogger = new Logger('milestones');
    $slackHandler = new SlackHandler(SLACK_TOKEN, '#website-visitors', 'SizzleBot', false);
    $slackHandler->setLevel(Logger::DEBUG);
    $visitorLogger->pushHandler($slackHandler);
    $visitorLogger->log(200, $message);
}
