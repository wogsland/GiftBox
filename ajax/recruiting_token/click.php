<?php
use \Sizzle\Bacon\Database\{
    RecruitingToken,
    RecruitingTokenClick
};

// collect post vars
$vars = ['id', 'tag', 'token'];
foreach ($vars as $var) {
  $$var = $_POST[$var] ?? '';
}

// look for cookie
$visitor_cookie = $_COOKIE['visitor'] ?? '';

// look for token match
if ($token != '') {
    $recruitingToken = new RecruitingToken($token, 'long_id');
    $recruitingTokenID = $recruitingToken->id ?? '';
}

// record click
(new RecruitingTokenClick())->create($id, $tag, $visitor_cookie, $recruitingTokenID ?? null);

header('Content-Type: application/json');
$result = array('success'=>'true');
echo json_encode($result);
