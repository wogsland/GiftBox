<?php
namespace Sizzle\Tests\Ajax\Email\Lista;

use \Sizzle\Bacon\Database\{
    EmailCredential,
    EmailList,
    EmailListEmail,
    RecruitingToken,
    User
};

/**
 * This class tests the ajax endpoint to send emails.
 *
 * ./vendor/bin/phpunit --bootstrap src/Tests/autoload.php src/Tests/Ajax/Email/Lista/SendTest
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class SendTest
extends \PHPUnit_Framework_TestCase
{
    use \Sizzle\Tests\Traits\RecruitingToken;
    /**
     * Requires the util.php file of functions
     */

    static $overloadedPHPMailer = "";
    public static function setUpBeforeClass()
    {
        include_once __DIR__.'/../../../../../util.php';
        SendTest::$overloadedPHPMailer = \Mockery::mock('overload:PHPMailer');
    }

    /**
     * Setup before each test
     */
    public function setUp()
    {
        $this->mockedPHPMailer = new SendTest::$overloadedPHPMailer;
        assert($this->mockedPHPMailer instanceof \Mockery\MockInterface);

        $this->url = TEST_URL . "/ajax/email/list/send";
        $cookieAndUserId = getTestCookie(false, true);
        $this->Cookie = $cookieAndUserId[0];
        $this->User = new User($cookieAndUserId[1]);

          $this->recruiting_token = new RecruitingToken();
        $this->recruiting_token->user_id = $this->User->id;
        $this->recruiting_token->long_id = substr(md5(microtime()), rand(0, 26), 20);
        $this->recruiting_token->save();

        //set up the test list
        $name = 'My '.rand().'th List';
        $this->EmailList = new EmailList();
        $this->EmailList->create($this->User->id, $name);
        $this->EmailListEmail = new EmailListEmail();
        $this->test_email = rand().'@GoSizzle.io';
        $this->EmailListEmail->create($this->EmailList->id, $this->test_email);

        $username = 'user'.rand();
        $password = 'my'.rand();
        $smtp_host = rand(0, 255).'.'.rand(0, 255).'.'.rand(0, 255).'.'.rand(0, 255);
        $smtp_port = rand(1, 1000);

        // Create credentials
        $this->EmailCredential = new EmailCredential();
        $this->EmailCredential->create($this->User->id, $username, $password, $smtp_host, $smtp_port);
    }

    /**
     * Tests successful request via ajax endpoint.
     */
    public function testRequest()
    {
        $this->mockedPHPMailer
          ->shouldReceive('send')->withAnyArgs()->once()
          ->andReturn(true);

        // need to set up testing email...
        // cookie + post vars
        $fields = array(
          'token_id'=>$this->recruiting_token->long_id,
          'email_list_id'=>$this->EmailList->id,
          'message'=>'toast',
          'email_credential_id'=>$this->EmailCredential->id,
          'subject'=>''
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
        curl_setopt($ch, CURLOPT_COOKIE, $this->Cookie);
        curl_setopt($ch, CURLOPT_URL, $this->url);
        $response = curl_exec($ch);
        $this->assertEquals(true, $response);
        $json = ob_get_contents();
        ob_end_clean();
        //echo $json;
        $return = json_decode($json);
        var_dump($return->data);
        $this->assertFalse(isset($return->data->errors));
        $this->assertEquals('', $return->data);
        $this->assertEquals('true', $return->success);
    }

    /**
     * Tests request failure via ajax endpoint.
     */
    public function testFailNoCookieNoVars()
    {
        // no cookie, no post vars
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
     * Tests request failure via ajax endpoint.
     */
    public function testFailNoCookiePostVars()
    {
        // no cookie, but post vars
        $fields = array(
            'token_id'=>1,
            'email_list_id'=>1,
            'message'=>'toast',
            'email_credential_id'=>1,
            'subject'=>''
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
     * Tests request failure via ajax endpoint.
     */
    public function testFailCookieNoVars()
    {
        // cookie, but no post vars
        ob_start();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_COOKIE, TEST_COOKIE);
        curl_setopt($ch, CURLOPT_URL, $this->url);
        $response = curl_exec($ch);
        $this->assertEquals(true, $response);
        $json = ob_get_contents();
        ob_end_clean();
        //echo $json;
        $return = json_decode($json);
        $this->assertEquals('false', $return->success);
        $this->assertTrue(isset($return->data->errors));
        $this->assertTrue(in_array('Missing required parameter(s).', $return->data->errors));
    }

    /**
     * Tests request failure via ajax endpoint.
     */
    public function testFailCookieBadParams()
    {
        $fields = array(
            'token_id'=>-1,
            'email_list_id'=>-1,
            'message'=>'toast',
            'email_credential_id'=>-1,
            'subject'=>''
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
        curl_setopt($ch, CURLOPT_COOKIE, TEST_COOKIE);
        curl_setopt($ch, CURLOPT_URL, $this->url);
        $response = curl_exec($ch);
        $this->assertEquals(true, $response);
        $json = ob_get_contents();
        ob_end_clean();
        $return = json_decode($json);
        $this->assertEquals('false', $return->success);
        $this->assertTrue(isset($return->data->errors));
        $this->assertTrue(in_array('Invalid credentials provided.', $return->data->errors));
        $this->assertTrue(in_array('Invalid list provided.', $return->data->errors));
        $this->assertTrue(in_array('Invalid token provided.', $return->data->errors));
    }
}
?>
