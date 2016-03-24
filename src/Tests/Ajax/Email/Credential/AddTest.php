<?php
namespace Sizzle\Tests\Ajax\Email\Credential;

use Sizzle\Database\EmailCredential;

/**
 * This class tests the ajax endpoint to add email credentials.
 *
 * ./vendor/bin/phpunit --bootstrap src/Tests/autoload.php src/Tests/Ajax/Email/Credential/AddTest
 */
class AddTest
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
     * Tests request via ajax endpoint.
     */
    public function testRequest()
    {
        // successful insertion
        $url = TEST_URL . "/ajax/email/credential/add";
        $fields = array(
            'username'=>'user'.rand(),
            'password'=>'my'.rand(),
            'smtp_host'=>rand(0, 255).'.'.rand(0, 255).'.'.rand(0, 255).'.'.rand(0, 255),
            'smtp_port'=>rand(1, 1000)
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
        ob_end_clean();
        $return = json_decode($json);
        $this->assertEquals('true', $return->success);
        $this->assertEquals((int) $return->data->id, $return->data->id);
        $this->assertTrue(0 < $return->data->id);

        // now test to see if it's in the database
        $EmailCredential = new EmailCredential($return->data->id);
        $this->assertEquals($EmailCredential->id, $return->data->id);
    }

    /**
     * Tests request failure via ajax endpoint.
     */
    public function testFail()
    {
        // no cookie, no post vars
        $url = TEST_URL . "/ajax/email/credential/add";
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

        // no cookie, but post vars
        $url = TEST_URL . "/ajax/email/credential/add";
        $fields = array(
            'username'=>'user'.rand(),
            'password'=>'my'.rand(),
            'smtp_host'=>rand(0, 255).'.'.rand(0, 255).'.'.rand(0, 255).'.'.rand(0, 255),
            'smtp_port'=>rand(1, 1000)
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

        // cookie, but no post vars
        $url = TEST_URL . "/ajax/email/credential/add";
        ob_start();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_COOKIE, TEST_COOKIE);
        curl_setopt($ch, CURLOPT_URL, $url);
        $response = curl_exec($ch);
        $this->assertEquals(true, $response);
        $json = ob_get_contents();
        ob_end_clean();
        $return = json_decode($json);
        $this->assertEquals('false', $return->success);
        $this->assertTrue(is_object($return->data));
        $this->assertTrue(is_array($return->data->errors));
        $this->assertEquals(4, count($return->data->errors));
        $this->assertTrue(in_array('Username cannot be left blank', $return->data->errors));
        $this->assertTrue(in_array('Password cannot be left blank', $return->data->errors));
        $this->assertTrue(in_array('Invalid SMTP host', $return->data->errors));
        $this->assertTrue(in_array('Invalid Port provided for SMTP host', $return->data->errors));
    }
}
?>
