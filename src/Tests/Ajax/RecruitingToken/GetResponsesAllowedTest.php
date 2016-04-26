<?php
namespace Sizzle\Tests\Ajax\RecruitingToken;

/**
 * This class tests the ajax endpoint to get if responses are allowed for a token.
 *
 * ./vendor/bin/phpunit --bootstrap src/Tests/autoload.php src/Tests/Ajax/RecruitingToken/GetResponsesAllowedTest
 */
class GetResponsesAllowedTest
extends \PHPUnit_Framework_TestCase
{
    use \Sizzle\Bacon\Tests\Traits\RecruitingToken,
        \Sizzle\Bacon\Tests\Traits\User {
            \Sizzle\Bacon\Tests\Traits\User::createUser insteadof \Sizzle\Bacon\Tests\Traits\RecruitingToken;
            \Sizzle\Bacon\Tests\Traits\User::deleteUsers insteadof \Sizzle\Bacon\Tests\Traits\RecruitingToken;
    }

    /**
     * Requires the util.php file of functions
     */
    public static function setUpBeforeClass()
    {
        include_once __DIR__.'/../../../../util.php';
    }

    /**
     * Requires the util.php file of functions
     */
    public function setUp()
    {
        $this->url = TEST_URL . "/ajax/recruiting_token/get_responses_allowed";
    }

    /**
     * Tests request via ajax endpoint.
     */
    public function testResponsesAllowed()
    {
        // setup test users
        $User1 = $this->createUser();
        $User1->allow_token_responses = 'Y';
        $User1->save();

        // setup test token
        $RecruitingToken = $this->createRecruitingToken($User1->id, 'none');

        // test responses allowed
        ob_start();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_COOKIE, TEST_COOKIE);
        curl_setopt($ch, CURLOPT_URL, $this->url.'/'.$RecruitingToken->long_id);
        $response = curl_exec($ch);
        $this->assertTrue($response);
        $json = ob_get_contents();
        ob_end_clean();
        $return = json_decode($json);
        $this->assertEquals('true', $return->success);
        $this->assertEquals('true', $return->data->allowed);
    }

    /**
     * Tests request via ajax endpoint.
     */
    public function testResponsesNotAllowed()
    {
        // setup test users
        $User1 = $this->createUser();
        $User1->allow_token_responses = 'N';
        $User1->save();

        // setup test token
        $RecruitingToken = $this->createRecruitingToken($User1->id, 'none');

        // test responses not being allowed
        ob_start();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_COOKIE, TEST_COOKIE);
        curl_setopt($ch, CURLOPT_URL, $this->url.'/'.$RecruitingToken->long_id);
        $response = curl_exec($ch);
        $this->assertTrue($response);
        $json = ob_get_contents();
        ob_end_clean();
        $return = json_decode($json);
        $this->assertEquals('true', $return->success);
        $this->assertEquals('false', $return->data->allowed);
    }

    /**
     * Tests request failure via ajax endpoint.
     */
    public function testFail()
    {
        ob_start();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_URL, $this->url);
        $response = curl_exec($ch);
        $this->assertEquals(true, $response);
        $json = ob_get_contents();
        $return = json_decode($json);
        $this->assertEquals('false', $return->success);
        $this->assertEquals('true', $return->data->allowed);
        ob_end_clean();
    }

    /**
     * Delete things created for testing
     */
    protected function tearDown()
    {
        $this->deleteRecruitingTokens();
    }
}
?>
