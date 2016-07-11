<?php
namespace Sizzle\Tests\Ajax\Email\Lista;

use \Sizzle\Bacon\Database\{
    EmailCredential,
    EmailList,
    EmailListEmail,
    RecruitingToken,
    User
};

use Sizzle\Tests\Ajax\Email\fakeSMTP;


/**a
 * This class tests the ajax endpoint to send emails.
 *
 * ./vendor/bin/phpunit --bootstrap src/Tests/autoload.php src/Tests/Ajax/Email/Lista/SendTest
 */
class SendTest
extends \PHPUnit_Framework_TestCase
{
    use \Sizzle\Bacon\Tests\Traits\User;
    /**
     * Requires the util.php file of functions
     */

    public static function setUpBeforeClass()
    {
        include_once __DIR__ . '/../../../../../util.php';
    }
    /**
     * Setup before each test
     */
    public function setUp()
    {
//       $this->overloadedPHPMailer = \Mockery::mock('overload:\PHPMailer')->makePartial();
//       $this->overloadedPHPMailer
//          ->shouldReceive('send')
//          ->andReturn(true);
//       $this->overloadedPHPMailer
//          ->shouldReceive('postSend')
//          ->andReturn(true);
//       $this->overloadedPHPMailer
//          ->shouldReceive('preSend')
//          ->andReturn(true);
//        $this->assertTrue((new \PHPMailer) instanceof \Mockery\MockInterface);

        $this->url = TEST_URL . "/ajax/email/list/send";

        $cookieAndUserId = getTestCookieAndUserId();
        $this->cookie = $cookieAndUserId[0];
        $this->user = new User($cookieAndUserId[1]);
        $this->recruiting_token = new RecruitingToken();
        $this->recruiting_token->user_id = $this->user->id;
        $this->recruiting_token->long_id = substr(md5(microtime()), rand(0, 26), 20);
        $this->recruiting_token->save();

        //set up the test list
        $name = 'My '.rand().'th List';
        $this->EmailList = new EmailList();
        $this->EmailList->create($this->user->id, $name);
        $this->EmailListEmail = new EmailListEmail();
        $this->test_email = rand().'@GoSizzle.io';
        $this->EmailListEmail->create($this->EmailList->id, $this->test_email);

        $username = 'user'.rand();
        $password = 'my'.rand();
        $smtp_host = "localhost";
        $smtp_port = 25;

        $this->smtp = new fakeSMTP;
        $this->smtp->receive();
        // Create credentials
        $this->EmailCredential = new EmailCredential();
        $this->EmailCredential->create($this->user->id, $username, $password, $smtp_host, $smtp_port);
    }

    /**
     * Tests successful request via ajax endpoint.
     * @runInSeparateProcess
     * @preserveGlobalState  disabled
     */
    public function testRequest()
    {
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
        echo "START";
        ob_start();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_COOKIE, $this->cookie);
        curl_setopt($ch, CURLOPT_URL, $this->url);
        $response = curl_exec($ch);
        $this->assertEquals(true, $response);
        $json = ob_get_contents();
        $return = json_decode($json);
        ob_end_clean();
        echo "GOGO";
        var_export($this->hp);
        if (!$this->hp->mail['rawEmail']) {
            echo "NO EMAIL";
        } else {
            var_export($this->hp);
            echo ' \n ';
        }
        echo 'Response Data: ';
        var_export($json);
//        $this->assertFalse(isset($return->data->errors));
//        $this->assertEquals('', $return->data);
//        $this->assertEquals('true', $return->success);
//        $this->assertFalse(true);
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
        curl_setopt($ch, CURLOPT_COOKIE, $this->cookie);
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
        curl_setopt($ch, CURLOPT_COOKIE, $this->cookie);
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
