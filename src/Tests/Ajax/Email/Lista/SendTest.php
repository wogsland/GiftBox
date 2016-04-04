<?php
namespace Sizzle\Tests\Ajax\Email\Lista;

use \Sizzle\Database\{
    EmailCredential,
    EmailList
};

/**
 * This class tests the ajax endpoint to send emails.
 *
 * ./vendor/bin/phpunit --bootstrap src/Tests/autoload.php src/Tests/Ajax/Email/Lista/SendTest
 */
class SendTest
extends \PHPUnit_Framework_TestCase
{
    /**
     * Requires the util.php file of functions
     */
    public static function setUpBeforeClass()
    {
        include_once __DIR__.'/../../../../../util.php';
    }

    /**
     * Setup before each test
     */
    public function setUp()
    {
        $this->url = TEST_URL . "/ajax/email/list/send";
    }

    /**
     * Tests successful request via ajax endpoint.
     */
    public function testRequest()
    {
        // need to set up testing email...
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
            'email_credential_id'=>1
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
            'email_credential_id'=>-1
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
