<?php
namespace Sizzle\Tests\Ajax\RecruitingToken;

use Sizzle\Database\RecruitingToken;

/**
 * This class tests the ajax endpoint to transfer tokens between users.
 *
 * ./vendor/bin/phpunit --bootstrap src/Tests/autoload.php src/Tests/Ajax/RecruitingToken/TransferTest
 */
class TransferTest
extends \PHPUnit_Framework_TestCase
{
    use \Sizzle\Tests\Traits\RecruitingToken,
        \Sizzle\Tests\Traits\User {
            \Sizzle\Tests\Traits\User::createUser insteadof \Sizzle\Tests\Traits\RecruitingToken;
            \Sizzle\Tests\Traits\User::deleteUsers insteadof \Sizzle\Tests\Traits\RecruitingToken;
        }

    /**
     * Requires the util.php file of functions
     */
    public static function setUpBeforeClass()
    {
        include_once __DIR__.'/../../../../util.php';
    }

    /**
     * Tests request via ajax endpoint.
     */
    public function testNoCompany()
    {
        // setup test users
        $User1 = $this->createUser();
        $User2 = $this->createUser();

        // setup test token
        $RecruitingToken = $this->createRecruitingToken($User1->id, 'none');

        // test user transfer
        $url = TEST_URL . "/ajax/recruiting_token/transfer";
        $fields = array(
            'token_id'=>$RecruitingToken->long_id,
            'old_user_id'=>$User1->id,
            'new_user_id'=>$User2->id
        );
        $fields_string = "";
        foreach ($fields as $key=>$value) {
            $fields_string .= $key.'='.$value.'&';
        }
        $fields_string = rtrim($fields_string, '&');
        ob_start();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_COOKIE, getTestCookie(true));
        curl_setopt($ch, CURLOPT_URL, $url);
        $response = curl_exec($ch);
        $this->assertTrue($response);
        $json = ob_get_contents();
        ob_end_clean();
        $return = json_decode($json);
        $this->assertEquals('true', $return->success);

        //check DB was updated
        $RecruitingToken2 = new RecruitingToken($RecruitingToken->long_id, 'long_id');
        $this->assertEquals($User2->id, $RecruitingToken2->user_id);
    }

    /**
     * Tests request via ajax endpoint.
     */
    public function testOldUserCompany()
    {
        // setup test users
        $User1 = $this->createUser();
        $User2 = $this->createUser();

        // setup test company with unrelated user
        $RecruitingCompany = $this->createRecruitingCompany($User1->id);

        // setup test token
        $RecruitingToken = $this->createRecruitingToken($User1->id, $RecruitingCompany->id);

        // test user transfer
        $url = TEST_URL . "/ajax/recruiting_token/transfer";
        $fields = array(
            'token_id'=>$RecruitingToken->long_id,
            'old_user_id'=>$User1->id,
            'new_user_id'=>$User2->id
        );
        $fields_string = "";
        foreach ($fields as $key=>$value) {
            $fields_string .= $key.'='.$value.'&';
        }
        $fields_string = rtrim($fields_string, '&');
        ob_start();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_COOKIE, getTestCookie(true));
        curl_setopt($ch, CURLOPT_URL, $url);
        $response = curl_exec($ch);
        $this->assertTrue($response);
        $json = ob_get_contents();
        ob_end_clean();
        $return = json_decode($json);
        $this->assertEquals('false', $return->success);
        $this->assertEquals('Company already assigned to a different user', $return->data->error);

        //check DB was not updated
        $RecruitingToken2 = new RecruitingToken($RecruitingToken->long_id, 'long_id');
        $this->assertEquals($User1->id, $RecruitingToken2->user_id);
    }

    /**
     * Tests request via ajax endpoint.
     */
    public function testNewUserCompany()
    {
        // setup test users
        $User1 = $this->createUser();
        $User2 = $this->createUser();

        // setup test company
        $RecruitingCompany = $this->createRecruitingCompany($User2->id);

        // setup test token
        $RecruitingToken = $this->createRecruitingToken($User1->id, $RecruitingCompany->id);

        // test user transfer
        $url = TEST_URL . "/ajax/recruiting_token/transfer";
        $fields = array(
            'token_id'=>$RecruitingToken->long_id,
            'old_user_id'=>$User1->id,
            'new_user_id'=>$User2->id
        );
        $fields_string = "";
        foreach ($fields as $key=>$value) {
            $fields_string .= $key.'='.$value.'&';
        }
        $fields_string = rtrim($fields_string, '&');
        ob_start();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_COOKIE, getTestCookie(true));
        curl_setopt($ch, CURLOPT_URL, $url);
        $response = curl_exec($ch);
        $this->assertTrue($response);
        $json = ob_get_contents();
        ob_end_clean();
        $return = json_decode($json);
        $this->assertEquals('true', $return->success);

        //check DB was updated
        $RecruitingToken2 = new RecruitingToken($RecruitingToken->long_id, 'long_id');
        $this->assertEquals($User2->id, $RecruitingToken2->user_id);
    }

    /**
     * Tests request via ajax endpoint.
     */
    public function testRandomUserCompany()
    {
        // setup test users
        $User1 = $this->createUser();
        $User2 = $this->createUser();
        $User3 = $this->createUser();

        // setup test company with unrelated user
        $RecruitingCompany = $this->createRecruitingCompany($User3->id);

        // setup test token
        $RecruitingToken = $this->createRecruitingToken($User1->id, $RecruitingCompany->id);

        // test user transfer
        $url = TEST_URL . "/ajax/recruiting_token/transfer";
        $fields = array(
            'token_id'=>$RecruitingToken->long_id,
            'old_user_id'=>$User1->id,
            'new_user_id'=>$User2->id
        );
        $fields_string = "";
        foreach ($fields as $key=>$value) {
            $fields_string .= $key.'='.$value.'&';
        }
        $fields_string = rtrim($fields_string, '&');
        ob_start();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_COOKIE, getTestCookie(true));
        curl_setopt($ch, CURLOPT_URL, $url);
        $response = curl_exec($ch);
        $this->assertTrue($response);
        $json = ob_get_contents();
        ob_end_clean();
        $return = json_decode($json);
        $this->assertEquals('false', $return->success);
        $this->assertEquals('Company already assigned to a different user', $return->data->error);

        //check DB was not updated
        $RecruitingToken2 = new RecruitingToken($RecruitingToken->long_id, 'long_id');
        $this->assertEquals($User1->id, $RecruitingToken2->user_id);
    }

    /**
     * Tests request failure via ajax endpoint.
     */
    public function testFail()
    {
        $url = TEST_URL . "/ajax/recruiting_token/transfer";
        ob_start();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_URL, $url);
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
    }
}
?>
