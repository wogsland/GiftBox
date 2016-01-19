<?php
namespace Sizzle\Tests;

/**
 * This class tests public/index.php
 *
 * ./vendor/bin/phpunit --bootstrap src/tests/autoload.php src/tests/RoutingTest
 */
class RoutingTest
extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the endpoint routing of public/index.php
     */
    public function testPublicEndpoints()
    {
        // test good endpoints not logged in
        $this->assertTrue($this->checkStatusCode(''));
        $this->assertTrue($this->checkStatusCode('/'));
        $this->assertTrue($this->checkStatusCode('/index.html'));
        $this->assertTrue($this->checkStatusCode('/about'));
        $this->assertTrue($this->checkStatusCode('/activate', false, 302));
        $this->assertTrue($this->checkStatusCode('/admin', false, 302));
        $this->assertTrue($this->checkStatusCode('/admin/active_users', false, 302));
        $this->assertTrue($this->checkStatusCode('/admin/add_city', false, 302));
        $this->assertTrue($this->checkStatusCode('/admin/stalled_new_customers', false, 302));
        $this->assertTrue($this->checkStatusCode('/admin/tokens', false, 302));
        $this->assertTrue($this->checkStatusCode('/admin/transfer_token', false, 302));
        $this->assertTrue($this->checkStatusCode('/admin/visitors', false, 302));
        $this->assertTrue($this->checkStatusCode('/ajax'));
        $this->assertTrue($this->checkStatusCode('/ajax/'));
        $this->assertTrue($this->checkStatusCode('/ajax/anything'));
        $this->assertTrue($this->checkStatusCode('/ajax/anything/'));
        $this->assertTrue($this->checkStatusCode('/ajax/anything/at'));
        $this->assertTrue($this->checkStatusCode('/ajax/anything/at/'));
        $this->assertTrue($this->checkStatusCode('/ajax/anything/at/all'));
        $this->assertTrue($this->checkStatusCode('/ajax/anything/at/all/'));
        $this->assertTrue($this->checkStatusCode('/ajax/anything/at/all/works'));
        $this->assertTrue($this->checkStatusCode('/ajax/anything/at/all/works/'));
        $this->assertTrue($this->checkStatusCode('/ajax/anything/at/all/works/here'));
        $this->assertTrue($this->checkStatusCode('/ajax/anything/at/all/works/here/'));
        $this->assertTrue($this->checkStatusCode('/create_recruiting', false, 302));
        $this->assertTrue($this->checkStatusCode('/free_trial'));
        $this->assertTrue($this->checkStatusCode('/forgot_password'));
        $this->assertTrue($this->checkStatusCode('/invoice', false, 302));
        $this->assertTrue($this->checkStatusCode('/js', false, 301));
        $this->assertTrue($this->checkStatusCode('/js/', false, 404));
        $this->assertTrue($this->checkStatusCode('/js/pay_with_stripe.js'));
        $this->assertTrue($this->checkStatusCode('/js/JSXTransformer.js'));
        $this->assertTrue($this->checkStatusCode('/password_reset', false, 302));
        $this->assertTrue($this->checkStatusCode('/pricing'));
        $this->assertTrue($this->checkStatusCode('/privacy'));
        $this->assertTrue($this->checkStatusCode('/profile', false, 302));
        $this->assertTrue($this->checkStatusCode('/recruiting_made_easy'));
        $this->assertTrue($this->checkStatusCode('/teapot', false, 418));
        $this->assertTrue($this->checkStatusCode('/terms'));
        $this->assertTrue($this->checkStatusCode('/thankyou'));
        $this->assertTrue($this->checkStatusCode('/token', false, 404));
        $this->assertTrue($this->checkStatusCode('/token/', false, 404));
        $this->assertTrue($this->checkStatusCode('/token/recruiting', false, 404));
        $this->assertTrue($this->checkStatusCode('/token/recruiting/', false, 200));
        $this->assertTrue($this->checkStatusCode('/token/recruiting/'.rand(), false, 200));
        $this->assertTrue($this->checkStatusCode('/tokens', false, 302));
        $this->assertTrue($this->checkStatusCode('/token_responses', false, 302));
        $this->assertTrue($this->checkStatusCode('/upgrade', false, 302));
        $this->assertTrue($this->checkStatusCode('/upload'));// should be under ajax?
        $this->assertTrue($this->checkStatusCode('/user', false, 302));
        $this->assertTrue($this->checkStatusCode('/test', false, 200));// only on DEVELOPMENT
    }

    /**
     * Tests the endpoint routing of public/index.php for logged in user
     */
    public function testLoggedInEndpoints()
    {
        $this->assertTrue($this->checkStatusCode('', true, 302));
        $this->assertTrue($this->checkStatusCode('/', true, 302));
        $this->assertTrue($this->checkStatusCode('/index.html', true, 302));
        $this->assertTrue($this->checkStatusCode('/about', true));
        $this->assertTrue($this->checkStatusCode('/activate', true, 302));
        $this->assertTrue($this->checkStatusCode('/admin', true, 302));
        $this->assertTrue($this->checkStatusCode('/admin/active_users', true, 302));
        $this->assertTrue($this->checkStatusCode('/admin/add_city', true, 302));
        $this->assertTrue($this->checkStatusCode('/admin/stalled_new_customers', true, 302));
        $this->assertTrue($this->checkStatusCode('/admin/tokens', true, 302));
        $this->assertTrue($this->checkStatusCode('/admin/transfer_token', true, 302));
        $this->assertTrue($this->checkStatusCode('/admin/visitors', true, 302));
        $this->assertTrue($this->checkStatusCode('/ajax', true));
        $this->assertTrue($this->checkStatusCode('/ajax/', true));
        $this->assertTrue($this->checkStatusCode('/ajax/anything', true));
        $this->assertTrue($this->checkStatusCode('/ajax/anything/', true));
        $this->assertTrue($this->checkStatusCode('/ajax/anything/at', true));
        $this->assertTrue($this->checkStatusCode('/ajax/anything/at/', true));
        $this->assertTrue($this->checkStatusCode('/ajax/anything/at/all', true));
        $this->assertTrue($this->checkStatusCode('/ajax/anything/at/all/', true));
        $this->assertTrue($this->checkStatusCode('/ajax/anything/at/all/works', true));
        $this->assertTrue($this->checkStatusCode('/ajax/anything/at/all/works/', true));
        $this->assertTrue($this->checkStatusCode('/ajax/anything/at/all/works/here', true));
        $this->assertTrue($this->checkStatusCode('/ajax/anything/at/all/works/here/', true));
        $this->assertTrue($this->checkStatusCode('/create_recruiting', true));
        $this->assertTrue($this->checkStatusCode('/free_trial', true));
        $this->assertTrue($this->checkStatusCode('/forgot_password', true));
        $this->assertTrue($this->checkStatusCode('/invoice', true));
        $this->assertTrue($this->checkStatusCode('/js', true, 301));
        $this->assertTrue($this->checkStatusCode('/js/', true, 404));
        $this->assertTrue($this->checkStatusCode('/js/pay_with_stripe.js', true));
        $this->assertTrue($this->checkStatusCode('/js/JSXTransformer.js', true));
        $this->assertTrue($this->checkStatusCode('/password_reset', true, 302));
        $this->assertTrue($this->checkStatusCode('/pricing', true));
        $this->assertTrue($this->checkStatusCode('/privacy', true));
        $this->assertTrue($this->checkStatusCode('/profile', true));
        $this->assertTrue($this->checkStatusCode('/recruiting_made_easy', true));
        $this->assertTrue($this->checkStatusCode('/teapot', true, 418));
        $this->assertTrue($this->checkStatusCode('/terms', true));
        $this->assertTrue($this->checkStatusCode('/thankyou', true));
        $this->assertTrue($this->checkStatusCode('/token', true, 404));
        $this->assertTrue($this->checkStatusCode('/token/', true, 404));
        $this->assertTrue($this->checkStatusCode('/token/recruiting', true, 404));
        $this->assertTrue($this->checkStatusCode('/token/recruiting/', true, 200));
        $this->assertTrue($this->checkStatusCode('/token/recruiting/'.rand(), true, 200));
        $this->assertTrue($this->checkStatusCode('/tokens', true));
        $this->assertTrue($this->checkStatusCode('/token_responses', true));
        $this->assertTrue($this->checkStatusCode('/upgrade', true));
        $this->assertTrue($this->checkStatusCode('/upload', true));// should be under ajax?
        $this->assertTrue($this->checkStatusCode('/user', true, 302));
        $this->assertTrue($this->checkStatusCode('/test', true, 302));// only on DEVELOPMENT
    }



    /**
     * Tests the endpoint routing of public/index.php for logged in admin user
     */
    public function testLoggedInAdminEndpoints()
    {
        $this->assertTrue($this->checkStatusCode('', true, 302, true));
        $this->assertTrue($this->checkStatusCode('/', true, 302, true));
        $this->assertTrue($this->checkStatusCode('/index.html', true, 302, true));
        $this->assertTrue($this->checkStatusCode('/about', true, 200, true));
        $this->assertTrue($this->checkStatusCode('/activate', true, 302, true));
        $this->assertTrue($this->checkStatusCode('/admin', true, 200, true));
        $this->assertTrue($this->checkStatusCode('/admin/active_users', true, 200, true));
        $this->assertTrue($this->checkStatusCode('/admin/add_city', true, 200, true));
        $this->assertTrue($this->checkStatusCode('/admin/stalled_new_customers', true, 200, true));
        $this->assertTrue($this->checkStatusCode('/admin/tokens', true, 200, true));
        $this->assertTrue($this->checkStatusCode('/admin/transfer_token', true, 200, true));
        $this->assertTrue($this->checkStatusCode('/admin/visitors', true, 200, true));
        $this->assertTrue($this->checkStatusCode('/ajax', true, 200, true));
        $this->assertTrue($this->checkStatusCode('/ajax/', true, 200, true));
        $this->assertTrue($this->checkStatusCode('/ajax/anything', true, 200, true));
        $this->assertTrue($this->checkStatusCode('/ajax/anything/', true, 200, true));
        $this->assertTrue($this->checkStatusCode('/ajax/anything/at', true, 200, true));
        $this->assertTrue($this->checkStatusCode('/ajax/anything/at/', true, 200, true));
        $this->assertTrue($this->checkStatusCode('/ajax/anything/at/all', true, 200, true));
        $this->assertTrue($this->checkStatusCode('/ajax/anything/at/all/', true, 200, true));
        $this->assertTrue($this->checkStatusCode('/ajax/anything/at/all/works', true, 200, true));
        $this->assertTrue($this->checkStatusCode('/ajax/anything/at/all/works/', true, 200, true));
        $this->assertTrue($this->checkStatusCode('/ajax/anything/at/all/works/here', true, 200, true));
        $this->assertTrue($this->checkStatusCode('/ajax/anything/at/all/works/here/', true, 200, true));
        $this->assertTrue($this->checkStatusCode('/create_recruiting', true, 200, true));
        $this->assertTrue($this->checkStatusCode('/free_trial', true, 200, true));
        $this->assertTrue($this->checkStatusCode('/forgot_password', true, 200, true));
        $this->assertTrue($this->checkStatusCode('/invoice', true, 200, true));
        $this->assertTrue($this->checkStatusCode('/js', true, 301, true));
        $this->assertTrue($this->checkStatusCode('/js/', true, 404, true));
        $this->assertTrue($this->checkStatusCode('/js/pay_with_stripe.js', true, 200, true));
        $this->assertTrue($this->checkStatusCode('/js/JSXTransformer.js', true, 200, true));
        $this->assertTrue($this->checkStatusCode('/password_reset', true, 302, true));
        $this->assertTrue($this->checkStatusCode('/pricing', true, 200, true));
        $this->assertTrue($this->checkStatusCode('/privacy', true, 200, true));
        $this->assertTrue($this->checkStatusCode('/profile', true, 200, true));
        $this->assertTrue($this->checkStatusCode('/recruiting_made_easy', true, 200, true));
        $this->assertTrue($this->checkStatusCode('/teapot', true, 418, true));
        $this->assertTrue($this->checkStatusCode('/terms', true, 200, true));
        $this->assertTrue($this->checkStatusCode('/thankyou', true, 200, true));
        $this->assertTrue($this->checkStatusCode('/token', true, 404, true));
        $this->assertTrue($this->checkStatusCode('/token/', true, 404, true));
        $this->assertTrue($this->checkStatusCode('/token/recruiting', true, 404, true));
        $this->assertTrue($this->checkStatusCode('/token/recruiting/', true, 200, true));
        $this->assertTrue($this->checkStatusCode('/token/recruiting/'.rand(), true, 200, true));
        $this->assertTrue($this->checkStatusCode('/tokens', true, 200, true));
        $this->assertTrue($this->checkStatusCode('/token_responses', true, 200, true));
        $this->assertTrue($this->checkStatusCode('/upgrade', true, 200, true));
        $this->assertTrue($this->checkStatusCode('/upload', true, 200, true));// should be under ajax?
        $this->assertTrue($this->checkStatusCode('/user', true, 200, true));
        $this->assertTrue($this->checkStatusCode('/test', true, 302, true));// only on DEVELOPMENT
    }

    /**
     * Tests the endpoint routing of public/index.php for logged in admin user
     */
    public function testBadEndpoints()
    {
        // test bad endpoints
        $this->assertTrue($this->checkStatusCode('/broken', false, 404));
        $this->assertTrue($this->checkStatusCode('/admin/broken', false, 404));
    }

    /******************************************************************

              HELPER METHODS

    *******************************************************************/

    /**
     * Checks that a given endpoint returns the desired status code.
     *
     * @param string  $endpoint   - the endpoint to test
     * @param boolean $loggedIn   - is the user logged in (defaults false)
     * @param int     $statusCode - the status code to check for (defaults to 200)
     * @param boolean $isAdmin    - is the user logged in an admin (defaults false)
     *
     * @return boolean - desired status code was returned
     */
    private function checkStatusCode($endpoint, $loggedIn = false, $statusCode = 200, $isAdmin = false)
    {
        //
        // test created city
        $url = TEST_URL . $endpoint;
        ob_start();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);
        if ($loggedIn && !$isAdmin) {
            curl_setopt($ch, CURLOPT_COOKIE, TEST_COOKIE);
        } else if ($loggedIn && $isAdmin) {
            curl_setopt($ch, CURLOPT_COOKIE, getTestCookie(true));
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        $response = curl_exec($ch);
        $page = ob_get_contents();
        ob_end_clean();
        $foundCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($statusCode == $foundCode) {
            return true;
        } else {
            echo "\nFound status $foundCode instead of $statusCode at '$endpoint'.\n";
            //echo $response;
            //echo $page;
            return false;
        }
    }
}
