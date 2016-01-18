<?php
namespace GiveToken\Tests\Ajax\Email;

use \GiveToken\EmailCredential;
use \GiveToken\User;

/**
 * This class tests the ajax endpoint to send emails.
 *
 * phpunit --bootstrap src/Tests/autoload.php src/Tests/Ajax/Email/SendTest
 */
class SendTest
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
        $url = TEST_URL . "/ajax/email/send";

        // no cookie, no post vars
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
     * Tests request failure via ajax endpoint.
     */
    public function testFailNoCookiePostVars()
    {
        $url = TEST_URL . "/ajax/email/send";

        // no cookie, but post vars
        $fields = array(
            'subject'=>'GiveToken Test Email',
            'body'=>'<b>Behold!</b> This is the body of an email.',
            'address'=>'test@gosizzle.io',
            'replyTo'=>'reply-to@gosizzle.io',
            'email_credential_id'=>1,
            'cc'=>'cc@gosizzle.io',
            'bcc'=>'bcc@gosizzle.io'
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
     * Tests request failure via ajax endpoint.
     */
    public function testFailCookieNoVars()
    {
        $url = TEST_URL . "/ajax/email/send";

        // cookie, but no post vars
        ob_start();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_COOKIE, TEST_COOKIE);
        curl_setopt($ch, CURLOPT_URL, $url);
        $response = curl_exec($ch);
        $this->assertEquals(true, $response);
        $json = ob_get_contents();
        $return = json_decode($json);
        $this->assertEquals('false', $return->success);
        $this->assertTrue(isset($return->data->error));
        $this->assertEquals('Missing required parameter(s).', $return->data->error);
        ob_end_clean();
    }

    /**
     * Tests request failure via ajax endpoint.
     */
    public function testFailCookieBadCredential()
    {
        $url = TEST_URL . "/ajax/email/send";
        $fields = array(
            'subject'=>'GiveToken Test Email',
            'body'=>'<b>Behold!</b> This is the body of an email.',
            'address'=>'test@gosizzle.io',
            'replyTo'=>'reply-to@gosizzle.io',
            'email_credential_id'=>rand(),
            'cc'=>'cc@gosizzle.io',
            'bcc'=>'bcc@gosizzle.io'
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
        curl_setopt($ch, CURLOPT_URL, $url);
        $response = curl_exec($ch);
        $this->assertEquals(true, $response);
        $json = ob_get_contents();
        $return = json_decode($json);
        $this->assertEquals('false', $return->success);
        $this->assertTrue(isset($return->data->error));
        $this->assertEquals('Invalid credentials provided.', $return->data->error);
        ob_end_clean();
    }
}
?>
