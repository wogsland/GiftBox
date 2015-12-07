<?php
namespace GiveToken\Tests\Ajax\Invoice;

use \GiveToken\User;

/**
 * This class tests the ajax endpoint to get a customers invoices.
 *
 * phpunit --bootstrap src/Tests/autoload.php src/Tests/Ajax/Invoice/GetTest
 */
class GetTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        // setup test user
        $User = new User();
        $User->email_address = rand();
        $User->first_name = rand();
        $User->last_name = rand();
        $User->save();
        $this->User = $User;
    }

    /**
     * Tests request  via ajax endpoint.
     */
    public function testRequest()
    {
        $url = TEST_URL . "/ajax/invoice/get";

        // no stripe_id
        ob_start();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_COOKIE, TEST_COOKIE);
        curl_setopt($ch, CURLOPT_URL, $url);
        $response = curl_exec($ch);
        $this->assertEquals(true, $response);
        $json = ob_get_contents();
        ob_end_clean();
        //print_r($json);
        $return = json_decode($json);
        //print_r($return);
        $this->assertEquals('true', $return->success);
        $this->assertTrue(0 < count($return->data->data));
    }

    /**
     * Tests request failure via ajax endpoint.
     */
    public function testFail()
    {
        $url = TEST_URL . "/ajax/invoice/get";
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
