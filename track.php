<?php
use \Sizzle\Bacon\Database\{
    EmailOpen,
    RecruitingToken,
    User
};

/**** the information in the URL is already being recorded in web_request ****/

/**
 * Click - record and redirect
 */
if (0 === strpos($_SERVER['REQUEST_URI'],'/track/click')) {

} else
/**
 * Email open - should have template id & email
 */
if (0 === strpos($_SERVER['REQUEST_URI'],'/track/open')
&& isset($_GET['t'], $_GET['e'])
&& is_numeric($_GET['t'])
&& filter_var($_GET['e'], FILTER_VALIDATE_EMAIL)) {
    $user = (new User())->fetch($_GET['e']);
    $user_id = is_null($user) ? $user : $user->id;
    if (isset($_GET['l']) && $_GET['t'] == 3) {
        // recruiting token email needs a long id
        $token = new RecruitingToken($_GET['l'], 'long_id');
        if (isset($token->id)) {
            (new EmailOpen())->create((int) $_GET['t'], $_GET['e'], $token->id);
        }
    } elseif (in_array($_GET['t'],[1,2])) {
        (new EmailOpen())->create((int) $_GET['t'], $_GET['e']);
    }
}
