<?php
namespace Sizzle\Tests\Ajax\RecruitingToken;

/**
 * This class tests the ajax endpoint to get the application link for a token.
 *
 * ./vendor/bin/phpunit --bootstrap src/Tests/autoload.php src/Tests/Ajax/RecruitingToken/GetApplyLinkTest
 */
class GetApplyLinkTest
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
     * Sets up the url for this endpoint
     */
    public function setUp()
    {
        $this->url = TEST_URL . "/ajax/recruiting_token/get_apply_link";
    }

    /**
     * Tests request via ajax endpoint.
     */
    public function testLink()
    {
        // setup test users
        $User1 = $this->createUser();
        $User1->allow_token_responses = 'Y';
        $User1->save();

        // setup test token
        $RecruitingToken = $this->createRecruitingToken($User1->id, 'none');
        $RecruitingToken->apply_link = 'http://dev.gosizzle.io/'.rand();
        $RecruitingToken->save();

        // test responses allowed
        ob_start();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_URL, $this->url.'/'.$RecruitingToken->long_id);
        $response = curl_exec($ch);
        $this->assertTrue($response);
        $json = ob_get_contents();
        echo $json;
        ob_end_clean();
        $return = json_decode($json);

        $this->assertEquals('true', $return->success);
        $this->assertEquals($RecruitingToken->apply_link, $return->data);
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
        $this->assertEquals('', $return->data);
        ob_end_clean();
    }

    /**
     * Delete things created for testing
     */
    protected function tearDown()
    {
        $this->deleteRecruitingTokens();
        $this->deleteUsers();
    }
}
?>
