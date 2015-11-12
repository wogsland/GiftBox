<?php
namespace GiveToken\Tests\Ajax\Email\Credential;

use \GiveToken\EmailCredential;
use \GiveToken\User;

/**
 * This class tests the ajax endpoint to delete email credentials.
 *
 * phpunit --bootstrap src/Tests/autoload.php src/Tests/Ajax/Email/Credential/DeleteTest
 */
class DeleteTest
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
        // create credential
        $User = new User();
        $User->email_address = rand();
        $User->first_name = rand();
        $User->last_name = rand();
        $User->save();
        $user_id = $User->getId();
        $username = 'user'.rand();
        $password = 'my'.rand();
        $smtp_host = rand(0,255).'.'.rand(0,255).'.'.rand(0,255).'.'.rand(0,255);
        $smtp_port = rand(1,1000);
        $EmailCredential = new EmailCredential();
        $id = $EmailCredential->create($user_id, $username, $password, $smtp_host, $smtp_port);

        // delete credential
        $url = TEST_URL . "/ajax/email/credential/delete";
        $fields = array(
            'id'=>$id,
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
        $this->assertEquals('true', $return->success);
        $this->assertTrue(isset($return->data->id));
        $this->assertEquals((int) $return->data->id, $return->data->id);
        $this->assertEquals($id, $return->data->id);
        ob_end_clean();

        // verify it's "deleted" in the database
        $EmailCredential = new EmailCredential($id);
        $this->assertFalse(isset($EmailCredential->id));
    }

    /**
     * Tests request failure via ajax endpoint.
     */
    public function testFail()
    {
        // no cookie, no post vars
        $url = TEST_URL . "/ajax/email/credential/delete";
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
        $url = TEST_URL . "/ajax/email/credential/delete";
        $fields = array(
            'id'=>rand(),
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
        $url = TEST_URL . "/ajax/email/credential/delete";
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
        $this->assertEquals('', $return->data);
        ob_end_clean();
    }
}
?>
