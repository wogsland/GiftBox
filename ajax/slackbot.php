<?php
use \Monolog\{
    Handler\SlackHandler,
    Logger
};
use \Sizzle\{
    Database\WebRequest,
    Service\IpinfoIo
};

if (ENVIRONMENT === "production") {
    // See from whence the vistor hails
    $IpinfoIo = new IpinfoIo();
    $locale = $IpinfoIo->getInfo($_SERVER['REMOTE_ADDR']);

    //see if the visitor is NEW
    $new = (new WebRequest())->newVisitor($_COOKIE['visitor'] ?? '') ? '*New*' : 'Returning';

    // see what visitor type is
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    if (strpos(strtolower($userAgent), 'googlebot') !== false) {
        $visitor = 'Googlebot';
    } else if (strpos(strtolower($userAgent), 'bingbot') !== false) {
        $visitor = 'Bingbot';
    } else if (strpos(strtolower($userAgent), 'slackbot') !== false) {
        $visitor = 'Slackbot';
    } else if (strpos(strtolower($userAgent), 'ahrefsBot') !== false) {
        $visitor = 'AhrefsBot (https://ahrefs.com/)';
    } else if (strpos(strtolower($userAgent), 'mj12bot') !== false) {
        $visitor = 'MJ12bot (http://www.majestic12.co.uk/)';
    } else if (strpos(strtolower($userAgent), 'blexbot') !== false) {
        $visitor = 'BLEXBot (http://webmeup-crawler.com/)';
    } else if (strpos(strtolower($userAgent), 'twitterbot') !== false) {
        $visitor = 'Twitterbot';
    } else if (strpos(strtolower($userAgent), 'yandexbot') !== false) {
        $visitor = 'YandexBot (http://yandex.com/)';
    } else if (strpos(strtolower($userAgent), 'nextgensearchbot') !== false) {
        $visitor = 'NextGenSearchBot (http://www.zoominfo.com/)';
    } else if (strpos(strtolower($userAgent), 'xovibot') !== false) {
        $visitor = 'XoviBot (http://www.xovibot.net/)';
    } else if (strpos(strtolower($userAgent), 'exabot') !== false) {
        $visitor = 'Exabot (http://www.exabot.com/)';
    } else if (strpos(strtolower($userAgent), 'seznambot') !== false) {
        $visitor = 'SeznamBot (http://fulltext.sblog.cz/)';
    } else if (strpos(strtolower($userAgent), 'dotbot') !== false) {
        $visitor = 'DotBot (http://www.opensiteexplorer.org/dotbot)';
    } else if (strpos(strtolower($userAgent), 'meanpathbot') !== false) {
        $visitor = 'DotBot (http://www.opensiteexplorer.org/dotbot)';
    } else if (strpos(strtolower($userAgent), 'spbot') !== false) {
        $visitor = "spbot (http://OpenLinkProfiler.org/bot)";
    } else if (strpos(strtolower($userAgent), 'duckduckgo-favicons-bot') !== false) {
        $visitor = "DuckDuckGo-Favicons-Bot (http://duckduckgo.com)";
    } else if (strpos(strtolower($userAgent), 'baiduspider') !== false) {
        $visitor = "Baiduspider (http://www.baidu.com)";
    } else if (strpos(strtolower($userAgent), 'yahoo! slurp') !== false) {
        $visitor = "Yahoo! Slurp";
    } else if (strpos(strtolower($userAgent), 'megaindex.ru') !== false) {
        $visitor = "MegaIndex.ru crawler (http://megaindex.com/crawler)";
    } else if (strpos(strtolower($userAgent), 'crazywebcrawler') !== false) {
        $visitor = "crazywebcrawler (http://www.crazywebcrawler.com)";
    } else if (strpos(strtolower($userAgent), 'bot') !== false
        || strpos(strtolower($userAgent), 'crawler') !== false
        || strpos(strtolower($userAgent), 'spider') !== false
    ) {
        $visitor = "unknown bot: {$userAgent}";
    } else {
        $visitor = 'visitor';
    }

    $botsToExclude = [
      'Googlebot'
    ];

    if ('*New*' == $new && !in_array($visitor, $botsToExclude)) {
        // Have Slackbot inform us of the visitor
        $message = "$new $visitor to " . APP_URL . " from ";
        $message .= isset($locale->city) && '' != $locale->city ? $locale->city . ', ' : '';
        $message .= isset($locale->region) && '' != $locale->region ? $locale->region . ', ' : '';
        $message .= isset($locale->country) && '' != $locale->country ? $locale->country : '';
        $message = rtrim($message);
        $message .= " ({$_SERVER['REMOTE_ADDR']}) ";
        $message .= isset($locale->org) && '' != $locale->org ? 'using ' . $locale->org : '';
        $visitorLogger = new Logger('milestones');
        $slackHandler = new SlackHandler(SLACK_TOKEN, '#website-visitors', 'S!zzleBot', false);
        $slackHandler->setLevel(Logger::DEBUG);
        $visitorLogger->pushHandler($slackHandler);
        $visitorLogger->log(200, $message);
    }
}
