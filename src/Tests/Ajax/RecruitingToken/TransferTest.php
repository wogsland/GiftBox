<?php
namespace Sizzle\Tests\Ajax\RecruitingToken;

use \Sizzle\Database\{
    RecruitingToken,
    RecruitingCompany,
    User
};

/**
 * This class tests the ajax endpoint to get the videos for a token.
 *
 * ./vendor/bin/phpunit --bootstrap src/Tests/autoload.php src/Tests/Ajax/RecruitingToken/TransferTest
 */
class TransferTest
extends \PHPUnit_Framework_TestCase
{
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
        $User1 = new User();
        $User1->email_address = rand();
        $User1->first_name = rand();
        $User1->last_name = rand();
        $User1->save();
        $User2 = new User();
        $User2->email_address = rand();
        $User2->first_name = rand();
        $User2->last_name = rand();
        $User2->save();

        // setup test token
        $RecruitingToken = new RecruitingToken();
        $RecruitingToken->user_id = $User1->getId();
        $RecruitingToken->long_id = substr(md5(microtime()), rand(0, 26), 20);
        $RecruitingToken->save();

        // test user transfer
        $url = TEST_URL . "/ajax/recruiting_token/transfer";
        $fields = array(
            'token_id'=>$RecruitingToken->long_id,
            'old_user_id'=>$User1->getId(),
            'new_user_id'=>$User2->getId()
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
        $this->assertEquals($User2->getId(), $RecruitingToken2->user_id);
    }

    /**
     * Tests request via ajax endpoint.
     */
    public function testOldUserCompany()
    {
        // setup test users
        $User1 = new User();
        $User1->email_address = rand();
        $User1->first_name = rand();
        $User1->last_name = rand();
        $User1->save();
        $User2 = new User();
        $User2->email_address = rand();
        $User2->first_name = rand();
        $User2->last_name = rand();
        $User2->save();

        // setup test company with unrelated user
        $RecruitingCompany = new RecruitingCompany();
        $RecruitingCompany->user_id = $User1->getId();
        $RecruitingCompany->save();

        // setup test token
        $RecruitingToken = new RecruitingToken();
        $RecruitingToken->user_id = $User1->getId();
        $RecruitingToken->recruiting_company_id = $RecruitingCompany->id;
        $RecruitingToken->long_id = substr(md5(microtime()), rand(0, 26), 20);
        $RecruitingToken->save();

        // test user transfer
        $url = TEST_URL . "/ajax/recruiting_token/transfer";
        $fields = array(
            'token_id'=>$RecruitingToken->long_id,
            'old_user_id'=>$User1->getId(),
            'new_user_id'=>$User2->getId()
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
        $this->assertEquals($User1->getId(), $RecruitingToken2->user_id);
    }

    /**
     * Tests request via ajax endpoint.
     */
    public function testNewUserCompany()
    {
        // setup test users
        $User1 = new User();
        $User1->email_address = rand();
        $User1->first_name = rand();
        $User1->last_name = rand();
        $User1->save();
        $User2 = new User();
        $User2->email_address = rand();
        $User2->first_name = rand();
        $User2->last_name = rand();
        $User2->save();

        // setup test company
        $RecruitingCompany = new RecruitingCompany();
        $RecruitingCompany->user_id = $User2->getId();
        $RecruitingCompany->save();

        // setup test token
        $RecruitingToken = new RecruitingToken();
        $RecruitingToken->user_id = $User1->getId();
        $RecruitingToken->recruiting_company_id = $RecruitingCompany->id;
        $RecruitingToken->long_id = substr(md5(microtime()), rand(0, 26), 20);
        $RecruitingToken->save();

        // test user transfer
        $url = TEST_URL . "/ajax/recruiting_token/transfer";
        $fields = array(
            'token_id'=>$RecruitingToken->long_id,
            'old_user_id'=>$User1->getId(),
            'new_user_id'=>$User2->getId()
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
        $this->assertEquals($User2->getId(), $RecruitingToken2->user_id);
    }

    /**
     * Tests request via ajax endpoint.
     */
    public function testRandomUserCompany()
    {
        // setup test users
        $User1 = new User();
        $User1->email_address = rand();
        $User1->first_name = rand();
        $User1->last_name = rand();
        $User1->save();
        $User2 = new User();
        $User2->email_address = rand();
        $User2->first_name = rand();
        $User2->last_name = rand();
        $User2->save();
        $User3 = new User();
        $User3->email_address = rand();
        $User3->first_name = rand();
        $User3->last_name = rand();
        $User3->save();

        // setup test company with unrelated user
        $RecruitingCompany = new RecruitingCompany();
        $RecruitingCompany->user_id = $User3->getId();
        $RecruitingCompany->save();

        // setup test token
        $RecruitingToken = new RecruitingToken();
        $RecruitingToken->user_id = $User1->getId();
        $RecruitingToken->recruiting_company_id = $RecruitingCompany->id;
        $RecruitingToken->long_id = substr(md5(microtime()), rand(0, 26), 20);
        $RecruitingToken->save();

        // test user transfer
        $url = TEST_URL . "/ajax/recruiting_token/transfer";
        $fields = array(
            'token_id'=>$RecruitingToken->long_id,
            'old_user_id'=>$User1->getId(),
            'new_user_id'=>$User2->getId()
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
        $this->assertEquals($User1->getId(), $RecruitingToken2->user_id);
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
}
?>
