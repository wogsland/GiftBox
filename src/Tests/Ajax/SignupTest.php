<?php
namespace Sizzle\Tests\Ajax;

use \Sizzle\Bacon\Database\User;

/**
 * This class tests the ajax endpoint to sign up.
 *
 * ./vendor/bin/phpunit --bootstrap src/Tests/autoload.php src/Tests/Ajax/SignupTest
 */
class SignupTest
extends \PHPUnit_Framework_TestCase
{
    /**
     * Requires the util.php file of functions
     */
    public static function setUpBeforeClass()
    {
        include_once __DIR__.'/../../../util.php';
    }

    /**
     * Tests request via ajax endpoint.
     *
     * @runInSeparateProcess
     * @preserveGlobalState  disabled
     */
    public function testInternalSignup()
    {
        // setup test credentials
        $email = rand().'@gosizzle.io';
        $password = rand();

        $this->markTestIncomplete();
        // need to find a way to Mock the ajax response so this won't actually sent emails

        /*
        // test for created images
        $url = TEST_URL . "/ajax/signup";
        $fields = array(
            'signup_email'=>$email,
            'signup_password'=>$password,
            'reg_type'=>'EMAIL'
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
        $this->assertTrue($response);
        $json = ob_get_contents();
        ob_end_clean();
        $return = json_decode($json);
        $this->assertEquals('SUCCESS', $return->status);
        $this->assertEquals("$email successsfully registered.", $return->message);

        // test user created
        $this->assertTrue((new User())->exists($email));
        $User = (new User())->fetch($email);
        $this->assertEquals($User->email_address, $email);
        $this->assertEquals($User->internal, 'Y');
        */
    }

    /**
     * Tests request failure via ajax endpoint.
     */
    public function testFail()
    {
        $url = TEST_URL . "/ajax/signup";
        ob_start();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $response = curl_exec($ch);
        $this->assertEquals(true, $response);
        $json = ob_get_contents();
        $return = json_decode($json);
        ob_end_clean();
        $this->assertEquals('ERROR', $return->status);
        $this->assertEquals('Unable to register at this time.', $return->message);
    }
}
?>
